<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use App\Models\IncrementLetter;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ClientManagement;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ADMSIncrementJOB implements ShouldQueue
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

            // $fileName = 'Increment_' . $row['Employee_Name'] . '_' . $row['Employee_ID'] . '.pdf';
            // $filePath = 'incrementletter/' . $fileName;

            $client = ClientManagement::where('client_name', $row['Client_Name'])->first();
            // \Log::info('Generated data:', $client);

            $info[] = [
                'company_id' => $client?->id,
                'employee_id' => $row['Employee_ID'] ?? 0,
                'emp_name' => $row['Employee_Name'] ?? 0,
                'basic_salary' => $row['Basic_Salary'] ?? 0,
                'hra' => $row['HRA'] ?? 0,
                'conveyance' => $row['Conveyance'] ?? 0,
                'medical_reimbursement' => $row['Medical_Reimbursement'] ?? 0,
                'special_allowance' => $row['Special Allowance'] ?? 0,
                'other_allowance' => $row['Other_Allowance'] ?? 0,
                'st_bonus' => $row['ST_Bonus'] ?? 0,
                'gross_salary' => $row['Gross_Salary'] ?? 0,
                'emp_pf' => $row['Employee_PF '] ?? 0,
                'emp_esic' => $row['Employee_ESIC '] ?? 0,
                'pt' => $row['PT'] ?? 0,
                'lwf' => $row['lwf'] ?? 0,
                'total_deduction' => $row['Total_Deduction'] ?? 0,
                'take_home' => $row['Take_Home_Salary'] ?? 0,
                'employer_pf' => $row['Employer_PF'] ?? 0,
                'employer_esic' => $row['Employer_ESIC'] ?? 0,
                'mediclaim' => $row['Mediclaim_Insurance'] ?? 0,
                'ctc' => $row['New_CTC'] ?? 0,
                'effective_date' => date('Y-m-d' ?? 0, strtotime($row['Effective_Date'])),
                'Increment_Percentage' => $row['Increment_percentage'] ?? 0,
                'old_ctc' => $row['Old_CTC'] ?? 0,
                'old_designation' => $row['Old_Designation'] ?? null,
                'designation' => $row['New_Designation'] ?? null,
                'interview_date' => date('Y-m-d' ?? 0, strtotime($row['Effective_Date'])) ?? 0,
                'status' => 1,
                'date' => now()->format('Y-m-d'),
                'offer_letter_type' => 1,
                // 'increment_path' => $filePath,
                'content' => '<p style="text-align: justify;">In recognition of your performance and the contribution to the company?? 0, we are pleased to inform you that you have be given an increase of {{increment_percentage}}% on CTC(Cost to the Company) which will be effective from {{effective_date}}.</p>
<p style="text-align: justify;">Current CTC (per annum): {{current_ctc}}</p>
<p style="text-align: justify;">Old CTC (per annum): {{old_ctc}}</p>
<p style="text-align: justify;">Current Designation: {{Current_Designation}}</p>
<p style="text-align: justify;">Old Designation: {{Old_Designation}}</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">Your commitment has been invaluable, and we look forward to your continued engagement.&nbsp; All other terms and conditions of your contract are as per the annexure attached below.</p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">With best wishes and warm regards.</p>
',
            ];
            // $paypdf[] = [
            //     'row' => array_merge($row),
            //     'increment_path' => $filePath
            // ];


        }
        \Log::info('Generated data:', $info);


        // foreach ($paypdf as $pdfData) {
        //     $pdf = Pdf::loadView('admin.adms.increment_letter.format', [
        //         'increment' => $pdfData['row']
        //     ]);
        //     Storage::disk('public')->put($pdfData['increment_path'], $pdf->output());
        // }
        if (!empty($info)) {
            foreach ($info as $data) {
                IncrementLetter::create(
                    $data
                );
            }
        }
        \Log::info('Job completed successfully');
    }
}
