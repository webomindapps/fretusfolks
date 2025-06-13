<?php

namespace App\Jobs;

use App\Models\Payslips;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GeneratePayslipPDFs implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, SerializesModels, Batchable;

    public $payslip;

    public function __construct(array $payslip)
    {
        $this->payslip = $payslip;
    }

    public function handle(): void
    {
        $payslip = $this->payslip;

        $pdf = Pdf::loadView('admin.adms.payslip.formate', ['payslip' => $payslip])
            ->setPaper('A4', 'portrait');

        $fileName = 'payslip_' . $this->payslip['id'] . $this->payslip['emp_id'] . $this->payslip['emp_name'] . '.pdf';
        $filePath = storage_path('app/temp/payslips/' . $fileName);

        \Log::info('Generated data:', $payslip);


        // Ensure directory exists
        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);
        }

        // Save PDF
        file_put_contents($filePath, $pdf->output());

        // Update DB record
        $payslip->payslips_letter_path = $fileName;
        $payslip->save();
    }
}
