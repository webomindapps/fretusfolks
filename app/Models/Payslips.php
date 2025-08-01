<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payslips extends Model
{
    public $table = 'payslips';

    protected $fillable = [
        'emp_id',
        'client_emp_id',
        'emp_name',
        'designation',
        'doj',
        'department',
        'vertical',
        'location',
        'client_name',
        'uan_no',
        'pf_no',
        'esi_no',
        'bank_name',
        'account_no',
        'ifsc_code',
        'month_days',
        'payable_days',
        'leave_days',
        'lop_days',
        'arrears_days',
        'ot_hours',
        'leave_balance',
        'notice_period_days',
        'fixed_basic_da',
        'fixed_hra',
        'fixed_conveyance',
        'fixed_medical_reimbursement',
        'fixed_special_allowance',
        'fixed_other_allowance',
        'fixed_ot_wages',
        'fixed_attendance_bonus',
        'fixed_st_bonus',
        'fixed_holiday_wages',
        'fixed_other_wages',
        'fixed_total_earnings',
        'fix_education_allowance',
        'fix_leave_wages',
        'fix_incentive_wages',
        'fix_arrear_wages',
        'earn_basic',
        'earn_hr',
        'earn_conveyance',
        'earn_medical_allowance',
        'earn_special_allowance',
        'earn_other_allowance',
        'earn_ot_wages',
        'earn_attendance_bonus',
        'earn_st_bonus',
        'earn_holiday_wages',
        'earn_other_wages',
        'earn_total_gross',
        'earn_education_allowance',
        'earn_leave_wages',
        'earn_incentive_wages',
        'earn_arrear_wages',
        'arr_basic',
        'arr_hra',
        'arr_conveyance',
        'arr_medical_reimbursement',
        'arr_special_allowance',
        'arr_other_allowance',
        'arr_ot_wages',
        'arr_attendance_bonus',
        'arr_st_bonus',
        'arr_holiday_wages',
        'arr_other_wages',
        'arr_total_gross',
        'total_basic',
        'total_hra',
        'total_conveyance',
        'total_medical_reimbursement',
        'total_special_allowance',
        'total_other_allowance',
        'total_ot_wages',
        'total_attendance_bonus',
        'total_st_bonus',
        'total_holiday_wages',
        'total_other_wages',
        'total_total_gross',
        'epf',
        'esic',
        'pt',
        'it',
        'lwf',
        'salary_advance',
        'other_deduction',
        'notice_period_deducation',
        'total_deduction',
        'net_salary',
        'in_words',
        'month',
        'year',
        'date_upload',
        'modify_on',
        'payslips_letter_path'
    ];
    public function payslips()
    {
        return $this->belongsTo(CFISModel::class, 'emp_id', 'ffi_emp_id');
    }
}

