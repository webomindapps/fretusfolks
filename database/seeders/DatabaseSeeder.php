<?php

namespace Database\Seeders;

use App\Models\MuserMaster;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $roles = ['Admin', 'Finance', 'HR Operations', 'Compliance', 'Recruitment', 'Sales'];

        foreach ($roles as $role) {
            Role::insertOrIgnore([
                'name' => $role,
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $user = MuserMaster::create([
            'name' => 'Super Admin',
            'username' => 'Super Admin',
            'emp_id' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password'),
            'enc_pass' => Hash::make('password'),
            'user_type' => 1,
            'status' => 0,
            'date' => date('Y-m-d'),
            'ref_no' => "1",
        ]);
        $user->assignRole('Admin');
        $this->call([PermissionSeeder::class]);
    }
}
