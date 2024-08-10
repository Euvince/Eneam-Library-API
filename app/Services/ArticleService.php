<?php

namespace App\Services;

use App\Models\Article;

class ArticleService
{

    // Méthode pour récupérer les statistiques mensuelles des ebooks
    public static function getEBooksMonthlyStatistics()
    {
        $startDate = now()->subMonths(6)->endOfMonth();
        $endDate = now()->endOfMonth();

        return Article::whereBetween('created_at', [$startDate, $endDate])
                   ->where('has_ebooks', 1)
                   ->selectRaw('MONTH(created_at) as month, has_ebooks, COUNT(*) as count')
                   ->groupBy('month', 'has_ebooks')
                   ->orderBy('month')
                   ->get();
    }

    // Méthode pour récupérer les statistiques mensuelles des livres physiques
    public static function getPhysicalBooksMonthlyStatistics()
    {
        $startDate = now()->subMonths(6)->endOfMonth();
        $endDate = now()->endOfMonth();

        return Article::whereBetween('created_at', [$startDate, $endDate])
                   ->where('is_physical', 1)
                   ->selectRaw('MONTH(created_at) as month, is_physical, COUNT(*) as count')
                   ->groupBy('month', 'is_physical')
                   ->orderBy('month')
                   ->get();
    }

}
