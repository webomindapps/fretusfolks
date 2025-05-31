<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\FHRMSModel;
use Illuminate\Http\Request;
use App\Models\LetterContent;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\FFIShowCauseModel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class FFIShowCauseController extends Controller
{
    public function model()
    {
        return new FFIShowCauseModel();
    }
    public function index()
    {
        $searchColumns = ['id', 'date', 'emp_id', 'emp_name', 'phone1', 'email'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->model()->with('show_letter');

        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        if ($search != '') {
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) {
                    if (in_array($value, ['emp_name', 'phone1', 'email'])) {
                        $q->orWhereHas('show_letter', function ($q2) use ($value, $search) {
                            $q2->where($value, 'LIKE', '%' . $search . '%');
                        });
                    } else {
                        $key == 0
                            ? $q->where($value, 'LIKE', '%' . $search . '%')
                            : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                    }
                }
            });
        }

        if ($order == '') {
            $query->orderByDesc('id');
        } else {
            $query->orderBy($order, $orderBy);
        }

        $show = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());

        return view("admin.hr_management.ffi.show_cause.index", compact("show"));
    }
    public function create()
    {
        return view("admin.hr_management.ffi.show_cause.create");
    }
    public function store(Request $request)
    {
        $request->validate([
            'ffi_emp_id' => 'required',
            'status' => 'nullable|string',
            'emp_id' => 'nullable',
            'date' => 'required|date',
            'content' => 'required|string',
        ]);
        $validatedData = $request->all();
        DB::beginTransaction();
        try {
            $show = $this->model()->create($validatedData);
            $show->emp_id = $request->ffi_emp_id;
            $show->date_of_update = now();
            $show->status = '1';
            $show->save();

            DB::commit();
            return redirect()->route('admin.ffi_show_cause')->with('success', 'Show Cause Letter has been Created!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function getEmployeeDetails(Request $request)
    {
        $show_letter = FHRMSModel::where('ffi_emp_id', $request->ffi_emp_id)->first();

        if ($show_letter) {
            return response()->json([
                'success' => true,
                'data' => [
                    'emp_name' => $show_letter->emp_name,
                    'designation' => $show_letter->designation,
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
        return redirect()->route('admin.ffi_show_cause')->with('success', 'Successfully deleted!');
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
    public function generateShowPdf($id)
    {
        $showLetter = $this->model()->with('show_letter')->findOrFail($id);

        $data = [
            'showLetter' => $showLetter,
        ];

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'chroot' => public_path()
        ])->loadView('admin.hr_management.ffi.show_cause.print_show', $data);


        return $pdf->stream('show_letter_' . $showLetter->id . '.pdf');
    }
    public function edit($id)
    {
        $show = $this->model()->with('show_letter')->findOrFail($id);
        return view('admin.hr_management.ffi.show_cause.update', compact('show'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ffi_emp_id' => 'required',
            'status' => 'nullable|string',
            'emp_id' => 'nullable',
            'date' => 'required|date',
            'content' => 'required|string',
        ]);
        $validatedData = $request->all();
        DB::beginTransaction();
        try {
            $show = $this->model()->findOrFail($id);
            $show->update($validatedData);
            $show->emp_id = $request->ffi_emp_id;
            $show->date_of_update = now();
            $show->status = '1';
            $show->save();

            DB::commit();
            return redirect()->route('admin.ffi_show_cause')->with('success', 'Show Cause details have been updated!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
}
