<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientGstn;
use App\Models\ClientManagement;
use App\Models\Invoice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function model()
    {
        return new Invoice;
    }
    public function index()
    {
        $searchColumns = ['id', 'invoice_no', 'gst_no', 'grand_total', 'date'];
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

        $invoices = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());
        return view('admin.fcms.cims.index', compact('invoices'));
    }
    public function create()
    {
        $clients = ClientManagement::where('status', 0)->latest()->get();
        return view('admin.fcms.cims.create', compact('clients'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'service_location' => 'required',
            'gst_no' => 'required',
            'invoice_no' => 'required',
            'gross_value' => 'required',
            'service_value' => 'required',
            'source_value' => 'required',
            'cgst' => 'required',
            'cgst_amount' => 'required',
            'sgst' => 'required',
            'sgst_amount' => 'required',
            'igst' => 'required',
            'igst_amount' => 'required',
            'total_tax' => 'required',
            'inv_total' => 'required',
            'credit_note' => 'required',
            'debit_note' => 'required',
            'grand_total' => 'required',
            'total_employee' => 'required',
            'date' => 'required',
            'inv_month' => 'required',
        ]);
        $data = $request->all();
        DB::beginTransaction();
        try {
            $fileName = '';
            if ($request->hasFile("file")) {
                $folder = 'invoices';
                $file = $request->file("file");
                $fileName = time() . '-' . $file->getClientOriginalName();
                $fileName = $file->storeAs($folder, $fileName, 'public');
            }
            $data['file_path'] = $fileName;
            $data['tax_amount'] = $request->total_tax;
            $data['total_value'] = $request->inv_total;
            $data['balance_amount'] = $request->grand_total;
            $this->model()->create($data);
            DB::commit();
            return to_route('admin.fcms.cims')->with('success', 'Invoice created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function edit($id)
    {
        $invoice = $this->model()->find($id);
        $clients = ClientManagement::where('status', 0)->latest()->get();
        $locations = ClientGstn::where('client_id', $invoice->client_id)->get();
        return view('admin.fcms.cims.edit', compact('invoice', 'clients', 'locations'));
    }
    public function update(Request $request, $id)
    {
        $invoice = $this->model()->find($id);
        $data = $request->all();
        DB::beginTransaction();
        try {
            $fileName = '';
            if ($request->hasFile("file")) {
                $folder = 'invoices';
                $file = $request->file("file");
                $fileName = time() . '-' . $file->getClientOriginalName();
                $fileName = $file->storeAs($folder, $fileName, 'public');
            }
            $data['file_path'] = $fileName;
            $data['total_value'] = $request->inv_total;
            $data['balance_amount'] = $request->grand_total;
            $invoice->update($data);
            DB::commit();
            return to_route('admin.fcms.cims')->with('success', 'Invoice created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function getClientLocation($client_id)
    {
        $clientGsts = ClientGstn::where('client_id', $client_id)->get();
        $locations = '<option>Select Location</option>';
        foreach ($clientGsts as $gst) {
            $locations .= '<option value="' . $gst->state . '">' . $gst->states?->state_name . '</option>';
        }
        return $locations;
    }
    public function getClientGST($client_id, $location)
    {
        $clientGsts = ClientGstn::where('client_id', $client_id)->where('state', $location)->first();
        return $clientGsts->gstn_no;
    }
    public function reports(Request $request)
    {
        $request->validate([
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            'data' => 'nullable|array',
            'service_state' => 'nullable|array',
            'region' => 'nullable|string',
            'status' => 'nullable|integer',
            'per_page' => 'nullable|integer|min:1',
        ]);
        $client_id = $request->client_id;
        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $selectedData = $request->input('data', []);
        $selectedStates = $request->input('service_state', []);
        $region = $request->region;
        $status = $request->status;
        $perPage = $request->input('per_page', 10);

        $filteredResults = $this->model()->newQuery();
        if ($client_id || $fromDate || $toDate || !empty($selectedStates) || $status !== null) {
            if ($client_id) {
                $filteredResults->where('client_id', $client_id);
            }
            if ($fromDate && $toDate) {
                $filteredResults->whereBetween('date', [$fromDate, $toDate]);
            }
            if (!empty($selectedStates)) {
                $filteredResults->whereIn('service_state', $selectedStates);
            }
            if ($status !== null && $status !== '') {
                $filteredResults->where('status', (int) $status);
            }
            if (!empty($selectedData)) {
                $filteredResults->select(array_merge($selectedData, ['id', 'client_id', 'invoice_no', 'service_location', 'gst_no', 'grand_total', 'date']));
            }
            $results = $filteredResults->paginate($perPage)->appends($request->query());
        } else {
            $results = new LengthAwarePaginator([], 0, 10);
        }
        $clients = ClientManagement::where('status', 0)->latest()->get();
        return view('admin.fcms.cims.reports', compact(
            'results',
            'fromDate',
            'toDate',
            'selectedData',
            'selectedStates',
            'region',
            'status',
            'clients'
        ));
    }
}
