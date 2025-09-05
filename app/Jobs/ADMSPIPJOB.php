<?php

namespace App\Jobs;

use App\Models\PipLetter;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ADMSPIPJOB implements ShouldQueue
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


            $info[] = [
                'emp_id' => $row['Employee_ID'] ?? 0,
                'from_name' => $row['From_Name'] ?? 0,
                'date' => date('Y-m-d', strtotime($row['Date'])),
                'date_of_update' => date('Y-m-d' ?? 0, strtotime($row['Date_Of_Update'])) ?? 0,
                'status' => 1,
                // 'content' => $row['Content'] ?? null,
                'observation' => $row['Observation'] ?? null,
                'timeline' => $row['Timeline'] ?? null,

                // 'showcause_letter_path' => $filePath,

            ];



        }
        \Log::info('Generated data:', $info);


        if (!empty($info)) {
            foreach ($info as $data) {
                PipLetter::create(
                    $data
                );
            }
        }
        // ShowcauseLetter::insert($info);

        \Log::info('Job completed successfully');
    }
}
