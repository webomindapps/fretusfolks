<?php

namespace App\Jobs;

use DateTime;
use Illuminate\Bus\Batchable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class GeneratePayslipPDFs implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, SerializesModels, Batchable;

    public $payslip;

    public function __construct($payslip)
    {
        $this->payslip = $payslip;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = [
            'payslip' => $this->payslip,
        ];
        $payslip = $this->payslip;
        $month = DateTime::createFromFormat('!m', $this->payslip['month'])->format('F');
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'chroot' => public_path()
        ])->loadView('admin.adms.payslip.formate', $data);
        $tempPath = storage_path('app/temp/');
        $fileName = 'Payslip_' . $this->payslip['emp_id'] . '-' . $this->payslip['emp_name'] . '-' . $month . '-' . $this->payslip['year'] . '.pdf';
        $filePath = $tempPath . $fileName;

        // Save the PDF
        file_put_contents($filePath, $pdf->output());
        $payslip->payslips_letter_path = $fileName;
        $payslip->save();
        \Log::info("Payslip created: {$filePath}");
    }
}
