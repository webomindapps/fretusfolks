<?php

namespace App\Http\Controllers\Admin;

use Log;
use Exception;
use ZipArchive;
use App\Models\CFISModel;
use App\Exports\CDMSExport;
use App\Exports\CFISExport;
use App\Jobs\ImportCFISJob;
use Illuminate\Http\Request;
use RecursiveIteratorIterator;
use App\Exports\EmployeeExport;
use App\Imports\CfisBulkImport;
use RecursiveDirectoryIterator;
use App\Imports\CFISBasicImport;
use App\Models\ClientManagement;
use App\Jobs\ImportBulkUpdateJob;
use App\Models\CandidateDocuments;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class CFISController extends Controller
{
    public function model()
    {
        return new CFISModel();
    }
    public function index()
    {
        $searchColumns = ['id', 'ffi_emp_id', 'client_id', 'emp_name', 'joining_date', 'phone1'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        // $query = $this->model()->query()->where('data_status', 0)->where('created_by', auth()->id());
        if (auth()->user()->hasRole('Admin')) {
            $query = $this->model()->query()->where('dcs_approval', 1)->where('data_status', 0);
        } elseif (auth()->user()->hasRole(['HR Operations', 'Recruitment'])) {
            $query = $this->model()->query()->where('dcs_approval', 1)
                ->where('created_by', auth()->id())
                ->where('data_status', 0);
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

        $candidate = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(100)->appends(request()->query());
        // dd(auth()->id());
        return view("admin.adms.cfis.index", compact("candidate"));

    }
    public function create()
    {
        return view("admin.adms.cfis.create");
    }
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|integer',
            'emp_name' => 'required|string|max:255',
            'phone1' => [
                'required',
                'string',
                'max:15',
                function ($attribute, $value, $fail) {
                    $existingRecord = $this->model()->where('phone1', $value)->first();
                    if ($existingRecord) {
                        $fail('The phone number has already been taken under Client: ' . $existingRecord->entity_name . '. Please Check With HR.');
                    }
                }
            ],
            'email' => 'required|email|max:255',
            'state' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'designation' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'interview_date' => 'required|date',
            'aadhar_no' => [
                'required',
                'string',
                'min:12',
                'max:12',
                function ($attribute, $value, $fail) {
                    $existingRecord = $this->model()->where('aadhar_no', $value)->first();
                    if ($existingRecord) {
                        $fail('The Aadhar number has already been taken under Client: ' . $existingRecord->entity_name . '. Please Check With HR.');
                    }
                }
            ],
            'driving_license_no' => 'nullable|string|max:255',
            'photo' => 'required|file|mimes:jpg,jpeg,png,gif,bmp,webp,pdf,doc,docx',
            'resume' => 'nullable|file|mimes:jpg,jpeg,png,gif,bmp,webp,pdf,doc,docx',
        ]);
        $validatedData = $request->all();
        $validatedData['created_at'] = $request->input('created_at', now());
        $validatedData['created_by'] = auth()->id();
        $validatedData['status'] = $request->input('status', 1);
        $validatedData['dcs_approval'] = $request->input('dcs_approval', 1);
        $validatedData['data_status'] = $request->input('data_status', 0);




        DB::beginTransaction();
        try {
            $client = $this->model()->create($validatedData);
            $client->entity_name = ClientManagement::where('id', $request->client_id)->value('client_name');
            $client->save();
            $fileFields = ['photo', 'resume'];
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {

                    $file = $request->file($field);
                    $newFileName = $field . '_' . $client->id . '.' . $file->getClientOriginalExtension();

                    $filePath = $file->storeAs('uploads/' . $field, $newFileName, 'public');

                    CandidateDocuments::create([
                        'emp_id' => $client->id,
                        'name' => $field,
                        'path' => $filePath,
                        'status' => 0,
                    ]);
                }
            }
            DB::commit();

            return redirect()->route('admin.cfis')->with('success', 'Candidate data added successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function edit($id)
    {
        $candidate = $this->model()->with('candidateDocuments')->find($id);
        return view('admin.adms.cfis.edit', compact('candidate'));
    }
    public function update(Request $request, $id)
    {
        $candidate = $this->model()->findOrFail($id);
        $request->only([
            'client_id',
            'emp_name',
            'phone1',
            'email',
            'state',
            'location',
            'designation',
            'department',
            'interview_date',
            'aadhar_no',
            'driving_license_no',
            'photo',
            'resume',
        ]);
        $validatedData = $request->all();

        // $validatedData['created_by'] = auth()->id();
        $validatedData['dcs_approval'] = $request->input('dcs_approval', 1);
        $validatedData['data_status'] = $request->input('data_status', 0);

        DB::beginTransaction();
        try {
            $candidate->update($validatedData);
            $candidate->entity_name = ClientManagement::where('id', $validatedData['client_id'])->value('client_name');
            $candidate->save();
            $fileFields = ['photo', 'resume'];
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {

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
            DB::commit();

            return redirect()->route('admin.cfis')->with('success', 'Candidate data updated successfully!');
        } catch (Exception $e) {
            DB::rollBack();


            return redirect()->back()->with('error', 'Failed to update candidate data. Please try again.');
        }
    }


    public function destroy($id)
    {
        $this->model()->destroy($id);
        return redirect()->route('admin.cfis')->with('success', 'Candidate data has been successfully deleted!');
    }
    public function bulk(Request $request)
    {
        $type = $request->type;
        $selectedItems = $request->selectedIds;
        $status = $request->status;

        foreach ($selectedItems as $item) {
            $candidate = $this->model()->find($item);
            if ($type == 1) {
                $candidate->delete();
            } else if ($type == 2) {
                $candidate->update(['status' => $status]);
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
        $candidates = $query->get();

        return Excel::download(new CFISExport($candidates), 'cfis.xlsx');
    }
    public function toggleStatus($id)
    {
        $candidate = $this->model()->findOrFail($id);
        $candidate->status = !$candidate->status;
        $candidate->save();
        return redirect()->back()->with('success', 'Status updated successfully.');
    }
    public function toggleData_status($id, $newStatus)
    {
        $candidate = $this->model()->findOrFail($id);

        if ($candidate) {
            if (in_array($newStatus, [0, 1, 2])) {
                $candidate->dcs_approval = $newStatus;
                $candidate->save();

                return redirect()->back()->with('success', 'Status updated successfully!');
            }

            return redirect()->back()->with('error', 'Invalid status provided.');
        }

        return redirect()->back()->with('error', 'Item not found.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,txt',
        ]);

        $created_by = auth()->id();

        try {
            $file = $request->file('file');

            if ($file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = public_path('imports');

                if (!File::exists($filePath)) {
                    File::makeDirectory($filePath, 0777, true);
                }

                $file->move($filePath, $fileName);
                $fileWithPath = $filePath . '/' . $fileName;

                Excel::import(new CFISBasicImport($created_by), $fileWithPath);

                if (file_exists($fileWithPath)) {
                    unlink($fileWithPath);
                }

                return redirect()->route('admin.cfis')->with([
                    'success' => 'File imported successfully'
                ]);
            }
        } catch (Exception $e) {
            return redirect()->route('admin.cfis')->with([
                'error' => 'Import failed: ' . $e->getMessage()
            ]);
        }
    }


    public function bulkindex()
    {
        $searchColumns = ['id', 'client_id', 'ffi_emp_id', 'employee_last_date', 'phone1'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        // $query = $this->model()->query();
        if (auth()->user()->hasRole(['Admin', 'HR Operations', 'Recruitment'])) {
            $query = $this->model()->query();
        }
        //  elseif (auth()->user()->hasRole(['HR Operations', 'Recruitment'])) {
        //     $query = $this->model()->query()->where('dcs_approval', 1)
        //         ->where('created_by', auth()->id())
        //         ->where('data_status', 0);
        // }

        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }
        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value)
                    ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $candidate = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(100)->appends(request()->query());

        return view("admin.adms.bulk_update", compact("candidate"));

    }
    public function bulkimport(Request $request)
    {
        $request->validate([

            'file' => 'required|file|mimes:xlsx,csv,txt',
        ]);
        $file = $request->file('file');
        // dd($file);
        try {
            if ($request->hasFile('file')) {
                $fileName = $file->getClientOriginalName();
                $fileWithPath = public_path('imports') . '/' . $fileName;

                if (!file_exists($fileWithPath)) {
                    $file->move(public_path('imports'), $fileName);
                }

                Excel::import(new CfisBulkImport(), $fileWithPath);

                if (file_exists($fileWithPath)) {
                    unlink($fileWithPath);
                }
            }
        } catch (Exception $e) {
            return redirect()->route('admin.cfisbulk')->with([
                'error_msg' => 'Import failed: ' . $e->getMessage()
            ]);
        }

        return redirect()->route('admin.cfisbulk')->with([
            'success' => 'File imported successfully'
        ]);
    }

    public function bulkdownload(Request $request)
    {
        $clientId = $request->client_id;
        $contractDate = $request->date;

        $employees = CFISModel::with(['candidateDocuments', 'educationCertificates', 'otherCertificates'])
            ->where('client_id', $clientId)
            ->where('employee_last_date', $contractDate)
            ->get();

        if ($employees->isEmpty()) {
            return back()->with('error', 'No employees found for selected criteria.');
        }

        $timestamp = time();
        $baseTempPath = public_path("app/temp_bulk_{$timestamp}");
        File::makeDirectory($baseTempPath, 0755, true);

        foreach ($employees as $employee) {
            $empFolder = $baseTempPath . "/employee_{$employee->id}";
            File::makeDirectory($empFolder, 0755, true);


            $fileName = "employee_details_{$employee->id}.xlsx";
            $publicPath = "public/employee_exports/{$fileName}";
            Excel::store(new EmployeeExport($employee), $publicPath);


            $source = Storage::path($publicPath);
            $destination = $baseTempPath . "/" . $fileName;

            if (File::exists($source)) {
                File::move($source, $destination);
            } else {
                Log::warning("❌ Excel file not found: {$source}");
            }

            $this->copyDocuments($employee->candidateDocuments, "{$empFolder}/Candidate_Documents");
            $this->copyDocuments($employee->educationCertificates, "{$empFolder}/Education_Documents");
            $this->copyDocuments($employee->otherCertificates, "{$empFolder}/Other_Documents");
        }

        $zipFileName = "bulk_employees_{$timestamp}.zip";
        $zipPath = public_path("app/{$zipFileName}");

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($baseTempPath, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $file) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($baseTempPath) + 1);
                $zip->addFile($filePath, $relativePath);
            }

            $zip->close();
        } else {
            return back()->with('error', 'Could not create ZIP file.');
        }
        File::deleteDirectory($baseTempPath);

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    private function copyDocuments($documents, $destPath)
    {
        if (!File::exists($destPath)) {
            File::makeDirectory($destPath, 0755, true, true);
            Log::info("Created directory: {$destPath}");
        }

        foreach ($documents as $document) {
            $docPath = $document->bank_document ?? $document->path ?? $document->photo ?? null;

            if ($docPath) {
                $originalStoragePath = public_path(ltrim($docPath, '/'));
                $fileName = basename($docPath);
                $destinationFilePath = "{$destPath}/{$fileName}";

                if (File::exists($originalStoragePath)) {
                    File::copy($originalStoragePath, $destinationFilePath);
                    Log::info("✅ Copied file: {$originalStoragePath} → {$destinationFilePath}");
                } else {
                    Log::warning("❌ File not found: {$originalStoragePath}");
                }
            }
        }
    }
}
