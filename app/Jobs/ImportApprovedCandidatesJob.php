<?php

namespace App\Jobs;

use App\Models\CFISModel;
use App\Models\BankDetails;
use App\Models\DCSChildren;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use App\Models\ClientManagement;
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
        \Log::info('Imported employee', $this->data);

        // dd($this->data);
        foreach ($this->data as $row) {
            $formatDate = function ($date) {
                if (isset($date)) {
                    $date = trim($date);
                    if (strtolower($date) === 'n/a') {
                        return null;
                    }
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
            $client = ClientManagement::where('client_name', $row['client_name'])->first();

            $employee = CFISModel::create([
                'entity_name' => $row['client_name'],
                'ffi_emp_id' => $row['emp_id'] ?? null,
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
                'father_aadhar' => $row['father_aadhar'] ?? null,
                'mother_name' => $row['mother_name'] ?? null,
                'mother_dob' => $formatDate($row['mother_dob'] ?? null),
                'mother_aadhar' => $row['mother_aadhar'] ?? null,
                'religion' => $row['religion'] ?? null,
                'languages' => $row['languages'] ?? null,
                'mother_tongue' => $row['mother_tongue'] ?? null,
                'maritial_status' => $row['maritial_status'] ?? null,
                'spouse_name' => $row['spouse_name'] ?? null,
                'spouse_dob' => $formatDate($row['spouse_dob'] ?? null),
                'spouse_aadhar' => $row['spouse_aadhar'] ?? null,
                'no_of_childrens' => $row['no_of_childrens'] ?? null,
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
                'basic_salary' => $row['basic_salary'] ?? null,
                'hra' => $row['hra'] ?? null,
                'lwf' => $row['lwf'] ?? null,
                'conveyance' => $row['conveyance'] ?? null,
                'medical_reimbursement' => $row['medical_reimbursement'] ?? null,
                'special_allowance' => $row['special_allowance'] ?? null,
                'other_allowance' => $row['other_allowance'] ?? null,
                'st_bonus' => $row['st_bonus'] ?? null,
                'gross_salary' => $row['gross_salary'] ?? null,
                'emp_pf' => $row['emp_pf'] ?? null,
                'emp_esic' => $row['emp_esic'] ?? null,
                'pt' => $row['pt'] ?? null,
                'total_deduction' => $row['total_deduction'] ?? null,
                'take_home' => $row['take_home'] ?? null,
                'employer_pf' => $row['employer_pf'] ?? null,
                'employer_esic' => $row['employer_esic'] ?? null,
                'mediclaim' => $row['mediclaim'] ?? null,
                'ctc' => $row['ctc'] ?? null,
                'dcs_approval' => match (strtolower(trim($row['dcs_approval'] ?? ''))) {
                    'Approved' => 1,
                    'Pending' => 0,
                    'Reject' => 2,
                    default => null,
                },
                'hr_approval' => 0,
                'status' => 1,
                // 'dcs_approval' => 0,
                'data_status' => 0,
                'created_by' => auth()->id(),
                'client_id' => $client?->id,

            ]);
            \Log::info('Imported employee', $employee->toArray());
            for ($i = 1; $i <= 4; $i++) {
                $childNameKey = "child_{$i}_name";
                $childDobKey = "child_{$i}_dob";
                $childGenderKey = "child_{$i}_gender";

                if (!empty($row[$childNameKey])) {
                    DCSChildren::create([
                        'emp_id' => $employee->id,
                        'name' => $row[$childNameKey],
                        'dob' => $formatDate($row[$childDobKey] ?? null),
                        'gender' => $row[$childGenderKey] ?? null,
                    ]);
                }
            }
            BankDetails::create([
                'emp_id' => $employee->id,
                'bank_name' => $row['bank_name'] ?? null,
                'bank_account_no' => $row['bank_account_no'] ?? null,
                'bank_ifsc_code' => $row['bank_ifsc_code'] ?? null,
                'bank_status' => 0,
            ]);
        }

        // if (!empty($info)) {
        //     try {
        //         foreach ($info as $data) {
        //             CFISModel::create($data);
        //         }
        //         // dd('Data saved successfully!');
        //     } catch (\Exception $e) {
        //         // dd('Error: ', $e->getMessage());
        //     }
        // }
    }
}
