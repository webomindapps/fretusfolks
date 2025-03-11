<?php

namespace App\Jobs;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;

class GeneratePayslipPDFs implements ShouldQueue
{
    use Queueable;
    public $payslip;
    /**
     * Create a new job instance.
     */
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

        $pdf = Pdf::loadView('admin.hr_management.ffi.payslips.print_payslips', $data)
            ->setPaper('A4', 'portrait')
            ->setOptions(['margin-top' => 10, 'margin-bottom' => 10, 'margin-left' => 15, 'margin-right' => 15]);
        $tempPath = storage_path('app/temp/');
        $fileName = 'payslip_' . $this->payslip->id . '.pdf';
        $filePath = $tempPath . $fileName;

        // Save the PDF
        file_put_contents($filePath, $pdf->output());
    }
}
