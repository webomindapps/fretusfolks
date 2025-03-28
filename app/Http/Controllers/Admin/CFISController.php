<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\CFISModel;
use App\Exports\CDMSExport;
use App\Exports\CFISExport;
use App\Jobs\ImportCFISJob;
use Illuminate\Http\Request;
use App\Models\ClientManagement;
use App\Jobs\ImportBulkUpdateJob;
use App\Models\CandidateDocuments;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class CFISController extends Controller
{
    public function model()
    {
        return new CFISModel();
    }
    public function index()
    {
        $searchColumns = ['id', 'client_id', 'emp_name', 'joining_date', 'phone1'];
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

        $candidate = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());

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
            'photo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'resume' => 'nullable',
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

        // $validatedData['created_by'] = auth()->id();
        $validatedData = $request->all();
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
        // dd($request->all());

        // dd($request->file());
        // $request->validate([
        //     'file' => 'required|file|mimes:csv',
        // ]);

        $file = $request->file;
        // dd($file);
        try {
            if ($file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = public_path('imports');

                $file->move($filePath, $fileName);
                $fileWithPath = $filePath . '/' . $fileName;

                $header = null;
                $datafromCsv = [];

                $records = array_map('str_getcsv', file($fileWithPath));
                $header = $records[0]; // First row as header
                unset($records[0]); // Remove header from data
                // dd($header, $records);

                $dataChunks = array_chunk($records, 1000);
                // dd($dataChunks);
                foreach ($dataChunks as $chunk) {
                    $processedData = [];

                    foreach ($chunk as $record) {
                        if (count($header) == count($record)) {
                            $processedData[] = array_combine($header, $record);
                        }
                    }

                    if (!empty($processedData)) {
                        // 
                        ImportCFISJob::dispatch($processedData);
                        // dd($processedData);
                    }
                }
                if (file_exists($fileWithPath)) {
                    unlink($fileWithPath);
                }
            }
        } catch (Exception $e) {
            return redirect()->route('admin.cfis')->with([
                'error_msg' => 'Import failed: ' . $e->getMessage()
            ]);
        }

        return redirect()->route('admin.cfis')->with([
            'success' => 'File imported successfully'
        ]);
    }

    public function bulkindex()
    {
        $searchColumns = ['id', 'client_id', 'emp_name', 'joining_date', 'phone1'];
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

        $candidate = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());

        return view("admin.adms.bulk_update", compact("candidate"));

    }
    public function bulkimport(Request $request)
    {


        $file = $request->file;
        // dd($file);
        try {
            if ($file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = public_path('imports');

                $file->move($filePath, $fileName);
                $fileWithPath = $filePath . '/' . $fileName;

                $header = null;
                $datafromCsv = [];

                $records = array_map('str_getcsv', file($fileWithPath));
                $header = $records[0]; // First row as header
                unset($records[0]); // Remove header from data
                // dd($header, $records);

                $dataChunks = array_chunk($records, 1000);
                // dd($dataChunks);
                foreach ($dataChunks as $chunk) {
                    $processedData = [];

                    foreach ($chunk as $record) {
                        if (count($header) == count($record)) {
                            $processedData[] = array_combine($header, $record);
                        }
                    }

                    if (!empty($processedData)) {
                        // 
                        ImportBulkUpdateJob::dispatch($processedData);
                        // dd($processedData);
                    }
                }
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
}
