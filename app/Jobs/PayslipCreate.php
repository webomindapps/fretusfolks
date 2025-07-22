<?php

namespace App\Jobs;

use Carbon\Carbon;
use NumberFormatter;
use App\Models\FFIPayslipsModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class PayslipCreate implements ShouldQueue
{
    use Queueable;

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
        // \Log::info('Generated data:', $this->payslips);
        foreach ($this->payslips as $key => $row) {
            $data[] = [
                'emp_id' => isset($row['Employee_ID']) ? $row['Employee_ID'] : 0,
                'employee_name' => isset($row['Employee_Name']) ? $row['Employee_Name'] : 'N/A',
                'designation' => isset($row['Designation']) ? $row['Designation'] : 'N/A',
                'location' => isset($row['Location']) ? $row['Location'] : 0,
                'date_of_joining' => date('Y-m-d', strtotime($row['Date_of_Joining'])),
                'department' => isset($row['Department']) ? $row['Department'] : 'N/A',
                'uan_no' => isset($row['UAN_Number']) ? $row['UAN_Number'] : 'N/A',
                'pf_no' => isset($row['PF_Number']) ? $row['PF_Number'] : 'N/A',
                'esi_no' => isset($row['ESI_Number']) ? $row['ESI_Number'] : 'N/A',
                'bank_name' => isset($row['Bank_Name']) ? $row['Bank_Name'] : 'N/A',
                'account_no' => isset($row['Account_Number']) ? $row['Account_Number'] : 'N/A',
                'ifsc_code' => isset($row['IFSC_Code']) ? $row['IFSC_Code'] : 'N/A',
                'month_days' => isset($row['Month_Days']) ? $row['Month_Days'] : 0,
                'pay_days' => isset($row['Payable_Days']) ? $row['Payable_Days'] : 0,
                'leave_days' => isset($row['Leave_Days']) ? $row['Leave_Days'] : 0,
                'lop_days' => isset($row['LOP_Days']) ? $row['LOP_Days'] : 0,
                'arrear_days' => isset($row['Arrears_Days']) ? $row['Arrears_Days'] : 0,
                'ot_hours' => isset($row['OT_Hours']) ? $row['OT_Hours'] : 0,
                'fixed_basic' => isset($row['Fixed_Basic_DA']) ? $row['Fixed_Basic_DA'] : 0,
                'fixed_hra' => isset($row['Fixed_HRA']) ? $row['Fixed_HRA'] : 0,
                'fixed_con_allow' => isset($row['Fixed_Conveyance']) ? $row['Fixed_Conveyance'] : 0,
                'fixed_edu_allowance' => isset($row['Fixed_Education_Allowance']) ? $row['Fixed_Education_Allowance'] : 0,
                'fixed_med_reim' => isset($row['Fixed_Medical_Reimbursement']) ? $row['Fixed_Medical_Reimbursement'] : 0,
                'fixed_spec_allow' => isset($row['Fixed_Special_Allowance']) ? $row['Fixed_Special_Allowance'] : 0,
                'fixed_oth_allow' => isset($row['Fixed_Other_Allowance']) ? $row['Fixed_Other_Allowance'] : 0,
                'fixed_st_bonus' => isset($row['Fixed_ST_Bonus']) ? $row['Fixed_ST_Bonus'] : 0,
                'fixed_leave_wages' => isset($row['Fixed_Leave_Wages']) ? $row['Fixed_Leave_Wages'] : 0,
                'fixed_holidays_wages' => isset($row['Fixed_Holiday_Wages']) ? $row['Fixed_Holiday_Wages'] : 0,
                'fixed_attendance_bonus' => isset($row['Fixed_Attendance_Bonus']) ? $row['Fixed_Attendance_Bonus'] : 0,
                'fixed_ot_wages' => isset($row['Fixed_OT_Wages']) ? $row['Fixed_OT_Wages'] : 0,
                'fixed_incentive' => isset($row['Fixed_Incentive_Wages']) ? $row['Fixed_Incentive_Wages'] : 0,
                'fixed_arrear_wages' => isset($row['Fixed_Arrear_Wages']) ? $row['Fixed_Arrear_Wages'] : 0,
                'fixed_other_wages' => isset($row['Fixed_Other_Wages']) ? $row['Fixed_Other_Wages'] : 0,
                'fixed_gross' => isset($row['Fixed_Gross']) ? $row['Fixed_Gross'] : 0,

                'earned_basic' => isset($row['Earned_Basic']) ? $row['Earned_Basic'] : 0,
                'earned_hra' => isset($row['Earned_HRA']) ? $row['Earned_HRA'] : 0,
                'earned_con_allow' => isset($row['Earned_Conveyance']) ? $row['Earned_Conveyance'] : 0,
                'earned_education_allowance' => isset($row['Earned_Education_Allowance']) ? $row['Earned_Education_Allowance'] : 0,
                'earned_med_reim' => isset($row['Earned_Medical_Reimbursement']) ? $row['Earned_Medical_Reimbursement'] : 0,
                'earned_spec_allow' => isset($row['Earned_Special_Allowance']) ? $row['Earned_Special_Allowance'] : 0,
                'earned_oth_allow' => isset($row['Earned_Other_Allowance']) ? $row['Earned_Other_Allowance'] : 0,
                'earned_st_bonus' => isset($row['Earned_ST_Bonus']) ? $row['Earned_ST_Bonus'] : 0,
                'earned_leave_wages' => isset($row['Earned_Leave_Wages']) ? $row['Earned_Leave_Wages'] : 0,
                'earned_holiday_wages' => isset($row['Earned_Holiday_Wages']) ? $row['Earned_Holiday_Wages'] : 0,
                'earned_attendance_bonus' => isset($row['Earned_Attendance_Bonus']) ? $row['Earned_Attendance_Bonus'] : 0,
                'earned_ot_wages' => isset($row['Earned_OT_Wages']) ? $row['Earned_OT_Wages'] : 0,
                'earned_incentive' => isset($row['Earned_Incentive_Wages']) ? $row['Earned_Incentive_Wages'] : 0,
                'earned_arrear_wages' => isset($row['Earned_Arrear_Wages']) ? $row['Earned_Arrear_Wages'] : 0,
                'earned_other_wages' => isset($row['Earned_Other_Wages']) ? $row['Earned_Other_Wages'] : 0,
                'earned_gross' => isset($row['Earned_Total_Gross']) ? $row['Earned_Total_Gross'] : 0,
                'epf' => isset($row['EPF']) ? $row['EPF'] : 0,
                'esic' => isset($row['ESIC']) ? $row['ESIC'] : 0,
                'pt' => isset($row['PT']) ? $row['PT'] : 0,
                'it' => isset($row['IT']) ? $row['IT'] : 0,
                'lwf' => isset($row['LWF']) ? $row['LWF'] : 0,
                'salary_advance' => isset($row['Salary_Advance']) ? $row['Salary_Advance'] : 0,
                'other_deduction' => isset($row['Other_Deduction']) ? $row['Other_Deduction'] : 0,
                'total_deductions' => isset($row['Total_Deduction']) ? $row['Total_Deduction'] : 0,
                'net_salary' => isset($row['Net_Salary']) ? $row['Net_Salary'] : 0,
                'in_words' => $row['In_Words'],
                'month' => $this->month,
                'year' => $this->year,
            ];
        }
        \Log::info('Generated data:');
        // Perform bulk insert
        FFIPayslipsModel::insert($data);
    }
}
