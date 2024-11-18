<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientManagement;
use App\Models\CMSESIC;
use Illuminate\Http\Request;

class CMSESICController extends Controller
{
    public function model()
    {
        return new CMSESIC;
    }
    public function index()
    {
        $clients = ClientManagement::where('status', true)->get();
        $challan = $this->model()->all();
        return view("admin.cms.esic_chalan.index", compact("clients"));
    }
    public function create()
    {
        $clients = ClientManagement::where('status', true)->get();
        return view("admin.cms.esic_chalan.create", compact('clients'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'state_id' => 'required',
        ]);
        foreach ($request->year as $key => $year) {
            if ($request->path[$key]) {
                $folder = 'cms_esic';
                $file = $request->path[$key];
                $fileName = time() . '-' . $file->getClientOriginalName();
                $filePath = $file->storeAs($folder, $fileName, 'public');
            }
            $this->model()->create([
                'client_id' => $request->client_id,
                'state_id' => $request->state_id,
                'year' => $year,
                'status' => 0,
                'month' => $request->month[$key],
                'path' => $filePath
            ]);
        }
        return to_route('admin.cms.esic')->with('added successfully');
    }
}
