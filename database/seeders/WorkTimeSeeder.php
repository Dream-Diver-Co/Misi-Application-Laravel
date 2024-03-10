<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WorkDayTime;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class WorkTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 3; $i++) {
            WorkDayTime::create([
                'therapist_id' => $i + 1,
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
                'weekly_holidays' => '["6","0"]'
            ]);
        }
    }
}
