<?php

namespace App\Http\Controllers\Admin;

use App\Models\CFISModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class DCSApprovalController extends Controller
{
    public function model()
    {
        return new CFISModel();
    }
    public function index()
    {
        $searchColumns = ['id', 'client_name', 'emp_name', 'phone1'];
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
                foreach ($searchColumns as $key => $value)
                    ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $candidate = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());

        return view("admin.adms.dcs_approval.index", compact("candidate"));
    }
    public function edit($id)
    {
        $lastId = $this->model()->where('ffi_emp_id', 'LIKE', 'FFIFC%')
            ->orderBy('ffi_emp_id', 'desc')
            ->value('ffi_emp_id');

        if ($lastId) {
            $number = (int) substr($lastId, 5);
            $newNumber = str_pad($number + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        $uniqueId = 'FFIFC' . $newNumber;
        $candidate = $this->model()->find($id);
        return view('admin.adms.dcs_approval.edit', compact('candidate', 'uniqueId'));

    }
    public function update(Request $request, $id)
    {
        $candidate = $this->model()->find($id);
        $candidate->update($request->all());
        return redirect()->route('dcs_approval.index')->with('success', 'Candidate updated successfully');

    }
    //pending update 
    public function destroy($id)
    {
        $this->model()->destroy($id);
        return redirect()->route('admin.dcs_approval')->with('success', 'Candidate data has been successfully deleted!');
    }
}
