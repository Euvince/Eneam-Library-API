<?php

namespace App\Http\Controllers\API;

use App\Models\Cycle;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CycleRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Cycle\CycleResource;
use App\Http\Responses\Cycle\{
    SingleCycleResponse,
    CycleCollectionResponse
};
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CycleController extends Controller
{

    /* public function __construct()
    {
        $this->authorizeResource(Cycle::class, 'cycle');
    } */

    /**
     * Display a listing of the resource.
     */
    public function index() : CycleCollectionResponse | LengthAwarePaginator
    {
        return new CycleCollectionResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            total : Cycle::count(),
            message : "Liste de tous les cycles",
            collection : Cycle::query()/* ->with(['soutenances']) */->orderBy('created_at', 'desc')->orderBy('created_at', 'desc')->get()/* paginate(perPage : 20) */,
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CycleRequest $request) : SingleCycleResponse
    {
        $cycle = Cycle::create($request->validated());
        return new SingleCycleResponse(
            statusCode : 201,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Le cycle a été crée avec succès",
            resource : new CycleResource(resource : $cycle)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Cycle $cycle) : SingleCycleResponse
    {
        return new SingleCycleResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Informations sur le cycle $cycle->name",
            resource : new CycleResource(resource : Cycle::query()/* ->with(['soutenances']) */->where('id', $cycle->id)->first())
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CycleRequest $request, Cycle $cycle) : SingleCycleResponse
    {
        $cycle->update($request->validated());
        return new SingleCycleResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Le cycle a été modifié avec succès",
            resource : new CycleResource(resource : Cycle::query()/* ->with(['soutenances']) */->where('id', $cycle->id)->first())
        );
    }


    /**
     * Check if the specified resource has any children.
    */
    public function checkChildrens (Cycle $cycle) : JsonResponse
    {
        $this->authorize('checkChildrens', $cycle);
        $soutenancesCount = $cycle->soutenances->count();
        $hasChildrens = $soutenancesCount > 0 ? true : false;
        $message = $hasChildrens === true
            ? "Ce cycle contient des soutenances, souhaitez vous-vraiment le supprimer ?"
            : "Voulez-vous vraiment supprimer ce cycle ?, attention, cette action est irréversible.";

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
    public function destroy(Cycle $cycle) : JsonResponse
    {
        $cycle->delete();
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : ['message' => "Le cycle a été supprimé avec succès",],
        );
    }

    /**
     * Remove many specified resources from storage
     *
     * @param CycleRequest $request
     * @return JsonResponse
     */
    public function destroyCycles (CycleRequest $request) : JsonResponse
    {
        /* $this->authorize('delete', Cycle::class); */
        $ids = $request->validated('ids');
        array_map(function (int $id) {
            Cycle::find($id)->delete();
        }, $ids);
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : [
                'message' => count($ids) > 1
                    ? "Les cycles ont été supprimés avec succès"
                    : "Le cycle a été supprimé avec succès"
            ],
        );
    }

}
