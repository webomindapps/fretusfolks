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
        $zipUrl = url("storage/temp/{$this->zipFileName}");

        return $this->subject('Your Payslips ZIP is Ready')
            ->view('mail.payslip_zip_ready')
            ->attach($this->zipPath, [
                'as' => $this->zipFileName,
                'mime' => 'application/zip',
            ]);
    }
}
