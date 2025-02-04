<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\CFISModel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DCSChildren;
use App\Models\OfferLetter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\OtherCertificate;
use App\Models\CandidateDocuments;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\EducationCertificate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class DCSApprovalController extends Controller
{
    public function model()
    {
        return new CFISModel();
    }
    public function index()
    {
        $searchColumns = ['id', 'client_id', 'emp_name', 'phone1'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        // $query = $this->model()->query()->where('data_status', 1);

        if (auth()->user()->hasRole('Admin')) {
            $query = $this->model()->query();
            // ->where('dcs_approval', 0)
            // ->whereIn('data_status', [0]);
        } else {
            $query = $this->model()->query()
                ->where('dcs_approval', 0)
                ->where('created_by', auth()->id())
                ->whereIn('data_status', [0]);
        }

        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }
        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value)
                    ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $candidate = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());
        // dd($candidate);
        return view("admin.adms.dcs_approval.index", compact("candidate"));
    }
    public function edit($id)
    {
        $candidate = $this->model()->with('candidateDocuments')->find($id);
        return view('admin.adms.dcs_approval.edit', compact('candidate'));

    }
    public function update(Request $request, $id)
    {
        $candidate = $this->model()->find($id);
        $validatedData = $request->validate([
            'client_id' => 'required|integer',
            'entity_name' => 'nullable|string|max:255',
            'console_id' => 'nullable|string|max:255',
            'ffi_emp_id' => 'nullable|string|max:255',
            'grade' => 'nullable|string|max:255',
            'client_emp_id' => 'nullable|string|max:255',
            'emp_name' => 'nullable|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'interview_date' => 'nullable|date',
            'joining_date' => 'nullable|date',
            'contract_date' => 'nullable|date',
            'designation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'branch' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'father_dob' => 'nullable|date',
            'father_aadhar_no' => 'nullable|string|min:12',
            'mother_aadhar_no' => 'nullable|string|min:12',
            'mother_name' => 'nullable|string|max:255',
            'mother_dob' => 'nullable|date',
            'religion' => 'nullable|string|max:255',
            'languages' => 'nullable|string|max:255',
            'mother_tongue' => 'nullable|string|max:255',
            'maritial_status' => 'nullable|string|max:255',
            'emer_contact_no' => 'nullable|string|max:15',
            'emer_name' => 'nullable|string|max:255',
            'emer_relation' => 'nullable|string|max:255',
            'spouse_name' => 'nullable|string|max:255',
            'spouse_dob' => 'nullable|date',
            'spouse_aadhar_no' => 'nullable|string|min:12',
            'no_of_childrens' => 'nullable|integer',
            'blood_group' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'phone1' => 'required|string|max:15',
            'phone2' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'official_mail_id' => 'nullable|email|max:255',
            'permanent_address' => 'nullable|string',
            'present_address' => 'nullable|string',
            'pan_no' => 'nullable|string|max:255',
            'pan_path' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
            'aadhar_no' => 'required|string|min:12',
            'aadhar_path' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
            'driving_license_no' => 'nullable|string|max:255',
            'driving_license_path' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
            'photo' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'family_photo' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'bank_document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:255',
            'bank_ifsc_code' => 'nullable|string|max:255',
            'uan_no' => 'nullable|string|max:255',
            'esic_no' => 'nullable|string|max:255',
            'basic_salary' => 'nullable|numeric',
            'hra' => 'nullable|numeric',
            'conveyance' => 'nullable|numeric',
            'medical_reimbursement' => 'nullable|numeric',
            'special_allowance' => 'nullable|numeric',
            'other_allowance' => 'nullable|numeric',
            'st_bonus' => 'nullable|numeric',
            'gross_salary' => 'nullable|numeric',
            'emp_pf' => 'nullable|numeric',
            'emp_esic' => 'nullable|numeric',
            'pt' => 'nullable|numeric',
            'total_deduction' => 'nullable|numeric',
            'take_home' => 'nullable|numeric',
            'employer_pf' => 'nullable|numeric',
            'employer_esic' => 'nullable|numeric',
            'mediclaim' => 'nullable|numeric',
            'ctc' => 'nullable|numeric',
            'status' => 'nullable|boolean',
            'modify_by' => 'nullable|integer',
            'password' => 'nullable|string|max:255',
            'refresh_code' => 'nullable|string|max:255',
            'psd' => 'nullable|string|max:255',
            'document_type.*' => 'required|string',
            'document_file.*' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'child_names.*' => 'required|string|max:255',
            'child_dobs.*' => 'required|date',

        ]);
        DB::beginTransaction();
        try {
            $validatedData['password'] = $request->input('dcs_approval', 'ffemp@123');
            $validatedData['psd'] = $request->input('dcs_approval', 'ffemp@123');
            $validatedData['dcs_approval'] = $request->input('dcs_approval', 0);
            $validatedData['data_status'] = $request->input('data_status', 1);
            $validatedData['hr_approval'] = $request->input('hr_approval', 0);

            $candidate->update($validatedData);

            $fileFields = ['pan_path', 'aadhar_path', 'driving_license_path', 'photo', 'resume', 'bank_document', 'voter_id', 'emp_form', 'pf_esic_form', 'payslip', 'exp_letter', 'family_photo'];
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    if ($candidate->$field) {
                        Storage::disk('public')->delete($candidate->$field);
                    }

                    $file = $request->file($field);
                    $newFileName = $field . '_' . $candidate->id . '.' . $file->getClientOriginalExtension();

                    $filePath = $file->storeAs('uploads/' . $field, $newFileName, 'public');

                    CandidateDocuments::create([
                        'emp_id' => $candidate->id,
                        'name' => $field,
                        'path' => $filePath,
                        'status' => 0,
                    ]);
                }
            }

            if ($request->has('document_type') && $request->hasFile('document_file')) {
                foreach ($request->document_type as $index => $type) {
                    $file = $request->file('document_file')[$index] ?? null;

                    if ($file) {
                        $fileName = $type . $candidate->id . $file->getClientOriginalExtension();
                        $filePath = $file->storeAs('documents/' . $type, $fileName, 'public');
                        if ($type === 'education_certificate') {
                            EducationCertificate::create([
                                'emp_id' => $candidate->id,
                                'path' => 'storage/' . $filePath,
                                'status' => 0,
                            ]);
                        } elseif ($type === 'other_certificate') {
                            OtherCertificate::create([
                                'emp_id' => $candidate->id,
                                'path' => 'storage/' . $filePath,
                                'status' => 0,
                            ]);
                        } else {
                            if ($candidate->$type) {
                                Storage::disk('public')->delete($candidate->$type);
                            }
                            $candidate->$type = $filePath;
                            $candidate->save();
                        }
                    }
                }
            }
            if ($request->has('child_names') && $request->has('child_dobs')) {

                $childNames = $request->child_names;
                $childDobs = $request->child_dobs;

                foreach ($childNames as $index => $name) {
                    if (!empty($name) && isset($childDobs[$index])) {
                        DCSChildren::create([
                            'emp_id' => $candidate->id,
                            'name' => $name,
                            'dob' => $childDobs[$index],
                        ]);
                    }
                }
            }
            $candidate->save();

            DB::commit();

            return redirect()->route('admin.dcs_approval')->with('success', 'Candidate updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function destroy($id)
    {
        $this->model()->destroy($id);
        return redirect()->route('admin.dcs_approval')->with('success', 'Candidate data has been successfully deleted!');
    }
    public function rejected()
    {
        $searchColumns = ['id', 'client_id', 'emp_name', 'phone1'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->model()->query()->where('dcs_approval', 2);

        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }
        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value)
                    ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $candidate = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());

        return view("admin.adms.dcs_approval.rejected", compact("candidate"));
    }

    public function hrindex()
    {
        $searchColumns = ['id', 'client_id', 'emp_name', 'phone1'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;
        $userId = auth()->id();

        $query = $this->model()->query()
            // ->whereIn('data_status', [0, 1])
            ->whereIn('data_status', [1])
            ->whereIn('hr_approval', [0, 1])
            ->whereHas('hrMasters', function ($q) use ($userId) {
                $q->where('user_id', $userId)
                    ->whereIn('dcs_approval', [0]);
            })
            ->with(['hrMasters.client']);

        $from_date = request()->get('from_date');
        $to_date = request()->get('to_date');
        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        $search = request()->get('search');
        if ($search) {
            $query->where('emp_name', 'LIKE', "%$search%");
        }

        $orderBy = request()->get('orderBy', 'desc');
        $query->orderBy('id', $orderBy);

        $candidates = $query->paginate(10)->appends(request()->query());

        return view("admin.adms.hr.hrindex", compact("candidates"));
    }

    public function hredit($id)
    {
        $candidate = $this->model()
            ->with(['client'])
            ->with(['educationCertificates', 'otherCertificates', 'candidateDocuments'])
            ->findOrFail($id);

        if (!$candidate->client || !$candidate->client->client_ffi_id) {
            throw new Exception("Client FFI ID not found for the candidate.");
        }

        $clientFfiId = $candidate->client->client_ffi_id;

        $lastId = $this->model()
            ->whereHas('client', function ($query) use ($candidate) {
                $query->where('id', $candidate->client_id);
            })
            ->where('ffi_emp_id', 'LIKE', $clientFfiId . '%')
            ->orderBy('ffi_emp_id', 'desc')
            ->value('ffi_emp_id');

        if ($lastId) {
            $number = (int) substr($lastId, strlen($clientFfiId));
            $newNumber = str_pad($number + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        $uniqueId = $clientFfiId . $newNumber;

        $children = DCSChildren::where('emp_id', $candidate->id)->get();

        return view('admin.adms.hr.hredit', compact('candidate', 'uniqueId', 'children'));
    }

    public function hrupdate(Request $request, $id)
    {
        // dd($request->cc_emails);
        $action = $request->input('action');
        $candidate = $this->model()->find($id);
        $validatedData = $request->validate([
            'client_id' => 'required|integer',
            'entity_name' => 'nullable|string|max:255',
            'console_id' => 'nullable|string|max:255',
            'ffi_emp_id' => 'nullable|string|max:255',
            'grade' => 'nullable|string|max:255',
            'client_emp_id' => 'nullable|string|max:255',
            'emp_name' => 'nullable|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'interview_date' => 'nullable|date',
            'joining_date' => 'nullable|date',
            'contract_date' => 'nullable|date',
            'designation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'branch' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'father_dob' => 'nullable|date',
            'mother_name' => 'nullable|string|max:255',
            'mother_dob' => 'nullable|date',
            'religion' => 'nullable|string|max:255',
            'languages' => 'nullable|string|max:255',
            'mother_tongue' => 'nullable|string|max:255',
            'maritial_status' => 'nullable|string|max:255',
            'emer_contact_no' => 'nullable|string|max:10',
            'emer_name' => 'nullable|string|max:255',
            'emer_relation' => 'nullable|string|max:255',
            'spouse_name' => 'nullable|string|max:255',
            'no_of_childrens' => 'nullable|integer',
            'blood_group' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'phone1' => 'nullable|string|max:15',
            'phone2' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'official_mail_id' => 'nullable|email|max:255',
            'permanent_address' => 'nullable|string',
            'present_address' => 'nullable|string',
            'pan_no' => 'nullable|string|max:255',
            'pan_path' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
            'aadhar_no' => 'nullable|string|max:255',
            'aadhar_path' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
            'driving_license_no' => 'nullable|string|max:255',
            'driving_license_path' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
            'photo' => 'nullable|file|mimes:jpg,png,doc,docx|max:2048',
            'family_photo' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'bank_document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:255',
            'bank_ifsc_code' => 'nullable|string|max:255',
            'uan_no' => 'nullable|string|max:255',
            'esic_no' => 'nullable|string|max:255',
            'basic_salary' => 'nullable|numeric',
            'hra' => 'nullable|numeric',
            'conveyance' => 'nullable|numeric',
            'medical_reimbursement' => 'nullable|numeric',
            'special_allowance' => 'nullable|numeric',
            'other_allowance' => 'nullable|numeric',
            'st_bonus' => 'nullable|numeric',
            'gross_salary' => 'nullable|numeric',
            'emp_pf' => 'nullable|numeric',
            'emp_esic' => 'nullable|numeric',
            'pt' => 'nullable|numeric',
            'total_deduction' => 'nullable|numeric',
            'take_home' => 'nullable|numeric',
            'employer_pf' => 'nullable|numeric',
            'employer_esic' => 'nullable|numeric',
            'mediclaim' => 'nullable|numeric',
            'ctc' => 'nullable|numeric',
            'hr_approval' => 'required|numeric',
            'modify_by' => 'nullable|integer',
            'password' => 'nullable|string|max:255',
            'refresh_code' => 'nullable|string|max:255',
            'psd' => 'nullable|string|max:255',
            'document_type.*' => 'nullable|string',
            'document_file.*' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'child_names.*' => 'nullable|string|max:255',
            'child_dobs.*' => 'nullable|date',

        ]);
        DB::beginTransaction();
        try {
            $validatedData['data_status'] = $request->input('data_status', 1);
            $validatedData['dcs_approval'] = $request->input('dcs_approval', 0);
            $candidate->update($validatedData);

            $fileFields = ['pan_path', 'aadhar_path', 'driving_license_path', 'photo', 'resume', 'bank_document', 'voter_id', 'emp_form', 'pf_esic_form', 'payslip', 'exp_letter', 'family_photo'];
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    if ($candidate->$field) {
                        Storage::disk('public')->delete($candidate->$field);
                    }

                    $file = $request->file($field);
                    $newFileName = $field . '_' . $candidate->id . '.' . $file->getClientOriginalExtension();

                    $filePath = $file->storeAs('uploads/' . $field, $newFileName, 'public');

                    CandidateDocuments::create([
                        'emp_id' => $candidate->id,
                        'name' => $field,
                        'path' => $filePath,
                        'status' => 1,
                    ]);
                }
            }

            if ($request->has('document_type') && $request->hasFile('document_file')) {
                foreach ($request->document_type as $index => $type) {
                    $file = $request->file('document_file')[$index] ?? null;

                    if ($file) {
                        $fileName = $type . $candidate->id . $file->getClientOriginalExtension();
                        $filePath = $file->storeAs('documents/' . $type, $fileName, 'public');
                        if ($type === 'education_certificate') {
                            EducationCertificate::create([
                                'emp_id' => $candidate->id,
                                'path' => 'storage/' . $filePath,
                                'status' => 1,
                            ]);
                        } elseif ($type === 'other_certificate') {
                            OtherCertificate::create([
                                'emp_id' => $candidate->id,
                                'path' => 'storage/' . $filePath,
                                'status' => 1,
                            ]);

                        } else {
                            if ($candidate->$type) {
                                Storage::disk('public')->delete($candidate->$type);
                            }
                            $candidate->$type = $filePath;
                            $candidate->save();
                        }
                    }
                }
            }
            if ($request->has('child_names') && $request->has('child_dobs')) {

                $childNames = $request->child_names;
                $childDobs = $request->child_dobs;
                DCSChildren::where('emp_id', $candidate->id)->delete();

                foreach ($childNames as $index => $name) {
                    if (!empty($name) && isset($childDobs[$index])) {
                        DCSChildren::create([
                            'emp_id' => $candidate->id,
                            'name' => $name,
                            'dob' => $childDobs[$index],
                        ]);
                    }
                }
            }
            $candidate->save();
            if ($candidate->hr_approval == 1) {
                $offerLetter = OfferLetter::create([
                    'company_id' => $candidate->client_id,
                    'employee_id' => $candidate->ffi_emp_id,
                    'emp_name' => $candidate->emp_name,
                    'phone1' => $candidate->phone1,
                    'entity_name' => $candidate->entity_name,
                    'joining_date' => $candidate->joining_date,
                    'location' => $candidate->location,
                    'department' => $candidate->department,
                    'father_name' => $candidate->father_name,
                    'tenure_month' => now()->format('m'),
                    'date' => now()->format('Y-m-d'),
                    'tenure_date' => now()->format('Y-m-d'),
                    'offer_letter_type' => 1,
                    'status' => 1,
                    'basic_salary' => $candidate->basic_salary ?? 0,
                    'hra' => $candidate->hra ?? 0,
                    'conveyance' => $candidate->conveyance ?? 0,
                    'medical_reimbursement' => $candidate->medical_reimbursement ?? 0,
                    'special_allowance' => $candidate->special_allowance ?? 0,
                    'other_allowance' => $candidate->other_allowance ?? 0,
                    'st_bonus' => $candidate->st_bonus ?? 0,
                    'gross_salary' => $candidate->gross_salary ?? 0,
                    'emp_pf' => $candidate->emp_pf ?? 0,
                    'emp_esic' => $candidate->emp_esic ?? 0,
                    'pt' => $candidate->pt ?? 0,
                    'total_deduction' => $candidate->total_deduction ?? 0,
                    'take_home' => $candidate->take_home ?? 0,
                    'employer_pf' => $candidate->employer_pf ?? 0,
                    'employer_esic' => $candidate->employer_esic ?? 0,
                    'mediclaim' => $candidate->mediclaim ?? 0,
                    'ctc' => $candidate->ctc ?? 0,
                    'leave_wage' => $candidate->leave_wage ?? 0,
                    'email' => $candidate->email,
                    'notice_period' => $candidate->notice_period ?? 7,
                    'salary_date' => $candidate->salary_date ?? 7,
                    'designation' => $candidate->designation,
                    'offer_letter_pdf' => '',
                ]);

                $directory = storage_path('app/public/offer_letters/');
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }

                $pdf = PDF::loadView('admin.adms.offer_letter.formate', compact('offerLetter'))
                    ->setOptions([
                        'isHtml5ParserEnabled' => true,
                        'isRemoteEnabled' => true,
                        'chroot' => public_path()
                    ]);

                $pdfPath = 'offer_letters/offer_letter_' . $candidate->ffi_emp_id . '.pdf';
                Storage::disk('public')->put($pdfPath, $pdf->output());

                $offerLetter->update(['offer_letter_pdf' => $pdfPath]);


                $ccEmails = $request->input('cc_emails', []);
                Mail::send('mail.offer_letter', ['employee' => $candidate], function ($message) use ($candidate, $pdfPath, $ccEmails) {
                    $message->to($candidate->email)
                        ->cc($ccEmails)
                        ->subject('Your Offer Letter')
                        ->attach(storage_path('app/public/' . $pdfPath)); // Attach the offer letter PDF
                });


            }
            DB::commit();



            return redirect()->route('admin.hrindex')->with('success', 'Candidate updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function updatePendingDetails(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:backend_management,id',
            'client_id' => 'required|integer',
            'entity_name' => 'nullable|string|max:255',
            'console_id' => 'nullable|string|max:255',
            'ffi_emp_id' => 'nullable|string|max:255',
            'grade' => 'nullable|string|max:255',
            'client_emp_id' => 'nullable|string|max:255',
            'emp_name' => 'nullable|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'interview_date' => 'nullable|date',
            'joining_date' => 'nullable|date',
            'contract_date' => 'nullable|date',
            'designation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'branch' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'father_dob' => 'nullable|date',
            'mother_name' => 'nullable|string|max:255',
            'mother_dob' => 'nullable|date',
            'religion' => 'nullable|string|max:255',
            'languages' => 'nullable|string|max:255',
            'mother_tongue' => 'nullable|string|max:255',
            'maritial_status' => 'nullable|string|max:255',
            'emer_contact_no' => 'nullable|string|max:15',
            'emer_name' => 'nullable|string|max:255',
            'emer_relation' => 'nullable|string|max:255',
            'spouse_name' => 'nullable|string|max:255',
            'no_of_childrens' => 'nullable|integer',
            'blood_group' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'phone1' => 'nullable|string|max:15',
            'phone2' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'official_mail_id' => 'nullable|email|max:255',
            'permanent_address' => 'nullable|string',
            'present_address' => 'nullable|string',
            'pan_no' => 'nullable|string|max:255',
            'pan_path' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
            'aadhar_no' => 'nullable|string|max:255',
            'aadhar_path' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
            'driving_license_no' => 'nullable|string|max:255',
            'driving_license_path' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
            'photo' => 'nullable|file|mimes:jpg,png,doc,docx|max:2048',
            'family_photo' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'resume' => 'nullable|file|mimes:pdf,doc,docx,|max:2048',
            'bank_document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:255',
            'bank_ifsc_code' => 'nullable|string|max:255',
            'uan_no' => 'nullable|string|max:255',
            'esic_no' => 'nullable|string|max:255',
            'basic_salary' => 'nullable|numeric',
            'hra' => 'nullable|numeric',
            'conveyance' => 'nullable|numeric',
            'medical_reimbursement' => 'nullable|numeric',
            'special_allowance' => 'nullable|numeric',
            'other_allowance' => 'nullable|numeric',
            'st_bonus' => 'nullable|numeric',
            'gross_salary' => 'nullable|numeric',
            'emp_pf' => 'nullable|numeric',
            'emp_esic' => 'nullable|numeric',
            'pt' => 'nullable|numeric',
            'total_deduction' => 'nullable|numeric',
            'take_home' => 'nullable|numeric',
            'employer_pf' => 'nullable|numeric',
            'employer_esic' => 'nullable|numeric',
            'mediclaim' => 'nullable|numeric',
            'ctc' => 'nullable|numeric',
            'status' => 'nullable|numeric',
            'modify_by' => 'nullable|integer',
            'password' => 'nullable|string|max:255',
            'refresh_code' => 'nullable|string|max:255',
            'psd' => 'nullable|string|max:255',
            'document_type.*' => 'nullable|string',
            'document_file.*' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'child_names.*' => 'nullable|string|max:255',
            'child_dobs.*' => 'nullable|date',

        ]);
        DB::beginTransaction();
        try {
            $candidate = $this->model()->findOrFail($validatedData['id']);
            $validatedData['dcs_approval'] = $request->input('data_status', 0);
            $validatedData['data_status'] = $request->input('status', 0);
            $candidate->update($validatedData);


            $fileFields = ['pan_path', 'aadhar_path', 'driving_license_path', 'photo', 'resume', 'bank_document', 'voter_id', 'emp_form', 'pf_esic_form', 'payslip', 'exp_letter', 'family_photo'];
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    if ($candidate->$field) {
                        Storage::disk('public')->delete($candidate->$field);
                    }

                    $file = $request->file($field);
                    $filePath = $file->storeAs('uploads/' . $field, $file->getClientOriginalName(), 'public');

                    CandidateDocuments::create([
                        'emp_id' => $candidate->id,
                        'name' => $file->getClientOriginalName(),
                        'path' => $filePath,
                        'status' => 0,
                    ]);
                }
            }

            if ($request->has('document_type') && $request->hasFile('document_file')) {
                foreach ($request->document_type as $index => $type) {
                    $file = $request->file('document_file')[$index] ?? null;

                    if ($file) {
                        $fileName = $type . $candidate->id . $file->getClientOriginalExtension();
                        $filePath = $file->storeAs('documents/' . $type, $fileName, 'public');
                        if ($type === 'education_certificate') {
                            EducationCertificate::create([
                                'emp_id' => $candidate->id,
                                'path' => 'storage/' . $filePath,
                                'status' => 0,
                            ]);
                        } elseif ($type === 'other_certificate') {
                            OtherCertificate::create([
                                'emp_id' => $candidate->id,
                                'path' => 'storage/' . $filePath,
                                'status' => 0,
                            ]);
                        } else {
                            if ($candidate->$type) {
                                Storage::disk('public')->delete($candidate->$type);
                            }
                            $candidate->$type = $filePath;
                            $candidate->save();
                        }
                    }
                }
            }
            if ($request->has('child_names') && $request->has('child_dobs')) {

                $childNames = $request->child_names;
                $childDobs = $request->child_dobs;

                foreach ($childNames as $index => $name) {
                    if (!empty($name) && isset($childDobs[$index])) {
                        DCSChildren::create([
                            'emp_id' => $candidate->id,
                            'name' => $name,
                            'dob' => $childDobs[$index],
                        ]);
                    }
                }
            }

            $candidate->save();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Record updated successfully.']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function updateStatus($id, $newStatus)
    {
        $candidateDocument = CandidateDocuments::find($id);
        if ($candidateDocument) {
            $candidateDocument->status = $newStatus;
            $candidateDocument->save();
            return back()->with('status', 'Candidate Document status updated successfully!');
        }

        $educationCertificate = EducationCertificate::find($id);
        if ($educationCertificate) {
            $educationCertificate->status = $newStatus;
            $educationCertificate->save();
            return back()->with('status', 'Education Certificate status updated successfully!');
        }

        $otherCertificate = OtherCertificate::find($id);
        if ($otherCertificate) {
            $otherCertificate->status = $newStatus;
            $otherCertificate->save();
            return back()->with('status', 'Other Certificate status updated successfully!');
        }

        return back()->with('error', 'Document not found!');
    }

    public function docrejected()
    {
        $searchColumns = ['id', 'client_id', 'emp_name', 'phone1'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->model()->query()->where('hr_approval', 2);

        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }
        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value)
                    ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $candidate = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());

        return view("admin.adms.dcs_approval.docrejected", compact("candidate"));
    }
    public function docedit($id)
    {
        $candidate = $this->model()
            ->with(['client'])
            ->with(['educationCertificates', 'otherCertificates', 'candidateDocuments'])
            ->findOrFail($id);

        $children = DCSChildren::where('emp_id', $candidate->id)->get();

        return view("admin.adms.dcs_approval.docedit", compact('candidate', 'children'));
    }
    public function docupdate(Request $request, $id)
    {
        $candidate = $this->model()->find($id);
        $validatedData = $request->validate([
            'client_id' => 'required|integer',
            'entity_name' => 'nullable|string|max:255',
            'console_id' => 'nullable|string|max:255',
            'ffi_emp_id' => 'nullable|string|max:255',
            'grade' => 'nullable|string|max:255',
            'client_emp_id' => 'nullable|string|max:255',
            'emp_name' => 'nullable|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'interview_date' => 'nullable|date',
            'joining_date' => 'nullable|date',
            'contract_date' => 'nullable|date',
            'designation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'branch' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'father_dob' => 'nullable|date',
            'mother_name' => 'nullable|string|max:255',
            'mother_dob' => 'nullable|date',
            'religion' => 'nullable|string|max:255',
            'languages' => 'nullable|string|max:255',
            'mother_tongue' => 'nullable|string|max:255',
            'maritial_status' => 'nullable|string|max:255',
            'emer_contact_no' => 'nullable|string|max:10',
            'emer_name' => 'nullable|string|max:255',
            'emer_relation' => 'nullable|string|max:255',
            'spouse_name' => 'nullable|string|max:255',
            'no_of_childrens' => 'nullable|integer',
            'blood_group' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'phone1' => 'nullable|string|max:15',
            'phone2' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'official_mail_id' => 'nullable|email|max:255',
            'permanent_address' => 'nullable|string',
            'present_address' => 'nullable|string',
            'pan_no' => 'nullable|string|max:255',
            'pan_path' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
            'aadhar_no' => 'nullable|string|max:255',
            'aadhar_path' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
            'driving_license_no' => 'nullable|string|max:255',
            'driving_license_path' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
            'photo' => 'nullable|file|mimes:jpg,png,doc,docx|max:2048',
            'family_photo' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'bank_document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:255',
            'bank_ifsc_code' => 'nullable|string|max:255',
            'uan_no' => 'nullable|string|max:255',
            'hr_approval' => 'required|numeric',
            'modify_by' => 'nullable|integer',
            'password' => 'nullable|string|max:255',
            'refresh_code' => 'nullable|string|max:255',
            'psd' => 'nullable|string|max:255',
            'document_type.*' => 'nullable|string',
            'document_file.*' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:2048',
            'child_names.*' => 'nullable|string|max:255',
            'child_dobs.*' => 'nullable|date',

        ]);
        DB::beginTransaction();
        try {
            $validatedData['data_status'] = $request->input('data_status', 1);
            $validatedData['dcs_approval'] = $request->input('dcs_approval', 0);
            $candidate->update($validatedData);

            $fileFields = ['pan_path', 'aadhar_path', 'driving_license_path', 'photo', 'resume', 'bank_document', 'voter_id', 'emp_form', 'pf_esic_form', 'payslip', 'exp_letter', 'family_photo'];
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    if ($candidate->$field) {
                        Storage::disk('public')->delete($candidate->$field);
                    }

                    $file = $request->file($field);
                    $newFileName = $field . '_' . $candidate->id . '.' . $file->getClientOriginalExtension();

                    $filePath = $file->storeAs('uploads/' . $field, $newFileName, 'public');

                    CandidateDocuments::create([
                        'emp_id' => $candidate->id,
                        'name' => $field,
                        'path' => $filePath,
                        'status' => 0,
                    ]);
                }
            }

            if ($request->has('document_type') && $request->hasFile('document_file')) {
                foreach ($request->document_type as $index => $type) {
                    $file = $request->file('document_file')[$index] ?? null;

                    if ($file) {
                        $fileName = $type . $candidate->id . $file->getClientOriginalExtension();
                        $filePath = $file->storeAs('documents/' . $type, $fileName, 'public');
                        if ($type === 'education_certificate') {
                            EducationCertificate::create([
                                'emp_id' => $candidate->id,
                                'path' => 'storage/' . $filePath,
                                'status' => 0,
                            ]);
                        } elseif ($type === 'other_certificate') {
                            OtherCertificate::create([
                                'emp_id' => $candidate->id,
                                'path' => 'storage/' . $filePath,
                                'status' => 0,
                            ]);
                        } else {
                            if ($candidate->$type) {
                                Storage::disk('public')->delete($candidate->$type);
                            }
                            $candidate->$type = $filePath;
                            $candidate->save();
                        }
                    }
                }
            }
            if ($request->has('child_names') && $request->has('child_dobs')) {

                $childNames = $request->child_names;
                $childDobs = $request->child_dobs;
                DCSChildren::where('emp_id', $candidate->id)->delete();

                foreach ($childNames as $index => $name) {
                    if (!empty($name) && isset($childDobs[$index])) {
                        DCSChildren::create([
                            'emp_id' => $candidate->id,
                            'name' => $name,
                            'dob' => $childDobs[$index],
                        ]);
                    }
                }
            }
            $candidate->save();
            DB::commit();

            return redirect()->route('admin.doc_rejected')->with('success', 'Candidate updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    // public function generateOfferLetter(Request $request, $id)
    // {
    //     dd($request->all());

    //     $employee = $this->model()->findOrFail($id);
    //     $action = $request->input('action');

    //     $offerLetter = OfferLetter::create([
    //         'company_id' => $employee->client_id,
    //         'employee_id' => $employee->ffi_emp_id,
    //         'emp_name' => $employee->emp_name,
    //         'phone1' => $employee->phone1,
    //         'entity_name' => $employee->entity_name,
    //         'joining_date' => $employee->joining_date,
    //         'location' => $employee->location,
    //         'department' => $employee->department,
    //         'father_name' => $employee->father_name,
    //         'tenure_month' => now()->format('m'),
    //         'date' => now()->format('Y-m-d'),
    //         'tenure_date' => now()->format('Y-m-d'),
    //         'offer_letter_type' => 1,
    //         'status' => 1,
    //         'basic_salary' => $employee->basic_salary,
    //         'hra' => $employee->hra,
    //         'conveyance' => $employee->conveyance,
    //         'medical_reimbursement' => $employee->medical_reimbursement,
    //         'special_allowance' => $employee->special_allowance,
    //         'other_allowance' => $employee->other_allowance,
    //         'st_bonus' => $employee->st_bonus,
    //         'gross_salary' => $employee->gross_salary,
    //         'emp_pf' => $employee->emp_pf,
    //         'emp_esic' => $employee->emp_esic,
    //         'pt' => $employee->pt,
    //         'total_deduction' => $employee->total_deduction,
    //         'take_home' => $employee->take_home,
    //         'employer_pf' => $employee->employer_pf,
    //         'employer_esic' => $employee->employer_esic,
    //         'mediclaim' => $employee->mediclaim,
    //         'ctc' => $employee->ctc,
    //         'leave_wage' => $employee->leave_wage ?? 0,
    //         'email' => $employee->email,
    //         'notice_period' => $employee->notice_period ?? 7,
    //         'salary_date' => $employee->salary_date ?? 7,
    //         'designation' => $employee->designation,
    //         'offer_letter_pdf' => '',
    //     ]);

    //     $directory = storage_path('app/public/offer_letters/');
    //     if (!file_exists($directory)) {
    //         mkdir($directory, 0777, true);
    //     }

    //     $pdf = PDF::loadView('admin.adms.offer_letter.formate', compact('offerLetter'))
    //         ->setOptions([
    //             'isHtml5ParserEnabled' => true,
    //             'isRemoteEnabled' => true,
    //             'chroot' => public_path()
    //         ]);

    //     $pdfPath = 'offer_letters/offer_letter_' . $offerLetter->id . '.pdf';
    //     Storage::disk('public')->put($pdfPath, $pdf->output());

    //     $offerLetter->update(['offer_letter_pdf' => $pdfPath]);

    //     if ($action == 'send') {
    //         Mail::send('emails.offer_letter', ['employee' => $employee], function ($message) use ($employee, $pdfPath) {
    //             $message->to($employee->email)
    //                 ->cc('admin@example.com')
    //                 ->subject('Your Offer Letter')
    //                 ->attach(storage_path('app/public/' . $pdfPath));
    //         });

    //         return response()->json(['success' => true, 'message' => 'Offer letter generated and sent successfully.']);
    //     }

    //     return response()->json(['success' => true, 'message' => 'Offer letter generated and saved successfully.']);
    // }

}
