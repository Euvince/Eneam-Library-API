<?php

namespace App\Http\Controllers\API;

use App\Models\Sector;
use App\Http\Controllers\Controller;
use App\Http\Requests\SectorRequest;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CycleCollectionResponse(
            statusCode : 200,
            allowValue : 'GET',
            total : Cycle::count(),
            message : "Liste de tous les cycles",
            collection : Cycle::query()->with(['soutenances'])->paginate(perPage : 20),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectorRequest $request)
    {
        $cycle = Cycle::create($request->validated());
        return new SingleCycleResponse(
            statusCode : 201,
            allowValue : 'POST',
            message : "Le cycle a été crée avec succès",
            resource : new CycleResource(resource : $cycle)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Sector $sector)
    {
        return new SingleCycleResponse(
            statusCode : 200,
            allowValue : 'GET',
            message : "Informations sur le cycle",
            resource : new CycleResource(resource : Cycle::query()->with(['soutenances'])->where('id', $cycle->id)->first())
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SectorRequest $request, Sector $sector)
    {
        $cycle->update($request->validated());
        return new SingleCycleResponse(
            statusCode : 200,
            allowValue : 'PUT',
            message : "Le cycle a été modifié avec succès",
            resource : new CycleResource(resource : Cycle::query()->with(['soutenances'])->where('id', $cycle->id)->first())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sector $sector)
    {
        $cycle->delete();
        return response()->json(
            status : 200,
            headers : [
                "Allow" => 'DELETE'
            ],
            data : [
                'message' => "Le cycle a àté supprimé avec succès",
            ],
        );
    }
}
