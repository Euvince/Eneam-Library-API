<?php

namespace App\Actions\Soutenance;

use App\Models\Cycle;
use App\Models\Soutenance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreAction
{
    public static function handle (array $data, Request $request) : JsonResponse | Soutenance {
        $name = Cycle::find($request->cycle_id)->name . $request->year;
        if (Soutenance::where('name', $name)->count() > 0) {
            return response()->json(
                status : 422,
                data : ['errors' => "Cette soutenance existe déjà"]
            );
        }
        return Soutenance::create($data);
    }
}
