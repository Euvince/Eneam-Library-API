<?php

namespace App\Actions\Soutenance;

use App\Models\Cycle;
use App\Models\Soutenance;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Soutenance\SoutenanceResource;
use App\Http\Responses\Soutenance\SingleSoutenanceResponse;

class UpdateAction
{
    public static function handle (array $data, Request $request, Soutenance $soutenance) : JsonResponse | SingleSoutenanceResponse {
        $name = Cycle::find($request->cycle_id)->name." ".\Carbon\Carbon::parse($request->start_date)->year;
        if (Soutenance::where([
            ['name', $name], ['id', '!=', $request->route()->parameter(name : 'soutenance')['id']]
        ])->count() > 0) {
            return response()->json(
                status : 422,
                data : ['errors' => "Cette soutenance existe déjà"]
            );
        }
        $soutenance->update($data);
        return new SingleSoutenanceResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "La soutenance a été modifiée avec succès",
            resource : new SoutenanceResource(resource : Soutenance::query()->with(['cycle', 'supportedMemories'])->where('id', $soutenance->id)->first())
        );
    }
}
