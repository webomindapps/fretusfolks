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
        $tds_code = TdsCode::paginate(10);
        return view('admin.ffimasters.tds_code.index', compact('tds_code'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',

        ]);
        TdsCode::create([
            'code' => $request->code,
            'discount' => 0,
            'status' => 1,

        ]);
        return redirect()->route('admin.tds_code')->with('success', 'Tds Code added successfully');
    }
    public function destroy($id)
    {
        $tds_code = TdsCode::findorfail($id);
        $tds_code->delete();
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
        $tdsCode = TdsCode::findOrFail($id);
        $tdsCode->status = !$tdsCode->status;
        $tdsCode->save();
        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
