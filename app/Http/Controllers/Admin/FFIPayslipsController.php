<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FFI_PayslipsExport;
use App\Imports\FFI_PayslipsImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\FFIPayslipsModel;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class FFIPayslipsController extends Controller
{

    public function model()
    {
        return new FFIPayslipsModel();
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

        $query = $this->model();

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

        $payslip = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());

        return view("admin.hr_management.ffi.payslips.index", compact("payslip"));
    }
    // public function bulkUpload(Request $request)
    // {
    //     $request->validate([
    //         'month' => 'required',
    //         'year' => 'required',
    //         'file' => 'required|file|mimes:xlsx,csv,txt',
    //     ]);
    //     $file = $request->file('file');
    //     $month = $request->input('month');
    //     $year = $request->input('year');
    //     $import = new FFI_PayslipsImport($month, $year);
    //     Excel::import($import, $file);
    //     $error = '';
    //     // dd($import);
    //     foreach ($import->failures() as $failure) {
    //         $failure->row();
    //         $failure->attribute();
    //         $failure->errors();
    //         $failure->values();
    //         $error .= 'Row no:-' . $failure->row() . ', Column:-' . $failure->attribute() . ', Error:-' . $failure->errors()[0] . '<br>';
    //     }
    //     return redirect()->route('admin.ffi_payslips')->with(['success' => 'Payslip added successfully', 'error_msg' => $error]);

    // }
    public function bulkUpload(Request $request)
    {
        $request->validate([
            'month' => 'required',
            'year' => 'required',
            'file' => 'required|file|mimes:xlsx,csv,txt',
        ]);

        $file = $request->file('file');
        $month = $request->input('month');
        $year = $request->input('year');

        $import = new FFI_PayslipsImport($month, $year);

        try {
            Excel::import($import, $file);
        } catch (\Exception $e) {
            return redirect()->route('admin.ffi_payslips')->with('error', 'There was an error during the import process: ' . $e->getMessage());
        }

        $error = '';
        foreach ($import->failures() as $failure) {
            $error .= 'Row no: ' . $failure->row() . ', Column: ' . $failure->attribute() . ', Error: ' . implode(', ', $failure->errors()) . '<br>';
        }

        return redirect()->route('admin.ffi_payslips')->with([
            'success' => 'Payslips added successfully',
            'error_msg' => $error
        ]);
    }

    public function export(Request $request)
    {
        $request->validate([
            'month' => 'required|integer',
            'year' => 'required|integer',
        ]);

        $month = $request->input('month');
        $year = $request->input('year');

        return Excel::download(new FFI_PayslipsExport($month, $year), "Payslips_{$month}_{$year}.xlsx");
    }

    public function searchPayslip(Request $request)
    {
        $emp_id = $request->input('emp_id');
        $month = $request->input('month');
        $year = $request->input('year');

        $query = FFIPayslipsModel::query();

        if (!empty($emp_id)) {
            $query->where('emp_id', $emp_id);
        }
        if (!empty($month)) {
            $query->where('month', $month);
        }
        if (!empty($year)) {
            $query->where('year', $year);
        }

        $payslips = $query->orderBy('id', 'ASC')->get();
        return response()->json([
            'success' => true,
            'data' => $payslips
        ]);


    }
    public function destroy($id)
    {
        $this->model()->destroy($id);
        return redirect()->route('admin.ffi_payslips')->with('success', 'Successfully deleted!');
    }
    public function generatePayslipsPdf($id)
    {
        $payslip = $this->model()->findOrFail($id);

        $data = [
            'payslip' => $payslip,
        ];

        $pdf = PDF::loadView('admin.hr_management.ffi.payslips.print_payslips', $data)
            ->setPaper('A4', 'portrait')
            ->setOptions(['margin-top' => 10, 'margin-bottom' => 10, 'margin-left' => 15, 'margin-right' => 15]);


        return $pdf->stream('payslip' . $payslip->id . '.pdf');
    }
}
