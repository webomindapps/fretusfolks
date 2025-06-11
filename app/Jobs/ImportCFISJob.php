<?php

namespace App\Jobs;

use App\Models\States;
use App\Models\CFISModel;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use App\Models\ClientManagement;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Laravel\Pail\ValueObjects\Origin\Console;

class ImportCFISJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels, Batchable;

    protected $data;
    protected $created_by;

    /**
     * Create a new job instance.
     */
    public function __construct($data, $created_by)
    {
        // \Log::info('ImportCFISJob Constructor:', ['created_by' => $created_by]);
        $this->data = $data;
        $this->created_by = $created_by;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Log::info('Job Started. User ID:', ['created_by' => $this->created_by]);

        // dd("hello");
        foreach ($this->data as $row) {

            $state = States::where('state_name', $row['State'])->first();
            $client = ClientManagement::where('client_name', $row['Client_Name'])->first();
            $info[] = [
                'entity_name' => $row['Client_Name'],
                'emp_name' => $row['Emp_Name'],
                'email' => $row['Email'] ?? null,
                'designation' => $row['Designation'] ?? null,
                'department' => $row['Department'] ?? null,
                'location' => $row['Location'] ?? null,
                'interview_date' => date('Y-m-d', strtotime($row['Interview_Date'])),
                'status' => 1,
                'dcs_approval' => 1,
                'data_status' => 0,
                'created_by' => $this->created_by,
                'client_id' => $client?->id,
                'state' => $state?->id,
            ];


        }
        \Log::info('Generated data:', $info);

        if (!empty($info)) {
            foreach ($info as $data) {
                CFISModel::create(
                    $data
                );
            }
        }
        \Log::info('Job completed successfully');

    }
}
