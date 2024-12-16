<?php

namespace App\Http\Controllers\Admin;

use ZipArchive;
use Illuminate\Http\Request;
use RecursiveIteratorIterator;
use Barryvdh\DomPDF\Facade\Pdf;
use RecursiveDirectoryIterator;
use App\Models\FFIPayslipsModel;
use App\Exports\FFI_PayslipsExport;
use App\Imports\FFI_PayslipsImport;
use App\Http\Controllers\Controller;
use App\Jobs\PayslipCreate;
use Exception;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Bus\Batchable;
use Illuminate\Support\Facades\Bus;

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
        try {
            if ($request->has('file')) {
                $fileName = $request->file->getClientOriginalName();
                $fileWithPath = public_path('uploads') . '/' . $fileName;
                if (!file_exists($fileWithPath)) {
                    $request->file->move(public_path('uploads'), $fileName);
                }
                $header = null;
                $datafromCsv = array();
                $records = array_map('str_getcsv', file($fileWithPath));
                $batch = Bus::batch([])->dispatch();
                foreach ($records as $key => $record) {
                    if (!$header) {
                        $header = $record;
                    } else {
                        $datafromCsv[] = $record;
                    }
                }
                $datafromCsv = array_chunk($datafromCsv, 1000);
                foreach ($datafromCsv as $index => $dataCsv) {
                    foreach ($dataCsv as $data) {
                        $payslipdata[$index][] = array_combine($header, $data);
                    }
                    $batch->add(new PayslipCreate($payslipdata[$index], $month, $year));
                    // PayslipCreate::dispatch($payslipdata[$index], $month, $year);
                }
                session()->put('lastBatch',$batch);
                return back();
            }
        } catch (Exception $e) {
            dd($e);
        }
        // $import = new FFI_PayslipsImport($month, $year);

        // try {
        //     Excel::import($import, $file);
        // } catch (Exception $e) {
        //     return redirect()->route('admin.ffi_payslips')->with('error', 'There was an error during the import process: ' . $e->getMessage());
        // }

        // $error = '';
        // foreach ($import->failures() as $failure) {
        //     $error .= 'Row no: ' . $failure->row() . ', Column: ' . $failure->attribute() . ', Error: ' . implode(', ', $failure->errors()) . '<br>';
        // }
        $error = '';
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
        $payslips = FFIPayslipsModel::where('month', $request->month)
            ->where('year', $request->year)
            ->get();
        return $this->zipDownload($payslips);
        // return Excel::download(new FFI_PayslipsExport($month, $year), "Payslips_{$month}_{$year}.xlsx");
    }

    public function searchPayslip(Request $request)
    {
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
