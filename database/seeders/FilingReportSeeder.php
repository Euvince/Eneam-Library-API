<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilingReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\FilingReport::factory(30)
            ->create()
            ->each(callback : function (\App\Models\FilingReport $filingReport) {
                $filingReport->update([
                    'supported_memory_id' => array_rand(\App\Models\SupportedMemory::pluck('cote', 'id')->toArray(), 1),
                ]);
            })
        ;
    }
}
