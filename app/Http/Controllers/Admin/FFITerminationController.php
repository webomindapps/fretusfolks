<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\FHRMSModel;
use Illuminate\Http\Request;
use App\Models\LetterContent;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\FFITerminationModel;
use App\Http\Controllers\Controller;

class FFITerminationController extends Controller
{
    public function model()
    {
        return new FFITerminationModel();
    }
    public function index()
    {
        $searchColumns = ['id', 'emp_name', 'date', 'phone1', 'email'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->model()->with('term_letter');

        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        if ($search != '') {
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) {
                    $key == 0 ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                }
            });
        }

        if ($order == '') {
            $query->orderByDesc('id');
        } else {
            $query->orderBy($order, $orderBy);
        }

        $termination = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());

        return view("admin.hr_management.ffi.termination.index", compact("termination"));
    }
    public function create()
    {
        $content = LetterContent::where('type', 2)->first();
        return view("admin.hr_management.ffi.termination.create", compact('content'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ffi_emp_id' => 'required', // Ensure the employee exists
            'status' => 'nullable|string',
            'emp_id' => 'nullable',
            'date' => 'required|date',
            'termination_date' => 'required|date',
            'show_cause_date' => 'required|date',
            'absent_date' => 'required|date',
            'content' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            $termination = $this->model()->create($validatedData);
            $termination->emp_id = $request->ffi_emp_id;
            $termination->date_of_update = now();
            $termination->status = '1';
            $termination->save();

            DB::commit();
            return redirect()->route('admin.ffi_termination')->with('success', 'Offer Letter has been Created!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function getEmployeeDetails(Request $request)
    {
        $term_letter = FHRMSModel::where('ffi_emp_id', $request->ffi_emp_id)->first();

        if ($term_letter) {
            return response()->json([
                'success' => true,
                'data' => [
                    'emp_name' => $term_letter->emp_name,
                    'designation' => $term_letter->designation,
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Employee not found.',
        ]);
    }
    public function destroy($id)
    {
        $this->model()->destroy($id);
        return redirect()->route('admin.ffi_termination')->with('success', 'Successfully deleted!');
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
    public function generateTerminationPdf($id)
    {
        $termLetter = $this->model()->with('term_letter')->findOrFail($id);

        $data = [
            'termLetter' => $termLetter,
        ];

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'chroot' => public_path()
        ])->loadView('admin.hr_management.ffi.termination.print_termination', $data);


        return $pdf->stream('termination_letter_' . $termLetter->id . '.pdf');
    }
    public function edit($id)
    {
        $termination = $this->model()->with('term_letter')->findOrFail($id);
        return view('admin.hr_management.ffi.termination.update', compact('termination'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'ffi_emp_id' => 'required',
            'status' => 'nullable|string',
            'emp_id' => 'nullable',
            'date' => 'required|date',
            'termination_date' => 'required|date',
            'show_cause_date' => 'required|date',
            'absent_date' => 'required|date',
            'content' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $termination = $this->model()->findOrFail($id);
            $termination->update($validatedData);
            $termination->emp_id = $request->ffi_emp_id;
            $termination->date_of_update = now();
            $termination->status = '1';
            $termination->save();

            DB::commit();
            return redirect()->route('admin.ffi_termination')->with('success', 'Termination details have been updated!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
}
