<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OfferLetterZipReady extends Mailable
{
    use Queueable, SerializesModels;

    public $clientName, $downloadUrl;

    public function __construct($clientName, $downloadUrl)
    {
        $this->clientName = $clientName;
        $this->downloadUrl = $downloadUrl;
    }

    public function build()
    {
        return $this->subject("Offer Letters for {$this->clientName}")
            ->view('mail.offer_letter_zip')
            ->with([
                'clientName' => $this->clientName,
                'downloadUrl' => $this->downloadUrl
            ]);
    }
}
