<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignPermissionsToRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // 1.  Patient seed

        $user = User::create([
            'name' => 'Patient',
            'first_name' => 'Patient',
            'last_name' => 'doe',
            'user_name' => 'patient',
            'email' => 'patient@patient.com',
            'password' => bcrypt('123456')
        ]);

        $role = Role::where('name', 'patient')->first();
        $permissions = Permission::whereIn('name', [
            'show-patient-list',
            'add-new-patient',
            'update-patient-info',
            'delete-patient-info',
        ])->pluck('id');
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);



        // 2. Therapist seed

        $user = User::create([
            'name' => 'Therapist',
            'first_name' => 'Therapist',
            'last_name' => 'doe',
            'user_name' => 'therapist',
            'email' => 'therapist@therapist.com',
            'password' => bcrypt('123456')
        ]);

        $role = Role::where('name', 'therapist')->first();
        $permissions = Permission::whereIn('name', [
            'show-therapist-list',
            'add-new-therapist',
            'update-therapist',
            'delete-therapist'
        ])->pluck('id');
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);


        // 3. Screener seed

        $user = User::create([
            'name' => 'Screener',
            'first_name' => 'Screener',
            'last_name' => 'doe',
            'user_name' => 'screener',
            'email' => 'screener@screener.com',
            'password' => bcrypt('123456')
        ]);

        $role = Role::where('name', 'screener')->first();
        $permissions = Permission::whereIn('name', [
            'show-screener-list',
            'update-screener',
            'delete-screener'
        ])->pluck('id');
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);


        // 4. Heralmelding seed

        // $user = User::create([
        //     'name' => 'Heralmelding',
        //     'first_name' => 'Heralmelding',
        //     'last_name' => 'doe',
        //     'user_name' => 'heralmelding',
        //     'email' => 'heralmelding@heralmelding.com',
        //     'password' => bcrypt('123456')
        // ]);

        // $role = Role::where('name', 'heralmelding')->first();
        // $permissions = Permission::whereIn('name', [
        //     'show-heralmelding-list',
        //     'update-heralmelding',
        //     'delete-heralmelding',
        // ])->pluck('id');
        // $role->syncPermissions($permissions);
        // $user->assignRole([$role->id]);



        // 5. Pib seed

        $user = User::create([
            'name' => 'Pib',
            'first_name' => 'Pib',
            'last_name' => 'doe',
            'user_name' => 'pib',
            'email' => 'pib@pib.com',
            'password' => bcrypt('123456')
        ]);

        $role = Role::where('name', 'pib')->first();
        $permissions = Permission::whereIn('name', [
            'show-pib-list',
            'update-pib',
            'delete-pib',
        ])->pluck('id');
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);



        // 6. Pit seed

        $user = User::create([
            'name' => 'Pit',
            'first_name' => 'Pit',
            'last_name' => 'doe',
            'user_name' => 'pit',
            'email' => 'pit@pit.com',
            'password' => bcrypt('123456')
        ]);

        $role = Role::where('name', 'pit')->first();
        $permissions = Permission::whereIn('name', [
            'show-pit-list',
            'update-pit',
            'delete-pit',
        ])->pluck('id');
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);




        // 7. Yes approval seed

        $user = User::create([
            'name' => 'Yesapproval',
            'first_name' => 'Yesapproval',
            'last_name' => 'doe',
            'user_name' => 'yesapproval',
            'email' => 'yesapproval@yesapproval.com',
            'password' => bcrypt('123456')
        ]);

        $role = Role::where('name', 'yes approval')->first();
        $permissions = Permission::whereIn('name', [
            'show-yes-approval-list',
            'update-yes-approval',
            'delete-yes-approval',
        ])->pluck('id');
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);


        // 8. No approval seed

        $user = User::create([
            'name' => 'Noapproval',
            'first_name' => 'Noapproval',
            'last_name' => 'doe',
            'user_name' => 'noapproval',
            'email' => 'noapproval@noapproval.com',
            'password' => bcrypt('123456')
        ]);

        $role = Role::where('name', 'no approval')->first();
        $permissions = Permission::whereIn('name', [
            'show-no-approval-list',
            'update-no-approval',
            'delete-no-approval',
        ])->pluck('id');
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);



        // 8. Heralmelding seed

        $user = User::create([
            'name' => 'Heralmelding',
            'first_name' => 'Heralmelding',
            'last_name' => 'doe',
            'user_name' => 'heralmelding',
            'email' => 'heralmelding@heralmelding.com',
            'password' => bcrypt('123456')
        ]);

        $role = Role::where('name', 'heralmelding')->first();
        $permissions = Permission::whereIn('name', [
            'show-heralmelding-list',
            'update-heralmelding',
            'delete-heralmelding',
        ])->pluck('id');
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);



        // 9. Appointment seed

        $user = User::create([
            'name' => 'Appointment',
            'first_name' => 'Appointment',
            'last_name' => 'doe',
            'user_name' => 'appointment',
            'email' => 'appointment@appointment.com',
            'password' => bcrypt('123456')
        ]);

        $role = Role::where('name', 'appointment')->first();
        $permissions = Permission::whereIn('name', [
            'create-appointment',
            'show-appointment-group-list',
            'update-appointment-group',
            'delete-appointment-group',
        ])->pluck('id');
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);


        // 10. VTCB

        $user = User::create([
            'name' => 'Vtcb',
            'first_name' => 'Vtcb',
            'last_name' => 'doe',
            'user_name' => 'vtcb',
            'email' => 'vtcb@vtcb.com',
            'password' => bcrypt('123456')
        ]);

        $role = Role::where('name', 'vtcb')->first();
        $permissions = Permission::whereIn('name', [
            'show-vtcb-list',
            'update-vtcb',
            'delete-vtcb',
        ])->pluck('id');
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
