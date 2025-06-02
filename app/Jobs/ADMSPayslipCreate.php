<?php

namespace App\Jobs;

use App\Models\Payslips;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use NumberFormatter;

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
        foreach ($this->payslips as $key => $row) {
            $fileName = 'payslip_' . $row['emp_id'] . '_' . $this->month . '_' . $this->year . '.pdf';
            $filePath = 'payslips/' . $fileName;

            $data[] = [
                'emp_id' => $row['emp_id'],
                'client_emp_id' => $row['client_emp_id'],
                'emp_name' => $row['emp_name'],
                'designation' => $row['designation'],
                'doj' => $row['doj'],
                'department' => $row['department'],
                'vertical' => $row['vertical'],
                'location' => $row['location'],
                'client_name' => $row['client_name'],
                'uan_no' => $row['uan_no'],
                'pf_no' => $row['pf_no'],
                'esi_no' => $row['esi_no'],
                'bank_name' => $row['bank_name'],
                'account_no' => $row['account_no'],
                'ifsc_code' => $row['ifsc_code'],
                'month_days' => $row['month_days'],
                'payable_days' => $row['payable_days'],
                'leave_days' => $row['leave_days'],
                'lop_days' => $row['lop_days'],
                'arrears_days' => $row['arrears_days'],
                'ot_hours' => $row['ot_hours'],
                'leave_balance' => $row['leave_balance'],
                'notice_period_days' => $row['notice_period_days'],
                'fixed_basic_da' => $row['fixed_basic_da'],
                'fixed_hra' => $row['fixed_hra'],
                'fixed_conveyance' => $row['fixed_conveyance'],
                'fixed_medical_reimbursement' => $row['fixed_medical_reimbursement'],
                'fixed_special_allowance' => $row['fixed_special_allowance'],
                'fixed_other_allowance' => $row['fixed_other_allowance'],
                'fixed_ot_wages' => $row['fixed_ot_wages'],
                'fixed_attendance_bonus' => $row['fixed_attendance_bonus'],
                'fixed_st_bonus' => $row['fixed_st_bonus'],
                'fixed_holiday_wages' => $row['fixed_holiday_wages'],
                'fixed_other_wages' => $row['fixed_other_wages'],
                'fixed_total_earnings' => $row['fixed_total_earnings'],
                'fix_education_allowance' => $row['fix_education_allowance'],
                'fix_leave_wages' => $row['fix_leave_wages'],
                'fix_incentive_wages' => $row['fix_incentive_wages'],
                'fix_arrear_wages' => $row['fix_arrear_wages'],
                'earn_basic' => $row['earn_basic'],
                'earn_hr' => $row['earn_hr'],
                'earn_conveyance' => $row['earn_conveyance'],
                'earn_medical_allowance' => $row['earn_medical_allowance'],
                'earn_special_allowance' => $row['earn_special_allowance'],
                'earn_other_allowance' => $row['earn_other_allowance'],
                'earn_ot_wages' => $row['earn_ot_wages'],
                'earn_attendance_bonus' => $row['earn_attendance_bonus'],
                'earn_st_bonus' => $row['earn_st_bonus'],
                'earn_holiday_wages' => $row['earn_holiday_wages'],
                'earn_other_wages' => $row['earn_other_wages'],
                'earn_total_gross' => $row['earn_total_gross'],
                'earn_education_allowance' => $row['earn_education_allowance'],
                'earn_leave_wages' => $row['earn_leave_wages'],
                'earn_incentive_wages' => $row['earn_incentive_wages'],
                'earn_arrear_wages' => $row['earn_arrear_wages'],
                'arr_basic' => $row['arr_basic'],
                'arr_hra' => $row['arr_hra'],
                'arr_conveyance' => $row['arr_conveyance'],
                'arr_medical_reimbursement' => $row['arr_medical_reimbursement'],
                'arr_special_allowance' => $row['arr_special_allowance'],
                'arr_other_allowance' => $row['arr_other_allowance'],
                'arr_ot_wages' => $row['arr_ot_wages'],
                'arr_attendance_bonus' => $row['arr_attendance_bonus'],
                'arr_st_bonus' => $row['arr_st_bonus'],
                'arr_holiday_wages' => $row['arr_holiday_wages'],
                'arr_other_wages' => $row['arr_other_wages'],
                'arr_total_gross' => $row['arr_total_gross'],
                'total_basic' => $row['total_basic'],
                'total_hra' => $row['total_hra'],
                'total_conveyance' => $row['total_conveyance'],
                'total_medical_reimbursement' => $row['total_medical_reimbursement'],
                'total_special_allowance' => $row['total_special_allowance'],
                'total_other_allowance' => $row['total_other_allowance'],
                'total_ot_wages' => $row['total_ot_wages'],
                'total_attendance_bonus' => $row['total_attendance_bonus'],
                'total_st_bonus' => $row['total_st_bonus'],
                'total_holiday_wages' => $row['total_holiday_wages'],
                'total_other_wages' => $row['total_other_wages'],
                'total_total_gross' => $row['total_total_gross'],
                'epf' => $row['epf'],
                'esic' => $row['esic'],
                'pt' => $row['pt'],
                'it' => $row['it'],
                'lwf' => $row['lwf'],
                'salary_advance' => $row['salary_advance'],
                'other_deduction' => $row['other_deduction'],
                'total_deduction' => $row['total_deduction'],
                'net_salary' => $row['net_salary'],
                'in_words' => ucfirst($formatter->format($row['net_salary'])),
                'month' => $this->month,
                'year' => $this->year,
                'date_upload' => now(),
                'modify_on' => now(),
            ];
            $paypdf[] = [
                'row' => $row,
                'payslips_letter_path' => $filePath
            ];
        }
        //working only in live
        // Perform bulk insert
        Payslips::insert($data);
        foreach ($paypdf as $pdfData) {
            $pdf = Pdf::loadView('admin.adms.payslip.formate', ['payslip' => $pdfData['row']]);
            Storage::disk('public')->put($pdfData['payslips_letter_path'], $pdf->output());
        }
    }
}
