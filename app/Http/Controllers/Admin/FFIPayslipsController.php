<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FFI_PayslipsExport;
use App\Imports\FFI_PayslipsImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\FFIPayslipsModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

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
        Excel::import($import, $file);
        $error = '';
        // dd($import);
        foreach ($import->failures() as $failure) {
            $failure->row();
            $failure->attribute();
            $failure->errors();
            $failure->values();
            $error .= 'Row no:-' . $failure->row() . ', Column:-' . $failure->attribute() . ', Error:-' . $failure->errors()[0] . '<br>';
        }
        return redirect()->route('admin.ffi_payslips')->with(['success' => 'Payslip added successfully', 'error_msg' => $error]);
    }
    public function export(Request $request)
    {
        $request->validate([
            'month' => 'required|integer',
            'year' => 'required|integer',
        ]);
        $payslips = FFIPayslipsModel::where('month', $request->month)
            ->where('year', $request->year)
            ->get();
        return $this->zipDownload($payslips);
        // return Excel::download(new FFI_PayslipsExport($month, $year), "Payslips_{$month}_{$year}.xlsx");
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

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'chroot' => public_path()])->loadView('admin.hr_management.ffi.payslips.print_payslips', $data);
        return $pdf->stream('payslip' . $payslip->id . '.pdf');
    }
    public function zipDownload($payslips)
    {
        $zipFileName = "ffi_payslips_" . date('Y') . '.zip';
        $zipPath = public_path($zipFileName);

        // Create ZIP archive
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($payslips as $payslip) {
                $data = [
                    'payslip' => $payslip,
                ];

                // Generate PDF content
                $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'chroot' => public_path()])
                    ->loadView('admin.hr_management.ffi.payslips.print_payslips', $data);
                $fileName = $payslip->emp_id . '_' . $payslip->employee_name . '.pdf';

                // Add PDF to the ZIP archive as a stream
                $zip->addFromString($fileName, $pdf->output());
            }
            $zip->close();
        } else {
            return response()->json(['error' => 'Could not create ZIP file.'], 500);
        }
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
