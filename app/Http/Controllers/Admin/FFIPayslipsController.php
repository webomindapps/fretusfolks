<?php

namespace App\Http\Controllers\Admin;

use Exception;
use ZipArchive;
use App\Models\Payslips;
use App\Jobs\PayslipCreate;
use Illuminate\Http\Request;
use RecursiveIteratorIterator;
use Barryvdh\DomPDF\Facade\Pdf;
use RecursiveDirectoryIterator;
use App\Models\FFIPayslipsModel;
use App\Imports\FFIPayslipImport;
use App\Exports\FFI_PayslipsExport;
use App\Imports\FFI_PayslipsImport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Response;

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

        $payslip = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(100)->appends(request()->query());

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

        try {
            $fileName = $file->getClientOriginalName();
            $filePath = public_path('uploads') . '/' . $fileName;

            // Move the file to public/uploads if not already there
            if (!file_exists($filePath)) {
                $file->move(public_path('uploads'), $fileName);
            }

            // Import using Laravel Excel with custom import logic
            Excel::import(new FFIPayslipImport($month, $year), $filePath);

            if (file_exists($filePath)) {
                unlink($filePath);
            }
        } catch (\Exception $e) {
            dd($e);
        }

        return redirect()->route('admin.ffi_payslips')->with([
            'success' => 'Payslips added successfully',
            'error_msg' => '',
        ]);
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
        // Artisan::call('queue:work');
        $searchColumns = ['id', 'emp_id', 'month', 'year', 'employee_name', 'designation', 'department'];
        $search = request()->search;
        $emp_id = $request->input('emp_id');
        $month = $request->input('month');
        $year = $request->input('year');

        $query = FFIPayslipsModel::query();
        if ($search != '') {
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) {
                    $key == 0 ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                }
            });
        }
        if (!empty($emp_id)) {
            $query->where('emp_id', $emp_id);
        }
        if (!empty($month)) {
            $query->where('month', $month);
        }
        if (!empty($year)) {
            $query->where('year', $year);
        }

        $payslips = $query->orderBy('id', 'ASC')->paginate(20)->withQueryString();

        return view('admin.hr_management.ffi.payslips.index', compact('payslips'));
    }
    public function destroy($id)
    {
        try {
            $this->model()->destroy($id);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function generatePayslipsPdf($id)
    {
        $payslip = $this->model()->findOrFail($id);

        // Get full month name
        $monthName = date("F", mktime(0, 0, 0, $payslip->month, 1));

        $data = [
            'payslip' => $payslip,
        ];

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'chroot' => public_path()
        ])->loadView('admin.hr_management.ffi.payslips.print_payslips', $data);

        // Generate clean filename
        $filename = 'Payslip' . '-' . ($payslip->employee_name) . '-' . $payslip->emp_id . '-' . $monthName . '-' . $payslip->year . '.pdf';

        return $pdf->stream($filename);
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
