<?php

namespace App\Jobs;

use App\Models\OfferLetter;
use Illuminate\Bus\Batchable;
use App\Models\ClientManagement;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ADMSOfferJOB implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels, InteractsWithQueue, Batchable;

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
            $client = ClientManagement::where('client_name', $row['Client_Name'])->first();

            $offerLetters[] = [
                'company_id' => $client?->id,
                'employee_id' => $row['Employee_ID'] ?? null,
                'emp_name' => $row['Employee_Name'] ?? null,
                'phone1' => $row['Phone'] ?? null,
                'entity_name' => $client?->client_name,
                'joining_date' => isset($row['Joining_Date']) ? date('Y-m-d', strtotime($row['Joining_Date'])) : null,
                'location' => $row['Location'] ?? null,
                'department' => $row['Department'] ?? null,
                'father_name' => $row['Father_Name'] ?? null,
                'tenure_month' => $row['Tenure_Month'] ?? null,
                'date' => now()->format('Y-m-d'),
                'tenure_date' => isset($row['Joining_Date']) ? date('Y-m-d', strtotime($row['Joining_Date'])) : null,
                'offer_letter_type' => $row['Offer_Letter_Type'] === 'Udaan' ? 4 :
                    ($row['Offer_Letter_Type'] === 'Grofers' ? 2 :
                        ($row['Offer_Letter_Type'] === 'Others' ? 3 :
                            ($row['Offer_Letter_Type'] === 'Blue Dart' ? 5 : 1))),

                'status' => 1,

                // Salary and Benefits
                'basic_salary' => $row['Basic_Salary'] ?? 0,
                'hra' => $row['HRA'] ?? 0,
                'conveyance' => $row['Conveyance'] ?? 0,
                'medical_reimbursement' => $row['Medical_Reimbursement'] ?? 0,
                'special_allowance' => $row['Special_Allowance'] ?? 0,
                'other_allowance' => $row['Other_Allowance'] ?? 0,
                'st_bonus' => $row['ST_Bonus'] ?? 0,
                'gross_salary' => $row['Gross_Salary'] ?? 0,
                'emp_pf' => $row['Employee_PF'] ?? 0,
                'emp_esic' => $row['Employee_ESIC'] ?? 0,
                'pt' => $row['PT'] ?? 0,
                'lwf' => $row['Employee_LWF'] ?? 0,
                'total_deduction' => $row['Total_Deduction'] ?? 0,
                'take_home' => $row['Take_Home_Salary'] ?? 0,
                'employer_pf' => $row['Employer_PF'] ?? 0,
                'employer_esic' => $row['Employer_ESIC'] ?? 0,
                'employer_lwf' => $row['Employer_LWF'] ?? 0,
                'mediclaim' => $row['Mediclaim'] ?? 0,
                'ctc' => $row['CTC'] ?? 0,
                'leave_wage' => $row['Leave_Wage'] ?? 0,

                'email' => $row['Email'] ?? null,
                'notice_period' => $row['Notice_Period'] ?? '7',
                'salary_date' => $row['Salary_Date'] ?? null,
                'designation' => $row['Designation'] ?? null,
                'offer_letter_path' => null, // will be generated later
            ];
        }

        \Log::info('Offer Letter Data Ready for Insert', ['count' => count($offerLetters)]);

        foreach ($offerLetters as $data) {
            OfferLetter::create($data);
        }

        \Log::info('Offer Letter Job completed successfully');
    }
}
