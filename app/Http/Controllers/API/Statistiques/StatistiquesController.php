<?php

namespace App\Http\Controllers\API\Statistiques;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\SupportedMemory;
use App\Services\SupportedMemoryService;
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

        $teachersNumber = User::query()
            ->whereHas(relation : 'roles', callback : function (Builder $query) {
                $query->where('name', "Enseignants");
            })
            ->count();

        $eneamiensNumber = User::query()
            ->whereHas(relation : 'roles', callback : function (Builder $query) {
                $query->where('name', "Etudiant-Eneamien");
            })
            ->count();

        $externesNumber = User::query()
            ->whereHas(relation : 'roles', callback : function (Builder $query) {
                $query->where('name', "Etudiant-Externe");
            })
            ->count();

        $validMemoriesCount = SupportedMemory::query()->where('status', 'Validé')->count();
        $invalidMemoriesCount = SupportedMemory::query()->where('status', 'Invalidé')->count();

        $ebooksCount = SupportedMemory::query()->where('has_ebooks', 1)->count();
        $phyicalBooksCount = SupportedMemory::query()->where('is_physical', 1)->count();

        /* dd(SupportedMemoryService::getMonthlyStatistics()); */

        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET'],
            data : [
                'message' => "Statistiques globales de l'application",
                'usersCount' => User::count(),
                'managersNumber' => $managersNumber,
                'teachersNumber' => $teachersNumber,
                'eneamiensNumber' => $eneamiensNumber,
                'externesNumber' => $externesNumber,

                'memoriesCount' => SupportedMemory::count(),
                'validMemoriesCount' => $validMemoriesCount,
                'invalidMemoriesCount' => $invalidMemoriesCount,

                'booksCount' => Article::count(),
                'ebooksCount' => $ebooksCount,
                'phyicalBooksCount' => $phyicalBooksCount,
            ],
        );
    }

}
