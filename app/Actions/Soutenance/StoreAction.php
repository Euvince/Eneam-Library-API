<?php

namespace App\Actions\Soutenance;

use App\Models\Cycle;
use App\Models\Soutenance;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Soutenance\SoutenanceResource;
use App\Http\Responses\Soutenance\SingleSoutenanceResponse;
use App\Models\SchoolYear;

class StoreAction
{
    public static function handle (array $data, Request $request) : JsonResponse | SingleSoutenanceResponse {
        /* $name = Cycle::find($request->cycle_id)->name." ".\Carbon\Carbon::parse($request->start_date)->year; */
        $name = Cycle::find($request->cycle_id)->name." ".SchoolYear::find($request->school_year_id)->school_year;
        if (Soutenance::where('name', $name)->count() > 0) {
            return response()->json(
                status : 422,
                data : ['errors' => "Cette soutenance existe déjà"]
            );
        }
        $soutenance = Soutenance::create($data);
        return new SingleSoutenanceResponse(
            statusCode : 201,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "La soutenance a été créée avec succès",
            resource : new SoutenanceResource(resource : Soutenance::query()->with(['cycle', 'supportedMemories'])->where('id', $soutenance->id)->first())
        );
    }
}
