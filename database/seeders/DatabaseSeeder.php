<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionTableSeeder::class,
            CreateAdminUserSeeder::class,
            CreateRoleSeeder::class,
            AssignPermissionsToRolesSeeder::class,
        ]);
        \App\Models\User::factory(1000)->create();
        \App\Models\Patient::factory(500)->create();
        \App\Models\Therapist::factory(50)->create();
        \App\Models\Ticket::factory(25)->create();
        $this->call([
            WorkTimeSeeder::class
        ]);
        $this->call([
            EmailTemplateSeeder::class
        ]);
    }
}
