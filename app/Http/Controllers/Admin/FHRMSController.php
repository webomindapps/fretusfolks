<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FHRMSReportExport;
use Exception;
use App\Models\FHRMSModel;
use App\Exports\FHRMSExport;
use App\Imports\FHRMSImport;
use Illuminate\Http\Request;
use App\Models\FFIOTherModel;
use App\Models\FFIEducationModel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class FHRMSController extends Controller
{
    public function model()
    {
        return new FHRMSModel();
    }
    public function index()
    {
        $searchColumns = ['id', 'emp_name', 'joining_date', 'phone1', 'email'];
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

        $employee = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());

        return view("admin.hr_management.fhrms.index", compact("employee"));

    }
    public function create()
    {
        return view("admin.hr_management.fhrms.create");
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ffi_emp_id' => 'required|string|max:255',
            'emp_name' => 'required|string|max:255',
            'interview_date' => 'required|date',
            'joining_date' => 'required|date',
            'contract_date' => 'required|date',
            'designation' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'state' => 'required|string',
            'location' => 'required|string|max:255',
            'dob' => 'required|date',
            'father_name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
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
            'password' => 'required|string|min:8',
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

        DB::beginTransaction();
        try {
            $employee = $this->model()->create($validatedData);
            $employee->fill($filePaths);
            $employee->password = bcrypt($request->password);
            $employee->data_status = '0';
            $employee->active_status = '0';
            $employee->save();

            if ($request->hasFile('education_certificates')) {
                foreach ($request->file('education_certificates') as $file) {
                    $filePath = $file->store('education_certificates', 'public');

                    \DB::table('ffi_education_certificate')->insert([
                        'emp_id' => $employee->id,
                        'path' => $filePath,
                    ]);
                }
            }

            if ($request->hasFile('others')) {
                foreach ($request->file('others') as $file) {
                    $filePath = $file->store('others', 'public');

                    \DB::table('ffi_other_certificate')->insert([
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

        $validatedData = $request->validate([
            'ffi_emp_id' => 'required|string|max:255',
            'emp_name' => 'required|string|max:255',
            'interview_date' => 'required|date',
            'joining_date' => 'required|date',
            'contract_date' => 'required|date',
            'designation' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'state' => 'required|string',
            'location' => 'required|string|max:255',
            'dob' => 'required|date',
            'father_name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
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
                $employee->password = bcrypt($request->password);
            }
            $employee->save();
            if ($request->hasFile('education_certificates')) {
                foreach ($request->file('education_certificates') as $file) {
                    $filePath = $file->store('education_certificates', 'public');

                    \DB::table('ffi_education_certificate')->insert([
                        'emp_id' => $employee->id,
                        'path' => $filePath,
                    ]);
                }
            }

            if ($request->hasFile('others')) {
                foreach ($request->file('others') as $file) {
                    $filePath = $file->store('others', 'public');

                    \DB::table('ffi_other_certificate')->insert([
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
        $this->model()->destroy($id);
        return redirect()->route('admin.fhrms')->with('success', 'Employee data has been successfully deleted!');
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
        $query = $this->model()->query();
        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
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

        // $file = $request->file('import_file');


        $file = $request->import_file;
        $import = new FHRMSImport();
        Excel::import($import, $file);
        $error = '';
        // dd($import);
        foreach ($import->failures() as $failure) {
            $failure->row();
            $failure->attribute();
            $failure->errors();
            $failure->values();
            $error .= 'Row no:-' . $failure->row() . ', Column:-' . $failure->attribute() . ', Error:-' . $failure->errors()[0] . '<br>';
        }
        return redirect()->route('admin.fhrms')->with(['success' => 'Employees added successfully', 'error_msg' => $error]);

    }

    public function showCodeReport()
    {
        return view('admin.hr_management.fhrms_report.index', [
            'results' => [],
            'fromDate' => null,
            'toDate' => null,
            'selectedData' => [],
            'selectedStates' => [],
            'location' => null,
            'status' => null,
        ]);
    }
    public function codeReport(Request $request)
    {
        $request->validate([
            'from-date' => 'nullable|date',
            'to-date' => 'nullable|date',
            'data' => 'nullable|array',
            'state' => 'nullable|array',
            'location' => 'nullable|string',
            'status' => 'nullable|integer',
            'per_page' => 'nullable|integer|min:1',
            'pending_doc' => 'nullable|array', // Validate pending documents
        ]);

        $fromDate = $request->input('from-date');
        $toDate = $request->input('to-date');
        $selectedData = $request->input('data', []);
        $selectedStates = $request->input('state', []);
        $location = $request->input('location');
        $status = $request->input('status');
        $pendingDocs = $request->input('pending_doc', []);
        $perPage = $request->input('per_page', 10);

        $filteredResults = $this->model()->newQuery();

        if ($fromDate && $toDate) {
            $filteredResults->whereBetween('created_at', ["{$fromDate} 00:00:00", "{$toDate} 23:59:59"]);
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

        $results = $filteredResults->paginate($perPage)->appends($request->query());

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
        $fields = explode(',', $request->input('fields'));
        if (empty($fields)) {
            return redirect()->route('admin.fhrms_report')->with('error', 'No fields selected for export');
        }

        return Excel::download(new FHRMSReportExport($fields), 'fhrms_report.xlsx');
    }
}