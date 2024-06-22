<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class CreateSchoolYear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-school-year';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "
        Cette tâche se chargera de créer
        dynamiquement une année scolaire chaque fois
        qu'une année scolaire se terminera
    ";

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        $startDate = Carbon::parse(Carbon::now()->format(format : "Y-m-d"))->year."-09-".rand(1, 30);
        $endDate = Carbon::parse($startDate)->addMonths(value : 10);

        \App\Models\SchoolYear::create([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'school_year' => Carbon::parse($startDate)->year."-".Carbon::parse($endDate)->year,
        ]);
    }
}
