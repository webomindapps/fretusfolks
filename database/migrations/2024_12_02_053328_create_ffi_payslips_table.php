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
        Schema::table('ffi_payslips', function (Blueprint $table) {
            DB::statement('ALTER TABLE ffi_payslips ADD PRIMARY KEY (`id`);');
            $table->bigInteger('id')->unsigned()->autoIncrement()->change();
            $table->string('emp_id', 128)->nullable()->change();
            $table->string('employee_name', 256)->nullable()->change();
            $table->string('designation', 128)->nullable()->change();
            $table->date('date_of_joining')->nullable()->change();
            $table->string('department', 128)->nullable()->change();
            $table->string('uan_no', 128)->nullable()->change();
            $table->string('pf_no', 128)->nullable()->change();
            $table->string('esi_no', 128)->nullable()->change();
            $table->string('bank_name', 128)->nullable()->change();
            $table->string('account_no', 128)->nullable()->change();
            $table->string('ifsc_code', 128)->nullable()->change();
            $table->string('month_days', 128)->nullable()->change();
            $table->string('pay_days', 128)->nullable()->change();
            $table->string('leave_days', 128)->nullable()->change();
            $table->string('lop_days', 128)->nullable()->change();
            $table->string('arrear_days', 128)->nullable()->change();
            $table->string('ot_hours', 128)->nullable()->change();
            $table->string('fixed_basic', 128)->nullable()->change();
            $table->string('fixed_hra', 128)->nullable()->change();
            $table->string('fixed_con_allow', 128)->nullable()->change();
            $table->string('fixed_edu_allowance', 128)->nullable()->change();
            $table->string('fixed_med_reim', 128)->nullable()->change();
            $table->string('fixed_spec_allow', 128)->nullable()->change();
            $table->string('fixed_oth_allow', 128)->nullable()->change();
            $table->string('fixed_st_bonus', 128)->nullable()->change();
            $table->string('fixed_leave_wages', 128)->nullable()->change();
            $table->string('fixed_holidays_wages', 128)->nullable()->change();
            $table->string('fixed_attendance_bonus', 128)->nullable()->change();
            $table->string('fixed_ot_wages', 128)->nullable()->change();
            $table->string('fixed_incentive', 128)->nullable()->change();
            $table->string('fixed_arrear_wages', 128)->nullable()->change();
            $table->string('fixed_other_wages', 128)->nullable()->change();
            $table->string('fixed_gross', 128)->nullable()->change();
            $table->string('earned_basic', 128)->nullable()->change();
            $table->string('earned_hra', 128)->nullable()->change();
            $table->string('earned_con_allow', 128)->nullable()->change();
            $table->string('earned_education_allowance', 128)->nullable()->change();
            $table->string('earned_med_reim', 128)->nullable()->change();
            $table->string('earned_spec_allow', 128)->nullable()->change();
            $table->string('earned_oth_allow', 128)->nullable()->change();
            $table->string('earned_st_bonus', 128)->nullable()->change();
            $table->string('earned_leave_wages', 128)->nullable()->change();
            $table->string('earned_holiday_wages', 128)->nullable()->change();
            $table->string('earned_attendance_bonus', 128)->nullable()->change();
            $table->string('earned_ot_wages', 128)->nullable()->change();
            $table->string('earned_incentive', 128)->nullable()->change();
            $table->string('earned_arrear_wages', 128)->nullable()->change();
            $table->string('earned_other_wages', 128)->nullable()->change();
            $table->string('earned_gross', 128)->nullable()->change();
            $table->string('epf', 128)->nullable()->change();
            $table->string('esic', 128)->nullable()->change();
            $table->string('pt', 128)->nullable()->change();
            $table->string('it', 128)->nullable()->change();
            $table->string('lwf', 128)->nullable()->change();
            $table->string('salary_advance', 128)->nullable()->change();
            $table->string('other_deduction', 128)->nullable()->change();
            $table->string('total_deductions', 128)->nullable()->change();
            $table->string('net_salary', 128)->nullable()->change();
            $table->string('in_words', 128)->nullable()->change();
            $table->string('month', 128)->nullable()->change();
            $table->string('year', 128)->nullable()->change();
            $table->string('location', 191)->nullable()->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('ffi_payslips');
    }
};
