<?php

use App\Http\Controllers\Admin\AdmsIncrementLetterController;
use App\Http\Controllers\Admin\AdmsPipLetterController;
use App\Http\Controllers\Admin\EmployeeLifecycleController;
use App\Http\Controllers\Admin\AdmsShowcauseLetterController;
use App\Http\Controllers\Admin\AdmsTerminationLetterController;
use App\Http\Controllers\Admin\AdmsWarningLetterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CDMSController;
use App\Http\Controllers\Admin\CFISController;
use App\Http\Controllers\Admin\FFCMController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CMSPFController;
use App\Http\Controllers\Admin\CMSPTController;
use App\Http\Controllers\Admin\FHRMSController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\CMSLWFController;
use App\Http\Controllers\Admin\CMSESICController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TdsCodeController;
use App\Http\Controllers\Admin\CMSFormTController;
use App\Http\Controllers\Admin\FFIAssetController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\Admin\ComplianceController;
use App\Http\Controllers\Admin\FFIWarningController;
use App\Http\Controllers\Admin\ADMSPayslipController;
use App\Http\Controllers\Admin\DCSApprovalController;
use App\Http\Controllers\Admin\FFIPayslipsController;
use App\Http\Controllers\Admin\OfferLetterController;
use App\Http\Controllers\Admin\FFIPipLetterController;
use App\Http\Controllers\Admin\FFIShowCauseController;
use App\Http\Controllers\AdmsShowcaseLetterController;
use App\Http\Controllers\Admin\LetterContentController;
use App\Http\Controllers\Admin\FFIOfferLetterController;
use App\Http\Controllers\Admin\FFITerminationController;
use App\Http\Controllers\Admin\CMSLabourNoticeController;
use App\Http\Controllers\Admin\FFIIncrementLetterController;

