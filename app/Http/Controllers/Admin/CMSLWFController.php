<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientManagement;
use App\Models\CMSLWF;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CMSLWFController extends Controller
{
    public function model()
    {
        return new CMSLWF;
    }
    public function index()
    {
        $client_id = request()->client_id;
        $month = request()->month;
        $year = request()->year;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        if (!$client_id && !$month && !$year) {
            $challans = new LengthAwarePaginator([], 0, 10);;
        } else {
            $query = $this->model()->query();

            if ($client_id) {
                $query->where('client_id', $client_id);
            }
            if ($month) {
                $query->where('month', $month);
            }
            if ($year) {
                $query->where('year', $year);
            }

            $challans = $query->paginate();
        }
        $clients = ClientManagement::where('status', true)->get();
        return view("admin.cms.lwf_chalan.index", compact("challans", "clients"));
    }
    public function create()
    {
        $clients = ClientManagement::where('status', true)->get();
        return view("admin.cms.lwf_chalan.create", compact('clients'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'state_id' => 'required',
        ]);

        foreach ($request->years as $key => $year) {
            $filePath = null;
            if ($request->hasFile("files.{$key}")) {
                $folder = 'cms_lwf';
                $file = $request->file("files.{$key}");
                $fileName = time() . '-' . $file->getClientOriginalName();
                $filePath = $file->storeAs($folder, $fileName, 'public');
            }

            $this->model()->create([
                'client_id' => $request->client_id,
                'state_id' => $request->state_id,
                'year' => $year,
                'status' => 0,
                'month' => $request->months[$key],
                'path' => $filePath
            ]);
        }
        return to_route('admin.cms.lwf')->with('success', 'added successfully');
    }
    public function destroy($id)
    {
        $this->model()->destroy($id);
        return back()->with('success', 'Lwf Challan removed successfully');
    }
}