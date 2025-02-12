<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\FHRMSModel;
use Illuminate\Http\Request;
use App\Models\LetterContent;
use App\Models\FFIWarningModel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class FFIWarningController extends Controller
{
    public function model()
    {
        return new FFIWarningModel();
    }
    public function index()
    {
        $searchColumns = ['id', 'date', 'emp_id'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->model()->with('warning_letter');

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

        $warning = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());

        return view("admin.hr_management.ffi.warning.index", compact("warning"));
    }
    public function create()
    {
        return view("admin.hr_management.ffi.warning.create");
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ffi_emp_id' => 'required',
            'status' => 'nullable|string',
            'emp_id' => 'nullable',
            'date' => 'required|date',
            'content' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            $warning = $this->model()->create($validatedData);
            $warning->emp_id = $request->ffi_emp_id;
            $warning->date_of_update = now();
            $warning->status = '1';
            $warning->save();

            DB::commit();
            return redirect()->route('admin.ffi_warning')->with('success', 'Warning Letter has been Created!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function getEmployeeDetails(Request $request)
    {
        $warning_letter = FHRMSModel::where('ffi_emp_id', $request->ffi_emp_id)->first();

        if ($warning_letter) {
            return response()->json([
                'success' => true,
                'data' => [
                    'emp_name' => $warning_letter->emp_name,
                    'designation' => $warning_letter->designation,
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
        return redirect()->route('admin.ffi_warning')->with('success', 'Successfully deleted!');
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
    public function generateWarningPdf($id)
    {
        $warningLetter = $this->model()->with('warning_letter')->findOrFail($id);

        $data = [
            'warningLetter' => $warningLetter,
        ];

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'chroot' => public_path()
        ])->loadView('admin.hr_management.ffi.warning.print_warning', $data);


        return $pdf->stream('warning_letter_' . $warningLetter->id . '.pdf');
    }
    public function edit($id)
    {
        $warning = $this->model()->with('warning_letter')->findOrFail($id);
        return view('admin.hr_management.ffi.warning.update', compact('warning'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'ffi_emp_id' => 'required',
            'status' => 'nullable|string',
            'emp_id' => 'nullable',
            'date' => 'required|date',
            'content' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $warning = $this->model()->findOrFail($id);
            $warning->update($validatedData);
            $warning->emp_id = $request->ffi_emp_id;
            $warning->date_of_update = now();
            $warning->status = '1';
            $warning->save();

            DB::commit();
            return redirect()->route('admin.ffi_warning')->with('success', 'Warning details have been updated!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
}
