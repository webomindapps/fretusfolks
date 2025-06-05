<?php

namespace App\Imports;

use Exception;
use App\Models\FFIPayslipsModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class FFI_PayslipsImport implements SkipsEmptyRows, ToModel, WithHeadingRow, SkipsOnFailure, WithValidation, WithBatchInserts, WithChunkReading, WithUpserts
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }
    use SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            $payslip = FFIPayslipsModel::create([
                'emp_id' => $row['emp_id'],
                'employee_name' => $row['employee_name'],
                'designation' => $row['designation'],
                'date_of_joining' => \Carbon\Carbon::parse($row['date_of_joining']),
                'department' => $row['department'],
                'uan_no' => $row['uan_no'],
                'pf_no' => $row['pf_no'],
                'esi_no' => $row['esi_no'],
                'bank_name' => $row['bank_name'],
                'account_no' => $row['account_no'],
                'ifsc_code' => $row['ifsc_code'],
                'month_days' => $row['month_days'],
                'pay_days' => $row['pay_days'],
                'leave_days' => $row['leave_days'],
                'lop_days' => $row['lop_days'],
                'arrear_days' => $row['arrear_days'],
                'ot_hours' => $row['ot_hours'],
                'fixed_basic' => $row['fixed_basic'],
                'fixed_hra' => $row['fixed_hra'],
                'fixed_con_allow' => $row['fixed_con_allow'],
                'fixed_edu_allowance' => $row['fixed_edu_allowance'],
                'fixed_med_reim' => $row['fixed_med_reim'],
                'fixed_spec_allow' => $row['fixed_spec_allow'],
                'fixed_oth_allow' => $row['fixed_oth_allow'],
                'fixed_st_bonus' => $row['fixed_st_bonus'],
                'fixed_leave_wages' => $row['fixed_leave_wages'],
                'fixed_holidays_wages' => $row['fixed_holidays_wages'],
                'fixed_attendance_bonus' => $row['fixed_attendance_bonus'],
                'fixed_ot_wages' => $row['fixed_ot_wages'],
                'fixed_incentive' => $row['fixed_incentive'],
                'fixed_arrear_wages' => $row['fixed_arrear_wages'],
                'fixed_other_wages' => $row['fixed_other_wages'],
                'fixed_gross' => $row['fixed_gross'],
                'earned_basic' => $row['earned_basic'],
                'earned_hra' => $row['earned_hra'],
                'earned_con_allow' => $row['earned_con_allow'],
                'earned_education_allowance' => $row['earned_education_allowance'],
                'earned_med_reim' => $row['earned_med_reim'],
                'earned_spec_allow' => $row['earned_spec_allow'],
                'earned_oth_allow' => $row['earned_oth_allow'],
                'earned_st_bonus' => $row['earned_st_bonus'],
                'earned_leave_wages' => $row['earned_leave_wages'],
                'earned_holiday_wages' => $row['earned_holiday_wages'],
                'earned_attendance_bonus' => $row['earned_attendance_bonus'],
                'earned_ot_wages' => $row['earned_ot_wages'],
                'earned_incentive' => $row['earned_incentive'],
                'earned_arrear_wages' => $row['earned_arrear_wages'],
                'earned_other_wages' => $row['earned_other_wages'],
                'earned_gross' => $row['earned_gross'],
                'epf' => $row['epf'],
                'esic' => $row['esic'],
                'pt' => $row['pt'],
                'it' => $row['it'],
                'lwf' => $row['lwf'],
                'salary_advance' => $row['salary_advance'],
                'other_deduction' => $row['other_deduction'],
                'total_deductions' => $row['total_deductions'],
                'net_salary' => $row['net_salary'],
                'in_words' => $row['in_words'],
                'month' => $this->month,
                'year' => $this->year,
                'location' => $row['location'],
            ]);
            return $payslip;
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function rules(): array
    {
        return [
            'emp_id' => 'required|string',
            'employee_name' => 'required|string',

        ];
    }
    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 50;
    }
    public function uniqueBy()
    {
        return 'emp_id';
    }
}
