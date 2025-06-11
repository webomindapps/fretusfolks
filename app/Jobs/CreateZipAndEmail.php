<?php

namespace App\Jobs;

use ZipArchive;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\PayslipZipReady;
use Illuminate\Bus\Batchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateZipAndEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels, Batchable;

    public $payslips;
    public $email;

    public function __construct($payslips, $email)
    {
        $this->payslips = $payslips;
        $this->email = is_array($email) ? $email : [$email];
    }

    public function handle()
    {
        $zipFileName = "Payslips_{$this->payslips->first()->client_name}_{$this->payslips->first()->month}_{$this->payslips->first()->year}.zip";
        $zipPath = storage_path("app/temp/{$zipFileName}");

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($this->payslips as $payslip) {
                // Generate PDF from view and data
                $pdf = PDF::setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'chroot' => public_path()
                ])->loadView('admin.adms.payslip.formate', ['payslip' => $payslip]);

                // Add in-memory PDF to ZIP
                $zip->addFromString("payslip_{$payslip->emp_name}_{$payslip->emp_id}.pdf", $pdf->output());
            }
            $zip->close();
        }

        // Send ZIP file via email
        Mail::to($this->email)->send(new PayslipZipReady($zipPath, $zipFileName));

        // Delete ZIP after sending
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }
    }

}
