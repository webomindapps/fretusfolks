<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\OtherPayslip;
use Illuminate\Http\Request;
use App\Models\ClientManagement;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class OtherPayslipController extends Controller
{
    public function model()
    {
        return new OtherPayslip;
    }

    public function index()
    {
        $client_id = request()->client_id;
        $month = request()->month;
        $year = request()->year;
        $ffi_emp_id = request()->ffi_emp_id;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        if (!$client_id && !$month && !$year && !$ffi_emp_id) {
            $challans = new LengthAwarePaginator([], 0, 10);

        } else {
            $query = $this->model()->query();

            if ($client_id) {
                $query->where('client_id', $client_id);
            }
            if ($ffi_emp_id) {
                $query->where('ffi_emp_id', $ffi_emp_id);
            }
            if ($month) {
                $query->where('month', $month);
            }
            if ($year) {
                $query->where('year', $year);
            }

            $challans = $query->paginate();
        }
        $clients = ClientManagement::where('status', 0)->latest()->get();
        return view("admin.adms.other_payslip.index", compact("challans", "clients"));
    }
    public function create()
    {
        $clients = ClientManagement::where('status', 0)->latest()->get();
        return view("admin.adms.other_payslip.create", compact('clients'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'state_id' => 'required',
        ]);
        DB::beginTransaction();
        try {
            foreach ($request->years as $key => $year) {
                $filePath = null;
                if ($request->hasFile("files.{$key}")) {
                    $folder = 'other_payslips';
                    $file = $request->file("files.{$key}");
                    $fileName = time() . '-' . $file->getClientOriginalName();
                    $filePath = $file->storeAs($folder, $fileName, 'public');
                }
                if ($year != "" && $year) {
                    $this->model()->create([
                        'client_id' => $request->client_id,
                        'state_id' => $request->state_id,
                        'ffi_emp_id' => $request->ffi_emp_id,
                        'year' => $year,
                        'status' => 0,
                        'month' => $request->months[$key],
                        'path' => $filePath
                    ]);
                }
            }
            DB::commit();
            return to_route('admin.other_payslips')->with('success', 'Added successfully');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function destroy($id)
    {
        $this->model()->destroy($id);
        return back()->with('success', 'Other Payslip removed successfully');
    }
}
