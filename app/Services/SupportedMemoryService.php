<?php

namespace App\Services;

use App\Models\SupportedMemory;

class SupportedMemoryService
{

    // Méthode pour récupérer les statistiques mensuelles
    public static function getMonthlyStatistics()
    {
        $startDate = now()->subMonths(6)->endOfMonth();
        $endDate = now()->endOfMonth();

        return SupportedMemory::whereBetween('created_at', [$startDate, $endDate])
                   ->selectRaw('MONTH(created_at) as month, status, COUNT(*) as count')
                   ->groupBy('month', 'status')
                   ->orderBy('month')
                   ->get();
    }

}
