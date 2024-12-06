<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\TdsCode;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Exports\tdsReportExport;
use App\Models\ClientManagement;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\LengthAwarePaginator;

class PaymentController extends Controller
{
    public function model()
    {
        return new Payment;
    }
    public function index()
    {
        $searchColumns = ['id', 'month', 'tds_code', 'amount_received', 'payment_received_date'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->model()->query();

        if ($from_date && $to_date) {
            $query->whereBetween('date', [$from_date, $to_date]);
        }
        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value)
                    ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $recipts = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());
        return view('admin.fcms.receivables.index', compact('recipts'));
    }
    public function create()
    {
        $tds_codes = TdsCode::where('status', 0)->get();
        $clients = ClientManagement::where('status', 0)->latest()->get();
        return view('admin.fcms.receivables.create', compact('clients', 'tds_codes'));
    }
    public function store(Request $request)
    {
        $request->validate([]);
        $data = $request->all();
        DB::beginTransaction();
        try {
            $data['total_amt'] = $request->total_gst;
            $data['total_amt_gst'] = $request->total_amt;
            $data['payment_received_date'] = $request->payment_date;
            $data['amount_received'] = $request->amount_paid;
            $data['date_time'] = date("Y-m-d H:i:s");
            $data['payment_received'] = 1;
            $data['status'] = 0;
            $data['active_status'] = 0;
            $data['modify_by'] = auth()->user()->id;
            $this->model()->create($data);
            DB::commit();
            return to_route('admin.fcms.receivables')->with('receivable added successfully');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function getClientInvoice($client_id)
    {
        $invoices = Invoice::where('client_id', $client_id)->where('status', '0')->get();
        $invoiceOptions = '<option>Select Invoice</option>';
        foreach ($invoices as $invoice) {
            $invoiceOptions .= '<option value="' . $invoice->id . '">' . $invoice->invoice_no . '</option>';
        }
        return $invoiceOptions;
    }
    public function getInvoiceDetails($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        return $invoice;
    }
    public function tdsReports(Request $request)
    {
        $request->validate([
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            'data' => 'nullable|array',
            'status' => 'nullable|integer',
            'per_page' => 'nullable|integer|min:1',
        ]);

        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $client_id = $request->client_id;
        $tds_code = $request->tds_code;
        $status = $request->status;
        $selectedData = $request->input('data', []);
        $perPage = $request->input('per_page', 10);

        $defaultColumns = ['id', 'client_id', 'tds_code', 'date_time', 'status'];

        $columnsToSelect = array_merge($defaultColumns, $selectedData);

        $query = $this->model()
            ->with([
                'invoice' => function ($query) {
                    $query->select('id', 'invoice_no', 'service_location');
                }
            ]);
        // dd($query);

        if ($client_id) {
            $query->where('client_id', $client_id);
        }

        if ($fromDate && $toDate) {
            $query->whereBetween('date_time', [$fromDate, $toDate]);
        }

        if ($tds_code) {
            $query->where('tds_code', $tds_code);
        }

        if ($status !== null && $status !== '') {
            $query->where('status', (int) $status);
        }

        $results = $query->paginate($perPage)->appends($request->query());
        // dd($results);
        $clients = ClientManagement::where('status', 0)->latest()->get();
        $tds_code = TdsCode::where('status', 0)->latest()->get();
        $invoice = Invoice::where('status', 0)->latest()->get();

        return view('admin.fcms.tds_report.index', compact(
            'results',
            'fromDate',
            'toDate',
            'selectedData',
            'status',
            'clients',
            'tds_code',
            'invoice'
        ));
    }
    public function exportReport(Request $request)
    {
        $fields = explode(',', $request->input('fields'));
        if (empty($fields)) {
            return redirect()->route('admin.tds_report')->with('error', 'No fields selected for export');
        }

        return Excel::download(new tdsReportExport($fields), 'tdsreport.xlsx');
    }
    public function show($id)
    {
        $payments = $this->model()->with('invoice')->findOrFail($id);
        $client = ClientManagement::findOrFail($payments->client_id);
        $tds_code = TdsCode::findOrFail($payments->tds_code);
        $htmlContent = view('admin.fcms.tds_report.view', compact('payments', 'client', 'tds_code'))->render();

        return response()->json(['html_content' => $htmlContent]);
    }


}
