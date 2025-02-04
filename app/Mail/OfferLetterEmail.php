<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OfferLetterEmail extends Mailable
{
    public $employee;
    public $pdfPath;

    public function __construct($employee, $pdfPath)
    {
        $this->employee = $employee;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->view('emails.offer_letter')
                    ->subject('Your Offer Letter')
                    ->attach(storage_path('app/public/' . $this->pdfPath));
    }
}
