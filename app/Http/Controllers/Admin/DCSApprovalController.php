<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\CFISModel;
use App\Models\BankDetails;
use App\Models\DCSChildren;
use App\Models\OfferLetter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\OtherCertificate;
use App\Models\CandidateDocuments;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\EducationCertificate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ImportApprovedCandidatesJob;

class DCSApprovalController extends Controller
{
    public function model()
    {
        return new CFISModel();
    }
    public function index()
    {
        $searchColumns = ['id', 'ffi_emp_id', 'client_id', 'emp_name', 'phone1'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        // $query = $this->model()->query()->where('data_status', 1);

        if (auth()->user()->hasRole(['HR Operations', 'Admin'])) {
            $query = $this->model()->query();
            // ->where('dcs_approval', 0)
            // ->whereIn('data_status', [0]);
        } elseif (auth()->user()->hasRole('Recruitment')) {
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

        $candidate = $this->model()->with('candidateDocuments', 'educationCertificates', 'otherCertificates')->find($id);
        $children = DCSChildren::where('emp_id', $candidate->id)->get();
        $bankdetails = BankDetails::where('emp_id', $candidate->id)
            ->whereIn('status', [null, 1])
            ->first() ?? new BankDetails();

        return view('admin.adms.dcs_approval.edit', compact('candidate', 'children', 'bankdetails'));

    }
    public function update(Request $request, $id)
    {
        $candidate = $this->model()->find($id);
        $request->validate([
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
            'pan_path' => 'nullable',
            'aadhar_no' => 'required|string|min:12',
            'aadhar_path' => 'nullable',
            'driving_license_no' => 'nullable|string|max:255',
            'driving_license_path' => 'nullable',
            'photo' => 'nullable|file|mimes:jpg,png,pdf',
            'family_photo' => 'nullable|file|mimes:jpg,png,pdf',
            'resume' => 'nullable|file',
            // 'bank_document' => 'nullable',
            // 'bank_name' => 'nullable|string|max:255',
            // 'bank_account_no' => 'nullable|string|max:255',
            // 'bank_ifsc_code' => 'nullable|string|max:255',
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
            'pan_status' => 'nullable|boolean',
            'modify_by' => 'nullable|integer',
            'password' => 'nullable|string|max:255',
            'refresh_code' => 'nullable|string|max:255',
            'psd' => 'nullable|string|max:255',
            'document_type.*' => 'nullable|string',
            'document_file.*' => 'nullable',
            'child_names.*' => 'nullable|string|max:255',
            'child_dobs.*' => 'nullable|date',
            'child_photo.*' => 'nullable|file|mimes:jpg,png,pdf',
            'child_aadhar_no.*' => 'nullable|string|min:12',

        ]);
        $validatedData = $request->all();
        DB::beginTransaction();
        try {
            $validatedData['password'] = $request->input('dcs_approval', 'ffemp@123');
            $validatedData['psd'] = $request->input('dcs_approval', 'ffemp@123');
            $validatedData['dcs_approval'] = $request->input('dcs_approval', 0);
            $validatedData['data_status'] = $request->input('data_status', 1);
            $validatedData['hr_approval'] = $request->input('hr_approval', 0);

            $candidate->update($validatedData);

            $fileFields = ['pan_path', 'aadhar_path', 'driving_license_path', 'photo', 'resume', 'family_photo', 'father_photo', 'mother_photo', 'spouse_photo', 'pan_declaration'];
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $newFileName = $field . '_' . $candidate->id . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('uploads/' . $field, $newFileName, 'public');

                    $existingDocument = CandidateDocuments::where('emp_id', $candidate->id)
                        ->where('name', $field)
                        ->first();

                    if ($existingDocument) {
                        Storage::disk('public')->delete($existingDocument->path);

                        $existingDocument->update(['path' => $filePath, 'status' => 0]);
                    } else {
                        CandidateDocuments::create([
                            'emp_id' => $candidate->id,
                            'name' => $field,
                            'path' => $filePath,
                            'status' => 0,
                        ]);
                    }
                }
            }

            if ($request->has('document_type') && $request->hasFile('document_file')) {
                foreach ($request->document_type as $index => $type) {
                    $file = $request->file('document_file')[$index] ?? null;

                    if ($file) {
                        $fileName = $type . $candidate->id . '.' . $file->getClientOriginalExtension();
                        $filePath = $file->storeAs('documents/' . $type, $fileName, 'public');
                        if ($type === 'education_certificate') {
                            EducationCertificate::create([
                                'emp_id' => $candidate->id,
                                'path' => $filePath,
                                'status' => 0,
                            ]);
                        } elseif ($type === 'other_certificate') {
                            OtherCertificate::create([
                                'emp_id' => $candidate->id,
                                'path' => $filePath,
                                'status' => 0,
                            ]);
                        } else {
                            CandidateDocuments::create([
                                'emp_id' => $candidate->id,
                                'name' => $type,
                                'path' => $filePath,
                                'status' => 0,
                            ]);
                            $candidate->save();
                        }
                    }
                }
            }
            if ($request->has(['child_names', 'child_dobs'])) {
                $childNames = $request->child_names;
                $childDobs = $request->child_dobs;
                $childPhotos = $request->file('child_photo') ?? [];
                $childAadhar = $request->child_aadhar ?? [];

                if (!isset($candidate) || empty($candidate->id)) {
                    return back()->with('error', 'Candidate not found.');
                }

                DCSChildren::where('emp_id', $candidate->id)->delete();

                $childrenData = [];

                foreach ($childNames as $index => $name) {
                    if (!empty($name) && isset($childDobs[$index])) {

                        $photoPath = null;
                        if (!empty($childPhotos) && isset($childPhotos[$index])) {
                            $photo = $childPhotos[$index];
                            $photoPath = $photo->store('children_photos', 'public');
                        }

                        $childData = [
                            'emp_id' => $candidate->id,
                            'name' => $name,
                            'dob' => $childDobs[$index],
                            'photo' => $photoPath,
                            'aadhar_no' => isset($childAadhar[$index]) ? $childAadhar[$index] : null,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];

                        $childrenData[] = $childData;
                    }
                }

                if (!empty($childrenData)) {
                    DCSChildren::insert($childrenData);
                }
            }

            if ($request->has(['bank_name', 'bank_account_no', 'bank_ifsc_code'])) {
                if (!isset($candidate) || empty($candidate->id)) {
                    return back()->with('error', 'Candidate not found.');
                }
                $filePath = null;
                if ($request->hasFile('bank_document')) {
                    $file = $request->file('bank_document');
                    $fileName = 'bank_document_' . $candidate->id . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('documents/bank', $fileName, 'public');
                }
                BankDetails::updateOrCreate(
                    ['emp_id' => $candidate->id],
                    [
                        'bank_name' => $request->bank_name,
                        'bank_account_no' => $request->bank_account_no,
                        'bank_ifsc_code' => $request->bank_ifsc_code,
                        'bank_status' => 0,
                        'bank_document' => $filePath,
                    ]
                );

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
        $searchColumns = ['id', 'ffi_emp_id', 'client_id', 'emp_name', 'phone1'];
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
        $searchColumns = ['id', 'ffi_emp_id', 'client_id', 'emp_name', 'phone1'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;
        $userId = auth()->id();

        if (auth()->user()->hasRole('Admin')) {
            $query = $this->model()->query()
                ->whereIn('data_status', [1])
                ->whereIn('hr_approval', [0, 1]);
        } else {
            $query = $this->model()->query()
                // ->whereIn('data_status', [0, 1])
                ->whereIn('data_status', [1])
                ->whereIn('hr_approval', [0, 1])
                ->whereHas('hrMasters', function ($q) use ($userId) {
                    $q->where('user_id', $userId)
                        ->whereIn('dcs_approval', [0]);
                })
                ->with(['hrMasters.client']);
        }
        $from_date = request()->get('from_date');
        $to_date = request()->get('to_date');
        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        $search = request()->get('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('emp_name', 'LIKE', "%$search%")
                    ->orWhere('ffi_emp_id', 'LIKE', "%$search%");
            });
        }

        $orderBy = in_array(request()->get('orderBy'), ['asc', 'desc']) ? request()->get('orderBy') : 'desc';
        $query->orderBy('id', $orderBy);

        $candidates = $query->paginate(10)->appends(request()->query());

        return view("admin.adms.hr.hrindex", compact("candidates"));
    }

    public function hredit($id)
    {
        $candidate = $this->model()
            ->with(['client', 'educationCertificates', 'otherCertificates', 'candidateDocuments'])
            ->findOrFail($id);

        $bankdetails = BankDetails::where('emp_id', $candidate->id)->where('status', 1)->get();

        $children = DCSChildren::where('emp_id', $candidate->id)->get();

        return view('admin.adms.hr.hredit', compact('candidate', 'children', 'bankdetails'));
    }

    public function hrupdate(Request $request, $id)
    {
        // dd($request->cc_emails);
        $action = $request->input('storing_option');
        $candidate = $this->model()->find($id);
        $request->validate([
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
            'spouse_dob' => 'nullable|date',
            'religion' => 'nullable|string|max:255',
            'languages' => 'nullable|string|max:255',
            'mother_tongue' => 'nullable|string|max:255',
            'maritial_status' => 'nullable|string|max:255',
            'father_aadhar_no' => 'nullable|string|min:12',
            'mother_aadhar_no' => 'nullable|string|min:12',
            'spouse_aadhar_no' => 'nullable|string|min:12',
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
            'pan_path' => 'nullable|file',
            'aadhar_no' => 'nullable|string|max:255',
            'aadhar_path' => 'nullable|file',
            'driving_license_no' => 'nullable|string|max:255',
            'driving_license_path' => 'nullable|file',
            'photo' => 'nullable|file',
            'family_photo' => 'nullable|file',
            'resume' => 'nullable|file',
            // 'bank_document' => 'nullable|file',
            // 'bank_name' => 'nullable|string|max:255',
            // 'bank_account_no' => 'nullable|string|max:255',
            // 'bank_ifsc_code' => 'nullable|string|max:255',
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
            'lwf' => 'nullable|numeric',
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
            'pan_status' => 'nullable|boolean',
            'document_type.*' => 'nullable|string',
            'document_file.*' => 'nullable|file',
            'child_names.*' => 'nullable|string|max:255',
            'child_dobs.*' => 'nullable|date',
            'child_photo.*' => 'nullable|file|mimes:jpg,png,pdf',
            'note' => 'nullable|string'


        ]);
        $validatedData = $request->all();
        DB::beginTransaction();
        try {
            $validatedData['data_status'] = $request->input('data_status', 1);
            $validatedData['dcs_approval'] = $request->input('dcs_approval', 0);
            $validatedData['comp_status'] = $request->input('comp_status', 0);
            $validatedData['modify_by'] = auth()->id();

            $candidate->update($validatedData);

            $fileFields = ['pan_path', 'aadhar_path', 'driving_license_path', 'photo', 'resume', 'family_photo', 'father_photo', 'mother_photo', 'spouse_photo', 'pan_declaration'];
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $newFileName = $field . '_' . $candidate->id . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('uploads/' . $field, $newFileName, 'public');

                    $existingDocument = CandidateDocuments::where('emp_id', $candidate->id)
                        ->where('name', $field)
                        ->first();

                    if ($existingDocument) {
                        Storage::disk('public')->delete($existingDocument->path);

                        $existingDocument->update(['path' => $filePath, 'status' => 0]);
                    } else {
                        CandidateDocuments::create([
                            'emp_id' => $candidate->id,
                            'name' => $field,
                            'path' => $filePath,
                            'status' => 0,
                        ]);
                    }
                }
            }
            if ($request->has('document_type') && $request->hasFile('document_file')) {
                foreach ($request->document_type as $index => $type) {
                    $file = $request->file('document_file')[$index] ?? null;

                    if ($file) {
                        $fileName = $type . $candidate->id . '.' . $file->getClientOriginalExtension();
                        $filePath = $file->storeAs('documents/' . $type, $fileName, 'public');
                        if ($type === 'education_certificate') {
                            EducationCertificate::create([
                                'emp_id' => $candidate->id,
                                'path' => $filePath,
                                'status' => 1,
                            ]);
                        } elseif ($type === 'other_certificate') {
                            OtherCertificate::create([
                                'emp_id' => $candidate->id,
                                'path' => $filePath,
                                'status' => 1,
                            ]);

                        } else {
                            CandidateDocuments::create([
                                'emp_id' => $candidate->id,
                                'name' => $type,
                                'path' => $filePath,
                                'status' => 0,
                            ]);
                            $candidate->save();
                        }
                    }
                }
            }
            if ($request->has(['child_names', 'child_dobs'])) {
                $childNames = $request->child_names;
                $childDobs = $request->child_dobs;
                $childPhotos = $request->file('child_photo') ?? [];
                $childAadhar = $request->child_aadhar ?? [];

                if (!isset($candidate) || empty($candidate->id)) {
                    return back()->with('error', 'Candidate not found.');
                }

                DCSChildren::where('emp_id', $candidate->id)->delete();

                $childrenData = [];

                foreach ($childNames as $index => $name) {
                    if (!empty($name) && isset($childDobs[$index])) {

                        $photoPath = null;
                        if (!empty($childPhotos) && isset($childPhotos[$index])) {
                            $photo = $childPhotos[$index];
                            $photoPath = $photo->store('children_photos', 'public');
                        }

                        $childData = [
                            'emp_id' => $candidate->id,
                            'name' => $name,
                            'dob' => $childDobs[$index],
                            'photo' => $photoPath,
                            'aadhar_no' => isset($childAadhar[$index]) ? $childAadhar[$index] : null,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];

                        $childrenData[] = $childData;
                    }
                }

                if (!empty($childrenData)) {
                    DCSChildren::insert($childrenData);
                }
            }

            if ($request->has(['bank_name', 'bank_account_no', 'bank_ifsc_code'])) {
                if (!isset($candidate) || empty($candidate->id)) {
                    return back()->with('error', 'Candidate not found.');
                }
                $bankDetails = BankDetails::where('emp_id', $candidate->id)
                    ->where('status', 1)
                    ->first();
                $filePath = $bankDetails ? $bankDetails->bank_document : null;
                if ($request->hasFile('bank_document')) {
                    $file = $request->file('bank_document');
                    $fileName = 'bank_document_' . $candidate->id . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('documents/bank', $fileName, 'public');
                }
                BankDetails::where('emp_id', $candidate->id)
                    ->where('status', 1)
                    ->update([
                        'bank_name' => $request->bank_name,
                        'bank_account_no' => $request->bank_account_no,
                        'bank_ifsc_code' => $request->bank_ifsc_code,
                        'bank_status' => 0,
                        'bank_document' => $filePath,
                    ]);
            }


            $candidate->hr_approval = $request->hr_approval;

            if ($request->hr_approval == '2') {
                $candidate->note = $request->note;
            } else {
                $candidate->note = null;
            }
            $candidate->save();
            if ($candidate->hr_approval == 1) {
                $existingOfferLetter = OfferLetter::where('employee_id', $candidate->ffi_emp_id)->first();

                if ($existingOfferLetter) {
                    $existingOfferLetter->delete();
                }

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
                    'lwf' => $candidate->lwf ?? 0,
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
                ]);
                $pdf = Pdf::loadView('admin.adms.offer_letter.formate', ['offerLetter' => $offerLetter]);

