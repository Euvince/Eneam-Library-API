<?php

namespace App\Http\Controllers\API\Statistics;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Statistic;
use App\Models\SupportedMemory;
use App\Services\ArticleService;
use App\Services\SupportedMemoryService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\JsonResponse;

class StatisticsController extends Controller
{
    public function __invoke(Request $request) : JsonResponse
    {
        $months = collect();
        for ($i = 1; $i < 6; $i++) {
            $months->push(Carbon::now()->subMonths($i)->format('F Y'));
        }
        $reversedMonths = $months->reverse();
        // dd($reversedMonths);
        // dd(Carbon::parse(explode(' ', $reversedMonths[0])[0])->month);
        // dd((int)explode(' ', $reversedMonths[0])[1]);

        $managersNumber = User::query()
            ->whereHas(relation : 'roles', callback : function (Builder $query) {
                $query->where('name', "Gestionnaire");
            })
            ->count();

        $teachersNumber = User::query()
            ->whereHas(relation : 'roles', callback : function (Builder $query) {
                $query->where('name', "Enseignant");
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

        $ebooksCount = Article::query()->where('has_ebooks', 1)->count();
        $physicalBooksCount = Article::query()->where('is_physical', 1)->count();

        $memoriesMonthlyStats = SupportedMemoryService::getMemoriesMonthlyStatistics();
        $data1 = [];
        foreach ($memoriesMonthlyStats as $stat) {
            $month = Carbon::create()->month($stat['month'])->translatedFormat('F');
            $status = $stat['status'];
            $count = $stat['count'];

            $data1[$month][$status] = $count;
        }

        $ebooksMonthlyStats = ArticleService::getEBooksMonthlyStatistics();
        $data2 = [];
        foreach ($ebooksMonthlyStats as $stat) {
            $month = Carbon::create()->month($stat['month'])->translatedFormat('F');
            $has_ebooks = $stat['has_ebooks'] === 1 ? 'Ebook' : '';
            $count = $stat['count'];

            $data2[$month][$has_ebooks] = $count;
        }

        $physicalBooksMonthlyStats = ArticleService::getPhysicalBooksMonthlyStatistics();
        $data3 = [];
        foreach ($physicalBooksMonthlyStats as $stat) {
            $month = Carbon::create()->month($stat['month'])->translatedFormat('F');
            $is_physical = $stat['is_physical'] === 1 ? 'Physique' : 0;
            $count = $stat['count'];

            $data3[$month][$is_physical] = $count;
        }

        /* $reversedMonthlyStats = Statistic::orderBy('id', 'desc')->limit(12)->get()->reverse(); */

        $monthlyStats = Statistic::orderBy('id', 'desc')->limit(12)->get()->toArray();
        $reversedMonthlyStats = array_reverse($monthlyStats);

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
                'physicalBooksCount' => $physicalBooksCount,

                /* 'memoriesMonthlyStats' => $data1,
                'ebooksMonthlyStats' => $data2,
                'physicalMonthlyStats' => $data3, */

                'monthlyStats' => $reversedMonthlyStats
            ],
        );
    }

}
