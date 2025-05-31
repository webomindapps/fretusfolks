<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\FHRMSModel;
use Illuminate\Http\Request;
use App\Models\LetterContent;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\FFIIncrementLetterModel;

class FFIIncrementLetterController extends Controller
{
    public function model()
    {
        return new FFIIncrementLetterModel();
    }
    public function index()
    {
        $searchColumns = ['id', 'date', 'employee_id', 'emp_name', 'phone1', 'email'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->model()->with('incrementletter');

        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        if ($search != '') {
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) {
                    if (in_array($value, ['emp_name', 'phone1', 'email'])) {
                        $q->orWhereHas('incrementletter', function ($q2) use ($value, $search) {
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

        $increment = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());

        return view("admin.hr_management.ffi.increment_letter.index", compact("increment"));
    }

    public function create()
    {
        $content = LetterContent::where('type', 1)->first();
        return view("admin.hr_management.ffi.increment_letter.create", compact("content"));
    }
    public function store(Request $request)
    {
        $request->validate([
            'ffi_emp_id' => 'required',
            'offer_letter_type' => 'nullable|string|max:255',
            'status' => 'nullable|string',
            'basic_salary' => 'required|numeric|min:0',
            'hra' => 'required|numeric|min:0',
            'conveyance' => 'required|numeric|min:0',
            'medical_reimbursement' => 'required|numeric|min:0',
            'special_allowance' => 'required|numeric|min:0',
            'other_allowance' => 'nullable|numeric|min:0',
            'st_bonus' => 'nullable|numeric|min:0',
            'pf_percentage' => 'required|numeric|min:0|max:100',
            'emp_pf' => 'nullable|numeric|min:0',
            'esic_percentage' => 'required|numeric|min:0|max:100',
            'gross_salary' => 'nullable|numeric|min:0',
            'emp_esic' => 'nullable|numeric|min:0',
            'pt' => 'required|numeric|min:0',
            'total_deduction' => 'nullable|numeric|min:0',
            'employer_pf_percentage' => 'required|numeric|min:0|max:100',
            'employer_pf' => 'nullable|numeric|min:0',
            'employer_esic_percentage' => 'required|numeric|min:0|max:100',
            'employer_esic' => 'nullable|numeric|min:0',
            'mediclaim' => 'required|numeric|min:0',
            'ctc' => 'nullable|numeric|min:0',
            'content' => 'required|string',
            'employee_id' => 'nullable',

        ]);
        $validatedData = $request->all();
        DB::beginTransaction();
        try {
            $increment = $this->model()->create($validatedData);
            $increment->employee_id = $request->ffi_emp_id;
            $increment->date = now();
            $increment->effective_date = now();
            $increment->status = '1';
            $increment->save();

            DB::commit();
            return redirect()->route('admin.ffi_increment_letter')->with('success', 'Increment Letter has been Created!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function getEmployeeDetails(Request $request)
    {
        $increment = FHRMSModel::where('ffi_emp_id', $request->ffi_emp_id)->first();

        if ($increment) {
            return response()->json([
                'success' => true,
                'data' => [
                    'emp_name' => $increment->emp_name,
                    'designation' => $increment->designation,
                    'department' => $increment->department,
                    'location' => $increment->location,
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
        return redirect()->route('admin.ffi_increment_letter')->with('success', 'Successfully deleted!');
    }
    public function generateIncrementLetterPdf($id)
    {
        $incrementLetter = $this->model()->with('incrementLetter')->findOrFail($id);

        $data = [
            'incrementLetter' => $incrementLetter,
        ];

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'chroot' => public_path()
        ])->loadView('admin.hr_management.ffi.increment_letter.formate_1', $data);


        return $pdf->stream('increment_letter_' . $incrementLetter->id . '.pdf');
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
}
