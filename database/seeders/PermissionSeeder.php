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
            ['name' => 'fhrms', 'guard_name' => 'web'],
            ['name' => 'add_fhrms', 'guard_name' => 'web'],
            ['name' => 'edit_fhrms', 'guard_name' => 'web'],
            ['name' => 'delete_fhrms', 'guard_name' => 'web'],
            ['name' => 'fhrms_report', 'guard_name' => 'web'],
            ['name' => 'ffi_offer_letter', 'guard_name' => 'web'],
            ['name' => 'add_ffi_offer_letter', 'guard_name' => 'web'],
            ['name' => 'delete_ffi_offer_letter', 'guard_name' => 'web'],
            ['name' => 'ffi_increment_letter', 'guard_name' => 'web'],
            ['name' => 'add_ffi_increment_letter', 'guard_name' => 'web'],
            ['name' => 'delete_ffi_increment_letter', 'guard_name' => 'web'],
            ['name' => 'ffi_payslip', 'guard_name' => 'web'],
            ['name' => 'add_ffi_payslip', 'guard_name' => 'web'],
            ['name' => 'delete_ffi_payslip', 'guard_name' => 'web'],
            ['name' => 'ffi_pip_letter', 'guard_name' => 'web'],
            ['name' => 'add_ffi_pip_letter', 'guard_name' => 'web'],
            ['name' => 'delete_ffi_pip_letter', 'guard_name' => 'web'],
            ['name' => 'ffi_termination', 'guard_name' => 'web'],
            ['name' => 'add_ffi_termination', 'guard_name' => 'web'],
            ['name' => 'delete_ffi_termination', 'guard_name' => 'web'],
            ['name' => 'ffi_warning', 'guard_name' => 'web'],
            ['name' => 'add_ffi_warning', 'guard_name' => 'web'],
            ['name' => 'delete_ffi_warning', 'guard_name' => 'web'],
            ['name' => 'birthday_details', 'guard_name' => 'web'],
            ['name' => 'invoices', 'guard_name' => 'web'],
            ['name' => 'add_invoice', 'guard_name' => 'web'],
            ['name' => 'edit_invoice', 'guard_name' => 'web'],
            ['name' => 'delete_invoice', 'guard_name' => 'web'],
            ['name' => 'invoice_report', 'guard_name' => 'web'],
            ['name' => 'receivables', 'guard_name' => 'web'],
            ['name' => 'add_receivables', 'guard_name' => 'web'],
            ['name' => 'delete_receivables', 'guard_name' => 'web'],
            ['name' => 'tds_report', 'guard_name' => 'web'],
            ['name' => 'ffcm', 'guard_name' => 'web'],
            ['name' => 'add_ffcm', 'guard_name' => 'web'],
            ['name' => 'edit_ffcm', 'guard_name' => 'web'],
            ['name' => 'delete_ffcm', 'guard_name' => 'web'],
            ['name' => 'ffcm_report', 'guard_name' => 'web'],
            ['name' => 'ffi_assets', 'guard_name' => 'web'],
            ['name' => 'add_ffi_asset', 'guard_name' => 'web'],
            ['name' => 'edit_ffi_asset', 'guard_name' => 'web'],
            ['name' => 'delete_ffi_asset', 'guard_name' => 'web'],
        ];
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
