<?php

namespace App\Http\Controllers\Admin;

use App\Models\CFISModel;
use App\Models\DCSChildren;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\OtherCertificate;
use App\Http\Controllers\Controller;
use App\Models\EducationCertificate;

class DCSApprovalController extends Controller
{
    public function model()
    {
        return new CFISModel();
    }
    public function index()
    {
        $searchColumns = ['id', 'client_name', 'emp_name', 'phone1'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->model()->query()->where('data_status', 1);

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

        return view("admin.adms.dcs_approval.index", compact("candidate"));
    }
    public function edit($id)
    {
        $lastId = $this->model()->where('ffi_emp_id', 'LIKE', 'FFIFC%')
            ->orderBy('ffi_emp_id', 'desc')
            ->value('ffi_emp_id');

        if ($lastId) {
            $number = (int) substr($lastId, 5);
            $newNumber = str_pad($number + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        $uniqueId = 'FFIFC' . $newNumber;
        $candidate = $this->model()->find($id);
        return view('admin.adms.dcs_approval.edit', compact('candidate', 'uniqueId'));

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
            'resume' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'bank_document' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
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
            'document_file.*' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
            'child_names.*' => 'required|string|max:255',
            'child_dobs.*' => 'required|date',
        ]);
        $candidate->update($validatedData);

        $fileFields = ['pan_path', 'aadhar_path', 'driving_license_path', 'photo', 'resume', 'bank_document'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $filePath = $request->file($field)->store('uploads', $fileFields);
                $candidate->$field = $filePath;
            }
        }
        if ($request->has('document_type') && $request->hasFile('document_file')) {
            foreach ($request->document_type as $index => $type) {
                $file = $request->file('document_file')[$index] ?? null;

                if ($file) {
                    $filePath = $file->store('documents', 'public');

                    if ($type === 'education_certificate') {
                        EducationCertificate::create([
                            'emp_id' => $candidate->id,
                            'path' => $filePath,
                        ]);
                    } elseif ($type === 'other_certificate') {
                        OtherCertificate::create([
                            'emp_id' => $candidate->id,
                            'path' => $filePath,
                        ]);
                    } else {
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

        return redirect()->route('admin.dcs_approval')->with('success', 'Candidate updated successfully');
    }

    //pending update 
    public function destroy($id)
    {
        $this->model()->destroy($id);
        return redirect()->route('admin.dcs_approval')->with('success', 'Candidate data has been successfully deleted!');
    }
    public function rejected()
    {
        $searchColumns = ['id', 'client_name', 'emp_name', 'phone1'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->model()->query()->where('data_status', 2);

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
}
