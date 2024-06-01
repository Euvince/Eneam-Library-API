<?php

namespace App\Http\Controllers\API;

use App\Models\Soutenance;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Actions\Soutenance\StoreAction;
use App\Actions\Soutenance\UpdateAction;
use App\Http\Requests\SoutenanceRequest;
use App\Http\Resources\Soutenance\SoutenanceResource;
use App\Responses\Soutenance\SingleSoutenanceResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Responses\Soutenance\SoutenanceCollectionResponse;

class SoutenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : SoutenanceCollectionResponse | LengthAwarePaginator
    {
        return new SoutenanceCollectionResponse(
            statusCode : 200,
            allowValue : 'GET',
            total : Soutenance::count(),
            message : "Liste de toutes les soutenances",
            collection : Soutenance::query()->with(['cycle', 'supportedMemories'])->paginate(perPage : 20),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SoutenanceRequest $request) : SingleSoutenanceResponse | JsonResponse
    {
        $response = StoreAction::handle(data : $request->validated(), request : $request);
        return $response;
    }

    /**
     * Display the specified resource.
     */
    public function show(Soutenance $soutenance) : SingleSoutenanceResponse
    {
        return new SingleSoutenanceResponse(
            statusCode : 200,
            allowValue : 'GET',
            message : "Informations sur la soutenance",
            resource : new SoutenanceResource(resource : Soutenance::query()->with(['cycle', 'supportedMemories'])->where('id', $soutenance->id)->first())
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SoutenanceRequest $request, Soutenance $soutenance) : SingleSoutenanceResponse | JsonResponse
    {
        $response = UpdateAction::handle(data : $request->validated(), request : $request, soutenance : $soutenance);
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Soutenance $soutenance) : JsonResponse
    {
        $soutenance->delete();
        return response()->json(
            status : 200,
            headers : ["Allow" => 'DELETE'],
            data : ['message' => "La soutenance a été supprimée avec succès",],
        );
    }
}
