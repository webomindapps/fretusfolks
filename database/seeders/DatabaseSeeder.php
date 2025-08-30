<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\MuserMaster;

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
        DB::table('muser_master')->insert([
            'emp_id'=>'Super Admin',
            'name' => ' Super Admin',
            'username' => 'Admin',
            'email' => 'admin@example.com',
            'enc_pass' => Hash::make('password'),
            'user_type'=>1,
            'date'=>date('Y-m-d'),
            'ref_no'=>1,
            'status'=>0,
            'password' => Hash::make('password')
        ]);
        $user = MuserMaster::where('email', 'admin@example.com')->first();
        if ($user) {
            $user->assignRole('Admin');
        }
        $this->call([PermissionSeeder::class]);
    }
}
