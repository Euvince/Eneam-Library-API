<?php

namespace App\Console\Commands;

use App\Models\Article;
use Carbon\Carbon;
use App\Models\Statistic;
use App\Models\SupportedMemory;
use Illuminate\Console\Command;

class StoreMonthlyStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:store-monthly-statistics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "
        Cette tâche se charge d'enrégistrer les
        statistiques mensuelles à utiliser sur le Dashboard
    ";

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        $monthlyValues = self::monthlyValues();
        Statistic::create([
            'month' => ucfirst(Carbon::now()->translatedFormat('F')),
            'valid_memories_number' => $monthlyValues['validMemoriesPerMonthNumber'],
            'invalid_memories_number' => $monthlyValues['invalidMemoriesPerMonthNumber'],
            'ebooks_number' => $monthlyValues['ebooksPerMonthNumber'],
            'physical_books_number' => $monthlyValues['physicalBooksPerMonthNumber'],
        ]);
        $this->info('Statistiques mensuelles enregistrées avec succès.');
    }

    private static function monthlyValues() : array
    {
        $validMemoriesPerMonthNumber =
            SupportedMemory::where('status', 'Validé')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
        $invalidMemoriesPerMonthNumber =
            SupportedMemory::where('status', 'Invalidé')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $ebooksPerMonthNumber =
            Article::where('has_ebooks', 1)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $physicalBooksPerMonthNumber =
            Article::where('is_physical', 1)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        return [
            'validMemoriesPerMonthNumber' => $validMemoriesPerMonthNumber,
            'invalidMemoriesPerMonthNumber' => $invalidMemoriesPerMonthNumber,
            'ebooksPerMonthNumber' => $ebooksPerMonthNumber,
            'physicalBooksPerMonthNumber' => $physicalBooksPerMonthNumber,
        ];
    }
}
