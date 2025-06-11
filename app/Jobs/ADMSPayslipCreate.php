<?php

namespace App\Jobs;

use Carbon\Carbon;
use NumberFormatter;
use App\Models\Payslips;
use Illuminate\Bus\Batchable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
        $formatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);

        $paypdf = [];
        $data = [];
        // dd($this->payslips);
        // \Log::info('Generated data:', $this->payslips);

        foreach ($this->payslips as $key => $row) {
            \Log::info($row);
            $uniqueId = time() . '_' . uniqid(); // Generates a unique identifier
            $fileName = 'payslip_' . $row['Employee_Name'] . '_' . $row['Employee_ID'] . '_' . $this->month . '_' . $this->year . '_' . $uniqueId . '.pdf';



            $filePath = 'payslips/' . $fileName;

            $data[] = [
                'emp_id' => isset($row['Employee_ID']) ? $row['Employee_ID'] : 0,
                'client_emp_id' => isset($row['Client_Employee_ID']) ? $row['Client_Employee_ID'] : 0,
                'emp_name' => isset($row['Employee_Name']) ? $row['Employee_Name'] : 'N/A',
                'designation' => isset($row['Designation']) ? $row['Designation'] : 'N/A',
                'doj' => date('Y-m-d', strtotime($row['Date_of_Joining'])),
                'department' => isset($row['Department']) ? $row['Department'] : 'N/A',
                'vertical' => isset($row['Vertical']) ? $row['Vertical'] : 'N/A',
                'location' => isset($row['Location']) ? $row['Location'] : 'N/A',
                'client_name' => isset($row['Client_Name']) ? $row['Client_Name'] : 'N/A',
                'uan_no' => isset($row['UAN_Number']) ? $row['UAN_Number'] : 'N/A',
                'pf_no' => isset($row['PF_Number']) ? $row['PF_Number'] : 'N/A',
                'esi_no' => isset($row['ESI_Number']) ? $row['ESI_Number'] : 'N/A',
                'bank_name' => isset($row['Bank_Name']) ? $row['Bank_Name'] : 'N/A',
                'account_no' => isset($row['Account_Number']) ? $row['Account_Number'] : 'N/A',
                'ifsc_code' => isset($row['IFSC_Code']) ? $row['IFSC_Code'] : 'N/A',
                'month_days' => isset($row['Month_Days']) ? $row['Month_Days'] : 0,
                'payable_days' => isset($row['Payable_Days']) ? $row['Payable_Days'] : 0,
                'leave_days' => isset($row['Leave_Days']) ? $row['Leave_Days'] : 0,
                'lop_days' => isset($row['LOP_Days']) ? $row['LOP_Days'] : 0,
                'arrears_days' => isset($row['Arrears_Days']) ? $row['Arrears_Days'] : 0,
                'ot_hours' => isset($row['OT_Hours']) ? $row['OT_Hours'] : 0,
                'leave_balance' => isset($row['Leave_Balance']) ? $row['Leave_Balance'] : 0,
                'notice_period_days' => isset($row['Notice_Period_Days']) ? $row['Notice_Period_Days'] : 0,

                'fixed_basic_da' => isset($row['Fixed_Basic_DA']) ? $row['Fixed_Basic_DA'] : 0,
                'fixed_hra' => isset($row['Fixed_HRA']) ? $row['Fixed_HRA'] : 0,
                'fixed_conveyance' => isset($row['Fixed_Conveyance']) ? $row['Fixed_Conveyance'] : 0,
                'fixed_medical_reimbursement' => isset($row['Fixed_Medical_Reimbursement']) ? $row['Fixed_Medical_Reimbursement'] : 0,
                'fixed_special_allowance' => isset($row['Fixed_Special_Allowance']) ? $row['Fixed_Special_Allowance'] : 0,
                'fixed_other_allowance' => isset($row['Fixed_Other_Allowance']) ? $row['Fixed_Other_Allowance'] : 0,
                'fixed_ot_wages' => isset($row['Fixed_OT_Wages']) ? $row['Fixed_OT_Wages'] : 0,
                'fixed_attendance_bonus' => isset($row['Fixed_Attendance_Bonus']) ? $row['Fixed_Attendance_Bonus'] : 0,
                'fixed_st_bonus' => isset($row['Fixed_ST_Bonus']) ? $row['Fixed_ST_Bonus'] : 0,
                'fixed_holiday_wages' => isset($row['Fixed_Holiday_Wages']) ? $row['Fixed_Holiday_Wages'] : 0,
                'fixed_other_wages' => isset($row['Fixed_Other_Wages']) ? $row['Fixed_Other_Wages'] : 0,
                'fixed_total_earnings' => isset($row['Fixed_Total_Earnings']) ? $row['Fixed_Total_Earnings'] : 0,
                'fix_education_allowance' => isset($row['Fixed_Education_Allowance']) ? $row['Fixed_Education_Allowance'] : 0,
                'fix_leave_wages' => isset($row['Fixed_Leave_Wages']) ? $row['Fixed_Leave_Wages'] : 0,
                'fix_incentive_wages' => isset($row['Fixed_Incentive_Wages']) ? $row['Fixed_Incentive_Wages'] : 0,
                'fix_arrear_wages' => isset($row['Fixed_Arrear_Wages']) ? $row['Fixed_Arrear_Wages'] : 0,

                'earn_basic' => isset($row['Earned_Basic']) ? $row['Earned_Basic'] : 0,
                'earn_hr' => isset($row['Earned_HRA']) ? $row['Earned_HRA'] : 0,
                'earn_conveyance' => isset($row['Earned_Conveyance']) ? $row['Earned_Conveyance'] : 0,
                'earn_medical_allowance' => isset($row['Earned_Medical_Allowance']) ? $row['Earned_Medical_Allowance'] : 0,
                'earn_special_allowance' => isset($row['Earned_Special_Allowance']) ? $row['Earned_Special_Allowance'] : 0,
                'earn_other_allowance' => isset($row['Earned_Other_Allowance']) ? $row['Earned_Other_Allowance'] : 0,
                'earn_ot_wages' => isset($row['Earned_OT_Wages']) ? $row['Earned_OT_Wages'] : 0,
                'earn_attendance_bonus' => isset($row['Earned_Attendance_Bonus']) ? $row['Earned_Attendance_Bonus'] : 0,
                'earn_st_bonus' => isset($row['Earned_ST_Bonus']) ? $row['Earned_ST_Bonus'] : 0,
                'earn_holiday_wages' => isset($row['Earned_Holiday_Wages']) ? $row['Earned_Holiday_Wages'] : 0,
                'earn_other_wages' => isset($row['Earned_Other_Wages']) ? $row['Earned_Other_Wages'] : 0,
                'earn_total_gross' => isset($row['Earned_Total_Gross']) ? $row['Earned_Total_Gross'] : 0,
                'earn_education_allowance' => isset($row['Earned_Education_Allowance']) ? $row['Earned_Education_Allowance'] : 0,
                'earn_leave_wages' => isset($row['Earned_Leave_Wages']) ? $row['Earned_Leave_Wages'] : 0,
                'earn_incentive_wages' => isset($row['Earned_Incentive_Wages']) ? $row['Earned_Incentive_Wages'] : 0,
                'earn_arrear_wages' => isset($row['Earned_Arrear_Wages']) ? $row['Earned_Arrear_Wages'] : 0,

                'arr_basic' => isset($row['Arrears_Basic']) ? $row['Arrears_Basic'] : 0,
                'arr_hra' => isset($row['Arrears_HRA']) ? $row['Arrears_HRA'] : 0,
                'arr_conveyance' => isset($row['Arrears_Conveyance']) ? $row['Arrears_Conveyance'] : 0,
                'arr_medical_reimbursement' => isset($row['Arrears_Medical_Reimbursement']) ? $row['Arrears_Medical_Reimbursement'] : 0,
                'arr_special_allowance' => isset($row['Arrears_Special_Allowance']) ? $row['Arrears_Special_Allowance'] : 0,
                'arr_other_allowance' => isset($row['Arrears_Other_Allowance']) ? $row['Arrears_Other_Allowance'] : 0,
                'arr_ot_wages' => isset($row['Arrears_OT_Wages']) ? $row['Arrears_OT_Wages'] : 0,
                'arr_attendance_bonus' => isset($row['Arrears_Attendance_Bonus']) ? $row['Arrears_Attendance_Bonus'] : 0,
                'arr_st_bonus' => isset($row['Arrears_ST_Bonus']) ? $row['Arrears_ST_Bonus'] : 0,
                'arr_holiday_wages' => isset($row['Arrears_Holiday_Wages']) ? $row['Arrears_Holiday_Wages'] : 0,
                'arr_other_wages' => isset($row['Arrears_Other_Wages']) ? $row['Arrears_Other_Wages'] : 0,
                'arr_total_gross' => isset($row['Arrears_Total_Gross']) ? $row['Arrears_Total_Gross'] : 0,

                'total_basic' => isset($row['Total_Basic']) ? $row['Total_Basic'] : 0,
                'total_hra' => isset($row['Total_HRA']) ? $row['Total_HRA'] : 0,
                'total_conveyance' => isset($row['Total_Conveyance']) ? $row['Total_Conveyance'] : 0,
                'total_medical_reimbursement' => isset($row['Total_Medical_Reimbursement']) ? $row['Total_Medical_Reimbursement'] : 0,
                'total_special_allowance' => isset($row['Total_Special_Allowance']) ? $row['Total_Special_Allowance'] : 0,
                'total_other_allowance' => isset($row['Total_Other_Allowance']) ? $row['Total_Other_Allowance'] : 0,
                'total_ot_wages' => isset($row['Total_OT_Wages']) ? $row['Total_OT_Wages'] : 0,
                'total_attendance_bonus' => isset($row['Total_Attendance_Bonus']) ? $row['Total_Attendance_Bonus'] : 0,
                'total_st_bonus' => isset($row['Total_ST_Bonus']) ? $row['Total_ST_Bonus'] : 0,
                'total_holiday_wages' => isset($row['Total_Holiday_Wages']) ? $row['Total_Holiday_Wages'] : 0,
                'total_other_wages' => isset($row['Total_Other_Wages']) ? $row['Total_Other_Wages'] : 0,
                'total_total_gross' => isset($row['Total_Total_Gross']) ? $row['Total_Total_Gross'] : 0,

                'epf' => isset($row['EPF']) ? $row['EPF'] : 0,
                'esic' => isset($row['ESIC']) ? $row['ESIC'] : 0,
                'pt' => isset($row['PT']) ? $row['PT'] : 0,
                'it' => isset($row['IT']) ? $row['IT'] : 0,
                'lwf' => isset($row['LWF']) ? $row['LWF'] : 0,
                'salary_advance' => isset($row['Salary_Advance']) ? $row['Salary_Advance'] : 0,
                'other_deduction' => isset($row['Other_Deduction']) ? $row['Other_Deduction'] : 0,
                'notice_period_deducation' => isset($row['Notice_Period_Deduction']) ? $row['Notice_Period_Deduction'] : 0,
                'total_deduction' => isset($row['Total_Deduction']) ? $row['Total_Deduction'] : 0,
                'net_salary' => isset($row['Net_Salary']) ? $row['Net_Salary'] : 0,
                'in_words' => $row['In_Words'],
                'month' => $this->month,
                'year' => $this->year,
                'date_upload' => now(),
                'modify_on' => now(),
                'payslips_letter_path' => $filePath,
            ];
            $paypdf[] = [
                'row' => array_merge($row, [
                    'month' => $this->month,
                    'year' => $this->year,
                ]),
                'payslips_letter_path' => $filePath
            ];
        }
        // \Log::info('Generated data:', $data);

        // Perform bulk insert
        foreach ($paypdf as $pdfData) {
            $pdf = Pdf::loadView('admin.adms.payslip.formate', [
                'payslip' => $pdfData['row']
            ]);
            Storage::disk('public')->put($pdfData['payslips_letter_path'], $pdf->output());
        }
        // dd($data);
        Payslips::insert($data);

    }
}
