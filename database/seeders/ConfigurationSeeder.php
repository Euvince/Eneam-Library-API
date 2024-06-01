<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Configuration::create([
            'school_name' => "École Nationnale d'Économie Appliquée et de Management",
            'school_acronym' => "ENEAM",
            'school_city' => "Cotonou",
            'eneamien_subscribe_amount' => 500,
            'extern_subscribe_amount' => 1000,
            'subscription_expiration_delay' => 1,
            'student_debt_amount' => 500,
            'teacher_debt_amount' => 1000,
            'student_loan_delay' => 14,
            'teacher_loan_delay' => 30,
            'max_books_per_student' => 2,
            'max_books_per_teacher' => 2,
            'student_renewals_number' => 1,
            'teacher_renewals_number' => 1,
            'max_copies_books_per_student' => 1,
            'max_copies_books_per_teacher' => 1,
            'created_by' => "APPLICATION",
        ]);
    }
}
