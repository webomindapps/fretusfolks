<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use App\Models\ShowcauseLetter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ADMSShowCauseJOB implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels, Batchable;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->data as $row) {

            // $fileName = 'Showcase_Letter_' . $row['Employee_ID'] . '.pdf';
            // $filePath = 'showcase_letter/' . $fileName;



            $info[] = [
                'emp_id' => $row['Employee_ID'] ?? 0,
                'date' => date('Y-m-d', strtotime($row['Date'])),
                'date_of_update' => date('Y-m-d' ?? 0, strtotime($row['Date_Of_Update'])) ?? 0,
                'status' => 1,
                'content' => $row['Content'] ?? null,
                // 'showcause_letter_path' => $filePath,

            ];
            // $paypdf[] = [
            //     'row' => array_merge($row),
            //     'showcause_letter_path' => $filePath
            // ];


        }
        \Log::info('Generated data:', $info);

        // \Log::info('Generated pdf:', $paypdf);
        // foreach ($paypdf as $pdfData) {
        //     $pdf = Pdf::loadView('admin.adms.showcause_letter.format', [
        //         'showLetter' => $pdfData['row']
        //     ]);
        //     Storage::disk('public')->put($pdfData['showcause_letter_path'], $pdf->output());
        // }
        if (!empty($info)) {
            foreach ($info as $data) {
                ShowcauseLetter::create(
                    $data
                );
            }
        }
        // ShowcauseLetter::insert($info);

        \Log::info('Job completed successfully');
    }
}
