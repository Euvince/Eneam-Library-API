<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;

class MarkArticleAsUnavailable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mark-article-as-unavailable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "
        Cette tâche se chargera de marquer tous les articles
        dont le stock disponible est de 0 comme indisponible
    ";

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        $unavailablesArticles = Article::where('available_stock', '0')->get();

        foreach ($unavailablesArticles as $article) {
            if (!Article::isAvailable($article)) {
                $article->update([
                    'available' => false
                ]);
            }
        }
    }
}
