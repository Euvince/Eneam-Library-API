<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;

class MarkArticleAsAvailable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mark-article-as-available';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "
        Cette tâche se chargera de marquer tous les articles
        dont le stock disponible est supérieur à 0 comme disponible
    ";

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        $availablesArticles = Article::where('available_stock', '>', '0')->get();

        foreach ($availablesArticles as $article) {
            if (!Article::isAvailable($article)) {
                $article->update([
                    'available' => true
                ]);
            }
        }
    }
}
