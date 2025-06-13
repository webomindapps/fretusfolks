<?php

namespace App\Http\Controllers;

use App\Models\BankDetails;
use App\Models\CFISModel;
use Illuminate\Http\Request;

class ComplainceBankAccountController extends Controller
{
    public function model()
    {
        return new BankDetails();
    }
    public function index()
    {
        $searchColumns = ['id', 'bank_name', 'bank_account_no', 'bank_ifsc_code']; // Adjust column names as per your database
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate ?? 10;

        $cfisExists = CFISModel::where('hr_approval', 1)
            ->where('comp_status', 0)
            ->exists();

        $query = $this->model()->where('status', 1)->with('clients');

        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) {
                    ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                }
            });
        }

        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $pendingbank = $cfisExists ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());

        return view('admin.adms.compliance.pending-bank_account.index', compact('pendingbank'));
    }
    public function edit($id)
    {
        $bankdetails = $this->model()->find($id);
        return view('admin.adms.compliance.pending-bank_account.edit', compact('bankdetails'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'bank_account_no' => 'required|string|max:50',
            'bank_ifsc_code' => 'required|string|max:20',
            'bank_status' => 'required',
        ]);

        $bankDetails = BankDetails::find($id);

        if (!$bankDetails) {
            return redirect()->back()->with('error', 'Bank details not found.');
        }

        $filePath = $bankDetails->bank_document;
        if ($request->hasFile('bank_document')) {
            $file = $request->file('bank_document');
            $fileName = 'bank_document_' . $bankDetails->emp_id . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('documents/bank', $fileName, 'public');
        }
        if ($request->bank_ststus == 1) {
            BankDetails::where('emp_id', $bankDetails->emp_id)
                ->where('id', '!=', $id) // Exclude the current record
                ->update(['status' => 0]);
        }
        $bankDetails->update([
            'bank_name' => $request->bank_name,
            'bank_account_no' => $request->bank_account_no,
            'bank_ifsc_code' => $request->bank_ifsc_code,
            'bank_document' => $filePath,
            'bank_status' => $request->bank_status,
        ]);

        return redirect()->route('admin.pendingbankapprovals')->with('success', 'Successfully updated!');
    }
}
