<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Article::factory(50)->create()
            ->each(callback : fn (\App\Models\Article $article) => $article->update([
                    'school_year_id' => \App\Models\SchoolYear::all()->random(1)->first()['id']
                ])
            )
        ;
    }
}
