<?php

namespace App\Jobs;

use App\Models\Payslips;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;

class ADMSPayslipCreate implements ShouldQueue
{
    use Batchable, Queueable, Dispatchable;

    protected $payslips;
    protected $month;
    protected $year;

    public function __construct($payslips, $month, $year)
    {
        $this->payslips = $payslips;
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->payslips as $key => $row) {
            $data[] = [
                'emp_id' => $row['Employee Id'],
                'emp_name' => $row['Employee Name'],
                'designation' => $row['Designation'],
                'doj' => $row['Date Of Joining'],
                'department' => $row['Department'],
                'vertical' => $row['Vertical'],
                'location' => $row['Location'],
                'client_name' => $row['Client Name'],
                'uan_no' => $row['Uan No'],
                'pf_no' => $row['Pf No'],
                'esi_no' => $row['Esi No'],
                'bank_name' => $row['Bank Name'],
                'account_no' => $row['Account No'],
                'ifsc_code' => $row['Ifsc Code'],
                'month_days' => $row['Month Days'],
                'payable_days' => $row['Payable Days'],
                'leave_days' => $row['Leave Days'],
                'lop_days' => $row['Lop Days'],
                'arrears_days' => $row['Arrears Days'],
                'ot_hours' => $row['Ot Hours'],
                'leave_balance' => $row['Leave Balance'],
                'notice_period_days' => $row['Notice Period Days'],
                'fixed_basic_da' => $row['Fixed Basic Da'],
                'fixed_hra' => $row['Fixed Hra'],
                'fixed_conveyance' => $row['Fixed Conveyance'],
                'fixed_medical_reimbursement' => $row['Fixed Medical Reimbursement'],
                'fixed_special_allowance' => $row['Fixed Special Allowance'],
                'fixed_other_allowance' => $row['Fixed Other Allowance'],
                'fixed_ot_wages' => $row['Fixed Ot Wages'],
                'fixed_attendance_bonus' => $row['Fixed Attendance Bonus'],
                'fixed_st_bonus' => $row['Fixed St Bonus'],
                'fixed_holiday_wages' => $row['Fixed Holiday Wages'],
                'fixed_other_wages' => $row['Fixed Other Wages'],
                'fixed_total_earnings' => $row['Fixed Total Earnings'],
                'fix_education_allowance' => $row['Fix Education Allowance'],
                'fix_leave_wages' => $row['Fix Leave Wages'],
                'fix_incentive_wages' => $row['Fix Incentive Wages'],
                'fix_arrear_wages' => $row['Fix Arrear Wages'],
                'earn_basic' => $row['Earn Basic'],
                'earn_hr' => $row['Earn Hr'],
                'earn_conveyance' => $row['Earn Conveyance'],
                'earn_medical_allowance' => $row['Earn Medical Allowance'],
                'earn_special_allowance' => $row['Earn Special Allowance'],
                'earn_other_allowance' => $row['Earn Other Allowance'],
                'earn_ot_wages' => $row['Earn Ot Wages'],
                'earn_attendance_bonus' => $row['Earn Attendance Bonus'],
                'earn_st_bonus' => $row['Earn St Bonus'],
                'earn_holiday_wages' => $row['Earn Holiday Wages'],
                'earn_other_wages' => $row['Earn Other Wages'],
                'earn_total_gross' => $row['Earn Total Gross'],
                'earn_education_allowance' => $row['Earn Education Allowance'],
                'earn_leave_wages' => $row['Earn Leave Wages'],
                'earn_incentive_wages' => $row['Earn Incentive Wages'],
                'earn_arrear_wages' => $row['Earn Arrear Wages'],
                'arr_basic' => $row['Arr Basic'],
                'arr_hra' => $row['Arr Hra'],
                'arr_conveyance' => $row['Arr Conveyance'],
                'arr_medical_reimbursement' => $row['Arr Medical Reimbursement'],
                'arr_special_allowance' => $row['Arr Special Allowance'],
                'arr_other_allowance' => $row['Arr Other Allowance'],
                'arr_ot_wages' => $row['Arr Ot Wages'],
                'arr_attendance_bonus' => $row['Arr Attendance Bonus'],
                'arr_st_bonus' => $row['Arr St Bonus'],
                'arr_holiday_wages' => $row['Arr Holiday Wages'],
                'arr_other_wages' => $row['Arr Other Wages'],
                'arr_total_gross' => $row['Arr Total Gross'],
                'total_basic' => $row['Total Basic'],
                'total_hra' => $row['Total Hra'],
                'total_conveyance' => $row['Total Conveyance'],
                'total_medical_reimbursement' => $row['Total Medical Reimbursement'],
                'total_special_allowance' => $row['Total Special Allowance'],
                'total_other_allowance' => $row['Total Other Allowance'],
                'total_ot_wages' => $row['Total Ot Wages'],
                'total_attendance_bonus' => $row['Total Attendance Bonus'],
                'total_st_bonus' => $row['Total St Bonus'],
                'total_holiday_wages' => $row['Total Holiday Wages'],
                'total_other_wages' => $row['Total Other Wages'],
                'total_total_gross' => $row['Total Total Gross'],
                'epf' => $row['Epf'],
                'esic' => $row['Esic'],
                'pt' => $row['Pt'],
                'it' => $row['It'],
                'lwf' => $row['Lwf'],
                'salary_advance' => $row['Salary Advance'],
                'other_deduction' => $row['Other Deduction'],
                'total_deduction' => $row['Total Deduction'],
                'net_salary' => $row['Net Salary'],
                'in_words' => $row['In Words'],
                'month' => $this->month,
                'year' => $this->year,
            ];
        }

        // Perform bulk insert
        Payslips::insert($data);
    }
}
