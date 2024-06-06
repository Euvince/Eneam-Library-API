<?php

namespace App\Http\Controllers\API;

use App\Models\Soutenance;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Actions\Soutenance\StoreAction;
use App\Actions\Soutenance\UpdateAction;
use App\Http\Requests\SoutenanceRequest;
use App\Http\Resources\Soutenance\SoutenanceResource;
use App\Http\Responses\Soutenance\{
    SingleSoutenanceResponse,
    SoutenanceCollectionResponse
};
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SoutenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : SoutenanceCollectionResponse | LengthAwarePaginator
    {
        return new SoutenanceCollectionResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            total : Soutenance::count(),
            message : "Liste de toutes les soutenances",
            collection : Soutenance::query()->with(['schoolYear', 'cycle'/* , 'supportedMemories' */])->orderBy('created_at', 'desc')->paginate(perPage : 20),
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
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Informations sur la soutenance $soutenance->name",
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
            headers : ["Allow" => 'GET, POST, PUT. PATCH, DELETE'],
            data : ['message' => "La soutenance a été supprimée avec succès",],
        );
    }
}
