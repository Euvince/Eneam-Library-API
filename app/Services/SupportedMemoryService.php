<?php

namespace App\Services;

use App\Models\SupportedMemory;

class SupportedMemoryService
{

    // Méthode pour récupérer les statistiques mensuelles
    public static function getMonthlyStatistics()
    {
        return SupportedMemory::selectRaw('MONTH(created_at) as month, status, COUNT(*) as count')
                ->groupBy('month', 'status')
                ->get();
    }

}
