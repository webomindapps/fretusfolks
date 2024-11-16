<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('backend_management', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->autoIncrement()->change();
            $table->string('client_id')->nullable()->change();
            $table->string('entity_name')->nullable()->change();
            $table->string('console_id')->nullable()->change();
            $table->string('ffi_emp_id')->nullable()->change();
            $table->string('grade')->nullable()->change();
            $table->string('client_emp_id')->nullable()->change();
            $table->string('emp_name')->nullable()->change();
            $table->string('middle_name')->nullable()->change();
            $table->string('last_name')->nullable()->change();
            $table->date('interview_date')->nullable()->change();
            $table->date('joining_date')->nullable()->change();
            $table->date('contract_date')->nullable()->change();
            $table->text('designation')->nullable()->change();
            $table->text('department')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->text('location')->nullable()->change();
            $table->string('branch')->nullable()->change();
            $table->date('dob')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->text('father_name')->nullable()->change();
            $table->text('mother_name')->nullable()->change();
            $table->text('religion')->nullable()->change();
            $table->text('languages')->nullable()->change();
            $table->text('mother_tongue')->nullable()->change();
            $table->string('maritial_status')->nullable()->change();
            $table->string('emer_contact_no')->nullable()->change();
            $table->string('spouse_name')->nullable()->change();
            $table->string('no_of_childrens')->nullable()->change();
            $table->string('blood_group')->nullable()->change();
            $table->string('qualification')->nullable()->change();
            $table->string('phone1')->nullable()->change();
            $table->string('phone2')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('official_mail_id')->nullable()->change();
            $table->text('permanent_address')->nullable()->change();
            $table->text('present_address')->nullable()->change();
            $table->string('pan_no')->nullable()->change();
            $table->string('pan_path')->nullable()->change();
            $table->string('aadhar_no')->nullable()->change();
            $table->string('aadhar_path')->nullable()->change();
            $table->string('driving_license_no')->nullable()->change();
            $table->string('driving_license_path')->nullable()->change();
            $table->string('photo')->nullable()->change();
            $table->string('resume')->nullable()->change();
            $table->string('bank_document')->nullable()->change();
            $table->string('bank_name')->nullable()->change();
            $table->string('bank_account_no')->nullable()->change();
            $table->string('bank_ifsc_code')->nullable()->change();
            $table->string('uan_no')->nullable()->change();
            $table->string('esic_no')->nullable()->change();
            $table->string('basic_salary')->nullable()->change();
            $table->string('hra')->nullable()->change();
            $table->string('conveyance')->nullable()->change();
            $table->string('medical_reimbursement')->nullable()->change();
            $table->string('special_allowance')->nullable()->change();
            $table->string('other_allowance')->nullable()->change();
            $table->string('st_bonus')->nullable()->change();
            $table->string('gross_salary')->nullable()->change();
            $table->string('emp_pf')->nullable()->change();
            $table->string('emp_esic')->nullable()->change();
            $table->string('pt')->nullable()->change();
            $table->string('total_deduction')->nullable()->change();
            $table->string('take_home')->nullable()->change();
            $table->string('employer_pf')->nullable()->change();
            $table->string('employer_esic')->nullable()->change();
            $table->string('mediclaim')->nullable()->change();
            $table->string('ctc')->nullable()->change();
            $table->integer('status')->nullable()->change();
            $table->integer('modify_by')->nullable()->change();
            $table->string('password')->nullable()->change();
            $table->string('refresh_code')->nullable()->change();
            $table->string('psd')->nullable()->change();
            $table->string('voter_id')->nullable()->change();
            $table->string('emp_form')->nullable()->change();
            $table->string('pf_esic_form')->nullable()->change();
            $table->string('payslip')->nullable()->change();
            $table->string('exp_letter')->nullable()->change();
            $table->dateTime('modified_date')->nullable()->change();
            $table->integer('data_status')->nullable()->change();
            $table->date('created_at')->nullable()->change();
            $table->integer('created_by')->nullable()->change();
            $table->integer('active_status')->nullable()->change();
            $table->integer('dcs_approval')->nullable()->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('backend_management', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at']);
        });    }
};
