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
            ? Sector::query()->where('type', $request->type)->with(['sector'/* , 'specialities', 'supportedMemories' */])->orderBy('created_at', 'desc')->paginate(perPage : 20)
            : Sector::query()->with(['sector'/* , 'specialities', 'supportedMemories' */])->orderBy('created_at', 'desc')->paginate(perPage : 20);
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
            resource : new SectorResource(resource : Sector::query()->with(['sector'/* , 'specialities', 'supportedMemories' */])->where('id', $sector->id)->first())
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
            resource : new SectorResource(resource : Sector::query()->with(['sector'/* , 'specialities', 'supportedMemories' */])->where('id', $sector->id)->first())
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
            resource : new SectorResource(resource : Sector::query()->with(['sector'/* , 'specialities', 'supportedMemories' */])->where('id', $sector->id)->first())
        );
    }


    /**
     * Check if the specified resource has any children.
    */
    public function checkChildrens (Sector $sector) : JsonResponse
    {
        $specialitiesCount = $sector->specialities()->count();
        $supportedMemoriesCount = $sector->supportedMemories()->count();
        $hasChildrens = ($supportedMemoriesCount > 0 || $specialitiesCount > 0) ? true : false;
        $message = $hasChildrens === true
            ? "Attention, cette filière est relié à certaines données, souhaitez vous-vraiment la supprimer ?"
            : "Voulez-vous vraiment supprimer cette filière ?, attention, cette action est irréversible.";

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

     /**
     * Remove many specified resources from storage
     *
     * @param SectorRequest $request
     * @return JsonResponse
     */
    public function destroySectors (SectorRequest $request) : JsonResponse
    {
        $ids = $request->validated('ids');
        array_map(function (int $id) {
            Sector::find($id)->delete();
        }, $ids);
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : [
                'message' => count($ids) > 1
                    ? "Les filières/spécialités ont été supprimées avec succès"
                    : "La filière/spécialité a été supprimée avec succès"
            ],
        );
    }

}