                $fileName = 'offer_letter' . $candidate->ffi_emp_id . '.pdf';
                $filePath = 'offer_letters/' . $fileName;

                Storage::disk('public')->put($filePath, $pdf->output());

                $offerLetter->update([
                    'offer_letter_path' => $filePath
                ]);


                if ($action === 'send') {
                    $ccEmails = $request->input('cc_emails', []);
                    Mail::send('mail.offer_letter', ['employee' => $candidate], function ($message) use ($candidate, $filePath, $ccEmails) {
                        $message->to($candidate->email)
                            ->cc($ccEmails)
                            ->subject('Offer Letter')
                            ->attach(asset($filePath)); // Use the file path for attaching the PDF to email
                    });
                }

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
        $request->validate([
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
            'phone1' => 'nullable|string|max:15',
            'phone2' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'official_mail_id' => 'nullable|email|max:255',
            'permanent_address' => 'nullable|string',
            'present_address' => 'nullable|string',
            'pan_no' => 'nullable|string|max:255',
            'pan_path' => 'nullable|file|',
            'aadhar_no' => 'nullable|string|min:12',
            'aadhar_path' => 'nullable|file|',
            'driving_license_no' => 'nullable|string|max:255',
            'driving_license_path' => 'nullable|file|',
            'photo' => 'nullable|file|mimes:jpg,png,pdf|',
            'family_photo' => 'nullable|file|mimes:jpg,png,pdf',
            'resume' => 'nullable|file',
            // 'bank_document' => 'nullable|file',
            // 'bank_name' => 'nullable|string|max:255',
            // 'bank_account_no' => 'nullable|string|max:255',
            // 'bank_ifsc_code' => 'nullable|string|max:255',
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
            'document_type.*' => 'nullable|string',
            'document_file.*' => 'nullable|file',
            'child_names.*' => 'nullable|string|max:255',
            'child_dobs.*' => 'nullable|date',
            'child_photo.*' => 'nullable|file|mimes:jpg,png,pdf',
            'child_aadhar_no.*' => 'nullable|string|min:12',


        ]);
        $validatedData = $request->all();
        DB::beginTransaction();
        try {
            $candidate = $this->model()->findOrFail($validatedData['id']);
            $validatedData['dcs_approval'] = $request->input('data_status', 0);
            $validatedData['data_status'] = $request->input('status', 0);
            $candidate->update($validatedData);


            $fileFields = ['pan_path', 'aadhar_path', 'driving_license_path', 'photo', 'resume', 'family_photo', 'father_photo', 'mother_photo', 'spouse_photo', 'pan_declaration'];
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $newFileName = $field . '_' . $candidate->id . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('uploads/' . $field, $newFileName, 'public');

                    $existingDocument = CandidateDocuments::where('emp_id', $candidate->id)
                        ->where('name', $field)
                        ->first();

                    if ($existingDocument) {
                        Storage::disk('public')->delete($existingDocument->path);

                        $existingDocument->update(['path' => $filePath, 'status' => 0]);
                    } else {
                        CandidateDocuments::create([
                            'emp_id' => $candidate->id,
                            'name' => $field,
                            'path' => $filePath,
                            'status' => 0,
                        ]);
                    }
                }
            }

            if ($request->has('document_type') && $request->hasFile('document_file')) {
                foreach ($request->document_type as $index => $type) {
                    $file = $request->file('document_file')[$index] ?? null;

                    if ($file) {
                        $fileName = $type . $candidate->id . '.' . $file->getClientOriginalExtension();
                        $filePath = $file->storeAs('documents/' . $type, $fileName, 'public');
                        if ($type === 'education_certificate') {
                            EducationCertificate::create([
                                'emp_id' => $candidate->id,
                                'path' => $filePath,
                                'status' => 0,
                            ]);
                        } elseif ($type === 'other_certificate') {
                            OtherCertificate::create([
                                'emp_id' => $candidate->id,
                                'path' => $filePath,
                                'status' => 0,
                            ]);
                        } else {
                            CandidateDocuments::create([
                                'emp_id' => $candidate->id,
                                'name' => $type,
                                'path' => $filePath,
                                'status' => 0,
                            ]);
                            $candidate->save();
                        }
                    }
                }
            }
            if ($request->has(['child_names', 'child_dobs'])) {
                $childNames = $request->child_names;
                $childDobs = $request->child_dobs;
                $childPhotos = $request->file('child_photo') ?? [];
                $childAadhar = $request->child_aadhar ?? [];

                if (!isset($candidate) || empty($candidate->id)) {
                    return back()->with('error', 'Candidate not found.');
                }

                DCSChildren::where('emp_id', $candidate->id)->delete();

                $childrenData = [];

                foreach ($childNames as $index => $name) {
                    if (!empty($name) && isset($childDobs[$index])) {

                        $photoPath = null;
                        if (!empty($childPhotos) && isset($childPhotos[$index])) {
                            $photo = $childPhotos[$index];
                            $photoPath = $photo->store('children_photos', 'public');
                        }

                        $childData = [
                            'emp_id' => $candidate->id,
                            'name' => $name,
                            'dob' => $childDobs[$index],
                            'photo' => $photoPath,
                            'aadhar_no' => isset($childAadhar[$index]) ? $childAadhar[$index] : null,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];

                        $childrenData[] = $childData;
                    }
                }

                if (!empty($childrenData)) {
                    DCSChildren::insert($childrenData);
                }
            }

            if ($request->has(['bank_name', 'bank_account_no', 'bank_ifsc_code'])) {
                if (!isset($candidate) || empty($candidate->id)) {
                    return back()->with('error', 'Candidate not found.');
                }
                $filePath = null;
                if ($request->hasFile('bank_document')) {
                    $file = $request->file('bank_document');
                    $fileName = 'bank_document_' . $candidate->id . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('documents/bank', $fileName, 'public');
                }
                BankDetails::updateOrCreate(
                    ['emp_id' => $candidate->id],
                    [
                        'bank_name' => $request->bank_name,
                        'bank_account_no' => $request->bank_account_no,
                        'bank_ifsc_code' => $request->bank_ifsc_code,
                        'bank_status' => 0,
                        'bank_document' => $filePath,
                    ]
                );

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
        $searchColumns = ['id', 'ffi_emp_id', 'client_id', 'emp_name', 'phone1'];
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
            ->with(['client', 'educationCertificates', 'otherCertificates', 'candidateDocuments'])
            ->findOrFail($id);

        $children = DCSChildren::where('emp_id', $candidate->id)->get();
        $bankdetails = BankDetails::where('emp_id', $candidate->id)->where('status', 1)->get();

        return view("admin.adms.dcs_approval.docedit", compact('candidate', 'children', 'bankdetails'));
    }
    public function docupdate(Request $request, $id)
    {
        $candidate = $this->model()->find($id);
        $request->validate([
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
            'phone1' => 'nullable|string|max:15',
            'phone2' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'official_mail_id' => 'nullable|email|max:255',
            'permanent_address' => 'nullable|string',
            'present_address' => 'nullable|string',
            'pan_no' => 'nullable|string|max:255',
            'pan_path' => 'nullable|file|',
            'aadhar_no' => 'nullable|string|min:12',
            'aadhar_path' => 'nullable|file|',
            'driving_license_no' => 'nullable|string|max:255',
            'driving_license_path' => 'nullable|file|',
            'photo' => 'nullable|file|mimes:jpg,png,pdf|',
            'family_photo' => 'nullable|file|mimes:jpg,png,pdf',
            'resume' => 'nullable|file',
            // 'bank_document' => 'nullable|file',
            // 'bank_name' => 'nullable|string|max:255',
            // 'bank_account_no' => 'nullable|string|max:255',
            // 'bank_ifsc_code' => 'nullable|string|max:255',
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
            'document_type.*' => 'nullable|string',
            'document_file.*' => 'nullable|file',
            'child_names.*' => 'nullable|string|max:255',
            'child_dobs.*' => 'nullable|date',
            'child_photo.*' => 'nullable|file|mimes:jpg,png,pdf',
            'child_aadhar_no.*' => 'nullable|string|min:12',
        ]);
        $validatedData = $request->all();

        DB::beginTransaction();
        try {
            $validatedData['data_status'] = $request->input('data_status', 1);
            $validatedData['dcs_approval'] = $request->input('dcs_approval', 0);
            $candidate->update($validatedData);

            $fileFields = ['pan_path', 'aadhar_path', 'driving_license_path', 'photo', 'resume', 'family_photo', 'father_photo', 'mother_photo', 'spouse_photo', 'pan_declaration'];
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $newFileName = $field . '_' . $candidate->id . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('uploads/' . $field, $newFileName, 'public');

                    $existingDocument = CandidateDocuments::where('emp_id', $candidate->id)
                        ->where('name', $field)
                        ->first();

                    if ($existingDocument) {
                        Storage::disk('public')->delete($existingDocument->path);

                        $existingDocument->update(['path' => $filePath, 'status' => 0]);
                    } else {
                        CandidateDocuments::create([
                            'emp_id' => $candidate->id,
                            'name' => $field,
                            'path' => $filePath,
                            'status' => 0,
                        ]);
                    }
                }
            }

            if ($request->has('document_type') && $request->hasFile('document_file')) {
                foreach ($request->document_type as $index => $type) {
                    $file = $request->file('document_file')[$index] ?? null;

                    if ($file) {
                        $fileName = $type . $candidate->id . '.' . $file->getClientOriginalExtension();
                        $filePath = $file->storeAs('documents/' . $type, $fileName, 'public');
                        if ($type === 'education_certificate') {
                            EducationCertificate::create([
                                'emp_id' => $candidate->id,
                                'path' => $filePath,
                                'status' => 0,
                            ]);
                        } elseif ($type === 'other_certificate') {
                            OtherCertificate::create([
                                'emp_id' => $candidate->id,
                                'path' => $filePath,
                                'status' => 0,
                            ]);
                        } else {
                            CandidateDocuments::create([
                                'emp_id' => $candidate->id,
                                'name' => $type,
                                'path' => $filePath,
                                'status' => 0,
                            ]);
                            $candidate->save();
                        }
                    }
                }
            }
            if ($request->has(['child_names', 'child_dobs'])) {
                $childNames = $request->child_names;
                $childDobs = $request->child_dobs;
                $childPhotos = $request->file('child_photo') ?? [];
                $childAadhar = $request->child_aadhar ?? [];

                if (!isset($candidate) || empty($candidate->id)) {
                    return back()->with('error', 'Candidate not found.');
                }

                DCSChildren::where('emp_id', $candidate->id)->delete();

                $childrenData = [];

                foreach ($childNames as $index => $name) {
                    if (!empty($name) && isset($childDobs[$index])) {

                        $photoPath = null;
                        if (!empty($childPhotos) && isset($childPhotos[$index])) {
                            $photo = $childPhotos[$index];
                            $photoPath = $photo->store('children_photos', 'public');
                        }

                        $childData = [
                            'emp_id' => $candidate->id,
                            'name' => $name,
                            'dob' => $childDobs[$index],
                            'photo' => $photoPath,
                            'aadhar_no' => isset($childAadhar[$index]) ? $childAadhar[$index] : null,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];

                        $childrenData[] = $childData;
                    }
                }

                if (!empty($childrenData)) {
                    DCSChildren::insert($childrenData);
                }
            }

            if ($request->has(['bank_name', 'bank_account_no', 'bank_ifsc_code'])) {
                if (!isset($candidate) || empty($candidate->id)) {
                    return back()->with('error', 'Candidate not found.');
                }
                $bankDetails = BankDetails::where('emp_id', $candidate->id)
                    ->where('status', 1)
                    ->first();
                $filePath = $bankDetails ? $bankDetails->bank_document : null;
                if ($request->hasFile('bank_document')) {
                    $file = $request->file('bank_document');
                    $fileName = 'bank_document_' . $candidate->id . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('documents/bank', $fileName, 'public');
                }
                BankDetails::where('emp_id', $candidate->id)
                    ->where('status', 1)
                    ->update([
                        'bank_name' => $request->bank_name,
                        'bank_account_no' => $request->bank_account_no,
                        'bank_ifsc_code' => $request->bank_ifsc_code,
                        'bank_status' => 0,
                        'bank_document' => $filePath,
                    ]);
            }

            $candidate->save();
            DB::commit();

            return redirect()->route('admin.doc_rejected')->with('success', 'Candidate updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function import(Request $request)
    {
        $created_by = auth()->id();
        // dd($request->all());
        $file = $request->file;
        // dd($file);
        try {
            if ($file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = public_path('imports');

                $file->move($filePath, $fileName);
                $fileWithPath = $filePath . '/' . $fileName;

                $header = null;

                $records = array_map('str_getcsv', file($fileWithPath));
                $header = $records[0];
                unset($records[0]);
                // dd($header, $records);

                $dataChunks = array_chunk($records, 1000);
                // dd($dataChunks);
                foreach ($dataChunks as $chunk) {
                    $processedData = [];

                    foreach ($chunk as $index => $record) {
                        if (count($header) == count($record)) {
                            $row = array_combine($header, $record);

                            $exists = DB::table('backend_management')
                                ->where('ffi_emp_id', $row['emp_id'])
                                ->orWhere('phone1', $row['phone1'])
                                ->exists();

                            if ($exists) {
                                $duplicates[] = "Duplicate at Row #" . ($index + 2) . " — ID: {$row['emp_id']}, Phone: {$row['phone1']}";
                            } else {
                                $processedData[] = $row;
                            }
                        }
                    }

                    if (!empty($processedData)) {
                        // 
                        ImportApprovedCandidatesJob::dispatch($processedData, $created_by);
                        // dd($processedData);
                    }
                }
                if (file_exists($fileWithPath)) {
                    unlink($fileWithPath);
                }
                if (!empty($duplicates)) {
                    $message = "Some records were skipped due to duplicates:\n";

                    foreach ($duplicates as $d) {
                        $message .= $d . "\n";
                    }

                    return redirect()->route('admin.dcs_approval')->with('error', nl2br($message));
                }
            }
        } catch (Exception $e) {
            return redirect()->route('admin.dcs_approval')->with([
                'error' => 'Import failed: ' . $e->getMessage()
            ]);
        }

        return redirect()->route('admin.dcs_approval')->with([
            'success' => 'File imported successfully'
        ]);
    }

}
