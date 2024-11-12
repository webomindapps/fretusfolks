<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientGstn;
use App\Models\ClientManagement;
use App\Models\States;
use Illuminate\Http\Request;

class CDMSController extends Controller
{
    public function model()
    {
        return new ClientManagement;
    }
    public function index()
    {
        $searchColumns = ['id', 'client_name', 'contact_person', 'contact_person_phone', 'contact_person_email'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->model()->query();

        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }
        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value)
                    ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        // sorting
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
        $validatedData = $request->validate([
            'client_code' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'land_line' => 'required|string|max:15',
            'client_email' => 'required|email|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_person_phone' => 'required|string|max:15',
            'contact_person_email' => 'required|email|max:255',
            'contact_name_comm' => 'required|string|max:255',
            'contact_phone_comm' => 'required|string|max:15',
            'contact_email_comm' => 'required|email|max:255',
            'registered_address' => 'required|string',
            'communication_address' => 'required|string',
            'pan' => 'required|string|max:10',
            'tan' => 'required|string|max:10',
            'gstn' => 'nullable',
            'website_url' => 'required|url',
            'mode_agreement' => 'required|in:1,2',
            'agreement_type' => 'required|in:1,2,3',
            'other_agreement' => 'nullable',
            'agreement_doc' => 'max:5000',
            'region' => 'required|string|max:255',
            'service_state' => 'required|integer',
            'contract_start' => 'required|date',
            'contract_end' => 'required|date',
            'rate' => 'required|string|max:255',
            'commercial_type' => 'required|integer',
            'remark' => 'required|string',
        ]);

        $validatedData['status'] = $request->input('status', 0);
        $validatedData['active_status'] = $request->input('active_status', 0);
        $validatedData['modify_date'] = $request->input('modify_date', now());
        $validatedData['modify_by'] = $request->input('modify_by', 1);

        if ($request->hasFile('agreement_doc')) {
            $folder = 'agreements';
            $agreement_doc1 = $request->file('agreement_doc')->store($folder, 'public');
            $validatedData['agreement_doc'] = $agreement_doc1;
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
        return redirect()->route('admin.cdms')->with('success', 'Client data has been successfully added!');
    }

    public function show($id)
    {
        $client = ClientManagement::findOrFail($id);

        // Prepare the data for the modal
        $htmlContent = view('admin.client_mangement.cdms.view', compact('client'))->render();

        // Return the HTML content wrapped in a JSON response
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
            'gstn_no' => '',
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
        $validatedData = $request->validate([
            'client_code' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'land_line' => 'required|string|max:15',
            'client_email' => 'required|email|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_person_phone' => 'required|string|max:15',
            'contact_person_email' => 'required|email|max:255',
            'contact_name_comm' => 'required|string|max:255',
            'contact_phone_comm' => 'required|string|max:15',
            'contact_email_comm' => 'required|email|max:255',
            'registered_address' => 'required|string',
            'communication_address' => 'required|string',
            'pan' => 'required|string|max:10',
            'tan' => 'required|string|max:10',
            'gstn' => 'nullable',
            'website_url' => 'required|url',
            'mode_agreement' => 'required|in:1,2',
            'agreement_type' => 'required|in:1,2,3',
            'other_agreement' => 'nullable',
            'agreement_doc' => 'max:5000',
            'region' => 'required|string|max:255',
            'service_state' => 'required|integer',
            'contract_start' => 'required|date',
            'contract_end' => 'required|date',
            'rate' => 'required|string|max:255',
            'commercial_type' => 'required|integer',
            'remark' => 'required|string',
        ]);

        $client = $this->model()->findOrFail($id);
        $client->update($validatedData);

        if ($request->hasFile('agreement_doc')) {
            $folder = 'agreements';
            $agreement_doc1 = $request->file('agreement_doc')->store($folder, 'public');
            $client->agreement_doc = $agreement_doc1;
            $client->save();
        }
        // $this->gststore($request, $client->id);
        return redirect()->route('admin.cdms')->with('success', 'Client data has been successfully updated!');
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

}
