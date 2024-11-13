<?php

namespace App\Http\Controllers\Admin;

use App\Models\TdsCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TdsCodeController extends Controller
{
    public function model()
    {
        return new TdsCode;
    }
    public function index()
    {
        $searchColumns = ['id', 'code'];
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
                foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        // sorting
        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $tds_code = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());
        return view('admin.ffimasters.tds_code.index', compact('tds_code'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',

        ]);
        $this->model()->create([
            'code' => $request->code,
            'discount' => 0,
            'status' => 1,

        ]);
        return redirect()->route('admin.tds_code')->with('success', 'Tds Code added successfully');
    }
    public function destroy($id)
    {
        $this->model()->destroy($id);
        return redirect()->route('admin.tds_code')->with('success', 'Tds Code deleted successfully');
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
    public function toggleStatus($id)
    {
        $tdsCode = $this->model()->findOrFail($id);
        $tdsCode->status = !$tdsCode->status;
        $tdsCode->save();
        return redirect()->back()->with('success', 'Status updated successfully.');
    }
    public function updateCode(Request $request, $id)
    {
        $tdsCode = $this->model()->findOrFail($id);
        $tdsCode->code = $request->query('code');
        $tdsCode->save();

        return redirect()->back()->with('success', 'Code updated successfully.');
    }
}
