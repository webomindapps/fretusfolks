<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ZipArchive;
use Illuminate\Support\Facades\Mail;
use App\Mail\PayslipZipReady;
use Illuminate\Bus\Batchable;

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
        $clientName = str_replace(' ', '_', $this->payslips->first()->client_name);
        $zipFileName = "Payslips_{$clientName}_{$this->payslips->first()->month}_{$this->payslips->first()->year}.zip";
        $zipPath = storage_path("app/temp/{$zipFileName}");

        $zip = new ZipArchive();
        $pdfFiles = [];
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($this->payslips as $payslip) {
                $filePath = storage_path('app/temp/' . $payslip->payslips_letter_path);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($filePath));
                    $pdfFiles[] = $filePath;
                } else {
                    \Log::warning("File does not exist: {$filePath}");
                }
            }
            $zip->close();
        } else {
            \Log::error("Failed to create ZIP at: {$zipPath}");
        }

        // Send ZIP file via email
        Mail::to($this->email)->send(new PayslipZipReady($zipPath, $zipFileName));
        // Delete ZIP file after sending email
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }
        foreach ($pdfFiles as $pdfPath) {
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }
        }
    }
}
