<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\FHRMSModel;
use Illuminate\Http\Request;
use App\Models\FFIAssetModel;
use App\Exports\FFIAssetExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class FFIAssetController extends Controller
{
    public function model()
    {
        return new FFIAssetModel();
    }
    public function index()
    {
        $searchColumns = ['id',  'asset_name', 'asset_code', 'issued_date', 'returned_date'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;
        $month = request()->month;
        $year = request()->year;

        $query = $this->model()->with('assets');

        if ($month) {
            $query->whereMonth('date', $month);
        }

        if ($year) {
            $query->whereYear('date', $year);
        }
        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }
        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value)
                    ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        if ($order == '') {
            $query->orderByDesc('id');
        } else {
            $query->orderBy($order, $orderBy);
        }

        $issues = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());

        return view("admin.fcms.ffi_assets.index", compact("issues"));
    }
    public function create()
    {
        $employees = FHRMSModel::all();
        return view('admin.fcms.ffi_assets.create', compact('employees'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required',
            'asset_name' => 'required|string|max:128',
            'asset_code' => 'required|string|max:128',
            'issued_date' => 'required|date',
            'returned_date' => 'nullable|date',
            'damage_recover' => 'nullable|string',
            'status' => 'required|integer',

        ]);
        DB::beginTransaction();
        try {
            $issues = $this->model()->create($validatedData);
            $issues->save();
            DB::commit();
            return redirect()->route('admin.fcms.ffi_assets')->with('success', 'FFI Assets created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function edit($id)
    {
        $employees = FHRMSModel::findOrFail($id)->all();
        $issues = $this->model()->findOrFail($id);
        return view('admin.fcms.ffi_assets.update', compact('issues', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $issues = $this->model()->findOrFail($id);
        $validatedData = $request->validate([
            'employee_id' => 'required',
            'asset_name' => 'required|string|max:128',
            'asset_code' => 'required|string|max:128',
            'issued_date' => 'required|date',
            'returned_date' => 'nullable|date',
            'damage_recover' => 'nullable|string',
            'status' => 'required|integer',

        ]);
        DB::beginTransaction();
        try {
            $issues->fill($validatedData);
            $issues->save();

            DB::commit();
            return redirect()->route('admin.fcms.ffi_assets')->with('success', 'FFI Assets updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function destroy($id)
    {
        $this->model()->destroy($id);
        return redirect()->route('admin.fcms.ffi_assets')->with('success', 'FFI Assets data has been successfully deleted!');
    }
    public function bulk(Request $request)
    {
        $type = $request->type;
        $selectedItems = $request->selectedIds;
        $status = $request->status;

        foreach ($selectedItems as $item) {
            $employee = $this->model()->find($item);
            if ($type == 1) {
                $employee->delete();
            } else if ($type == 2) {
                $employee->update(['status' => $status]);
            }
        }
        return response()->json(['success' => true, 'message' => 'Bulk operation is completed']);
    }
    public function export(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $query = $this->model()->with('assets');
        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        $issues = $query->get();

        return Excel::download(new FFIAssetExport($issues), 'ffi_assets.xlsx');
    }

}
