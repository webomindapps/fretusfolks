<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\FFCMModel;
use App\Exports\FFCMExport;
use Illuminate\Http\Request;
use App\Exports\FFCMReportExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class FFCMController extends Controller
{
    public function model()
    {
        return new FFCMModel();
    }
    public function index()
    {
        $searchColumns = ['id', 'date', 'nature_expenses', 'month', 'amount'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;
        $month = request()->month;
        $year = request()->year;

        $query = $this->model()->query();

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

        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $expenses = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(100)->appends(request()->query());

        return view("admin.fcms.ffcm.index", compact("expenses"));
    }
    public function create()
    {
        return view('admin.fcms.ffcm.create');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'month' => 'required|integer|between:1,12',
            'nature_expenses' => 'required|string|max:256',
            'amount' => 'required|numeric|min:0',
            'status' => 'nullable|string',
        ]);


        DB::beginTransaction();
        try {
            $expenses = $this->model()->create($validatedData);
            $expenses->save();
            DB::commit();
            return redirect()->route('admin.fcms.ffcm')->with('success', 'Expense created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function edit($id)
    {
        $expenses = $this->model()->findOrFail($id); // Replace `YourModel` with your actual model
        return view('admin.fcms.ffcm.update', compact('expenses'));
    }

    public function update(Request $request, $id)
    {
        $expenses = $this->model()->findOrFail($id);
        $validatedData = $request->validate([
            'date' => 'required|date',
            'month' => 'required|integer|between:1,12',
            'nature_expenses' => 'required|string|max:256',
            'amount' => 'required|numeric|min:0',
        ]);
        DB::beginTransaction();
        try {
            $expenses->fill($validatedData);
            $expenses->save();

            DB::commit();
            return redirect()->route('admin.fcms.ffcm')->with('success', 'Expense updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function destroy($id)
    {
        $this->model()->destroy($id);
        return redirect()->route('admin.fcms.ffcm')->with('success', 'Expense data has been successfully deleted!');
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
        $query = $this->model();
        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        $expenses = $query->get();

        return Excel::download(new FFCMExport($expenses), 'ffcm.xlsx');
    }

    public function ffcmReports(Request $request)
    {
        $request->validate([
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            'data' => 'nullable|array',
            'per_page' => 'nullable|integer|min:1',
        ]);

        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $selectedData = $request->input('data', []);
        $perPage = $request->input('per_page', 10);

        $query = $this->model()->query();

        if ($fromDate && $toDate) {
            $query->whereBetween('date', [$fromDate, $toDate]);
        }

        if (!empty($selectedData)) {
            foreach ($selectedData as $filter) {
                switch ($filter) {
                    case 'date':
                        $query->whereNotNull('date');
                        break;
                    case 'month':
                        $query->whereNotNull('month');
                        break;
                    case 'amount':
                        $query->whereNotNull('amount');
                        break;
                    case 'nature_expenses':
                        $query->whereNotNull('nature_expenses');
                        break;
                    default:
                        break;
                }
            }
        }
        $results = $query->paginate($perPage)->appends($request->query());

        return view('admin.fcms.ffcm_reports.index', compact(
            'results',
            'fromDate',
            'toDate',
            'selectedData'
        ));
    }
    public function exportReport(Request $request)
    {
        $fields = explode(',', $request->input('fields'));
        if (empty($fields)) {
            return redirect()->route('admin.fcms.ffcm_report')->with('error', 'No fields selected for export');
        }

        return Excel::download(new FFCMReportExport($fields), 'ffcmreport.xlsx');
    }
}
