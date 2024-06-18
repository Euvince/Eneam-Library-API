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

    /* public function __construct()
    {
        $this->authorizeResource(Soutenance::class, 'soutenance');
    } */

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
            resource : new SoutenanceResource(resource : Soutenance::query()->with(['cycle'/* , 'supportedMemories' */])->where('id', $soutenance->id)->first())
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
     * Check if the specified resource has any children.
    */
    public function checkChildrens (Soutenance $soutenance) : JsonResponse
    {
        $supportedMemoriesCount = $soutenance->supportedMemories()->count();
        $hasChildrens = $supportedMemoriesCount > 0 ? true : false;
        $message = $hasChildrens === true
            ? "Cette soutenance contient des mémoires soutenus, souhaitez vous-vraiment la supprimer ?"
            : "Voulez-vous vraiment supprimer cette soutenance ?, attention, cette action est irréversible.";

        return response()->json(
            status : 200,
            headers : [
                'Allow' => 'GET, POST, PUT, PATCH, DELETE',
                'Content-Type' => 'application/json',
            ],
            data :  [
                'has-children' => $hasChildrens,
                "message" => $message
            ]
        );
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


    /**
     * Remove many specified resources from storage
     *
     * @param SoutenanceRequest $request
     * @return JsonResponse
     */
    public function destroySoutenances (SoutenanceRequest $request) : JsonResponse
    {
        $ids = $request->validated('ids');
        array_map(function (int $id) {
            Soutenance::find($id)->delete();
        }, $ids);
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : [
                'message' => count($ids) > 1
                    ? "Les soutenances ont été supprimées avec succès"
                    : "La soutenance a été supprimée avec succès"
            ],
        );
    }

}
