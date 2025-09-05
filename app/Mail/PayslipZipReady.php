<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PayslipZipReady extends Mailable
{
    use Queueable, SerializesModels;

    public $zipPath;
    public $zipFileName;

    public function __construct($zipPath, $zipFileName)
    {
        $this->zipPath = $zipPath;
        $this->zipFileName = $zipFileName;
    }
    /**
     * Build the message.
     */
    public function build()
    {
        $publicPath = public_path('payslips_zip'); // /public/payslips

        // Ensure the public/payslips folder exists
        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0755, true);
        }
    
        // Actual file move (from storage/app/temp/ to public/payslips/)
        $sourcePath = storage_path("app/temp/{$this->zipFileName}");
        $destinationPath = public_path("payslips_zip/{$this->zipFileName}");
    
        // Move the file
        if (file_exists($sourcePath)) {
            rename($sourcePath, $destinationPath);
        }
    
        // Public URL (this will now work)
        $zipUrl ="https://newapp.fretusfolks.com/payslips_zip/".$this->zipFileName;
    
        return $this->subject('Your Payslips ZIP is Ready')
            ->view('mail.payslip_zip_ready')
            ->with(compact('zipUrl'));
        // $zipUrl = asset("storage/temp/{$this->zipFileName}");

        // return $this->subject('Your Payslips ZIP is Ready')
        //     ->view('mail.payslip_zip_ready')
        //     ->with(compact('zipUrl'));
            // ->attach($this->zipPath, [
            //     'as' => $this->zipFileName,
            //     'mime' => 'application/zip',
            // ]);
    }
}