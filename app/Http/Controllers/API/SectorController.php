<?php

namespace App\Http\Controllers\API;

use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sector\SectorRequest;
use App\Http\Resources\Sector\SectorResource;
use App\Http\Responses\Sector\{
    SingleSectorResponse,
    SectorCollectionResponse
};
use App\Http\Requests\Sector\FindSectorByTypeRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(/* FindSectorByTypeRequest */ Request $request) : SectorCollectionResponse | LengthAwarePaginator
    {
        /* $type = $request->validated('type'); */
        $collection = $request->has('type')
            ? Sector::query()->where('type', $request->type)->with(['sector', 'specialities', 'supportedMemories'])->orderBy('created_at', 'desc')->paginate(perPage : 20)
            : Sector::query()->with(['sector', 'specialities', 'supportedMemories'])->orderBy('created_at', 'desc')->paginate(perPage : 20);
        $message = !$request->has('type')
            ? "Liste des filières et spécialités"
            : ($request->has('type') && mb_strtolower($request->type) === mb_strtolower('Filière') ? "Liste des filières" : "Liste des spécialités");
        return new SectorCollectionResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            total : Sector::count(),
            message : $message,
            collection : $collection,
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectorRequest $request) : SingleSectorResponse
    {
        $sector = Sector::create($request->all());
        return new SingleSectorResponse(
            statusCode : 201,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
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
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : $sector->sector_id !== NULL
                ? "Informations sur la spécialité $sector->name"
                : "Informations sur la filière $sector->name",
            resource : new SectorResource(resource : Sector::query()->with(['sector', 'specialities', 'supportedMemories'])->where('id', $sector->id)->first())
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SectorRequest $request, Sector $sector) : SingleSectorResponse
    {
        $sector->update($request->all());
        return new SingleSectorResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : $sector->sector_id !== NULL ? "La spécialité a été modifiée avec succès" : "La filière a été modifiée avec succès",
            resource : new SectorResource(resource : Sector::query()->with(['sector', 'specialities', 'supportedMemories'])->where('id', $sector->id)->first())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sector $sector) : JsonResponse
    {
        $message = $sector->sector_id !== NULL ? "La spécialité a été supprimée avec succès" : "La filière a été supprimée avec succès";
        $sector->delete();
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : ['message' => $message],
        );
    }
}
