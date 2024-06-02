<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Loan::factory(35)
            ->create()
            ->each(callback : function (\App\Models\Loan $loan) {
                $user = \App\Models\User::all()->random(rand(min : 1, max : 1));
                $loan->user_id = $user;
                $articles = \App\Models\Article::all()->random(rand(1, 2));
                foreach ($articles as $article) {
                    $loan->articles()->sync(
                        ids : [
                            $article->id => [
                                'quantity' => \App\Models\Configuration::appConfig()->max_copies_books_per_student
                            ]
                        ]
                    );
                }
            })
        ;
    }
}
