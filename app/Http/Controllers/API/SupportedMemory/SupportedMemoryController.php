<?php

namespace App\Http\Controllers\API\SupportedMemory;

use App\Models\SupportedMemory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Http\Requests\SupportedMemory\SupportedMemoryRequest;
use App\Http\Resources\SupportedMemory\SupportedMemoryResource;
use App\Responses\SupportedMemory\SingleSupportedMemoryResponse;
use App\Responses\SupportedMemory\SupportedMemoryCollectionResponse;

class SupportedMemoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : SupportedMemoryCollectionResponse | LengthAwarePaginator
    {
        return new SupportedMemoryCollectionResponse(
            statusCode : 200,
            allowValue : 'GET',
            total : SupportedMemory::count(),
            message : "Liste des mémoires soutenus",
            collection : SupportedMemory::query()->with(['sector', 'soutenance'])->paginate(perPage : 20),
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportedMemory $supportedMemory) : SingleSupportedMemoryResponse
    {
        return new SingleSupportedMemoryResponse(
            statusCode : 200,
            allowValue : 'GET',
            message : "Informations sur le mémoire soutenu",
            resource : new SupportedMemoryResource(resource : SupportedMemory::query()->with(['sector', 'soutenance'])->where('id', $supportedMemory->id)->first())
        );
    }

    public function validateMemory() : void
    {
    }

    public function rejectedMemory() : void
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupportedMemory $supportedMemory)
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
            headers : ["Allow" => 'DELETE'],
            data : ['message' => "Le mémoire soutenu a été supprimé avec succès",],
        );
    }
}
