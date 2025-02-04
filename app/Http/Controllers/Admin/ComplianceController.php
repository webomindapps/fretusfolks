<?php

namespace App\Http\Controllers\Admin;

use App\Models\CFISModel;
use App\Models\DCSChildren;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ComplianceController extends Controller
{
    public function model()
    {
        return new CFISModel();
    }
    public function index()
    {
        $searchColumns = ['id', 'client_id', 'emp_name', 'phone1'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        // $query = $this->model()->query()->where('data_status', 1);


        $query = $this->model()->query()
            ->where('hr_approval', 1);



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
        // dd($candidate);
        return view('admin.adms.compliance.compliance', compact("candidate"));
    }
    public function viewdetail($id)
    {

        // $education = FFIEducationModel::where('emp_id', $id)->get();
        $children = DCSChildren::where('emp_id', $id)->get();
        $candidate = $this->model()
            ->with(['client'])
            ->with(['educationCertificates', 'otherCertificates', 'candidateDocuments'])
            ->findOrFail($id);
        $htmlContent = view('admin.adms.compliance.view', compact('candidate', 'children'))->render();
        return response()->json(['html_content' => $htmlContent]);

    }
}
