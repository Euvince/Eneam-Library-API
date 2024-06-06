<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateConfiguration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-configuration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Cette tâche se chargera de créer la nouvelle configuration de chaque année";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lastSchoolYear = \App\Models\SchoolYear::latest()->first();
        $lastConfiguration = \App\Models\Configuration::latest()->first();
        $attributes = $lastConfiguration->getAttributes();
        array_diff_key($attributes, array_flip(['id', 'created_at', 'updated_at', 'year_id']));
        \App\Models\Configuration::create(array_merge($attributes, [
            'year_id' => $lastSchoolYear->id,
            'created_at' => \Carbon\Carbon::now()->format(format : "Y-m-d H:i:s"),
            'updated_at' => \Carbon\Carbon::now()->format(format : "Y-m-d H:i:s"),
        ]));
    }
}
