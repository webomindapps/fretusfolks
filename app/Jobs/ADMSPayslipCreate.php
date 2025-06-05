<?php

namespace App\Jobs;

use NumberFormatter;
use App\Models\Payslips;
use Illuminate\Bus\Batchable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
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
        foreach ($this->payslips as $key => $row) {

            $uniqueId = time() . '_' . uniqid(); // Generates a unique identifier
            $fileName = 'payslip_' . $row['emp_id'] . '_' . $this->month . '_' . $this->year . '_' . $uniqueId . '.pdf';



            $filePath = 'payslips/' . $fileName;

            $data[] = [
                'emp_id' => isset($row['emp_id']) ? $row['emp_id'] : 0,
                'client_emp_id' => isset($row['client_emp_id']) ? $row['client_emp_id'] : 0,
                'emp_name' => isset($row['emp_name']) ? $row['emp_name'] : 'N/A',
                'designation' => isset($row['designation']) ? $row['designation'] : 'N/A',
                'doj' => !empty($row['doj']) ? \Carbon\Carbon::parse($row['doj']) : null,
                'department' => isset($row['department']) ? $row['department'] : 'N/A',
                'vertical' => isset($row['vertical']) ? $row['vertical'] : 'N/A',
                'location' => isset($row['location']) ? $row['location'] : 'N/A',
                'client_name' => isset($row['client_name']) ? $row['client_name'] : 'N/A',
                'uan_no' => isset($row['uan_no']) ? $row['uan_no'] : 'N/A',
                'pf_no' => isset($row['pf_no']) ? $row['pf_no'] : 'N/A',
                'esi_no' => isset($row['esi_no']) ? $row['esi_no'] : 'N/A',
                'bank_name' => isset($row['bank_name']) ? $row['bank_name'] : 'N/A',
                'account_no' => isset($row['account_no']) ? $row['account_no'] : 'N/A',
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
                'fix_leave_wages' => isset($row['fix_leave_wages']) ? $row['fix_leave_wages'] : 0,
                'fix_incentive_wages' => isset($row['fix_incentive_wages']) ? $row['fix_incentive_wages'] : 0,
                'fix_arrear_wages' => isset($row['fix_arrear_wages']) ? $row['fix_arrear_wages'] : 0,

                'earn_basic' => isset($row['earn_basic']) ? $row['earn_basic'] : 0,
                'earn_hr' => isset($row['earn_hr']) ? $row['earn_hr'] : 0,
                'earn_conveyance' => isset($row['earn_conveyance']) ? $row['earn_conveyance'] : 0,
                'earn_medical_allowance' => isset($row['earn_medical_allowance']) ? $row['earn_medical_allowance'] : 0,
                'earn_special_allowance' => isset($row['earn_special_allowance']) ? $row['earn_special_allowance'] : 0,
                'earn_other_allowance' => isset($row['earn_other_allowance']) ? $row['earn_other_allowance'] : 0,
                'earn_ot_wages' => isset($row['earn_ot_wages']) ? $row['earn_ot_wages'] : 0,
                'earn_attendance_bonus' => isset($row['earn_attendance_bonus']) ? $row['earn_attendance_bonus'] : 0,
                'earn_st_bonus' => isset($row['earn_st_bonus']) ? $row['earn_st_bonus'] : 0,
                'earn_holiday_wages' => isset($row['earn_holiday_wages']) ? $row['earn_holiday_wages'] : 0,
                'earn_other_wages' => isset($row['earn_other_wages']) ? $row['earn_other_wages'] : 0,
                'earn_total_gross' => isset($row['earn_total_gross']) ? $row['earn_total_gross'] : 0,
                'earn_education_allowance' => isset($row['earn_education_allowance']) ? $row['earn_education_allowance'] : 0,
                'earn_leave_wages' => isset($row['earn_leave_wages']) ? $row['earn_leave_wages'] : 0,
                'earn_incentive_wages' => isset($row['earn_incentive_wages']) ? $row['earn_incentive_wages'] : 0,
                'earn_arrear_wages' => isset($row['earn_arrear_wages']) ? $row['earn_arrear_wages'] : 0,

                'arr_basic' => isset($row['arr_basic']) ? $row['arr_basic'] : 0,
                'arr_hra' => isset($row['arr_hra']) ? $row['arr_hra'] : 0,
                'arr_conveyance' => isset($row['arr_conveyance']) ? $row['arr_conveyance'] : 0,
                'arr_medical_reimbursement' => isset($row['arr_medical_reimbursement']) ? $row['arr_medical_reimbursement'] : 0,
                'arr_special_allowance' => isset($row['arr_special_allowance']) ? $row['arr_special_allowance'] : 0,
                'arr_other_allowance' => isset($row['arr_other_allowance']) ? $row['arr_other_allowance'] : 0,
                'arr_ot_wages' => isset($row['arr_ot_wages']) ? $row['arr_ot_wages'] : 0,
                'arr_attendance_bonus' => isset($row['arr_attendance_bonus']) ? $row['arr_attendance_bonus'] : 0,
                'arr_st_bonus' => isset($row['arr_st_bonus']) ? $row['arr_st_bonus'] : 0,
                'arr_holiday_wages' => isset($row['arr_holiday_wages']) ? $row['arr_holiday_wages'] : 0,
                'arr_other_wages' => isset($row['arr_other_wages']) ? $row['arr_other_wages'] : 0,
                'arr_total_gross' => isset($row['arr_total_gross']) ? $row['arr_total_gross'] : 0,

                'total_basic' => isset($row['total_basic']) ? $row['total_basic'] : 0,
                'total_hra' => isset($row['total_hra']) ? $row['total_hra'] : 0,
                'total_conveyance' => isset($row['total_conveyance']) ? $row['total_conveyance'] : 0,
                'total_medical_reimbursement' => isset($row['total_medical_reimbursement']) ? $row['total_medical_reimbursement'] : 0,
                'total_special_allowance' => isset($row['total_special_allowance']) ? $row['total_special_allowance'] : 0,
                'total_other_allowance' => isset($row['total_other_allowance']) ? $row['total_other_allowance'] : 0,
                'total_ot_wages' => isset($row['total_ot_wages']) ? $row['total_ot_wages'] : 0,
                'total_attendance_bonus' => isset($row['total_attendance_bonus']) ? $row['total_attendance_bonus'] : 0,
                'total_st_bonus' => isset($row['total_st_bonus']) ? $row['total_st_bonus'] : 0,
                'total_holiday_wages' => isset($row['total_holiday_wages']) ? $row['total_holiday_wages'] : 0,
                'total_other_wages' => isset($row['total_other_wages']) ? $row['total_other_wages'] : 0,
                'total_total_gross' => isset($row['total_total_gross']) ? $row['total_total_gross'] : 0,

                'epf' => isset($row['epf']) ? $row['epf'] : 0,
                'esic' => isset($row['esic']) ? $row['esic'] : 0,
                'pt' => isset($row['pt']) ? $row['pt'] : 0,
                'it' => isset($row['it']) ? $row['it'] : 0,
                'lwf' => isset($row['lwf']) ? $row['lwf'] : 0,
                'salary_advance' => isset($row['salary_advance']) ? $row['salary_advance'] : 0,
                'other_deduction' => isset($row['other_deduction']) ? $row['other_deduction'] : 0,
                'total_deduction' => isset($row['total_deduction']) ? $row['total_deduction'] : 0,
                'net_salary' => (float) (isset($row['net_salary']) ? $row['net_salary'] : 0),
                'in_words' => ucfirst($formatter->format(isset($row['net_salary']) ? $row['net_salary'] : 0)),
                'month' => $this->month,
                'year' => $this->year,
                'date_upload' => now(),
                'modify_on' => now(),
                'payslips_letter_path' => $filePath,
            ];
            $paypdf[] = [
                'row' => $row,
                'payslips_letter_path' => $filePath
            ];
        }
        \Log::info('Generated data:', $data);

        // Perform bulk insert
        foreach ($paypdf as $pdfData) {
            $pdf = Pdf::loadView('admin.adms.payslip.formate', ['payslip' => $pdfData['row']]);
            Storage::disk('public')->put($pdfData['payslips_letter_path'], $pdf->output());
        }
        // dd($data);
        Payslips::insert($data);

    }
}
