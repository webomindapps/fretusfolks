<?php

namespace App\Jobs;

use App\Models\TerminationLetter;
use Illuminate\Bus\Batchable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ADMSTerminationJOB implements ShouldQueue
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

            // $fileName = 'Termination_Letter_' . $row['Employee_ID'] . '.pdf';
            // $filePath = 'termination_letter/' . $fileName;



            $info[] = [
                'emp_id' => $row['Employee_ID'] ?? 0,
                'date' => date('Y-m-d' ?? 0, strtotime($row['Date'])),
                'absent_date' => date('Y-m-d' ?? 0, strtotime($row['Absent_Date'])),
                'show_cause_date' => date('Y-m-d' ?? 0, strtotime($row['Show_Cause_Date'])),
                'termination_date' => date('Y-m-d' ?? 0, strtotime($row['Termination_Date'])),
                'date_of_update' => date('Y-m-d' ?? 0, strtotime($row['Date_Of_Update'])) ?? 0,
                'status' => 1,
                'content' => $row['Content'] ?? null,
                // 'termination_letter_path' => $filePath,

            ];
            // $paypdf[] = [
            //     'row' => array_merge($row),
            //     'termination_letter_path' => $filePath
            // ];


        }
        \Log::info('Generated data:', $info);

        // \Log::info('Generated pdf:', $paypdf);
        // foreach ($paypdf as $pdfData) {
        //     $pdf = Pdf::loadView('admin.adms.termination_letter.format', [
        //         'termLetter' => $pdfData['row']
        //     ]);
        //     Storage::disk('public')->put($pdfData['termination_letter_path'], $pdf->output());
        // }
        if (!empty($info)) {
            foreach ($info as $data) {
                TerminationLetter::create(
                    $data
                );
            }
        }
        // TerminationLetter::insert($info);

        \Log::info('Job completed successfully');
    }
}
