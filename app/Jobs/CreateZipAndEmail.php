<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ZipArchive;
use Illuminate\Support\Facades\Mail;
use App\Mail\PayslipZipReady;

class CreateZipAndEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $payslips;
    public $email;

    public function __construct($payslips, $email)
    {
        $this->payslips = $payslips;
        $this->email = $email;
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
