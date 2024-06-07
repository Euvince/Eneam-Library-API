<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeywordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Keyword::factory(25)
            ->create()
            ->each(callback : function (\App\Models\Keyword $keyword) {
                $user = \App\Models\User::all()->random(rand(min : 1, max : 1));
                $keyword->user_id = $user;
                $articles = \App\Models\Article::all()->random(rand(3, 5));
                foreach ($articles as $article) {
                    $keyword->articles()->sync(ids : [$article->id]);
                }
            })
        ;
    }
}
