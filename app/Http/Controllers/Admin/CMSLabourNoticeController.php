<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientManagement;
use App\Models\CMSLabour;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CMSLabourNoticeController extends Controller
{
    public function model()
    {
        return new CMSLabour;
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
            $notices = new LengthAwarePaginator([], 0, 10);;
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

            $notices = $query->paginate();
        }
        $clients = ClientManagement::where('status', 0)->latest()->get();
        return view("admin.cms.labour.index", compact("notices", "clients"));
    }
    public function create()
    {
        $clients = ClientManagement::where('status', 0)->latest()->get();
        return view("admin.cms.labour.create", compact('clients'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'state_id' => 'required',
        ]);
        $labour_document = "";
        $closure_document = "";
        DB::beginTransaction();
        try {
            if ($request->hasFile("notice_file")) {
                $folder = 'cms_labour_notice';
                $file = $request->file("notice_file");
                $labour_document = time() . '-' . $file->getClientOriginalName();
                $labour_document = $file->storeAs($folder, $labour_document, 'public');
            }
            if ($request->hasFile("closure_document")) {
                $folder = 'cms_labour_notice';
                $file = $request->file("closure_document");
                $closure_document = time() . '-' . $file->getClientOriginalName();
                $closure_document = $file->storeAs($folder, $closure_document, 'public');
            }

            $this->model()->create([
                'client_id' => $request->client_id,
                'state_id' => $request->state_id,
                'location' => $request->location,
                'notice_received_date' => $request->notice_received_date,
                'notice_document' => $labour_document,
                'closure_date' => $request->closure_date,
                'closure_document' => $closure_document,
                'status' => 1,
            ]);
            DB::commit();
            return to_route('admin.cms.labour')->with('success', 'added successfully');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function edit($id)
    {
        $notice = $this->model()->find($id);
        $clients = ClientManagement::where('status', true)->get();
        return view("admin.cms.labour.update", compact('clients', 'notice'));
    }
    public function update(Request $request, $id)
    {
        $notice = $this->model()->find($id);
        $labour_document = $notice->notice_document;
        $closure_document = $notice->closure_document;
        DB::beginTransaction();
        try {
            if ($request->hasFile("notice_file")) {
                $folder = 'cms_labour_notice';
                $file = $request->file("notice_file");
                $labour_document = time() . '-' . $file->getClientOriginalName();
                $labour_document = $file->storeAs($folder, $labour_document, 'public');
            }
            if ($request->hasFile("closure_document")) {
                $folder = 'cms_labour_notice';
                $file = $request->file("closure_document");
                $closure_document = time() . '-' . $file->getClientOriginalName();
                $closure_document = $file->storeAs($folder, $closure_document, 'public');
            }

            $notice->update([
                'client_id' => $request->client_id,
                'state_id' => $request->state_id,
                'location' => $request->location,
                'notice_received_date' => $request->notice_received_date,
                'notice_document' => $labour_document,
                'closure_date' => $request->closure_date,
                'closure_document' => $closure_document,
                'status' => 1,
            ]);
            DB::commit();
            return to_route('admin.cms.labour')->with('success', 'Date updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function destroy($id)
    {
        $this->model()->destroy($id);
        return back()->with('success', 'Form t registration removed successfully');
    }
}
