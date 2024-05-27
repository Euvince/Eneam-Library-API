<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Comment::factory(200)->create()
            ->each(callback : function (\App\Models\Comment $comment) {
                $comment->update([
                    'user_id' => array_rand(\App\Models\User::pluck('matricule', 'id')->toArray(), 1),
                    'article_id' => array_rand(\App\Models\Article::pluck('cote', 'id')->toArray(), 1),
                ]);
            })
        ;
    }
}
