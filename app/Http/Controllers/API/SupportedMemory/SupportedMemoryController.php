<?php

namespace App\Http\Controllers\API\SupportedMemory;

use App\Models\SupportedMemory;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Jobs\RejectSupportedMemoryJob;
use Illuminate\Support\Facades\Storage;
use App\Actions\SupportedMemory\SMHelper;
use App\Http\Requests\SupportedMemory\ImportRequest;
use App\Actions\SupportedMemory\DownloadMemories;
use App\Actions\SupportedMemory\GenerateReports;
use App\Actions\SupportedMemory\ValidateMemories;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Http\Requests\SupportedMemory\SupportedMemoryRequest;
use App\Http\Resources\SupportedMemory\SupportedMemoryResource;
use App\Http\Requests\SupportedMemory\DepositSupportedMemoryRequest;
use App\Http\Responses\SupportedMemory\{
    SingleSupportedMemoryResponse,
    SupportedMemoryCollectionResponse
};
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
            collection : SupportedMemory::query()->with([
                'sector.sector', 'soutenance.cycle', 'soutenance.schoolYear'
            ])->orderBy('created_at', 'desc')->paginate(perPage : 20),
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
            collection : SupportedMemory::query()->with([
                'sector.sector', 'soutenance.cycle', 'soutenance.schoolYear'
            ])->orderBy('created_at', 'desc')->get(),
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
            resource : new SupportedMemoryResource(
                resource : SupportedMemory::query()->with([
                    'sector.sector', 'soutenance.cycle', 'soutenance.schoolYear'
            ])->where('id', $supportedMemory->id)->first())
        );
    }

    /**
     * Download the specified resource.
     */
    public function downloadMemory(SupportedMemory $supportedMemory)
    {
        /* $this->authorize('downloadMemory', $supportedMemory); */
        return DownloadMemories::downloadMemory($supportedMemory);
    }

     /**
     * Download many supported memories
     *
     * @param SupportedMemoryRequest $request
     */
    public function downloadMemories (SupportedMemoryRequest $request)
    {
        return DownloadMemories::downloadMemories(request : $request);
    }

    /**
     * Validate supported memory.
     */
    public function validateMemory(SupportedMemory $supportedMemory)
    {
        /* $this->authorize('validateMemory', $supportedMemory); */
        return ValidateMemories::validateMemory($supportedMemory);
    }

    /**
     * Validate many supported memories
     *
     * @param SupportedMemoryRequest $request
     */
    public function validateMemories (SupportedMemoryRequest $request)
    {
        return ValidateMemories::validateMemories($request);
    }


    /**
     * Reject supported memory.
     */
    public function rejectMemory(SupportedMemoryRequest $request, SupportedMemory $supportedMemory) : JsonResponse
    {
        /* $this->authorize('rejectMemory', $supportedMemory); */
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
     * Print supported memory filing report.
     */
    public function printFilingReport (SupportedMemory $supportedMemory)
    {
        /* $this->authorize('printFilingReport', $supportedMemory); */
        return GenerateReports::printReportUsingWord($supportedMemory);
    }


    /**
     * Print filings reports for many supported memories
     *
     * @param SupportedMemoryRequest $request
     */
    public function printReports (SupportedMemoryRequest $request)
    {
        return GenerateReports::printReportsUsingWord($request);
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


    /**
    * @return \Illuminate\Support\Collection
    */
    public function getMemories() : View
    {
        $memories = SupportedMemory::get();
        return view('memories', compact('memories'));
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function importPdfsReports(ImportRequest $request) : RedirectResponse
    {
        GenerateReports::importPdfsReports($request);
        return back()->with(['success' => "Fiches de dépôts de mémoires importées avec succès"]);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function importWordsReports(ImportRequest $request) : RedirectResponse
    {
        GenerateReports::importWordsReports($request);
        return back()->with(['success' => "Fiches de dépôts de mémoires importées avec succès"]);
    }

}
