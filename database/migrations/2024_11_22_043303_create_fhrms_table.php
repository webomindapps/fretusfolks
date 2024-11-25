<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('fhrms', function (Blueprint $table) {
            DB::statement('ALTER TABLE fhrms ADD PRIMARY KEY (`id`);');
            $table->bigInteger('id')->unsigned()->autoIncrement()->change();
            $table->string('ffi_emp_id', 100)->nullable()->change();
            $table->string('emp_name', 100)->nullable()->change();
            $table->date('interview_date')->nullable()->change();
            $table->date('joining_date')->nullable()->change();
            $table->date('contract_date')->nullable()->change();
            $table->text('designation')->nullable()->change();
            $table->text('department')->nullable()->change();
            $table->text('state')->nullable()->change();
            $table->text('location')->nullable()->change();
            $table->date('dob')->nullable()->change();
            $table->string('gender', 100)->nullable()->change();
            $table->text('father_name', 100)->nullable()->change();
            $table->string('blood_group', 100)->nullable()->change();
            $table->string('qualification', 100)->nullable()->change();
            $table->string('phone1', 100)->nullable()->change();
            $table->string('phone2', 100)->nullable()->change();
            $table->string('email', 100)->nullable()->change();
            $table->text('permanent_address')->nullable()->change();
            $table->text('present_address')->nullable()->change();
            $table->string('pan_no', 100)->nullable()->change();
            $table->string('pan_path', 100)->nullable()->change();
            $table->string('aadhar_no', 100)->nullable()->change();
            $table->string('aadhar_path', 100)->nullable()->change();
            $table->string('driving_license_no', 100)->nullable()->change();
            $table->string('driving_license_path', 100)->nullable()->change();
            $table->string('photo', 100)->nullable()->change();
            $table->string('resume', 100)->nullable()->change();
            $table->string('bank_document', 100)->nullable()->change();
            $table->string('bank_name', 100)->nullable()->change();
            $table->string('bank_account_no', 100)->nullable()->change();
            $table->string('bank_ifsc_code', 100)->nullable()->change();
            $table->string('uan_generatted', 100)->nullable()->change();
            $table->string('uan_type', 100)->nullable()->change();
            $table->string('uan_no', 100)->nullable()->change();
            $table->string('basic_salary', 100)->nullable()->change();
            $table->string('hra', 100)->nullable()->change();
            $table->string('conveyance', 100)->nullable()->change();
            $table->string('medical_reimbursement', 100)->nullable()->change();
            $table->string('special_allowance', 100)->nullable()->change();
            $table->string('other_allowance', 100)->nullable()->change();
            $table->string('st_bonus', 100)->nullable()->change();
            $table->string('gross_salary', 100)->nullable()->change();
            $table->string('pf_percentage', 100)->nullable()->change();
            $table->string('emp_pf', 100)->nullable()->change();
            $table->string('esic_percentage', 100)->nullable()->change();
            $table->string('emp_esic', 100)->nullable()->change();
            $table->string('pt', 100)->nullable()->change();
            $table->string('total_deduction', 100)->nullable()->change();
            $table->string('take_home', 100)->nullable()->change();
            $table->string('employer_pf_percentage', 100)->nullable()->change();
            $table->string('employer_pf', 100)->nullable()->change();
            $table->string('employer_esic_percentage', 100)->nullable()->change();
            $table->string('employer_esic', 100)->nullable()->change();
            $table->string('mediclaim', 100)->nullable()->change();
            $table->string('ctc', 100)->nullable()->change();
            $table->integer('status')->nullable()->change();
            $table->integer('modify_by')->nullable()->change();
            $table->string('password', 100)->nullable()->change();
            $table->string('psd', 100)->nullable()->change();
            $table->string('voter_id', 100)->nullable()->change();
            $table->string('emp_form', 100)->nullable()->change();
            $table->string('pf_esic_form', 100)->nullable()->change();
            $table->string('payslip', 100)->nullable()->change();
            $table->string('exp_letter', 100)->nullable()->change();
            $table->dateTime('modified_date')->nullable()->change();
            $table->integer('data_status')->nullable()->change();
            $table->date('ref_no', 100)->nullable()->change();
            $table->integer('active_status')->nullable()->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fhrms', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }

};
