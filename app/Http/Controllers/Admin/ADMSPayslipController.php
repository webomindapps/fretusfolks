<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Throwable;
use ZipArchive;
use Carbon\Carbon;
use App\Models\Payslips;
use App\Models\CFISModel;
use Illuminate\Bus\Batch;
use Illuminate\Http\Request;
use App\Imports\PayslipImport;
use App\Jobs\ADMSPayslipCreate;
use App\Jobs\CreateZipAndEmail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Jobs\GeneratePayslipPDFs;
use Illuminate\Support\Facades\Bus;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;


class ADMSPayslipController extends Controller
{
    public function model()
    {
        return new Payslips();
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
            $query->whereBetween('modify_on', [$from_date, $to_date]);
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

        return view('admin.adms.payslip.index', compact("payslip"));
    }
    public function destroy($id)
    {
        $this->model()->destroy($id);
        return redirect()->route('admin.payslips')->with('success', 'Successfully deleted!');
    }
    public function bulkUpload(Request $request)
    {
        $request->validate([
            'month' => 'required',
            'year' => 'required',
            'file' => 'required|file|mimes:xlsx,csv,txt',
        ]);
        // dd($request->all());
        $file = $request->file('file');
        $month = $request->input('month');
        $year = $request->input('year');
        try {
            if ($request->has('file')) {
                // dd($request->file);
                $fileName = $request->file->getClientOriginalName();
                $fileWithPath = public_path('uploads') . '/' . $fileName;
                // dd($fileWithPath);
                if (!file_exists($fileWithPath)) {
                    $request->file->move(public_path('uploads'), $fileName);
                }
                // dd($fileWithPath);
                Excel::import(new PayslipImport($month, $year), $fileWithPath);
                if (file_exists($fileWithPath)) {
                    unlink($fileWithPath);
                }
            }
        } catch (Exception $e) {
            dd($e);
        }
        $error = '';
        return redirect()->route('admin.payslips')->with([
            'success' => 'Payslips added successfully',
            'error_msg' => $error
        ]);
    }
    public function export(Request $request)
    {
        $request->validate([
            'month' => 'required|integer',
            'year' => 'required|integer',
            'client' => 'nullable|array',
            'state' => 'nullable|array',
        ]);

        $payslips = $this->model()
            ->where('month', $request->month)
            ->where('year', $request->year)
            ->whereHas('payslips', function ($query) use ($request) {
                if (!empty($request->client)) {
                    $query->whereIn('client_id', $request->client);
                }
                if (!empty($request->state)) {
                    $query->whereIn('state', $request->state);
                }
            })
            ->get();

        if ($payslips->isEmpty()) {
            return back()->with('error', 'No payslips found for the selected month and year.');
        }

        return $this->zipDownload($payslips, $request->ademails);
    }
    public function searchPayslip(Request $request)
    {
        $searchColumns = ['id', 'emp_id', 'month', 'year', 'emp_name', 'designation', 'department'];
        $search = request()->search;
        $emp_id = $request->input('emp_id');
        $month = $request->input('month');
        $year = $request->input('year');

        $query = $this->model()->query();
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

        return view('admin.adms.payslip.index', compact('payslips'));
    }

    public function generatePayslipsPdf($id)
    {
        $payletter = $this->model()->findOrFail($id);
        // dd($payletter->payslips_letter_path);
        if (!$payletter->payslips_letter_path) {
            abort(404, 'PDF not found');
        }

        $filePath = str_replace('storage/', '', $payletter->payslips_letter_path);

        return response()->file(public_path($filePath));
    }
    public function zipDownload($payslips, $ademails)
    {
        if ($payslips->isEmpty()) {
            return redirect()->back()->with('error', 'No Payslips Found for the Month and Year');
        }

        try {
            $batch = Bus::batch([])->then(function (Batch $batch) {
                Cache::put("batch_status_{$batch->id}", 'completed', 3600);
            })->catch(function (Batch $batch, Throwable $e) {
                Cache::put("batch_status_{$batch->id}", 'failed', 3600);
            })->dispatch();

            foreach ($payslips as $payslip) {
                $batch->add(new GeneratePayslipPDFs($payslip));
                // dump($batch->id);
            }
            // dd("end");
            $emails = explode(',', $ademails);
            $emails = array_map('trim', $emails);
            // dd("end");
            $batch->add(new CreateZipAndEmail($payslips, $emails));
            // Store batch ID in session to track progress
            session(['batch_id' => $batch->id]);
            return redirect()->back()->with('success', 'Payslips are being processed. You will receive an email when ready.');
        } catch (Throwable $e) {
            dd($e);
            return redirect()->back()->with('error', 'An error occurred while processing payslips.');
        }

    }
    public function downloadfiltered(Request $request)
    {

        $clients = $request->input('data', []);


        if (empty($clients)) {
            return response()->json(['message' => 'Invalid parameters'], 400);
        }
        $query = CFISModel::query()
            ->whereIn('client_id', $clients)
            ->where('status', 1);



        $candidates = $query->where('hr_approval', 1)->get();
        // ->where('comp_status', 1)->get();

        if ($candidates->isEmpty()) {
            return redirect()->back()->with('error', 'No records found');
        }


        $fileName = "payslip_format.xlsx";

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($candidates) {
            $file = fopen('php://output', 'w');

            $csvHeaders = [
                'emp_id',
                'client_emp_id',
                'emp_name',
                'designation',
                'doj',
                'department',
                'location',
                'client_name',
                'uan_no',
                'pf_no',
                'esi_no',
                'bank_name',
                'account_no',
                'ifsc_code',
                'month_days',
                'payable_days',
                'leave_days',
                'lop_days',
                'arrears_days',
                'ot_hours',
                'leave_balance',
                'fixed_basic_da',
                'fixed_hra',
                'fixed_conveyance',
                'fix_education_allowance',
                'fixed_medical_reimbursement',
                'fixed_special_allowance',
                'fixed_other_allowance',
                'fixed_st_bonus',
                'fix_leave_wages',
                'fixed_holiday_wages',
                'fixed_attendance_bonus',
                'fixed_ot_wages',
                'fix_incentive_wages',
                'fix_arrear_wages',
                'fixed_other_wages',
                'fixed_total_earnings',
                'earn_basic',
                'earn_hr',
                'earn_conveyance',
                'earn_education_allowance',
                'earn_medical_allowance',
                'earn_special_allowance',
                'earn_other_allowance',
                'earn_st_bonus',
                'earn_leave_wages',
                'earn_holiday_wages',
                'earn_attendance_bonus',
                'earn_ot_wages',
                'earn_incentive_wages',
                'earn_arrear_wages',
                'earn_other_wages',
                'earn_total_gross',
                'epf',
                'esic',
                'pt',
                'it',
                'lwf',
                'salary_advance',
                'other_deduction',
                'total_deduction',
                'net_salary',
                'in_words'

            ];


            fputcsv($file, $csvHeaders);

            foreach ($candidates as $candidate) {
                fputcsv($file, [
                    $candidate->ffi_emp_id,
                    $candidate->client_emp_id,
                    $candidate->client_name,
                    $candidate->emp_name,
                    $candidate->designation,
                    Carbon::parse($candidate->joining_date)->format('d-m-Y'),
                    $candidate->department,
                    '',
                    $candidate->location,
                    $candidate->entity_name,
                    '',
                    '',
                    $candidate->uan_no,
                    '',
                    $candidate->esic_no,
                    $candidate->bank_name,
                    $candidate->bank_account_no,
                    $candidate->bank_ifsc_code,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
