<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CreateRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'patient']);
        Role::create(['name' => 'therapist']);
        Role::create(['name' => 'screener']);
        // Role::create(['name' => 'heralmelding']);
        Role::create(['name' => 'pib']);
        Role::create(['name' => 'pit']);
        Role::create(['name' => 'yes approval']);
        Role::create(['name' => 'no approval']);
        Role::create(['name' => 'heranmelding']);
        Role::create(['name' => 'appointment']);
        Role::create(['name' => 'vtcb']);
    }
}
