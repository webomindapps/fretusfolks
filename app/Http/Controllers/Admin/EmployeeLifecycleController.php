<?php

namespace App\Http\Controllers\Admin;

use App\Models\CFISModel;
use App\Models\BankDetails;
use App\Models\DCSChildren;
use Illuminate\Http\Request;
use App\Models\IncrementLetter;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CadidateReportExport;
use Illuminate\Pagination\LengthAwarePaginator;



class EmployeeLifecycleController extends Controller
{
    public function model()
    {
        return new CFISModel();
    }
    public function index(Request $request)
    {
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $selectedData = $request->input('data', []);
        $search_query = $request->input('search_query');

        $filteredResults = $this->model()->newQuery();

        if ($fromDate && $toDate) {
            $filteredResults->whereBetween('created_at', ["{$fromDate} 00:00:00", "{$toDate} 23:59:59"]);
        }
        if ($order == '') {
            $filteredResults->orderByDesc('id');
        } else {
            $filteredResults->orderBy($order, $orderBy);
        }
        if (!empty($search_query)) {
            $filteredResults->where(function ($query) use ($search_query) {
                $query->where('emp_name', 'like', "%{$search_query}%")
                    ->orWhere('phone1', 'like', "%{$search_query}%")
                    ->orWhere('entity_name', 'like', "%{$search_query}%")
                    ->orWhere('email', 'like', "%{$search_query}%")
                    ->orWhere('ffi_emp_id', 'like', "%{$search_query}%");
            });
        }

        if (!empty($selectedData)) {
            $filteredResults->whereIn('client_id', $selectedData);
        }

        $defaultColumns = ['id', 'created_at', 'emp_name', 'entity_name', 'phone1', 'email', 'ffi_emp_id', 'client_id'];

        $results = $filteredResults->select($defaultColumns)->paginate(10)->appends($request->query());

        return view('admin.adms.employee_lifecycle.index', compact(
            'results',
            'fromDate',
            'toDate',
            'selectedData',
            'search_query'
        ));
    }
    public function viewdetail($id)
    {
        $children = DCSChildren::where('emp_id', $id)->get();
        $bankdetails = BankDetails::where('emp_id', $id)->get();

        $candidate = $this->model()
            ->with(['client', 'educationCertificates', 'otherCertificates', 'candidateDocuments', 'offerletters', 'incrementletters', 'showcauseletters', 'warningletters', 'terminationletter', 'pipletter', 'payslipletter'])
            ->findOrFail($id);
        // dd($candidate->showcauseletters);
        return view('admin.adms.employee_lifecycle.view', compact('candidate', 'children','bankdetails'));
        // return response()->json(['html_content' => $htmlContent]);
    }

    public function exportFilteredReport(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $selectedData = $request->input('data', []); // Selected client IDs
        $search_query = $request->input('search_query');

        // $defaultColumns = ['id', 'ffi_emp_id', 'emp_name', 'entity_name', 'phone1', 'email',];

        $query = $this->model()->newQuery();

        if ($fromDate && $toDate) {
            $query->whereBetween('created_at', ["{$fromDate} 00:00:00", "{$toDate} 23:59:59"]);
        }

        if (!empty($search_query)) {
            $query->where(function ($q) use ($search_query) {
                $q->where('emp_name', 'like', "%{$search_query}%")
                    ->orWhere('phone1', 'like', "%{$search_query}%")
                    ->orWhere('entity_name', 'like', "%{$search_query}%")
                    ->orWhere('email', 'like', "%{$search_query}%")
                    ->orWhere('ffi_emp_id', 'like', "%{$search_query}%");
            });
        }

        if (!empty($selectedData)) {
            $query->whereIn('client_id', $selectedData);
        }

        $candidates = $query->get();

        return Excel::download(new CadidateReportExport($candidates), 'filtered_report.xlsx');
    }




}
