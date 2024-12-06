<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientManagement;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\TdsCode;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
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
}
