<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\FHRMSModel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\FFIPipLetterModel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class FFIPipLetterController extends Controller
{
    public function model()
    {
        return new FFIPipLetterModel();
    }
    public function index()
    {
        $searchColumns = ['id', 'date', 'emp_id'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->model()->with('pip_letter');

        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        if ($search != '') {
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) {
                    $key == 0 ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                }
            });
        }

        if ($order == '') {
            $query->orderByDesc('id');
        } else {
            $query->orderBy($order, $orderBy);
        }

        $pip = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());

        return view("admin.hr_management.ffi.pip_letter.index", compact("pip"));
    }
    public function create()
    {
        return view("admin.hr_management.ffi.pip_letter.create");
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ffi_emp_id' => 'required',
            'status' => 'nullable|string',
            'from_name' => 'required|string',
            'emp_id' => 'nullable',
            'date' => 'required|date',
            'content' => 'required|string',
            'observation' => 'required|string',
            'goals' => 'required|string',
            'updates' => 'required|string',
            'timeline' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            $warning = $this->model()->create($validatedData);
            $warning->emp_id = $request->ffi_emp_id;
            $warning->date_of_update = now();
            $warning->status = '1';
            $warning->save();

            DB::commit();
            return redirect()->route('admin.ffi_pip_letter')->with('success', 'Pip Letter has been Created!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function getEmployeeDetails(Request $request)
    {
        $pip_letter = FHRMSModel::where('ffi_emp_id', $request->ffi_emp_id)->first();

        if ($pip_letter) {
            return response()->json([
                'success' => true,
                'data' => [
                    'emp_name' => $pip_letter->emp_name,
                    'designation' => $pip_letter->designation,
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Employee not found.',
        ]);
    }
    public function edit($id)
    {
        $pip = $this->model()->with('pip_letter')->findOrFail($id);
        return view('admin.hr_management.ffi.pip_letter.update', compact('pip'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'ffi_emp_id' => 'required',
            'status' => 'nullable|string',
            'from_name' => 'required|string',
            'emp_id' => 'nullable',
            'date' => 'required|date',
            'content' => 'required|string',
            'observation' => 'required|string',
            'goals' => 'required|string',
            'updates' => 'required|string',
            'timeline' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $show = $this->model()->findOrFail($id);
            $show->update($validatedData);
            $show->emp_id = $request->ffi_emp_id;
            $show->date_of_update = now();
            $show->status = '1';
            $show->save();

            DB::commit();
            return redirect()->route('admin.ffi_pip_letter')->with('success', 'Pip Letter details have been updated!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function destroy($id)
    {
        $this->model()->destroy($id);
        return redirect()->route('admin.ffi_pip_letter')->with('success', 'Successfully deleted!');
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
    public function generatePipPdf($id)
    {
        $pipLetter = $this->model()->with('pip_letter')->findOrFail($id);

        $data = [
            'pipLetter' => $pipLetter,
        ];

        $pdf = PDF::loadView('admin.hr_management.ffi.pip_letter.print_pip', $data)
            ->setPaper('A4', 'portrait')
            ->setOptions(['margin-top' => 10, 'margin-bottom' => 10, 'margin-left' => 15, 'margin-right' => 15]);


        return $pdf->stream('pip_letter_' . $pipLetter->id . '.pdf');
    }
}
