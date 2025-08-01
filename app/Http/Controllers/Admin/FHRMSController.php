<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\FHRMSModel;
use App\Exports\FHRMSExport;
use App\Imports\FHRMSImport;
use Illuminate\Http\Request;
use App\Models\FFIOTherModel;
use App\Models\FFIEducationModel;
use App\Exports\FHRMSReportExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class FHRMSController extends Controller
{
    public function model()
    {
        return new FHRMSModel();
    }
    public function index()
    {
        $searchColumns = ['id', 'ffi_emp_id', 'emp_name', 'joining_date', 'phone1', 'email'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->model()->query();

        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }
        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value)
                    ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $employee = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(100)->appends(request()->query());

        return view("admin.hr_management.fhrms.index", compact("employee"));

    }
    public function create()
    {
        return view("admin.hr_management.fhrms.create");
    }
    public function store(Request $request)
    {
        $request->validate([
            'ffi_emp_id' => 'required|string|max:255',
            'emp_name' => 'required|string|max:255',
            'interview_date' => 'required|date',
            'joining_date' => 'required|date',
            'contract_date' => 'nullable|date',
            'designation' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'state' => 'required|integer',
            'location' => 'required|string|max:255',
            'dob' => 'required|date',
            'father_name' => 'required|string|max:255',
            'gender' => 'required',
            'blood_group' => 'required|string',
            'qualification' => 'required|string|max:255',
            'phone1' => 'required|digits:10|min:10|max:15',
            'phone2' => 'nullable|digits:10|min:10|max:15',
            'email' => 'nullable|email|max:255',
            'permanent_address' => 'required|string',
            'present_address' => 'required|string',
            'pan_no' => 'nullable|string|max:20',
            'pan_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'aadhar_no' => 'required|string|max:20',
            'aadhar_path' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'driving_license_no' => 'nullable|string|max:20',
            'driving_license_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'photo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'resume' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'bank_name' => 'nullable|string|max:255',
            'bank_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'bank_account_no' => 'nullable|string|max:20',
            'repeat_acc_no' => 'nullable|string|same:bank_account_no',
            'bank_ifsc_code' => 'required|string|max:20',
            'uan_generatted' => 'nullable|string|max:255',
            'uan_type' => 'nullable|string',
            'uan_no' => 'nullable|string|max:20',
            'status' => 'nullable|string',
            'basic_salary' => 'required|numeric',
            'hra' => 'required|numeric',
            'conveyance' => 'required|numeric',
            'medical_reimbursement' => 'required|numeric',
            'special_allowance' => 'required|numeric',
            'other_allowance' => 'required|numeric',
            'st_bonus' => 'required|numeric',
            'gross_salary' => 'required|numeric',
            'emp_pf' => 'required|numeric',
            'emp_esic' => 'required|numeric',
            'pt' => 'required|numeric',
            'total_deduction' => 'required|numeric',
            'take_home' => 'required|numeric',
            'employer_pf' => 'required|numeric',
            'employer_esic' => 'required|numeric',
            'mediclaim' => 'required|numeric',
            'ctc' => 'required|numeric',
            'voter_id' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'emp_form' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'pf_esic_form' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'payslip' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'exp_letter' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'education_certificates' => 'nullable|array',
            'education_certificates.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'others' => 'nullable|array',
            'others.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'password' => 'required|string',
            'psd' => 'nullable',

        ]);

        $filePaths = [];
        $fileFields = [
            'pan_path',
            'aadhar_path',
            'driving_license_path',
            'photo',
            'resume',
            'bank_document',
            'voter_id',
            'emp_form',
            'pf_esic_form',
            'payslip',
            'exp_letter'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $filePaths[$field] = $request->file($field)->store('uploads', 'public');
            }
        }
        $validatedData = $request->all();

        DB::beginTransaction();
        try {
            $employee = $this->model()->create($validatedData);
            $employee->fill($filePaths);
            $employee->modified_date = now();
            $employee->psd = $request->password;
            $employee->password = bcrypt($request->password);
            $employee->data_status = '0';
            $employee->active_status = '0';
            $employee->save();

            if ($request->hasFile('education_certificates')) {
                foreach ($request->file('education_certificates') as $file) {
                    $filePath = $file->store('education_certificates', 'public');

                    FFIEducationModel::create([
                        'emp_id' => $employee->id,
                        'path' => $filePath,
                    ]);
                }
            }

            if ($request->hasFile('others')) {
                foreach ($request->file('others') as $file) {
                    $filePath = $file->store('others', 'public');

                    FFIOTherModel::create([
                        'emp_id' => $employee->id,
                        'path' => $filePath,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.fhrms')->with('success', 'Employee data has been successfully saved!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function edit($id)
    {
        $employee = $this->model()->find($id);
        $education = FFIEducationModel::where('emp_id', $id)->get();
        $other = FFIOTherModel::where('emp_id', $id)->get();

        return view('admin.hr_management.fhrms.update', compact('employee', 'education', 'other'));

    }
    public function update(Request $request, $id)
    {
        $employee = $this->model()->findOrFail($id);

        $request->validate([
            'ffi_emp_id' => 'required|string|max:255',
            'emp_name' => 'required|string|max:255',
            'interview_date' => 'required|date',
            'joining_date' => 'required|date',
            'contract_date' => 'nullable|date',
            'designation' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'state' => 'required|integer',
            'location' => 'required|string|max:255',
            'dob' => 'required|date',
            'father_name' => 'required|string|max:255',
            'gender' => 'required',
            'blood_group' => 'required|string',
            'qualification' => 'required|string|max:255',
            'phone1' => 'required|digits:10',
            'phone2' => 'nullable|digits:10',
            'email' => 'nullable|email|max:255',
            'permanent_address' => 'required|string',
            'present_address' => 'required|string',
            'pan_no' => 'nullable|string|max:20',
            'pan_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'aadhar_no' => 'required|string|max:20',
            'aadhar_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'driving_license_no' => 'nullable|string|max:20',
            'driving_license_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'resume' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'bank_name' => 'nullable|string|max:255',
            'bank_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'bank_account_no' => 'nullable|string|max:20',
            'repeat_acc_no' => 'nullable|string|same:bank_account_no',
            'bank_ifsc_code' => 'required|string|max:20',
            'uan_generatted' => 'nullable|string|max:255',
            'uan_type' => 'nullable|string',
            'uan_no' => 'nullable|string|max:20',
            'status' => 'nullable|string',
            'basic_salary' => 'required|numeric',
            'hra' => 'required|numeric',
            'conveyance' => 'required|numeric',
            'medical_reimbursement' => 'required|numeric',
            'special_allowance' => 'required|numeric',
            'other_allowance' => 'required|numeric',
            'st_bonus' => 'required|numeric',
            'gross_salary' => 'required|numeric',
            'emp_pf' => 'required|numeric',
            'emp_esic' => 'required|numeric',
            'pt' => 'required|numeric',
            'total_deduction' => 'required|numeric',
            'take_home' => 'required|numeric',
            'employer_pf' => 'required|numeric',
            'employer_esic' => 'required|numeric',
            'mediclaim' => 'required|numeric',
            'ctc' => 'required|numeric',
            'voter_id' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'emp_form' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'pf_esic_form' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'payslip' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'exp_letter' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'education_certificates' => 'nullable|array',
            'education_certificates.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'others' => 'nullable|array',
            'others.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'password' => 'nullable|string|min:8',
            'psd' => 'nullable',
        ]);

        $filePaths = [];
        $fileFields = [
            'pan_path',
            'aadhar_path',
            'driving_license_path',
            'photo',
            'resume',
            'bank_document',
            'voter_id',
            'emp_form',
            'pf_esic_form',
            'payslip',
            'exp_letter'
        ];
        $validatedData = $request->all();

        DB::beginTransaction();

        try {
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    if ($employee->$field) {
                        Storage::disk('public')->delete($employee->$field);
                    }
                    $filePaths[$field] = $request->file($field)->store('uploads', 'public');
                }
            }

            $employee->fill($validatedData);

            $employee->fill($filePaths);

            if ($request->filled('password')) {
                $employee->psd = $request->password;
                $employee->password = bcrypt($request->password);
            }
            $employee->save();
            if ($request->hasFile('education_certificates')) {
                foreach ($request->file('education_certificates') as $file) {
                    $filePath = $file->store('education_certificates', 'public');

                    FFIEducationModel::create([
                        'emp_id' => $employee->id,
                        'path' => $filePath,
                    ]);
                }
            }

            if ($request->hasFile('others')) {
                foreach ($request->file('others') as $file) {
                    $filePath = $file->store('others', 'public');

                    FFIOTherModel::create([
                        'emp_id' => $employee->id,
                        'path' => $filePath,
                    ]);
                }
            }
            DB::commit();

            return redirect()->route('admin.fhrms')->with('success', 'Employee data has been successfully updated!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function destroy($id)
    {
        $employee = $this->model()->findOrFail($id);
        $employee->delete(); // This will not remove the record permanently
        return redirect()->route('admin.fhrms')->with('success', 'Employee moved to trash.');
        // $this->model()->destroy($id);
        // return redirect()->route('admin.fhrms')->with('success', 'Employee data has been successfully deleted!');
    }
    public function bulk(Request $request)
    {
        $type = $request->type;
        $selectedItems = $request->selectedIds;
        $status = $request->status;

        foreach ($selectedItems as $item) {
            $employee = $this->model()->find($item);
            if ($type == 1) {
                $employee->delete();
            } else if ($type == 2) {
                $employee->update(['status' => $status]);
            }
        }
        return response()->json(['success' => true, 'message' => 'Bulk operation is completed']);
    }
    public function export(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $query = $this->model()->with('stateRelation');
        if ($from_date && $to_date) {
            $query->whereBetween('modified_date', [$from_date, $to_date]);
        }

        $employees = $query->get();

        return Excel::download(new FHRMSExport($employees), 'fhrms.xlsx');
    }
    public function show($id)
    {
        $education = FFIEducationModel::where('emp_id', $id)->get();
        $others = FFIOTherModel::where('emp_id', $id)->get();
        $employee = $this->model()->findOrFail($id);
        $htmlContent = view('admin.hr_management.fhrms.view', compact('employee', 'education', 'others'))->render();
        return response()->json(['html_content' => $htmlContent]);
    }
    public function eduDelete(Request $request)
    {
        $education = FFIEducationModel::findOrFail($request->id);
        $education->delete();
        return redirect()->back()->with('success', 'Education Cirtificate deleted successfully.');

    }
    public function otherDelete(Request $request)
    {
        $other = FFIOTherModel::findOrFail($request->id);
        $other->delete();
        return redirect()->back()->with('success', 'Other Cirtificate deleted successfully.');
    }
    public function bulkUpload(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,csv,txt',
        ]);

        $created_by = auth()->id();

        try {
            $file = $request->file('import_file');
            // dd($file);
            if ($file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = public_path('imports');

                if (!file_exists($filePath)) {
                    mkdir($filePath, 0777, true);
                }

                $file->move($filePath, $fileName);
                $fileWithPath = $filePath . '/' . $fileName;

                // Excel Import using Maatwebsite
                Excel::import(new FHRMSImport($created_by), $fileWithPath);

                if (file_exists($fileWithPath)) {
                    unlink($fileWithPath);
                }

                return redirect()->route('admin.fhrms')->with([
                    'success' => 'File imported successfully'
                ]);
            }
        } catch (Exception $e) {
            return redirect()->route('admin.fhrms')->with([
                'alert' => $e->getMessage()
            ]);
        }
    }

    public function showCodeReport(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $selectedData = $request->input('data', []);
        $selectedStates = $request->input('state', []);
        $location = $request->input('location');
        $status = $request->input('status');
        $pendingDocs = $request->input('pending_doc', []);

        $filteredResults = $this->model()->newQuery();

        if ($fromDate || $toDate || !empty($selectedStates) || !empty($location) || (!empty($pendingDocs)) || $status !== null) {
            if ($fromDate && $toDate) {
                $filteredResults->whereBetween('modified_date', ["{$fromDate} 00:00:00", "{$toDate} 23:59:59"]);
            }
            if (!empty($selectedStates)) {
                $filteredResults->whereIn('state', $selectedStates);
            }

            if (!empty($location)) {
                $filteredResults->where('location', $location);
            }
            if ($status !== null && $status !== '') {
                $filteredResults->where('status', $status);
            }

            if (!empty($pendingDocs)) {
                $filteredResults->where(function ($query) use ($pendingDocs) {
                    foreach ($pendingDocs as $doc) {
                        $query->orWhereNull($doc)->orWhere($doc, '');
                    }
                });
            }
            if (!empty($selectedData)) {
                $filteredResults->select(array_merge($selectedData, ['id', 'created_at', 'location', 'state', 'status']));
            }

            $results = $filteredResults->paginate(10)->appends($request->query());
        } else {
            $results = new LengthAwarePaginator([], 0, 10);

        }
        return view('admin.hr_management.fhrms_report.index', compact(
            'results',
            'fromDate',
            'toDate',
            'selectedData',
            'selectedStates',
            'location',
            'status',
            'pendingDocs'
        ));
    }

    public function exportReport(Request $request)
    {
        // dd($request->all());
        $fields = explode(',', $request->input('fields'));
        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $states = explode(',', $request->input('state', ''));
        $location = $request->location;
        $pendingDocs = $request->pending_doc;
        $status = $request->status;

        if (empty($fields)) {
            return redirect()->route('admin.fhrms_report')->with('error', 'No fields selected for export');
        }
        $query = $this->model()->newQuery();
        if ($fromDate && $toDate) {
            $query->whereBetween('modified_date', ["{$fromDate} 00:00:00", "{$toDate} 23:59:59"]);
        }


        if (!empty($states)) {
            $query->whereIn('state', $states);
        }
        if (!empty($pendingDocs)) {
            $pendingDocsArray = is_array($pendingDocs) ? $pendingDocs : explode(',', $pendingDocs);

            $query->where(function ($query) use ($pendingDocsArray) {
                foreach ($pendingDocsArray as $doc) {
                    $query->whereNull($doc)->orWhere($doc, '');
                }
            });
        }
        if ($location) {
            $query->where('location', $location);
        }

        if ($status !== null && $status !== '') {
            $query->where('status', $status);
        }
        $data = $query->select($fields)->get();
        return Excel::download(new FHRMSReportExport($data, $fields), 'fhrms_report.xlsx');
    }

    public function storePendingDetails(Request $request)
    {
        $request->validate([
            'ffi_emp_id' => 'nullable|string|max:255',
            'emp_name' => 'nullable|string|max:255',
            'interview_date' => 'nullable|date',
            'joining_date' => 'nullable|date',
            'contract_date' => 'nullable|date',
            'designation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'state' => 'nullable|integer',
            'location' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'father_name' => 'nullable|string|max:255',
            'gender' => 'nullable',
            'blood_group' => 'nullable|string',
            'qualification' => 'nullable|string|max:255',
            'phone1' => 'nullable|digits:10',
            'phone2' => 'nullable|digits:10',
            'email' => 'nullable|email|max:255',
            'permanent_address' => 'nullable|string',
            'present_address' => 'nullable|string',
            'pan_no' => 'nullable|string|max:20',
            'pan_path' => 'nullable|max:2048',
            'aadhar_no' => 'nullable|string|max:20',
            'aadhar_path' => 'nullable|max:2048',
            'driving_license_no' => 'nullable|string|max:20',
            'driving_license_path' => 'nullable|max:2048',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'resume' => 'nullable|max:2048',
            'bank_name' => 'nullable|string|max:255',
            'bank_document' => 'nullable|max:2048',
            'bank_account_no' => 'nullable|string|max:20',
            'repeat_acc_no' => 'nullable|string|same:bank_account_no',
            'bank_ifsc_code' => 'nullable|string|max:20',
            'uan_generatted' => 'nullable|string|max:255',
            'uan_type' => 'nullable|string',
            'uan_no' => 'nullable|string|max:20',
            'status' => 'nullable|string',
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
            'voter_id' => 'nullable|max:2048',
            'emp_form' => 'nullable|max:2048',
            'pf_esic_form' => 'nullable|max:2048',
            'payslip' => 'nullable|max:2048',
            'exp_letter' => 'nullable|max:2048',
            'education_certificates' => 'nullable|array',
            'education_certificates.*' => 'nullable|max:2048',
            'others' => 'nullable|array',
            'others.*' => 'nullable|max:2048',
            'password' => 'nullable|string',
            'psd' => 'nullable',
        ]);

        $filePaths = [];
        $fileFields = [
            'pan_path',
            'aadhar_path',
            'driving_license_path',
            'photo',
            'resume',
            'bank_document',
            'voter_id',
            'emp_form',
            'pf_esic_form',
            'payslip',
            'exp_letter'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $filePaths[$field] = $request->file($field)->store('uploads', 'public');
            }
        }
        $validatedData = $request->all();

        DB::beginTransaction();
        try {
            $employee = $this->model()->create($validatedData);
            $employee->fill($filePaths);
            $employee->save();

            if ($request->hasFile('education_certificates')) {
                foreach ($request->file('education_certificates') as $file) {
                    $filePath = $file->store('education_certificates', 'public');

                    FFIEducationModel::create([
                        'emp_id' => $employee->id,
                        'path' => $filePath,
                    ]);
                }
            }

            if ($request->hasFile('others')) {
                foreach ($request->file('others') as $file) {
                    $filePath = $file->store('others', 'public');

                    FFIOTherModel::create([
                        'emp_id' => $employee->id,
                        'path' => $filePath,
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function updatePendingDetails(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:fhrms,id',
            'ffi_emp_id' => 'nullable|string|max:255',
            'emp_name' => 'nullable|string|max:255',
            'interview_date' => 'nullable|date',
            'joining_date' => 'nullable|date',
            'contract_date' => 'nullable|date',
            'designation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'state' => 'nullable|integer',
            'location' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'father_name' => 'nullable|string|max:255',
            'gender' => 'nullable',
            'blood_group' => 'nullable|string',
            'qualification' => 'nullable|string|max:255',
            'phone1' => 'nullable|digits:10',
            'phone2' => 'nullable|digits:10',
            'email' => 'nullable|email|max:255',
            'permanent_address' => 'nullable|string',
            'present_address' => 'nullable|string',
            'pan_no' => 'nullable|string|max:20',
            'pan_path' => 'nullable|max:2048',
            'aadhar_no' => 'nullable|string|max:20',
            'aadhar_path' => 'nullable|max:2048',
            'driving_license_no' => 'nullable|string|max:20',
            'driving_license_path' => 'nullable|max:2048',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'resume' => 'nullable|max:2048',
            'bank_name' => 'nullable|string|max:255',
            'bank_document' => 'nullable|max:2048',
            'bank_account_no' => 'nullable|string|max:20',
            'repeat_acc_no' => 'nullable|string|same:bank_account_no',
            'bank_ifsc_code' => 'nullable|string|max:20',
            'uan_generatted' => 'nullable|string|max:255',
            'uan_type' => 'nullable|string',
            'uan_no' => 'nullable|string|max:20',
            'status' => 'nullable|string',
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
            'voter_id' => 'nullable|max:2048',
            'emp_form' => 'nullable|max:2048',
            'pf_esic_form' => 'nullable|max:2048',
            'payslip' => 'nullable|max:2048',
            'exp_letter' => 'nullable|max:2048',
            'education_certificates' => 'nullable|array',
            'education_certificates.*' => 'nullable|max:2048',
            'others' => 'nullable|array',
            'others.*' => 'nullable|max:2048',
            'password' => 'nullable|string',
            'psd' => 'nullable',
        ]);

        $filePaths = [];
        $fileFields = [
            'pan_path',
            'aadhar_path',
            'driving_license_path',
            'photo',
            'resume',
            'bank_document',
            'voter_id',
            'emp_form',
            'pf_esic_form',
            'payslip',
            'exp_letter'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $filePaths[$field] = $request->file($field)->store('uploads', 'public');
            }
        }
        $validatedData = $request->all();

        DB::beginTransaction();
        try {
            $employee = $this->model()->findOrFail($validatedData['id']);

            $employee->fill($validatedData);
            $employee->fill($filePaths);
            $employee->save();

            if ($request->hasFile('education_certificates')) {
                foreach ($request->file('education_certificates') as $file) {
                    $filePath = $file->store('education_certificates', 'public');

                    FFIEducationModel::updateOrCreate(
                        ['emp_id' => $employee->id, 'path' => $filePath],
                        ['path' => $filePath]
                    );
                }
            }

            if ($request->hasFile('others')) {
                foreach ($request->file('others') as $file) {
                    $filePath = $file->store('others', 'public');

                    FFIOTherModel::updateOrCreate(
                        ['emp_id' => $employee->id, 'path' => $filePath],
                        ['path' => $filePath]
                    );
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Record updated successfully.']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function todayBirthday(Request $request)
    {
        $query = $this->model()->query();
        if ($request->filled('dob')) {
            $dob = \Carbon\Carbon::parse($request->dob)->format('Y-m-d');
            $query->whereDate('dob', $dob);
        } else {
            $today = \Carbon\Carbon::now()->format('m-d');
            $query->whereRaw("DATE_FORMAT(dob, '%m-%d') = ?", [$today]);
        }
        $employees = $query->paginate(100)->withQueryString();
        return view('admin.hr_management.fhrms.today_birthday', [
            'employee' => $employees,
        ]);
    }

    public function trashed()
    {
        $searchColumns = ['id', 'ffi_emp_id', 'emp_name', 'joining_date', 'phone1', 'email'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->model()->onlyTrashed();

        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }
        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value)
                    ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $employee = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(100)->appends(request()->query());

        // $employee = $this->model()->onlyTrashed()->get();
        return view('admin.hr_management.fhrms.trashed', compact('employee'));
    }
    public function restore($id)
    {
        $fhrms = $this->model()->onlyTrashed()->findOrFail($id);
        $fhrms->restore();
        return redirect()->back()->with('success', 'Fhrms Employees restored successfully.');
    }
    public function forceDelete($id)
    {
        $fhrms = $this->model()->onlyTrashed()->findOrFail($id);
        $fhrms->forceDelete();
        return redirect()->back()->with('success', 'Fhrms Employee permanently deleted.');
    }
}
