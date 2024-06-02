<?php

namespace App\Http\Controllers\API;

use App\Models\Cycle;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CycleRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Cycle\CycleResource;
use App\Responses\Cycle\SingleCycleResponse;
use App\Responses\Cycle\CycleCollectionResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CycleController extends Controller
{
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
            collection : Cycle::query()->with(['soutenances'])->orderBy('created_at', 'desc')->paginate(perPage : 20),
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
            resource : new CycleResource(resource : Cycle::query()->with(['soutenances'])->where('id', $cycle->id)->first())
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
            resource : new CycleResource(resource : Cycle::query()->with(['soutenances'])->where('id', $cycle->id)->first())
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
}
