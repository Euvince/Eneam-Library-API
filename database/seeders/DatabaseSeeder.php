<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /* \App\Models\User::factory(10)->create(); */

        \App\Models\Cycle::factory()->count(3)->create()->each(callback : function (\App\Models\Cycle $cycle) {
            \App\Models\Soutenance::factory()->count(30)->create()->each(callback : function (\App\Models\Soutenance $soutenance) use($cycle) {
                $soutenance->cycle_id = $cycle->id;
                $soutenance->name = $cycle->name . $soutenance->year;
                $soutenance->slug = \Illuminate\Support\Str::slug($soutenance->name);
            });
        });

        $this->call(\Database\Seeders\SectorSeeder::class);
        $this->call(\Database\Seeders\ConfigurationSeeder::class);


        /* $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class); */

    }
}
