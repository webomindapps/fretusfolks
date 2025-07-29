<?php

namespace App\Jobs;

use PDF;
use ZipArchive;
use App\Models\OfferLetter;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Container\Attributes\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateOfferLetterZip implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $letterIds, $clientName, $zipFileName;

    public function __construct(array $letterIds, $clientName, $zipFileName)
    {
        $this->letterIds = $letterIds;
        $this->clientName = $clientName;
        $this->zipFileName = $zipFileName;
    }

    public function handle()
    {
        $zipPath = storage_path("app/temp/{$this->zipFileName}");

        $viewMap = [
            1 => 'admin.adms.offer_letter.format1',
            2 => 'admin.adms.offer_letter.format2',
            3 => 'admin.adms.offer_letter.format3',
            4 => 'admin.adms.offer_letter.format4',
            5 => 'admin.adms.offer_letter.format5',
        ];

        $letters = OfferLetter::whereIn('id', $this->letterIds)->get();
        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($letters as $offerLetter) {
                $type = $offerLetter->offerletter_type;

                if (isset($viewMap[$type])) {
                    $view = $viewMap[$type];
                    $pdf = \PDF::loadView($view, compact('offerLetter'));

                    $pdfPath = storage_path("app/temp/offer_letter_{$offerLetter->id}.pdf");
                    $pdf->save($pdfPath);
                    \Log::info('Generated PDF for offer letter', ['id' => $offerLetter->id]);

                    $zip->addFile($pdfPath, "OfferLetter_{$offerLetter->id}.pdf");

                    // ✅ Clean up temp PDFs after adding
                    unlink($pdfPath);
                }
            }
            \Log::info("Bulk offer letter zip generated", [
                'zip_file' => $this->zipFileName,
                'client' => $this->clientName,
                'letter_count' => $letters->count()
            ]);
            $zip->close();
        }
    }

}
