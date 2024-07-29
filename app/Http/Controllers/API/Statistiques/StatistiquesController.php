<?php

namespace App\Http\Controllers\API\Statistiques;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\JsonResponse;

class StatistiquesController extends Controller
{
    public function __invoke(Request $request) : JsonResponse
    {
        $managersNumber = User::query()
            ->whereHas(relation : 'roles', callback : function (Builder $query) {
                $query->where('name', "Gestionnaire");
            })
            ->count();

        $users = [
            'managers' =>$managersNumber
        ];

        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET'],
            data : ['message' => "Statistiques globales de l'application",],
        );
    }

    private static function example () {

    }

}
