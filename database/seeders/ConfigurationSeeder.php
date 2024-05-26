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
            'eneamien_subscribe_rising' => 500,
            'extern_subscribe_rising' => 1000,
            'subscription_expiration_delay' => 1,
            'student_debt_price' => 500,
            'teacher_debt_price' => 1000,
            'student_loan_delay' => 14,
            'teacher_loan_delay' => 30,
            'student_renewals_number' => 1,
            'teacher_renewals_number' => 1,
            'max_number_books_borrowed_student' => 2,
            'max_number_books_borrowed_teacher' => 2,
            'created_by' => "APPLICATION",
        ]);
    }
}
