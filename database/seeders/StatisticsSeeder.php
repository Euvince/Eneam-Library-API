<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Article;
use App\Models\SupportedMemory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $months = collect();
        for ($i = 1; $i < 6; $i++) {
            $months->push(Carbon::now()->subMonths($i)->format('F Y'));
        }

        foreach($months->reverse() as $month) {
            $tab = explode(' ', $month);

            $validMemoriesPerMonthNumber =
                SupportedMemory::where('status', 'Validé')
                ->whereYear('created_at', (int)$tab[1])
                ->whereMonth('created_at', Carbon::parse($tab[0])->month)
                ->count();

            $invalidMemoriesPerMonthNumber =
                SupportedMemory::where('status', 'Invalidé')
                ->whereYear('created_at', (int)$tab[1])
                ->whereMonth('created_at', Carbon::parse($tab[0])->month)
                ->count();

            $ebooksPerMonthNumber =
                Article::where('has_ebooks', 1)
                ->whereYear('created_at', (int)$tab[1])
                ->whereMonth('created_at', Carbon::parse($tab[0])->month)
                ->count();

            $physicalBooksPerMonthNumber =
                Article::where('is_physical', 1)
                ->whereYear('created_at', (int)$tab[1])
                ->whereMonth('created_at', Carbon::parse($tab[0])->month)
                ->count();

            \App\Models\Statistic::create([
                'month' => ucfirst(Carbon::parse($tab[0])->locale('fr')->translatedFormat('F')),
                'valid_memories_number' => $validMemoriesPerMonthNumber,
                'invalid_memories_number' => $invalidMemoriesPerMonthNumber,
                'ebooks_number' => $ebooksPerMonthNumber,
                'physical_books_number' => $physicalBooksPerMonthNumber,
            ]);
        }
    }
}
