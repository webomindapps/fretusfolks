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
        $zipFileName = "payslips_{$this->payslips->first()->month}_{$this->payslips->first()->year}.zip";
        $zipPath = storage_path("app/temp/{$zipFileName}");

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($this->payslips as $payslip) {
                $filePath = $payslip->payslips_letter_path ? public_path($payslip->payslips_letter_path) : storage_path("app/temp/payslip_{$payslip->id}.pdf");
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($filePath));
                }
            }
            $zip->close();
        }

        // Send ZIP file via email
        Mail::to($this->email)->send(new PayslipZipReady($zipPath, $zipFileName));
        // Delete ZIP file after sending email
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }
    }

}
