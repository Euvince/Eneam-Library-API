<?php

namespace App\Http\Controllers\API;

use App\Helpers;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sector\SectorRequest;
use App\Http\Resources\Sector\SectorResource;
use App\Responses\Sector\SingleSectorResponse;
use App\Responses\Sector\SectorCollectionResponse;
use App\Http\Requests\Sector\FindSectorByTypeRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FindSectorByTypeRequest $request) : SectorCollectionResponse | LengthAwarePaginator
    {
        /* $type = $request->validated('type'); */
        $collection = $request->has('type')
            ? Sector::query()->where('type', /* ucfirst(strtolower($type)) */ $request->type)->with(['sector', 'specialities', 'supportedMemories'])->paginate(perPage : 20)
            : Sector::query()->with(['sector', 'specialities', 'supportedMemories'])->paginate(perPage : 20);
        return new SectorCollectionResponse(
            statusCode : 200,
            allowValue : 'GET',
            total : Sector::count(),
            message : "Liste des filières et spécialités",
            collection : $collection,
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : SingleSectorResponse
    {
        $sector = Sector::create($request->all());
        return new SingleSectorResponse(
            statusCode : 201,
            allowValue : 'POST',
            message : $sector->sector_id !== NULL ? "La spécialité a été crée avec succès" : "La filière a été crée avec succès",
            resource : new SectorResource(resource : Sector::query()->with(['sector', 'specialities', 'supportedMemories'])->where('id', $sector->id)->first())
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Sector $sector) : SingleSectorResponse
    {
        return new SingleSectorResponse(
            statusCode : 200,
            allowValue : 'GET',
            message : "Informations sur le cycle",
            resource : new SectorResource(resource : Sector::query()->with(['sector', 'specialities', 'supportedMemories'])->where('id', $sector->id)->first())
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sector $sector) : SingleSectorResponse
    {
        $sector->update($request->all());
        return new SingleSectorResponse(
            statusCode : 200,
            allowValue : 'PUT',
            message : $sector->sector_id !== NULL ? "La spécialité a été crée avec succès" : "La filière a été crée avec succès",
            resource : new SectorResource(resource : Sector::query()->with(['sector', 'specialities', 'supportedMemories'])->where('id', $sector->id)->first())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sector $sector) : JsonResponse
    {
        $sector->delete();
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
