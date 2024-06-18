<?php

namespace App\Http\Controllers\API\SupportedMemory;

use App\Actions\SupportedMemory\SMHelper;
use App\Models\SupportedMemory;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupportedMemory\DepositSupportedMemoryRequest;
use App\Http\Requests\SupportedMemory\SupportedMemoryRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Http\Resources\SupportedMemory\SupportedMemoryResource;
use App\Jobs\GenerateFilingReportJob;
use App\Jobs\RejectSupportedMemoryJob;
use App\Jobs\ValidateSupportedMemoryJob;
use App\Http\Responses\SupportedMemory\{
    SingleSupportedMemoryResponse,
    SupportedMemoryCollectionResponse
};
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\JsonResponse;

class SupportedMemoryController extends Controller
{

    /* public function __construct()
    {
        $this->authorizeResource(SupportedMemory::class, 'supportedMemory');
    } */

    /**
     * Display a listing of the resource.
     */
    public function index() : SupportedMemoryCollectionResponse | LengthAwarePaginator
    {
        return new SupportedMemoryCollectionResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PATCH, DELETE',
            total : SupportedMemory::count(),
            message : "Liste des mémoires soutenus paginés",
            collection : SupportedMemory::query()->with(['sector.sector', 'soutenance.cycle', 'soutenance.schoolYear'])->orderBy('created_at', 'desc')->paginate(perPage : 20),
        );
    }

    /**
     * Display a listing of the resource without pagination.
     */
    public function indexWithoutPagination() : SupportedMemoryCollectionResponse | LengthAwarePaginator
    {
        /* $this->authorize('viewAnyWithoutPagination', SupportedMemory::class); */
        return new SupportedMemoryCollectionResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PATCH, DELETE',
            total : SupportedMemory::count(),
            message : "Liste des mémoires soutenus sans pagination",
            collection : SupportedMemory::query()->with(['sector.sector', 'soutenance.cycle', 'soutenance.schoolYear'])->orderBy('created_at', 'desc')->get(),
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportedMemory $supportedMemory) : SingleSupportedMemoryResponse
    {
        return new SingleSupportedMemoryResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PATCH, DELETE',
            message : "Informations sur le mémoire soutenu ayant pour thème $supportedMemory->theme",
            resource : new SupportedMemoryResource(resource : SupportedMemory::query()->with(['sector.sector', 'soutenance.cycle', 'soutenance.schoolYear'])->where('id', $supportedMemory->id)->first())
        );
    }

    /**
     * Print supported memory filing report.
     */
    public function printFilingReport (SupportedMemory $supportedMemory)
    {
        $pdf = FacadePdf::loadView(view : 'fiche', data : [
            'memory' => $supportedMemory,
            'config' => \App\Models\Configuration::appConfig(),
        ])
        ->setOptions(['defaultFont' => 'sans-serif'])
        ->setPaper('A4', 'portrait');
        return $pdf->stream(filename : 'fiche.pdf');
    }


    /**
     * Print filings reports for many supported memories
     *
     * @param SupportedMemoryRequest $request
     * @return JsonResponse
     */
    public function printReports (SupportedMemoryRequest $request)
    {
        $ids = $request->validated('ids');
        array_map(function (int $id) {
            $supportedMemory = SupportedMemory::find($id);
            $pdf = FacadePdf::loadView(view : 'fiche', data : [
                'memory' => $supportedMemory,
                'config' => \App\Models\Configuration::appConfig(),
            ])
            ->setOptions(['defaultFont' => 'sans-serif'])
            ->setPaper('A4', 'portrait');
            return $pdf->download(filename : 'fiche.pdf');
        }, $ids);
    }

    /**
     * Validate supported memory.
     */
    public function validateMemory(SupportedMemory $supportedMemory) : JsonResponse
    {
        /* $validMemoriesInCurrentYearNumber = \App\Models\SchoolYear::query()
            ->find($supportedMemory->soutenance->school_year_id)
            ->whereHas('soutenances', function (Builder $query) {
                $query->whereHas('supportedMemories', function (Builder $query) {
                    $query->where('status', 'Validé');
                });
        })->count(); */

        $validMemoriesInCurrentYearNumber = SupportedMemory::query()
            ->where('status', 'Validé')
            ->whereHas('soutenance', function (Builder $query) use ($supportedMemory) {
                $query->where('school_year_id', $supportedMemory->soutenance->school_year_id);
        })->count();

        $supportedMemory->update([
            'status' => "Validé",
            'cote'   => \Carbon\Carbon::parse($supportedMemory->soutenance->start_date)->year."/".$supportedMemory->sector->acronym."/".$validMemoriesInCurrentYearNumber + 1
        ]);
        /* GenerateFilingReportJob::dispatch($supportedMemory); */
        ValidateSupportedMemoryJob::dispatch($supportedMemory);
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PATCH, DELETE'],
            data : ['message' => "Le mémoire soutenu a été validé avec succès"],
        );
    }


    /**
     * Validate many supported memories
     *
     * @param SupportedMemoryRequest $request
     * @return JsonResponse
     */
    public function validateMemories (SupportedMemoryRequest $request) : JsonResponse
    {
        $ids = $request->validated('ids');
        array_map(function (int $id) {
            $supportedMemory = SupportedMemory::find($id);
            $validMemoriesInCurrentYearNumber = SupportedMemory::query()
            ->where('status', 'Validé')
            ->whereHas('soutenance', function (Builder $query) use ($supportedMemory) {
                $query->where('school_year_id', $supportedMemory->soutenance->school_year_id);
            })->count();

            $supportedMemory->update([
                'status' => "Validé",
                'cote'   => \Carbon\Carbon::parse($supportedMemory->soutenance->start_date)->year."/".$supportedMemory->sector->acronym."/".$validMemoriesInCurrentYearNumber + 1
            ]);
            ValidateSupportedMemoryJob::dispatch($supportedMemory);

        }, $ids);
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : [
                'message' => count($ids) > 1
                    ? "Les mémoires soutenus ont été validés avec succès"
                    : "Le mémoire soutenu a été validé avec succès"
            ],
        );
    }


    /**
     * Reject supported memory.
     */
    public function rejectMemory(SupportedMemoryRequest $request, SupportedMemory $supportedMemory) : JsonResponse
    {
        $supportedMemory->update(['status' => "Rejeté"]);
        $supportedMemory->delete();
        RejectSupportedMemoryJob::dispatch($request->validated('reason'), $supportedMemory);
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PATCH, DELETE'],
            data : ['message' => "Le mémoire soutenu a été rejeté avec succès",],
        );
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(DepositSupportedMemoryRequest $request, SupportedMemory $supportedMemory)
    {
        $supportedMemory->update(SMHelper::helper($supportedMemory, $request));
        return new SingleSupportedMemoryResponse(
            statusCode : 201,
            allowedMethods : 'GET, POST, DELETE',
            message : "Le mémoire soutenu a été édité avec succès",
            resource : new SupportedMemoryResource(resource : SupportedMemory::query()->with(['sector.sector', 'soutenance.cycle', 'soutenance.schoolYear'])->where('id', $supportedMemory->id)->first())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupportedMemory $supportedMemory) :  JsonResponse
    {
        $supportedMemory->delete();
        if(($smFilePath = $supportedMemory->file_path) !== '') {
            $smPath = 'public/' . $smFilePath;
            if(Storage::exists($smPath)) Storage::delete($smPath);
        }
        if(($smCoverPagePath = $supportedMemory->cover_page_path) !== '') {
            $smCoverPath = 'public/' . $smCoverPagePath;
            if(Storage::exists($smCoverPath)) Storage::delete($smCoverPath);
        }
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PATCH, DELETE'],
            data : ['message' => "Le mémoire soutenu a été supprimé avec succès",],
        );
    }

    /**
     * Remove many specified resources from storage
     *
     * @param SupportedMemoryRequest $request
     * @return JsonResponse
     */
    public function destroyMemories (SupportedMemoryRequest $request) : JsonResponse
    {
        $ids = $request->validated('ids');
        array_map(function (int $id) {
            $supportedMemory = SupportedMemory::find($id);
            $supportedMemory->delete();

            if(($smFilePath = $supportedMemory->file_path) !== '') {
                $smPath = 'public/' . $smFilePath;
                if(Storage::exists($smPath)) Storage::delete($smPath);
            }
            if(($smCoverPagePath = $supportedMemory->cover_page_path) !== '') {
                $smCoverPath = 'public/' . $smCoverPagePath;
                if(Storage::exists($smCoverPath)) Storage::delete($smCoverPath);
            }

        }, $ids);
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : [
                'message' => count($ids) > 1
                    ? "Les mémoires soutenus ont été supprimés avec succès"
                    : "Le mémoire soutenu a été supprimé avec succès"
            ],
        );
    }

}
