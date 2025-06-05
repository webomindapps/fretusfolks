<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\FHRMSModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FFIOfferLetterModel;
use App\Http\Controllers\Controller;

class FFIOfferLetterController extends Controller
{

    public function model()
    {
        return new FFIOfferLetterModel();
    }
    public function index()
    {
        $searchColumns = ['id', 'employee_id', 'emp_name', 'date', 'phone1', 'email'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->model()->with('employee');

        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }


        if ($search != '') {
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) {
                    if (in_array($value, ['emp_name', 'phone1', 'email'])) {
                        $q->orWhereHas('employee', function ($q2) use ($value, $search) {
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


        $offer = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());

        return view("admin.hr_management.ffi.offer_letter.index", compact("offer"));
    }


    public function create()
    {
        return view("admin.hr_management.ffi.offer_letter.create");
    }
    public function store(Request $request)
    {
        $request->validate([
            'ffi_emp_id' => 'required', // Ensure the employee exists
            'offer_letter_type' => 'nullable|string|max:255',
            'status' => 'nullable|string',
            'basic_salary' => 'required|numeric|min:0',
            'hra' => 'required|numeric|min:0',
            'conveyance' => 'nullable|numeric|min:0',
            'medical_reimbursement' => 'nullable|numeric|min:0',
            'special_allowance' => 'required|numeric|min:0',
            'other_allowance' => 'nullable|numeric|min:0',
            'st_bonus' => 'required|numeric|min:0',
            'pf_percentage' => 'required|numeric|min:0|max:100',
            'emp_pf' => 'nullable|numeric|min:0',
            'esic_percentage' => 'required|numeric|min:0|max:100',
            'emp_esic' => 'nullable|numeric|min:0',
            'pt' => 'required|numeric|min:0',
            'total_deduction' => 'nullable|numeric|min:0',
            'employer_pf_percentage' => 'required|numeric|min:0|max:100',
            'employer_pf' => 'nullable|numeric|min:0',
            'employer_esic_percentage' => 'required|numeric|min:0|max:100',
            'employer_esic' => 'nullable|numeric|min:0',
            'mediclaim' => 'required|numeric|min:0',
            'ctc' => 'nullable|numeric|min:0',
            'employee_id' => 'nullable',
        ]);
        $validatedData = $request->all();

        DB::beginTransaction();
        try {
            $offer = $this->model()->create($validatedData);
            $offer->employee_id = $request->ffi_emp_id;
            $offer->date = now();
            $offer->status = '1';
            $offer->save();

            DB::commit();
            return redirect()->route('admin.ffi_offer_letter')->with('success', 'Offer Letter has been Created!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }

    }
    public function getEmployeeDetails(Request $request)
    {
        $employee = FHRMSModel::where('ffi_emp_id', $request->ffi_emp_id)->first();

        if ($employee) {
            return response()->json([
                'success' => true,
                'data' => [
                    'emp_name' => $employee->emp_name,
                    'interview_date' => $employee->interview_date,
                    'contract_date' => $employee->contract_date,
                    'designation' => $employee->designation,
                    'department' => $employee->department,
                    'location' => $employee->location,
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
        return redirect()->route('admin.ffi_offer_letter')->with('success', 'Successfully deleted!');
    }
    public function generateOfferLetterPdf($id)
    {
        $offerLetter = $this->model()->with('employee')->findOrFail($id);

        $data = [
            'offerLetter' => $offerLetter,
        ];

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'chroot' => public_path()
        ])->loadView('admin.hr_management.ffi.offer_letter.formate1', $data);
        // ->setPaper('A4', 'portrait')
        // ->setOptions(['margin-top' => 10, 'margin-bottom' => 10, 'margin-left' => 15, 'margin-right' => 15]);


        return $pdf->stream('offer_letter_' . $offerLetter->id . '.pdf');
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
