<?php

namespace App\Http\Controllers\API\SupportedMemory;

use App\Models\SupportedMemory;
use App\Http\Controllers\Controller;
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
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\JsonResponse;

class SupportedMemoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : SupportedMemoryCollectionResponse | LengthAwarePaginator
    {
        return new SupportedMemoryCollectionResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PATCH, DELETE',
            total : SupportedMemory::count(),
            message : "Liste des mémoires soutenus",
            collection : SupportedMemory::query()->with(['sector', 'soutenance'])->orderBy('created_at', 'desc')->paginate(perPage : 20),
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
            resource : new SupportedMemoryResource(resource : SupportedMemory::query()->with(['sector', 'soutenance'])->where('id', $supportedMemory->id)->first())
        );
    }

    public function validateMemory(SupportedMemory $supportedMemory) : JsonResponse
    {
        $supportedMemory->update(['status' => "Validé"]);
        GenerateFilingReportJob::dispatch($supportedMemory);
        ValidateSupportedMemoryJob::dispatch($supportedMemory);
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PATCH, DELETE'],
            data : ['message' => "Le mémoire soutenu a été validé avec succès"],
        );
    }

    public function printFilingReport (SupportedMemory $supportedMemory) {
        $pdf = FacadePdf::loadView(view : 'fiche', data : [
            'memory' => $supportedMemory,
            'config' => \App\Models\Configuration::appConfig(),
        ])
        ->setOptions(['defaultFont' => 'sans-serif'])
        ->setPaper('A4', 'portrait');
        return $pdf->download('fiche.pdf');
    }

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
     * Remove the specified resource from storage.
     */
    public function destroy(SupportedMemory $supportedMemory) :  JsonResponse
    {
        $supportedMemory->delete();
        if(($smFilePath = $supportedMemory->file_path) !== '') {
            $smPath = 'public/' . $smFilePath;
            if(Storage::exists($smPath)) Storage::delete('public/' . $smFilePath);
        }
        if(($smCoverPagePath = $supportedMemory->cover_page_path) !== '') {
            $smCoverPath = 'public/' . $smCoverPagePath;
            if(Storage::exists($smCoverPath)) Storage::delete('public/' . $smCoverPagePath);
        }
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PATCH, DELETE'],
            data : ['message' => "Le mémoire soutenu a été supprimé avec succès",],
        );
    }
}
