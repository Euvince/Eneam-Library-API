<?php

namespace App\Actions\Soutenance;

use App\Models\Cycle;
use App\Models\Soutenance;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Soutenance\SoutenanceResource;
use App\Responses\Soutenance\SingleSoutenanceResponse;

class StoreAction
{
    public static function handle (array $data, Request $request) : JsonResponse | SingleSoutenanceResponse {
        $name = Cycle::find($request->cycle_id)->name . $request->year;
        if (Soutenance::where('name', $name)->count() > 0) {
            return response()->json(
                status : 422,
                data : ['errors' => "Cette soutenance existe déjà"]
            );
        }
        $soutenance = Soutenance::create($data);
        return new SingleSoutenanceResponse(
            statusCode : 201,
            allowValue : 'POST',
            message : "La soutenance a été créee avec succès",
            resource : new SoutenanceResource(resource : Soutenance::query()->with(['cycle'])->where('id', $soutenance->id)->first())
        );
    }
}
