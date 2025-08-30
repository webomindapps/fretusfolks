<?php

namespace App\Jobs;

use PDF;
use Mail;
// use Barryvdh\DomPDF\PDF;
use ZipArchive;
use App\Models\OfferLetter;
use Illuminate\Bus\Queueable;
use App\Mail\OfferLetterZipReady;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Container\Attributes\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateOfferLetterZip implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $letterIds, $clientName, $zipFileName, $emails;

    public function __construct(array $letterIds, $clientName, $zipFileName, array $emails)
    {
        $this->letterIds = $letterIds;
        $this->clientName = $clientName;
        $this->zipFileName = $zipFileName;
        $this->emails = $emails;

    }

    public function handle()
    {
        $zipPath = storage_path("app/public/{$this->zipFileName}");
        \Log::info("created: {  $zipPath}");

        $viewMap = [
            1 => 'admin.adms.offer_letter.format1',
            2 => 'admin.adms.offer_letter.format2',
            3 => 'admin.adms.offer_letter.format3',
            4 => 'admin.adms.offer_letter.format4',
            5 => 'admin.adms.offer_letter.format5',
        ];

        $letters = OfferLetter::whereIn('id', $this->letterIds)->get();
        $zip = new \ZipArchive;

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            foreach ($letters as $offerLetter) {
                $type = $offerLetter->offer_letter_type; // ✅ fixed typo
                if (isset($viewMap[$type])) {
                    $pdf = \PDF::loadView($viewMap[$type], compact('offerLetter'));
                    $pdfPath = storage_path("app/temp/offer_letter_{$offerLetter->emp_name}.pdf");
                    $pdf->save($pdfPath);
                    $zip->addFile($pdfPath, "OfferLetter_{$offerLetter->emp_name}.pdf");
                }
            }
            $zip->close();
            \Log::info("offer : {{$this->zipFileName}");

            // Public download link
            $downloadUrl = asset("storage/{$this->zipFileName}");
            \Log::info("offer created: {$downloadUrl}");


            // Send emails
            foreach ($this->emails as $email) {
                Mail::to($email)->send(new OfferLetterZipReady($this->clientName, $downloadUrl));
            }
        }
    }

}
