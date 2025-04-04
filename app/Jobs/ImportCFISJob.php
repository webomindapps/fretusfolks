<?php

namespace App\Jobs;

use App\Models\CFISModel;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportCFISJob implements ShouldQueue
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
        $info = [];
        // dd($this->data);
        foreach ($this->data as $row) {
            $info[] = [
                'emp_name' => $row['emp_name'],
                'email' => $row['email'] ?? null,
                'designation' => $row['designation'] ?? null,
                'department' => $row['department'] ?? null,
                'location' => $row['location'] ?? null,
                'interview_date' => isset($row['interview_date']) ? str_replace('/', '-', $row['interview_date']) : null,
                'status' => 1,
                'dcs_approval' => 1,
                'data_status' => 0,
                'created_by' => auth()->id(),
            ];


        }

        // if (!empty($info)) {
        //     // dd($info);
        //     CFISModel::Create($info[]);
        // }
        if (!empty($info)) {
            foreach ($info as $data) {
                CFISModel::updateOrCreate(
                    $data
                );
            }
        }
    }
}
