<?php

namespace App\Http\Controllers\Admin;

use App\Models\CFISModel;
use App\Exports\CDMSExport;
use App\Exports\CFISExport;
use Illuminate\Http\Request;
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
        $searchColumns = ['id', 'client_name', 'emp_name', 'joining_date', 'phone1'];
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

        $candidate = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());

        return view("admin.adms.cfis.index", compact("candidate"));

    }
    public function create()
    {
        return view("admin.adms.cfis.create");
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'entity_name' => 'required|string',
            'emp_name' => 'required|string',
            'phone1' => 'required|digits:10',
            'email' => 'required|email|max:255',
            'state' => 'required|string',
            'location' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'interview_date' => 'required|date',
            'joining_date' => 'required|date|after_or_equal:interview_date',
            'aadhar_no' => 'required|digits:12',
            'aadhar_path' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'driving_license_no' => 'required|string|max:255',
            'driving_license_path' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'photo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'resume' => 'required|file|max:2048',
        ]);
        $validatedData['status'] = $request->input('status', 1);
        $validatedData['data_status'] = $request->input('data_status', 1);
        $validatedData['active_status'] = $request->input('active_status', 1);
        $validatedData['aadhar_path'] = $request->file('aadhar_path')->store('uploads/aadhar');
        $validatedData['driving_license_path'] = $request->file('driving_license_path')->store('uploads/license');
        $validatedData['photo'] = $request->file('photo')->store('uploads/photos');
        $validatedData['resume'] = $request->file('resume')->store('uploads/resumes');

        $this->model()->create($validatedData);
        return redirect()->route('admin.cfis')->with('success', 'Candidate data added successfully!');
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
        $query = $this->model();
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
    public function toggleData_status($id)
    {
        $candidate = $this->model()->findOrFail($id);
        $candidate->data_status = !$candidate->data_status;
        $candidate->save();
        return redirect()->back()->with('success', 'Data Status updated successfully.');
    }
}
