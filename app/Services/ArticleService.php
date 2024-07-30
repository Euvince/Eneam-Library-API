<?php

namespace App\Services;

use App\Models\Article;

class ArticleService
{

    // Méthode pour récupérer les statistiques mensuelles
    public static function getMonthlyStatistics()
    {
        return Article::selectRaw('MONTH(created_at) as month, status, COUNT(*) as count')
                ->groupBy('month', 'status')
                ->get();
    }

}
