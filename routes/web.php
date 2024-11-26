<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CDMSController;
use App\Http\Controllers\Admin\CFISController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FHRMSController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\TdsCodeController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\Admin\CDMSReportController;
use App\Http\Controllers\Admin\CMSESICController;
use App\Http\Controllers\Admin\CMSFormTController;
use App\Http\Controllers\Admin\CMSLabourNoticeController;
use App\Http\Controllers\Admin\CMSPFController;
use App\Http\Controllers\Admin\CMSPTController;
use App\Http\Controllers\Admin\DCSApprovalController;
use App\Http\Controllers\Admin\LetterContentController;
use App\Http\Controllers\Admin\CMSLWFController;

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

        // CMS ESIC
        Route::get('/cms_esic', [CMSESICController::class, 'index'])->name('cms.esic');
        Route::get('/cms_esic/create', [CMSESICController::class, 'create'])->name('cms.esic.create');
        Route::post('/cms_esic/create', [CMSESICController::class, 'store']);
        Route::get('/cms_esic/id/delete', [CMSESICController::class, 'destroy'])->name('cms.esic.delete');

        // CMS PF
        Route::get('/cms_pf', [CMSPFController::class, 'index'])->name('cms.pf');
        Route::get('/cms_pf/create', [CMSPFController::class, 'create'])->name('cms.pf.create');
        Route::post('/cms_pf/create', [CMSPFController::class, 'store']);
        Route::get('/cms_pf/id/delete', [CMSPFController::class, 'destroy'])->name('cms.pf.delete');

        // CMS PT
        Route::get('/cms_pt', [CMSPTController::class, 'index'])->name('cms.pt');
        Route::get('/cms_pt/create', [CMSPTController::class, 'create'])->name('cms.pt.create');
        Route::post('/cms_pt/create', [CMSPTController::class, 'store']);
        Route::get('/cms_pt/id/delete', [CMSPTController::class, 'destroy'])->name('cms.pt.delete');

        // CMS LWF
        Route::get('/cms_lwf', [CMSLWFController::class, 'index'])->name('cms.lwf');
        Route::get('/cms_lwf/create', [CMSLWFController::class, 'create'])->name('cms.lwf.create');
        Route::post('/cms_lwf/create', [CMSLWFController::class, 'store']);
        Route::get('/cms_lwf/id/delete', [CMSLWFController::class, 'destroy'])->name('cms.lwf.delete');

        // Form T Register
        Route::get('/cms_formt', [CMSFormTController::class, 'index'])->name('cms.formt');
        Route::get('/cms_formt/create', [CMSFormTController::class, 'create'])->name('cms.formt.create');
        Route::post('/cms_formt/create', [CMSFormTController::class, 'store']);
        Route::get('/cms_formt/id/delete', [CMSFormTController::class, 'destroy'])->name('cms.formt.delete');

        // Form T Register
        Route::get('/cms/labour/notice', [CMSLabourNoticeController::class, 'index'])->name('cms.labour');
        Route::get('/cms/labour/notice/create', [CMSLabourNoticeController::class, 'create'])->name('cms.labour.create');

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

        //fhrms
        Route::get('/fhrms', [FHRMSController::class, 'index'])->name('fhrms');
        Route::get('fhrms/create', [FHRMSController::class, 'create'])->name('fhrms.create');
        Route::post('fhrms/create', [FHRMSController::class, 'store']);
        Route::get('fhrms/{id}/edit', [FHRMSController::class, 'edit'])->name('fhrms.edit');
        Route::post('fhrms/{id}/edit', [FHRMSController::class, 'update']);
        Route::post('fhrms/bulk_operation', [FHRMSController::class, 'bulk'])->name('fhrms.bulk');
        Route::get('fhrms/{id}/delete', [FHRMSController::class, 'destroy'])->name('fhrms.delete');
        Route::post('fhrms/export', [FHRMSController::class, 'export'])->name('fhrms.export');
        Route::get('fhrms/show/{id}', [FHRMSController::class, 'show'])->name('fhrms.show');
        Route::get('fhrms/{id}/eduDelete', [FHRMSController::class, 'eduDelete'])->name('fhrms.eduDelete');
        Route::get('fhrms/{id}/otherDelete', [FHRMSController::class, 'otherDelete'])->name('fhrms.otherDelete');
        Route::post('fhrms/bulk-upload', [FHRMSController::class, 'bulkUpload'])->name('fhrms.bulk.upload');
        Route::get('fhrms/fhrms_report', [FHRMSController::class, 'showCodeReport'])->name('fhrms_report.get');
        Route::post('fhrms/fhrms_report', [FHRMSController::class, 'codeReport'])->name('fhrms_report');
        Route::post('fhrms/fhrms_report/export', [FHRMSController::class, 'exportReport'])->name('fhrms_report.export');

    });
});
