<?php

use App\Http\Controllers\Admin\DCSApprovalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CDMSController;
use App\Http\Controllers\Admin\CFISController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\TdsCodeController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\Admin\CDMSReportController;
use App\Http\Controllers\Admin\LetterContentController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate']);

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');

        //ffi UserMasters
        Route::get('/usermasters', [UserController::class, 'index'])->name('usermasters');
        Route::get('usermasters/create', [UserController::class, 'create'])->name('usermasters.create');
        Route::post('usermasters/create', [UserController::class, 'store']);
        Route::post('usermasters/bulkupdate', [UserController::class, 'bulk'])->name('usermasters.bulk');
        Route::get('usermasters/{id}/edit', [UserController::class, 'edit'])->name('usermasters.edit');
        Route::post('usermasters/{id}/edit', [UserController::class, 'update']);
        Route::get('usermasters/{id}/delete', [UserController::class, 'delete'])->name('usermasters.delete');


        //tds_code
        Route::get('/tds_code', [TdsCodeController::class, 'index'])->name('tds_code');
        Route::post('/tds_code/store', [TdsCodeController::class, 'store'])->name('tds_code.store');
        Route::post('/tds_code/bulk_operation', [TdsCodeController::class, 'bulk'])->name('tds_code.bulk');
        Route::get('tds_code/{id}/delete', [TdsCodeController::class, 'destroy'])->name('tds_code.delete');
        Route::get('tds_code/status/{id}', [TdsCodeController::class, 'toggleStatus'])->name('tds_code.status');
        Route::get('tds_code/update_code/{id}', [TdsCodeController::class, 'updateCode'])->name('tds_code.update_code');


        //letter_content
        Route::get('/letter_content', [LetterContentController::class, 'index'])->name('letter_content');
        Route::get('letter_content/create', [LetterContentController::class, 'create'])->name('letter_content.create');
        Route::post('letter_content/create', [LetterContentController::class, 'store']);
        Route::get('letter_content/{id}/edit', [LetterContentController::class, 'edit'])->name('letter_content.edit');
        Route::post('letter_content/{id}/edit', [LetterContentController::class, 'update']);
        Route::post('letter_content/bulk_operation', [LetterContentController::class, 'bulk'])->name('letter_content.bulk');

        //cdms
        Route::get('/cdms', [CDMSController::class, 'index'])->name('cdms');
        Route::get('cdms/create', [CDMSController::class, 'create'])->name('cdms.create');
        Route::post('cdms/create', [CDMSController::class, 'store']);
        Route::get('cdms/{id}/edit', [CDMSController::class, 'edit'])->name('cdms.edit');
        Route::post('cdms/{id}/edit', [CDMSController::class, 'update']);
        Route::post('cdms/bulk_operation', [CDMSController::class, 'bulk'])->name('cdms.bulk');
        Route::get('cdms/{id}/delete', [CDMSController::class, 'destroy'])->name('cdms.delete');
        Route::get('cdms/show/{id}', [CDMSController::class, 'show'])->name('cdms.show');
        Route::post('cdms/gststore/{id}', [CDMSController::class, 'gststore'])->name('cdms.gststore');
        Route::get('cdms/update_gst/{id}', [CDMSController::class, 'updateGst'])->name('cdms.update_gst');
        Route::get('cdms/update_state/{id}', [CDMSController::class, 'updateState'])->name('cdms.updateState');
        Route::get('cdms/{id}/gstdelete', [CDMSController::class, 'gstdestroy'])->name('cdms.gstdelete');
        Route::post('cdms/export', [CDMSController::class, 'export'])->name('cdms.export');
        Route::get('cdms/cdms_report', [CDMSController::class, 'showCodeReport'])->name('cdms_report.get');
        Route::post('cdms/cdms_report', [CDMSController::class, 'codeReport'])->name('cdms_report');
        Route::post('cdms/cdms_report/export', [CDMSController::class, 'exportReport'])->name('cdms_report.export');

        // roles
        Route::get('/roles', [RolePermissionController::class, 'index'])->name('roles');
        Route::get('/role/{id}/permissions', [RolePermissionController::class, 'permission'])->name('permission');
        Route::post('/role/{id}/permissions', [RolePermissionController::class, 'assignPermission']);

        //cfis
        Route::get('/cfis', [CFISController::class, 'index'])->name('cfis');
        Route::get('cfis/create', [CFISController::class, 'create'])->name('cfis.create');
        Route::post('cfis/create', [CFISController::class, 'store']);
        Route::post('cfis/bulk_operation', [CFISController::class, 'bulk'])->name('cfis.bulk');
        Route::get('cfis/{id}/delete', [CFISController::class, 'destroy'])->name('cfis.delete');
        Route::post('cfis/export', [CFISController::class, 'export'])->name('cfis.export');
        Route::get('cfis/status/{id}', [CFISController::class, 'toggleStatus'])->name('cfis.status');
        Route::get('cfis/data_status/{id}', [CFISController::class, 'toggleData_status'])->name('cfis.data_status');

        //dcs_approval
        Route::get('/dcs_approval', [DCSApprovalController::class, 'index'])->name('dcs_approval');
        Route::get('dcs_approval/{id}/edit', [DCSApprovalController::class, 'edit'])->name('dcs_approval.edit');
        Route::post('dcs_approval/{id}/edit', [DCSApprovalController::class, 'update']);
        Route::get('dcs_approval/{id}/delete', [DCSApprovalController::class, 'destroy'])->name('dcs_approval.delete');

    });
});
