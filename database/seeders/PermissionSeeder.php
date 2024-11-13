<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'view_dashboard', 'guard_name' => 'web'],
            ['name' => 'view_tdscode', 'guard_name' => 'web'],
            ['name' => 'add_tdscode', 'guard_name' => 'web'],
            ['name' => 'delete_tdscode', 'guard_name' => 'web'],
            ['name' => 'view_lettercontent', 'guard_name' => 'web'],
            ['name' => 'update_lettercontent', 'guard_name' => 'web'],
            ['name' => 'view_users', 'guard_name' => 'web'],
            ['name' => 'add_user', 'guard_name' => 'web'],
            ['name' => 'edit_user', 'guard_name' => 'web'],
            ['name' => 'delete_user', 'guard_name' => 'web'],
            ['name' => 'view_clients', 'guard_name' => 'web'],
            ['name' => 'add_client', 'guard_name' => 'web'],
            ['name' => 'edit_client', 'guard_name' => 'web'],
            ['name' => 'delete_client', 'guard_name' => 'web'],
            ['name' => 'export_client', 'guard_name' => 'web'],
            ['name' => 'view_candidate', 'guard_name' => 'web'],
            ['name' => 'add_candidate', 'guard_name' => 'web'],
            ['name' => 'edit_candidate', 'guard_name' => 'web'],
            ['name' => 'delete_candidate', 'guard_name' => 'web'],
        ];
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
