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
    public $tries = 2;
    public $backoff = 30;
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
            $fileName = 'payslip_' . $row['employee_name'] . '_' . $row['employee_id'] . '_' . $this->month . '_' . $this->year . '_' . $uniqueId . '.pdf';



            $filePath = 'payslips/' . $fileName;

            $data[] = [
                'emp_id' => isset($row['employee_id']) ? $row['employee_id'] : 0,
                'client_emp_id' => isset($row['client_employee_id']) ? $row['client_employee_id'] : 0,
                'emp_name' => isset($row['employee_name']) ? $row['employee_name'] : 'N/A',
                'designation' => isset($row['designation']) ? $row['designation'] : 'N/A',
                'doj' => date('Y-m-d', strtotime($row['date_of_joining'])),
                'department' => isset($row['department']) ? $row['department'] : 'N/A',
                'vertical' => isset($row['vertical']) ? $row['vertical'] : 'N/A',
                'location' => isset($row['location']) ? $row['location'] : 'N/A',
                'client_name' => isset($row['client_name']) ? $row['client_name'] : 'N/A',
                'uan_no' => isset($row['uan_number']) ? $row['uan_number'] : 'N/A',
                'pf_no' => isset($row['pf_number']) ? $row['pf_number'] : 'N/A',
                'esi_no' => isset($row['esi_number']) ? $row['esi_number'] : 'N/A',
                'bank_name' => isset($row['bank_name']) ? $row['bank_name'] : 'N/A',
                'account_no' => isset($row['account_number']) ? $row['account_number'] : 'N/A',
                'ifsc_code' => isset($row['ifsc_code']) ? $row['ifsc_code'] : 'N/A',
                'month_days' => isset($row['month_days']) ? $row['month_days'] : 0,
                'payable_days' => isset($row['payable_days']) ? $row['payable_days'] : 0,
                'leave_days' => isset($row['leave_days']) ? $row['leave_days'] : 0,
                'lop_days' => isset($row['lop_days']) ? $row['lop_days'] : 0,
                'arrears_days' => isset($row['arrears_days']) ? $row['arrears_days'] : 0,
                'ot_hours' => isset($row['ot_hours']) ? $row['ot_hours'] : 0,
                'leave_balance' => isset($row['leave_balance']) ? $row['leave_balance'] : 0,
                'notice_period_days' => isset($row['notice_period_days']) ? $row['notice_period_days'] : 0,

                'fixed_basic_da' => isset($row['fixed_basic_da']) ? $row['fixed_basic_da'] : 0,
                'fixed_hra' => isset($row['fixed_hra']) ? $row['fixed_hra'] : 0,
                'fixed_conveyance' => isset($row['fixed_conveyance']) ? $row['fixed_conveyance'] : 0,
                'fixed_medical_reimbursement' => isset($row['fixed_medical_reimbursement']) ? $row['fixed_medical_reimbursement'] : 0,
                'fixed_special_allowance' => isset($row['fixed_special_allowance']) ? $row['fixed_special_allowance'] : 0,
                'fixed_other_allowance' => isset($row['fixed_other_allowance']) ? $row['fixed_other_allowance'] : 0,
                'fixed_ot_wages' => isset($row['fixed_ot_wages']) ? $row['fixed_ot_wages'] : 0,
                'fixed_attendance_bonus' => isset($row['fixed_attendance_bonus']) ? $row['fixed_attendance_bonus'] : 0,
                'fixed_st_bonus' => isset($row['fixed_st_bonus']) ? $row['fixed_st_bonus'] : 0,
                'fixed_holiday_wages' => isset($row['fixed_holiday_wages']) ? $row['fixed_holiday_wages'] : 0,
                'fixed_other_wages' => isset($row['fixed_other_wages']) ? $row['fixed_other_wages'] : 0,
                'fixed_total_earnings' => isset($row['fixed_total_earnings']) ? $row['fixed_total_earnings'] : 0,
                'fix_education_allowance' => isset($row['fix_education_allowance']) ? $row['fix_education_allowance'] : 0,
                'fix_leave_wages' => isset($row['fixed_leave_wages']) ? $row['fixed_leave_wages'] : 0,
                'fix_incentive_wages' => isset($row['fixed_incentive_wages']) ? $row['fixed_incentive_wages'] : 0,
                'fix_arrear_wages' => isset($row['fixed_arrear_wages']) ? $row['fixed_arrear_wages'] : 0,

                'earn_basic' => isset($row['earned_basic']) ? $row['earned_basic'] : 0,
                'earn_hr' => isset($row['earned_hra']) ? $row['earned_hra'] : 0,
                'earn_conveyance' => isset($row['earned_conveyance']) ? $row['earned_conveyance'] : 0,
                'earn_medical_allowance' => isset($row['earn_medical_allowance']) ? $row['earn_medical_allowance'] : 0,
                'earn_special_allowance' => isset($row['earned_special_allowance']) ? $row['earned_special_allowance'] : 0,
                'earn_other_allowance' => isset($row['earned_other_allowance']) ? $row['earned_other_allowance'] : 0,
                'earn_ot_wages' => isset($row['earned_ot_wages']) ? $row['earned_ot_wages'] : 0,
                'earn_attendance_bonus' => isset($row['earned_attendance_bonus']) ? $row['earned_attendance_bonus'] : 0,
                'earn_st_bonus' => isset($row['earned_st_bonus']) ? $row['earned_st_bonus'] : 0,
                'earn_holiday_wages' => isset($row['earned_holiday_wages']) ? $row['earned_holiday_wages'] : 0,
                'earn_other_wages' => isset($row['earned_other_wages']) ? $row['earned_other_wages'] : 0,
                'earn_total_gross' => isset($row['earned_total_gross']) ? $row['earned_total_gross'] : 0,
                'earn_education_allowance' => isset($row['earn_education_allowance']) ? $row['earn_education_allowance'] : 0,
                'earn_leave_wages' => isset($row['earned_leave_wages']) ? $row['earned_leave_wages'] : 0,
                'earn_incentive_wages' => isset($row['earned_incentive_wages']) ? $row['earned_incentive_wages'] : 0,
                'earn_arrear_wages' => isset($row['earned_arrear_wages']) ? $row['earned_arrear_wages'] : 0,

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

                'epf' => isset($row['epf']) ? $row['epf'] : 0,
                'esic' => isset($row['esic']) ? $row['esic'] : 0,
                'pt' => isset($row['pt']) ? $row['pt'] : 0,
                'it' => isset($row['it']) ? $row['it'] : 0,
                'lwf' => isset($row['lwf']) ? $row['lwf'] : 0,
                'salary_advance' => isset($row['salary_advance']) ? $row['salary_advance'] : 0,
                'other_deduction' => isset($row['other_deduction']) ? $row['other_deduction'] : 0,
                'notice_period_deducation' => isset($row['notice_period_deduction']) ? $row['notice_period_deduction'] : 0,
                'total_deduction' => isset($row['total_deduction']) ? $row['total_deduction'] : 0,
                'net_salary' => isset($row['net_salary']) ? $row['net_salary'] : 0,
                'in_words' => $row['in_words'],
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
        \Log::info('payslip:', $data);

    }
}
