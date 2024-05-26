<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Database\Seeders\ConfigurationSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\Cycle::factory()->count(3)->create()->each(callback : function (\App\Models\Cycle $cycle) {
            \App\Models\Soutenance::factory()->count(30)->each(callback : function (\App\Models\Soutenance $soutenance) use($cycle) {
                $soutenance->cycle_id = $cycle->id;
                $soutenance->name = $cycle->name . $soutenance->year;
                $soutenance->cycle_id = \Illuminate\Support\Str::slug($soutenance->name);
            });
        });

        $this->call(ConfigurationSeeder::class);


        /* $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);

        \App\Models\User::factory()->create([
            'nom' => 'Doe',
            'prenoms' => 'Jonh',
            'email' => 'jonh@doe.fr',
            'password' => Hash::make('jonhdoefr'),
        ])->assignRole([Role::all()])->permissions()->sync(Permission::all());

        \App\Models\User::factory()->create([
            'nom' => 'Lawson',
            'prenoms' => 'Tony',
            'email' => 'tony@lawson.fr',
            'password' => Hash::make('tonylawson'),
        ])->assignRole(['Administrateur']);

        \App\Models\User::factory()->create([
            'nom' => 'Lossin',
            'prenoms' => 'lobert',
            'email' => 'lossin@lobert.fr',
            'password' => Hash::make('lossinlobert'),
        ])->assignRole(['Gestionnaire-Standard']);

        \App\Models\User::factory()->create([
            'nom' => 'Jackson',
            'prenoms' => 'jinard',
            'email' => 'jin@jack.fr',
            'password' => Hash::make('jackjinard'),
        ])->assignRole(['Gestionnaire-Central']); */
    }
}
