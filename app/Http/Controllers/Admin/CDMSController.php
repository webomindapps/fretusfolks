<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientManagement;
use App\Models\States;
use Illuminate\Http\Request;

class CDMSController extends Controller
{
    public function index()
    {
        return view("admin.client_mangement.cdms.index");

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
            'gstn' => 'required|string|max:15',
            'website_url' => 'required|url',
            'mode_agreement' => 'required|in:1,2',
            'agreement_type' => 'required|string|max:255',
            'other_agreement' => 'required|string|max:255',
            'agreement_doc' => 'required|file|mimes:doc,docx,jpg,jpeg,pdf|max:5000',
            'region' => 'required|string|max:255',
            'service_state' => 'required|integer',
            'contract_start' => 'required|date',
            'contract_end' => 'required|date',
            'rate' => 'required|string|max:255',
            'commercial_type' => 'required|integer',
            'remark' => 'required|string',
            'status' => 'required|integer',
            'modify_by' => 'required|string|max:255',
            'modify_date' => 'required|date',
            'active_status' => 'required|integer',
        ]);
        if ($request->hasFile('agreement_doc')) {
            $file = $request->file('agreement_doc');
            $filePath = $file->store('agreements', 'public');
            $validatedData['agreement_doc'] = $filePath;
        }
        ClientManagement::create($validatedData);
        return redirect()->route('admin.client_management.index')->with('success', 'Client data has been successfully added!');
    }

    public function show($id)
    {

    }
    public function edit($id)
    {

    }
    public function update(Request $request, $id)
    {

    }
}
