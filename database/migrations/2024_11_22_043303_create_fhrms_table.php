<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('fhrms', function (Blueprint $table) {
            // DB::statement('ALTER TABLE fhrms ADD PRIMARY KEY (`id`);');
            // $table->bigInteger('id')->unsigned()->autoIncrement()->change();
            $table->string('ffi_emp_id', 256)->nullable()->change();
            $table->string('emp_name', 256)->nullable()->change();
            $table->date('interview_date')->nullable()->change();
            $table->date('joining_date')->nullable()->change();
            $table->date('contract_date')->nullable()->change();
            $table->string('designation', 256)->nullable()->change();
            $table->string('department', 256)->nullable()->change();
            $table->string('state',256)->nullable()->change();
            $table->string('location', 256)->nullable()->change();
            $table->date('dob')->nullable()->change();
            $table->string('gender', 128)->nullable()->change();
            $table->string('father_name', 128)->nullable()->change();
            $table->string('blood_group', 128)->nullable()->change();
            $table->string('qualification', 128)->nullable()->change();
            $table->string('phone1', 128)->nullable()->change();
            $table->string('phone2', 128)->nullable()->change();
            $table->string('email', 128)->nullable()->change();
            $table->string('permanent_address', 300)->nullable()->change();
            $table->string('present_address', 300)->nullable()->change();
            $table->string('pan_no', 128)->nullable()->change();
            $table->string('pan_path', 256)->nullable()->change();
            $table->string('aadhar_no', 126)->nullable()->change();
            $table->string('aadhar_path', 256)->nullable()->change();
            $table->string('driving_license_no', 128)->nullable()->change();
            $table->string('driving_license_path', 256)->nullable()->change();
            $table->string('photo', 256)->nullable()->change();
            $table->string('resume', 256)->nullable()->change();
            $table->string('bank_document', 256)->nullable()->change();
            $table->string('bank_name', 128)->nullable()->change();
            $table->string('bank_account_no', 128)->nullable()->change();
            $table->string('bank_ifsc_code', 128)->nullable()->change();
            $table->string('uan_generatted', 128)->nullable()->change();
            $table->string('uan_type', 128)->nullable()->change();
            $table->string('uan_no', 128)->nullable()->change();
            $table->string('basic_salary', 128)->nullable()->change();
            $table->string('hra', 128)->nullable()->change();
            $table->string('conveyance', 128)->nullable()->change();
            $table->string('medical_reimbursement', 128)->nullable()->change();
            $table->string('special_allowance', 128)->nullable()->change();
            $table->string('other_allowance', 128)->nullable()->change();
            $table->string('st_bonus', 128)->nullable()->change();
            $table->string('gross_salary', 128)->nullable()->change();
            $table->string('pf_percentage', 128)->nullable()->change();
            $table->string('emp_pf', 128)->nullable()->change();
            $table->string('esic_percentage', 128)->nullable()->change();
            $table->string('emp_esic', 128)->nullable()->change();
            $table->string('pt', 128)->nullable()->change();
            $table->string('total_deduction', 128)->nullable()->change();
            $table->string('take_home', 128)->nullable()->change();
            $table->string('employer_pf_percentage', 128)->nullable()->change();
            $table->string('employer_pf', 128)->nullable()->change();
            $table->string('employer_esic_percentage', 128)->nullable()->change();
            $table->string('employer_esic', 128)->nullable()->change();
            $table->string('mediclaim', 128)->nullable()->change();
            $table->string('ctc', 128)->nullable()->change();
            $table->integer('status')->nullable()->change();
            $table->integer('modify_by')->nullable()->change();
            $table->string('password', 256)->nullable()->change();
            $table->string('psd', 256)->nullable()->change();
            $table->string('voter_id', 256)->nullable()->change();
            $table->string('emp_form', 256)->nullable()->change();
            $table->string('pf_esic_form', 256)->nullable()->change();
            $table->string('payslip', 256)->nullable()->change();
            $table->string('exp_letter', 256)->nullable()->change();
            $table->dateTime('modified_date')->nullable()->change();
            $table->integer('data_status')->nullable()->change();
            $table->string('ref_no', 256)->nullable()->change();
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