Route::get('/', function () {
    return to_route('admin.dashboard');
    // return view('welcome');
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
        Route::get('user/status/{id}', [UserController::class, 'toggleStatus'])->name('user.status');


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
        Route::get('cdms/cdms_report', [CDMSController::class, 'showCodeReport'])->name('cdms_report');
        Route::post('cdms/cdms_report/export', [CDMSController::class, 'exportReport'])->name('cdms_report.export');

        // roles
        Route::get('/roles', [RolePermissionController::class, 'index'])->name('roles');
        Route::get('/role/{id}/permissions', [RolePermissionController::class, 'permission'])->name('permission');
        Route::post('/role/{id}/permissions', [RolePermissionController::class, 'assignPermission']);

        // CMS ESIC
        Route::get('/cms_esic', [CMSESICController::class, 'index'])->name(name: 'cms.esic');
        Route::get('/cms_esic/create', [CMSESICController::class, 'create'])->name('cms.esic.create');
        Route::post('/cms_esic/create', [CMSESICController::class, 'store']);
        Route::get('/cms_esic/{id}/delete', [CMSESICController::class, 'destroy'])->name('cms.esic.delete');

        // CMS PF
        Route::get('/cms_pf', [CMSPFController::class, 'index'])->name('cms.pf');
        Route::get('/cms_pf/create', [CMSPFController::class, 'create'])->name('cms.pf.create');
        Route::post('/cms_pf/create', [CMSPFController::class, 'store']);
        Route::get('/cms_pf/{id}/delete', [CMSPFController::class, 'destroy'])->name('cms.pf.delete');

        // CMS PT
        Route::get('/cms_pt', [CMSPTController::class, 'index'])->name('cms.pt');
        Route::get('/cms_pt/create', [CMSPTController::class, 'create'])->name('cms.pt.create');
        Route::post('/cms_pt/create', [CMSPTController::class, 'store']);
        Route::get('/cms_pt/{id}/delete', [CMSPTController::class, 'destroy'])->name('cms.pt.delete');

        // CMS LWF
        Route::get('/cms_lwf', [CMSLWFController::class, 'index'])->name('cms.lwf');
        Route::get('/cms_lwf/create', [CMSLWFController::class, 'create'])->name('cms.lwf.create');
        Route::post('/cms_lwf/create', [CMSLWFController::class, 'store']);
        Route::get('/cms_lwf/{id}/delete', [CMSLWFController::class, 'destroy'])->name('cms.lwf.delete');

        // Form T Register
        Route::get('/cms_formt', [CMSFormTController::class, 'index'])->name('cms.formt');
        Route::get('/cms_formt/create', [CMSFormTController::class, 'create'])->name('cms.formt.create');
        Route::post('/cms_formt/create', [CMSFormTController::class, 'store']);
        Route::get('/cms_formt/{id}/delete', [CMSFormTController::class, 'destroy'])->name('cms.formt.delete');

        // Form Labour Notice
        Route::get('/cms/labour/notice', [CMSLabourNoticeController::class, 'index'])->name('cms.labour');
        Route::get('/cms/labour/notice/create', [CMSLabourNoticeController::class, 'create'])->name('cms.labour.create');
        Route::post('/cms/labour/notice/create', [CMSLabourNoticeController::class, 'store']);
        Route::get('/cms/labour/notice/{id}/edit', [CMSLabourNoticeController::class, 'edit'])->name('cms.labour.edit');
        Route::post('/cms/labour/notice/{id}/edit', [CMSLabourNoticeController::class, 'update']);
        Route::get('/cms/labour/{id}/delete', [CMSLabourNoticeController::class, 'destroy'])->name('cms.labour.delete');

        //cfis
        Route::get('/cfis', [CFISController::class, 'index'])->name('cfis');
        Route::get('cfis/create', [CFISController::class, 'create'])->name('cfis.create');
        Route::post('cfis/create', [CFISController::class, 'store']);
        Route::get('cfis/{id}/edit', [CFISController::class, 'edit'])->name('cfis.edit');
        Route::post('cfis/{id}/edit', [CFISController::class, 'update']);
        Route::post('cfis/bulk_operation', [CFISController::class, 'bulk'])->name('cfis.bulk');
        Route::get('cfis/{id}/delete', [CFISController::class, 'destroy'])->name('cfis.delete');
        Route::post('cfis/export', [CFISController::class, 'export'])->name('cfis.export');
        Route::get('cfis/status/{id}', [CFISController::class, 'toggleStatus'])->name('cfis.status');
        Route::get('cfis/data-status/{id}/{newStatus}', [CFISController::class, 'toggleData_status'])->name('cfis.data_status');


        //dcs_approval
        Route::get('/dcs_approval', [DCSApprovalController::class, 'index'])->name('dcs_approval');
        Route::get('dcs_approval/{id}/edit', [DCSApprovalController::class, 'edit'])->name('dcs_approval.edit');
        Route::post('dcs_approval/{id}/edit', [DCSApprovalController::class, 'update']);
        Route::get('dcs_approval/{id}/delete', [DCSApprovalController::class, 'destroy'])->name('dcs_approval.delete');
        Route::get('/dcs_rejected', [DCSApprovalController::class, 'rejected'])->name('dcs_rejected');
        Route::post('/dcs_approval/pending-update', [DCSApprovalController::class, 'updatePendingDetails'])->name('dcs_approval.pending.update');
        Route::get('/dcs_approval/hr', [DCSApprovalController::class, 'hrindex'])->name('hrindex');
        Route::get('dcs_approval/{id}/hredit', [DCSApprovalController::class, 'hredit'])->name('hr.hredit');
        Route::post('dcs_approval/{id}/hredit', [DCSApprovalController::class, 'hrupdate']);
        Route::get('dcs_approval/status/{id}/{newStatus}', [DCSApprovalController::class, 'updateStatus'])->name('document.status');
        Route::get('/document_rejected', [DCSApprovalController::class, 'docrejected'])->name('doc_rejected');
        Route::get('dcs_approval/{id}/docedit', [DCSApprovalController::class, 'docedit'])->name('dcs_approval.docedit');
        Route::post('dcs_approval/{id}/docedit', [DCSApprovalController::class, 'docupdate']);
        // Route::post('/offer_letter/generate/{id}', action: [DCSApprovalController::class, 'generateOfferLetter'])->name('offer_letter.generate');


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
        Route::get('fhrms/fhrms_report', [FHRMSController::class, 'showCodeReport'])->name('fhrms_report');
        Route::post('fhrms/fhrms_report/export', [FHRMSController::class, 'exportReport'])->name('fhrms_report.export');
        Route::post('fhrms/pending-details', [FHRMSController::class, 'storePendingDetails'])->name('fhrms.pending.store');
        Route::get('/fhrms/ffi_birthday', [FHRMSController::class, 'todayBirthday'])->name('fhrms.ffi_birthday');
        Route::post('/fhrms/pending-update', [FHRMSController::class, 'updatePendingDetails'])->name('fhrms.pending.update');
        //FFI-Offer Letter
        Route::get('/ffi_offer_letter', [FFIOfferLetterController::class, 'index'])->name('ffi_offer_letter');
        Route::get('ffi_offer_letter/create', [FFIOfferLetterController::class, 'create'])->name('ffi_offer_letter.create');
        Route::post('ffi_offer_letter/create', [FFIOfferLetterController::class, 'store']);
        Route::get('/get-employee-details/{ffi_emp_id}', [FFIOfferLetterController::class, 'getEmployeeDetails'])->name('get.employee.details');
        Route::get('ffi_offer_letter/{id}/delete', [FFIOfferLetterController::class, 'destroy'])->name('ffi_offer_letter.delete');
        Route::get('/generate-offer-letter/{id}', [FFIOfferLetterController::class, 'generateOfferLetterPdf'])->name('generate.offer.letter');
        Route::post('ffi_offer_letter/bulk_operation', [FFIOfferLetterController::class, 'bulk'])->name('ffi_offer_letter.bulk');

        //ffi_increment_letter
        Route::get('/ffi_increment_letter', [FFIIncrementLetterController::class, 'index'])->name('ffi_increment_letter');
        Route::get('ffi_increment_letter/create', [FFIIncrementLetterController::class, 'create'])->name('ffi_increment_letter.create');
        Route::post('ffi_increment_letter/create', [FFIIncrementLetterController::class, 'store']);
        Route::get('/get-employeeIncrement-details/{ffi_emp_id}', [FFIIncrementLetterController::class, 'getEmployeeDetails'])->name('get.employeeIncrement.details');
        Route::get('ffi_increment_letter/{id}/delete', action: [FFIIncrementLetterController::class, 'destroy'])->name('ffi_increment_letter.delete');
        Route::get('/generate-increment-letter/{id}', [FFIIncrementLetterController::class, 'generateIncrementLetterPdf'])->name('generate.increment.letter');
        Route::post('ffi_increment_letter/bulk_operation', [FFIIncrementLetterController::class, 'bulk'])->name('ffi_increment_letter.bulk');

        //termination
        Route::get('/ffi_termination', [FFITerminationController::class, 'index'])->name('ffi_termination');
        Route::get('ffi_termination/create', [FFITerminationController::class, 'create'])->name('ffi_termination.create');
        Route::post('ffi_termination/create', [FFITerminationController::class, 'store']);
        Route::get('/get-employeeTermination-details/{ffi_emp_id}', [FFITerminationController::class, 'getEmployeeDetails'])->name('get.employeeTermination.details');
        Route::post('ffi_termination/bulk_operation', [FFITerminationController::class, 'bulk'])->name('ffi_termination.bulk');
        Route::get('ffi_termination/{id}/delete', action: [FFITerminationController::class, 'destroy'])->name('ffi_termination.delete');
        Route::get('/generate-termination-letter/{id}', [FFITerminationController::class, 'generateTerminationPdf'])->name('generate.termination.letter');
        Route::get('/ffi-termination/{id}/edit', [FFITerminationController::class, 'edit'])->name('ffi_termination.edit');
        Route::post('/ffi-termination/{id}/edit', [FFITerminationController::class, 'update']);

        //warning_letter
        Route::get('/ffi_warning', [FFIWarningController::class, 'index'])->name('ffi_warning');
        Route::get('ffi_warning/create', [FFIWarningController::class, 'create'])->name('ffi_warning.create');
        Route::post('ffi_warning/create', [FFIWarningController::class, 'store']);
        Route::get('/get-employeeWarning-details/{ffi_emp_id}', [FFIWarningController::class, 'getEmployeeDetails'])->name('get.employeeWarning.details');
        Route::post('ffi_warning/bulk_operation', [FFIWarningController::class, 'bulk'])->name('ffi_warning.bulk');
        Route::get('ffi_warning/{id}/delete', action: [FFIWarningController::class, 'destroy'])->name('ffi_warning.delete');
        Route::get('/generate-warning-letter/{id}', [FFIWarningController::class, 'generateWarningPdf'])->name('generate.warning.letter');
        Route::get('/ffi_warning/{id}/edit', [FFIWarningController::class, 'edit'])->name('ffi_warning.edit');
        Route::post('/ffi_warning/{id}/edit', [FFIWarningController::class, 'update']);

        //show_case_letter
        Route::get('/ffi_show_cause', [FFIShowCauseController::class, 'index'])->name('ffi_show_cause');
        Route::get('ffi_show_cause/create', [FFIShowCauseController::class, 'create'])->name('ffi_show_cause.create');
        Route::post('ffi_show_cause/create', [FFIShowCauseController::class, 'store']);
        Route::get('/get-employeeShow-details/{ffi_emp_id}', [FFIShowCauseController::class, 'getEmployeeDetails'])->name('get.employeeShow.details');
        Route::post('ffi_show_cause/bulk_operation', [FFIShowCauseController::class, 'bulk'])->name('ffi_show_cause.bulk');
        Route::get('ffi_show_cause/{id}/delete', action: [FFIShowCauseController::class, 'destroy'])->name('ffi_show_cause.delete');
        Route::get('/generate-show-letter/{id}', [FFIShowCauseController::class, 'generateShowPdf'])->name('generate.show.letter');
        Route::get('/ffi_show_cause/{id}/edit', [FFIShowCauseController::class, 'edit'])->name('ffi_show_cause.edit');
        Route::post('/ffi_show_cause/{id}/edit', [FFIShowCauseController::class, 'update']);

        //ffi_pip_letter
        Route::get('/ffi_pip_letter', [FFIPipLetterController::class, 'index'])->name('ffi_pip_letter');
        Route::get('ffi_pip_letter/create', [FFIPipLetterController::class, 'create'])->name('ffi_pip_letter.create');
        Route::post('ffi_pip_letter/create', [FFIPipLetterController::class, 'store']);
        Route::get('/get-employeePip-details/{ffi_emp_id}', [FFIPipLetterController::class, 'getEmployeeDetails'])->name('get.employeePip.details');
        Route::post('ffi_pip_letter/bulk_operation', [FFIPipLetterController::class, 'bulk'])->name('ffi_pip_letter.bulk');
        Route::get('ffi_pip_letter/{id}/delete', action: [FFIPipLetterController::class, 'destroy'])->name('ffi_pip_letter.delete');
        Route::get('/generate-pip-letter/{id}', [FFIPipLetterController::class, 'generatePipPdf'])->name('generate.pip.letter');
        Route::get('/ffi_pip_letter/{id}/edit', [FFIPipLetterController::class, 'edit'])->name('ffi_pip_letter.edit');
        Route::post('/ffi_pip_letter/{id}/edit', [FFIPipLetterController::class, 'update']);

        // FCMS CIMS 
        Route::get('/cims', [InvoiceController::class, 'index'])->name('fcms.cims');
        Route::get('/cims/create', [InvoiceController::class, 'create'])->name('fcms.cims.create');
        Route::post('/cims/create', [InvoiceController::class, 'store']);
        Route::get('/cims/{id}/edit', [InvoiceController::class, 'edit'])->name('fcms.cims.edit');
        Route::post('/cims/{id}/edit', [InvoiceController::class, 'update']);
        Route::get('/get-client-location/{id}', [InvoiceController::class, 'getClientLocation'])->name('get.client.location');
        Route::get('/get-client-gst/{client}/{gst}', [InvoiceController::class, 'getClientGST'])->name('get.client.gst');
        Route::get('/cims/show/{id}', [InvoiceController::class, 'show'])->name('cims.show');

        // CIMS Report
        Route::get('/cims/report', [InvoiceController::class, 'reports'])->name('fcms.cims.reports');

        // Receivables
        Route::get('/receivables', [PaymentController::class, 'index'])->name('fcms.receivables');
        Route::get('/receivable/create', [PaymentController::class, 'create'])->name('fcms.receivable.create');
        Route::post('/receivable/create', [PaymentController::class, 'store']);
        Route::get('/receivable/show/{id}', [PaymentController::class, 'paymentView'])->name('receivable.show');
        Route::get('/receivable/delete/{id}', [PaymentController::class, 'destroy'])->name('receivable.delete');
        Route::get('/get-client-invoices/{id}', [PaymentController::class, 'getClientInvoice'])->name('get.client.invoices');
        Route::get('/get-invoice/{id}/details', [PaymentController::class, 'getInvoiceDetails'])->name('get.invoice.details');
        Route::get('/receivable/report', [PaymentController::class, 'reports'])->name('fcms.receivable.reports');
        Route::post('/receivable/export', [PaymentController::class, 'exportReciveables'])->name('receivable.export');

        //ffi_payslips
        Route::get('/ffi_payslips', [FFIPayslipsController::class, 'index'])->name('ffi_payslips');
        Route::post('ffi_payslips/bulk-upload', [FFIPayslipsController::class, 'bulkUpload'])->name('ffi_payslips.bulk.upload');
        Route::post('ffi_payslips/export', [FFIPayslipsController::class, 'export'])->name('ffi_payslips.export');
        Route::get('ffi_payslips/search-payslip', [FFIPayslipsController::class, 'searchPayslip'])->name('search.ffi_payslips');
        Route::get('/generate-payslips/{id}', [FFIPayslipsController::class, 'generatePayslipsPdf'])->name('generate.payslips');
        Route::get('/ffi_payslips/delete/{id}', [FFIPayslipsController::class, 'destroy'])->name('ffi_payslips.delete');

        //tds_report
        Route::get('/fcms/tds_report', [PaymentController::class, 'tdsReports'])->name('fcms.tds_report');
        Route::post('fcms/tds_report/export', [PaymentController::class, 'exportReport'])->name('tds_report.export');

        //ffcm
        Route::get('/ffcm', [FFCMController::class, 'index'])->name('fcms.ffcm');
        Route::get('ffcm/create', [FFCMController::class, 'create'])->name('fcms.ffcm.create');
        Route::post('ffcm/create', [FFCMController::class, 'store']);
        Route::get('ffcm/{id}/edit', [FFCMController::class, 'edit'])->name('fcms.ffcm.edit');
        Route::post('ffcm/{id}/edit', [FFCMController::class, 'update']);
        Route::post('ffcm/bulk_operation', [FFCMController::class, 'bulk'])->name('fcms.ffcm.bulk');
        Route::get('ffcm/{id}/delete', [FFCMController::class, 'destroy'])->name('fcms.ffcm.delete');
        Route::get('ffcm/export', [FFCMController::class, 'export'])->name('fcms.ffcm.export');
        Route::get('/fcms/ffcm_report', [FFCMController::class, 'ffcmReports'])->name('fcms.ffcm_report');
        Route::post('fcms/ffcm_report/export', [FFCMController::class, 'exportReport'])->name('fcms.ffcm_report.export');

        //ffi_assets
        Route::get('/ffi_assets', [FFIAssetController::class, 'index'])->name('fcms.ffi_assets');
        Route::get('ffi_assets/create', [FFIAssetController::class, 'create'])->name('fcms.ffi_assets.create');
        Route::post('ffi_assets/create', [FFIAssetController::class, 'store']);
        Route::get('ffi_assets/{id}/edit', [FFIAssetController::class, 'edit'])->name('fcms.ffi_assets.edit');
        Route::post('ffi_assets/{id}/edit', [FFIAssetController::class, 'update']);
        Route::post('ffi_assets/bulk_operation', [FFIAssetController::class, 'bulk'])->name('fcms.ffi_assets.bulk');
        Route::get('ffi_assets/{id}/delete', [FFIAssetController::class, 'destroy'])->name('fcms.ffi_assets.delete');
        Route::get('ffi_assets/export', [FFIAssetController::class, 'export'])->name('fcms.ffi_assets.export');

        // settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings');
        Route::post('/settings', [SettingController::class, 'update']);

        //offer_letter
        Route::get('/offer_letter', [OfferLetterController::class, 'index'])->name('offer_letter');
        Route::get('/generate-offer-letter/{id}', [OfferLetterController::class, 'generateOfferLetterPdf'])->name('generate.offer.letter');
        Route::get('offer_letter/{id}/delete', [OfferLetterController::class, 'destroy'])->name('offer_letter.delete');

        //increment_letter
        Route::get('/increment_letter', [AdmsIncrementLetterController::class, 'index'])->name('increment_letter');
        Route::get('/increment_letter/create', [AdmsIncrementLetterController::class, 'create'])->name('increment_letter.create');
        Route::post('/increment_letter/create', [AdmsIncrementLetterController::class, 'store'])->name('increment_letter.store');
        Route::get('increment_letter/{ffi_emp_id}/details', [AdmsIncrementLetterController::class, 'details'])->name('increment_letter.details');
        Route::get('increment_letter/{ffi_emp_id}/view', [AdmsIncrementLetterController::class, 'viewpdf'])->name('increment_letter.viewpdf');
        Route::get('increment_letter/{ffi_emp_id}/delete', [AdmsIncrementLetterController::class, 'destroy'])->name('increment_letter.delete');

        //warning Letter
        Route::get('/warning_letter', [AdmsWarningLetterController::class, 'index'])->name('warning_letter');
        Route::get('/warning_letter/create', [AdmsWarningLetterController::class, 'create'])->name('warning_letter.create');
        Route::get('/warning_letter/{emp_id}/details', [AdmsWarningLetterController::class, 'details'])->name('warning_letter.details');
        Route::post('/warning_letter/create', [AdmsWarningLetterController::class, 'store']);
        Route::get('warning_letter/{id}/view', [AdmsWarningLetterController::class, 'viewpdf'])->name('warning_letter.viewpdf');
        Route::get('warning_letter/{id}/edit', [AdmsWarningLetterController::class, 'edit'])->name('warning_letter.edit');
        Route::post('warning_letter/{id}/edit', [AdmsWarningLetterController::class, 'update']);
        Route::get('warning_letter/{id}/delete', [AdmsWarningLetterController::class, 'delete'])->name('warning_letter.delete');

        //showcase Letter
        Route::get('/showcause_letter', [AdmsShowcauseLetterController::class, 'index'])->name('showcause_letter');
        Route::get('/showcause_letter/create', [AdmsShowcauseLetterController::class, 'create'])->name('showcause_letter.create');
        Route::get('/showcause_letter/{emp_id}/details', [AdmsShowcauseLetterController::class, 'details'])->name('showcause_letter.details');
        Route::post('/showcause_letter/create', [AdmsShowcauseLetterController::class, 'store']);
        Route::get('showcause_letter/{id}/view', [AdmsShowcauseLetterController::class, 'viewpdf'])->name('showcause_letter.viewpdf');
        Route::get('showcause_letter/{id}/edit', [AdmsShowcauseLetterController::class, 'edit'])->name('showcause_letter.edit');
        Route::post('showcause_letter/{id}/edit', [AdmsShowcauseLetterController::class, 'update']);
        Route::get('showcause_letter/{id}/delete', [AdmsShowcauseLetterController::class, 'delete'])->name('showcause_letter.delete');

        //Termination Letter
        Route::get('/termination_letter', [AdmsTerminationLetterController::class, 'index'])->name('termination_letter');
        Route::get('/termination_letter/create', [AdmsTerminationLetterController::class, 'create'])->name('termination_letter.create');
        Route::get('/termination_letter/{emp_id}/details', [AdmsTerminationLetterController::class, 'details'])->name('termination_letter.details');
        Route::post('/termination_letter/create', [AdmsTerminationLetterController::class, 'store']);
        Route::get('termination_letter/{id}/view', [AdmsTerminationLetterController::class, 'viewpdf'])->name('termination_letter.viewpdf');
        Route::get('termination_letter/{id}/edit', [AdmsTerminationLetterController::class, 'edit'])->name('termination_letter.edit');
        Route::post('termination_letter/{id}/edit', [AdmsTerminationLetterController::class, 'update']);
        Route::get('termination_letter/{id}/delete', [AdmsTerminationLetterController::class, 'delete'])->name('termination_letter.delete');

        //PIP Letter
        Route::get('pip_letter', [AdmsPipLetterController::class, 'index'])->name('pip_letter');
        Route::get('/pip_letter/create', [AdmsPipLetterController::class, 'create'])->name('pip_letter.create');
        Route::post('/pip_letter/create', [AdmsPipLetterController::class, 'store']);
        Route::get('/pip_letter/details', [AdmsPipLetterController::class, 'details'])->name('pip_letter.details');
        Route::get('pip_letter/{id}/view', [AdmsPipLetterController::class, 'viewpdf'])->name('pip_letter.viewpdf');
        Route::get('pip_letter/{id}/edit', [AdmsPipLetterController::class, 'edit'])->name('pip_letter.edit');
        Route::post('pip_letter/{id}/edit', [AdmsPipLetterController::class, 'update']);
        Route::get('pip_letter/{id}/delete', [AdmsPipLetterController::class, 'delete'])->name('pip_letter.delete');

        //compliance 
        Route::get('candidatemaster', [ComplianceController::class, 'index'])->name('candidatemaster');
        Route::get('candidatemaster/view/{id}', [ComplianceController::class, 'viewdetail'])->name('candidatemaster.view');
        Route::get('candidatemaster/download/{id}', [ComplianceController::class, 'downloadpdf'])->name('candidatemaster.download');
        Route::post('candidatemaster/export', [ComplianceController::class, 'export'])->name('candidatemaster.export');
        Route::get('candidatemaster/{id}/edit', [ComplianceController::class, 'edit'])->name('candidatemaster.edit');
        Route::post('candidatemaster/{id}/edit', [ComplianceController::class, 'update']);
        Route::post('/candidatemaster/import', [ComplianceController::class, 'import'])->name('candidatemaster.import');

        //Employee Lifecycle
        Route::get('candidatelifecycle', [EmployeeLifecycleController::class, 'index'])->name('candidatelifecycle');
        Route::get('candidatelifecycle/view/{id}', [EmployeeLifecycleController::class, 'viewdetail'])->name('candidatelifecycle.view');
        Route::get('/export-candidate-report', [EmployeeLifecycleController::class, 'exportFilteredReport'])->name('exportFilteredReport');

    });
});
