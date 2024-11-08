<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $roles = ['Admin', 'Finance', 'Hroperations', 'Compliance', 'Recruitment', 'Sales'];

        foreach ($roles as $role) {
            DB::table('roles')->insertOrIgnore([
                'name' => $role,
                'guard_name'=>'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        User::create([
            'name' => ' Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password')
        ]);

    }
}
