<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\States;
use App\Models\ClientGstn;
use App\Exports\CDMSExport;
use Illuminate\Http\Request;
use App\Exports\ClientExport;
use App\Models\ClientManagement;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\LengthAwarePaginator;

class CDMSController extends Controller
{
    public function model()
    {
        return new ClientManagement;
    }
    public function index()
    {
        $searchColumns = ['id', 'client_code', 'client_name', 'contact_person', 'contact_person_phone', 'contact_person_email'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->model()->query();

        if ($from_date && $to_date) {
            $query->whereBetween('modify_date', [$from_date, $to_date]);
        }
        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value)
                    ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $client = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());

        return view("admin.client_mangement.cdms.index", compact("client"));

    }
    public function create()
    {
        $states = States::all();
        return view("admin.client_mangement.cdms.create", compact("states"));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'client_code' => 'required|string|max:255',
            'client_ffi_id' => 'nullable|string|max:255',
            'client_name' => 'required|string|max:255',
            'land_line' => 'required|string|max:15',
            'client_email' => 'required|email|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_person_phone' => 'required|string|min:10|max:15',
            'contact_person_email' => 'required|email|max:255',
            'contact_name_comm' => 'required|string|max:255',
            'contact_phone_comm' => 'required|string|min:10|max:15',
            'contact_email_comm' => 'required|email|max:255',
            'registered_address' => 'required|string',
            'communication_address' => 'required|string',
            'pan' => 'required|string|max:10',
            'tan' => 'required|string|max:10',
            'gstn' => 'nullable',
            'website_url' => 'required|url',
            'mode_agreement' => 'required|string|in:1,2',
            'agreement_type' => 'required|string|in:1,2,3',
            'other_agreement' => 'nullable',
            'agreement_doc' => 'nullable|file|max:5000',
            'region' => 'required|string|max:255',
            'service_state' => 'required|integer',
            'contract_start' => 'required|date',
            'contract_end' => 'required|date',
            'rate' => 'required|string|max:255',
            'commercial_type' => 'required|integer',
            'remark' => 'required|string',
        ]);
        $validatedData = $request->all();
        $validatedData['status'] = $request->input('status', 1);
        $validatedData['active_status'] = $request->input('active_status', 0);
        $validatedData['modify_date'] = $request->input('modify_date', now());
        $validatedData['modify_by'] = $request->input('modify_by', 1);

        DB::beginTransaction();
        try {
            if ($request->hasFile('agreement_doc')) {
                $folder = 'agreements';
                $file = $request->file('agreement_doc');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $agreementDocPath = $file->storeAs($folder, $fileName, 'public');
                $validatedData['agreement_doc'] = $agreementDocPath;
            }

            $client = $this->model()->create($validatedData);

            $states = $request->state;
            $gstnNos = $request->gstn_no;

            if (count($states) === count($gstnNos)) {
                foreach ($states as $index => $state) {
                    ClientGstn::create([
                        'client_id' => $client->id,
                        'state' => $state,
                        'gstn_no' => strtoupper($gstnNos[$index]),
                        'status' => $request->status ?? 1,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.cdms')->with('success', 'Client data has been successfully added!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function show($id)
    {
        $client = $this->model()->findOrFail($id);
        $clientgstn = ClientGstn::where('client_id', $client->id)->get();
        $htmlContent = view('admin.client_mangement.cdms.view', compact('client', 'clientgstn'))->render();
        return response()->json(['html_content' => $htmlContent]);
    }
    public function edit($id)
    {
        $states = States::all();
        $client = $this->model()->findOrFail($id);
        $clientGstns = ClientGstn::where('client_id', $id)->get();
        return view('admin.client_mangement.cdms.update', compact('states', 'client', 'clientGstns'));
    }
    public function gststore(Request $request, $id)
    {
        $client = $this->model()->findOrFail($id);
        $request->validate([
            'state' => 'exists:states,id',
            'gstn_no' => 'required|string',
        ]);
        ClientGstn::create([
            'client_id' => $client->id,
            'state' => $request->state,
            'gstn_no' => strtoupper($request->gstn_no),
            'status' => $request->status ?? 1,
        ]);
        return redirect()->back()->with('success', 'GSTN details saved successfully.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'client_code' => 'required|string|max:255',
            'client_ffi_id' => 'nullable|string|max:255',
            'client_name' => 'required|string|max:255',
            'land_line' => 'required|string|max:15',
            'client_email' => 'required|email|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_person_phone' => 'required|string|min:10|max:15',
            'contact_person_email' => 'required|email|max:255',
            'contact_name_comm' => 'required|string|max:255',
            'contact_phone_comm' => 'required|string|min:10|max:15',
            'contact_email_comm' => 'required|email|max:255',
            'registered_address' => 'required|string',
            'communication_address' => 'required|string',
            'pan' => 'required|string|max:10',
            'tan' => 'required|string|max:10',
            'gstn' => 'nullable',
            'website_url' => 'required|url',
            'mode_agreement' => 'required|string|in:1,2',
            'agreement_type' => 'required|string|in:1,2,3',
            'other_agreement' => 'nullable',
            'agreement_doc' => 'nullable|file|max:5000',
            'region' => 'required|string|max:255',
            'service_state' => 'required|integer',
            'contract_start' => 'required|date',
            'contract_end' => 'required|date',
            'rate' => 'required|string|max:255',
            'commercial_type' => 'required|integer',
            'remark' => 'required|string',
            'status' => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
            $client = $this->model()->findOrFail($id);
            $validatedData = $request->all();
            $client->update($validatedData);

            if ($request->hasFile('agreement_doc')) {
                $folder = 'agreements';
                $agreementDocPath = $request->file('agreement_doc')->store($folder, 'public');
                $client->agreement_doc = $agreementDocPath;
                $client->save();
            }

            DB::commit();

            return redirect()->route('admin.cdms')->with('success', 'Client data has been successfully updated!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function destroy($id)
    {
        $client = $this->model()->findOrFail($id);
        ClientGstn::where('client_id', $client->id)->delete();
        $client->delete();
        return redirect()->route('admin.cdms')->with('success', 'Client data has been successfully deleted!');
    }
    public function bulk(Request $request)
    {
        $type = $request->type;
        $selectedItems = $request->selectedIds;
        $status = $request->status;

        foreach ($selectedItems as $item) {
            $tds_code = $this->model()->find($item);
            if ($type == 1) {
                $tds_code->delete();
            } else if ($type == 2) {
                $tds_code->update(['status' => $status]);
            }
        }
        return response()->json(['success' => true, 'message' => 'Bulk operation is completed']);
    }
    public function updateGst(Request $request, $id)
    {
        $client = ClientGstn::findOrFail($id);
        $client->gstn_no = $request->query('gstn_no');
        $client->save();

        return redirect()->back()->with('success', 'GST NO updated successfully.');
    }
    public function updateState(Request $request, $id)
    {
        $gstn = ClientGstn::findOrFail($id);
        $gstn->state = $request->state;
        $gstn->save();
        return redirect()->back()->with('success', 'State updated successfully.');
    }
    public function gstdestroy(Request $request, $id)
    {
        $gstn = ClientGstn::findOrFail($request->id);
        $gstn->delete();
        return redirect()->back()->with('success', 'GST NO deleted successfully.');
    }
    public function export(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $query = $this->model()->with('gstn', 'state');
        if ($from_date && $to_date) {
            $query->whereBetween('modify_date', [$from_date, $to_date]);
        }
        $clients = $query->get();
        return Excel::download(new CDMSExport($clients), 'cdms.xlsx');
    }
    public function exportReport(Request $request)
    {
        // dd($request->all());
        $fields = explode(',', $request->input('fields'));
        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $states = $request->states;
        $region = $request->region;
        $status = $request->status;

        if (empty($fields)) {
            return redirect()->route('admin.cdms_report')->with('error', 'No fields selected for export');
        }
        $query = $this->model()->newQuery();

        // dd($query = $this->model()->newQuery());
        if ($fromDate && $toDate) {
            $query->whereBetween('modify_date', ["{$fromDate} 00:00:00", "{$toDate} 23:59:59"]);
        }
        // dd($fromDate, $toDate);
        if ($states) {
            $query->whereIn('service_state', explode(',', $states));
        }
        // dd($states);
        if ($region) {
            $query->where('region', $region);
        }
        // dd($region);
        if ($status) {
            $query->where('status', $status);
        }
        // dd($status);
        $data = $query->select($fields)->get();

        // dd($data);
        return Excel::download(new ClientExport($data, $fields), 'cdmsreport.xlsx');
    }
    public function showCodeReport(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $selectedData = $request->input('data', []);
        $selectedStates = $request->input('service_state', []);
        $region = $request->input('region');
        $status = $request->input('status');

        $filteredResults = $this->model()->newQuery();

        if ($fromDate || $toDate || !empty($selectedStates) || !empty($region) || $status !== null) {
            if ($fromDate && $toDate) {
                $filteredResults->whereBetween('modify_date', ["{$fromDate} 00:00:00", "{$toDate} 23:59:59"]);
            }
            if (!empty($selectedStates)) {
                $filteredResults->whereIn('service_state', $selectedStates);
            }
            if (!empty($region)) {
                $filteredResults->where('region', $region);
            }
            if ($status !== null && $status !== '') {
                $filteredResults->where('status', (int) $status);
            }
            if (!empty($selectedData)) {
                $filteredResults->select(array_merge($selectedData, ['id', 'created_at', 'region', 'service_state', 'status']));
            }

            $results = $filteredResults->paginate(10)->appends($request->query());
        } else {
            $results = new LengthAwarePaginator([], 0, 10);
        }
        return view('admin.client_mangement.cdms_report.index', compact(
            'results',
            'fromDate',
            'toDate',
            'selectedData',
            'selectedStates',
            'region',
            'status'
        ));
    }
}
