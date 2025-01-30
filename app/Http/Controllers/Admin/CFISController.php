<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\CFISModel;
use App\Exports\CDMSExport;
use App\Exports\CFISExport;
use Illuminate\Http\Request;
use App\Models\ClientManagement;
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
        } else {
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
        $validatedData = $request->only([
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
        $candidate = $this->model()->find($id);
        return view('admin.adms.cfis.edit', compact('candidate'));
    }
    public function update(Request $request, $id)
    {
        $candidate = $this->model()->findOrFail($id);

        $validatedData = $request->only([
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

}
