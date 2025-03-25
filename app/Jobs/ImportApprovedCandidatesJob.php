<?php

namespace App\Jobs;

use App\Models\CFISModel;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportApprovedCandidatesJob implements ShouldQueue
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
            $formatDate = function ($date) {
                if (isset($date)) {
                    if (strpos($date, '/') !== false) {
                        $parts = explode('/', $date);
                        if (count($parts) === 3) {
                            return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                        }
                    } elseif (strpos($date, '-') !== false) {
                        $parts = explode('-', $date);
                        if (count($parts) === 3) {
                            return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                        }
                    }
                }
                return $date;
            };

            $info[] = [
                'console_id' => $row['console_id'] ?? null,
                'grade' => $row['grade'] ?? null,
                'emp_name' => $row['emp_name'],
                'email' => $row['email'] ?? null,
                'interview_date' => $formatDate($row['interview_date'] ?? null),
                'joining_date' => $formatDate($row['joining_date'] ?? null),
                'contract_date' => $formatDate($row['contract_date'] ?? null),
                'designation' => $row['designation'] ?? null,
                'department' => $row['department'] ?? null,
                'location' => $row['location'] ?? null,
                'branch' => $row['branch'] ?? null,
                'gender' => $row['gender'] ?? null,
                'dob' => $formatDate($row['dob'] ?? null),
                'father_name' => $row['father_name'] ?? null,
                'father_dob' => $formatDate($row['father_dob'] ?? null),
                'mother_name' => $row['mother_name'] ?? null,
                'mother_dob' => $formatDate($row['mother_dob'] ?? null),
                'religion' => $row['religion'] ?? null,
                'languages' => $row['languages'] ?? null,
                'mother_tongue' => $row['mother_tongue'] ?? null,
                'emer_contact_no' => $row['emer_contact_no'] ?? null,
                'emer_name' => $row['emer_name'] ?? null,
                'emer_relation' => $row['emer_relation'] ?? null,
                'blood_group' => $row['blood_group'] ?? null,
                'phone1' => $row['phone1'] ?? null,
                'official_mail_id' => $row['official_mail_id'] ?? null,
                'permanent_address' => $row['permanent_address'] ?? null,
                'present_address' => $row['present_address'] ?? null,
                'pan_no' => $row['pan_no'] ?? null,
                'aadhar_no' => $row['aadhar_no'] ?? null,
                'driving_license_no' => $row['driving_license_no'] ?? null,
                'uan_no' => $row['uan_no'] ?? null,
                'esic_no' => $row['esic_no'] ?? null,
                'status' => 1,
                'dcs_approval' => 0,
                'data_status' => 0,
                'created_by' => auth()->id(),
            ];
        }

        if (!empty($info)) {
            try {
                foreach ($info as $data) {
                    CFISModel::create($data);
                }
                // dd('Data saved successfully!');
            } catch (\Exception $e) {
                // dd('Error: ', $e->getMessage());
            }
        }
    }
}
