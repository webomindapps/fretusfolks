<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CFISModel;
use App\Models\IncrementLetter;
use App\Models\LetterContent;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdmsIncrementLetterController extends Controller
{

    public function model()
    {
        return new IncrementLetter();
    }
    public function index()
    {

        $searchColumns = ['id', 'employee_id', 'emp_name'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->model()->with('incrementdata');

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

        $increment = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());

        return view("admin.adms.increment_letter.index", compact("increment"));
    }

    public function create()
    {
        $content = LetterContent::where('type', 1)->first();
        return view('admin.adms.increment_letter.create', compact('content'));
    }

    public function details(Request $request)
    {
        $increment = CFISModel::where('ffi_emp_id', $request->ffi_emp_id)->first();

        if ($increment) {
            return response()->json([
                'success' => true,
                'data' => [
                    'emp_name' => $increment->emp_name,
                    'designation' => $increment->designation,
                    'department' => $increment->department,
                    'location' => $increment->location,
                    'basic_salary' => $increment->basic_salary,
                    'hra' => $increment->hra,
                    'pt' => $increment->pt,
                    'lwf' => $increment->lwf,
                    'conveyance' => $increment->conveyance,
                    'medical_reimbursement' => $increment->medical_reimbursement,
                    'special_allowance' => $increment->special_allowance,
                    'other_allowance' => $increment->other_allowance,
                    'st_bonus' => $increment->st_bonus,
                    'gross_salary' => $increment->gross_salary,
                    'pf_percentage' => $increment->pf_percentage,
                    'take_home' => $increment->take_home,
                    'emp_pf' => $increment->emp_pf,
                    'employer_esic' => $increment->employer_esic,
                    'employer_esic_percentage' => $increment->employer_esic_percentage,
                    'mediclaim' => $increment->mediclaim,
                    'ctc' => $increment->ctc,
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Employee not found.',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'ffi_emp_id' => 'required',
            'offer_letter_type' => 'nullable|string|max:255',
            'status' => 'nullable|string',
            'basic_salary' => 'required|numeric|min:0',
            'hra' => 'required|numeric|min:0',
            'conveyance' => 'required|numeric|min:0',
            'medical_reimbursement' => 'required|numeric|min:0',
            'special_allowance' => 'required|numeric|min:0',
            'other_allowance' => 'nullable|numeric|min:0',
            'st_bonus' => 'nullable|numeric|min:0',
            'pf_percentage' => 'required|numeric|min:0|max:100',
            'emp_pf' => 'nullable|numeric|min:0',
            'esic_percentage' => 'required|numeric|min:0|max:100',
            'gross_salary' => 'nullable|numeric|min:0',
            'emp_esic' => 'nullable|numeric|min:0',
            'pt' => 'required|numeric|min:0',
            'lwf' => 'required|numeric|min:0',
            'total_deduction' => 'nullable|numeric|min:0',
            'employer_pf_percentage' => 'required|numeric|min:0|max:100',
            'employer_pf' => 'nullable|numeric|min:0',
            'employer_esic_percentage' => 'required|numeric|min:0|max:100',
            'employer_esic' => 'nullable|numeric|min:0',
            'mediclaim' => 'required|numeric|min:0',
            'ctc' => 'nullable|numeric|min:0',
            'content' => 'required|string',
            'employee_id' => 'nullable',
        ]);

        DB::beginTransaction();
        try {
            // Fetch CFIS record
            $cfis = CFISModel::where('ffi_emp_id', $request->ffi_emp_id)->first();

            if (!$cfis) {
                return back()->with('error', 'CFIS record not found.');
            }

            // Create Increment Letter
            $increment = $this->model()->create([
                'company_id' => $cfis->client_id,
                'employee_id' => $request->ffi_emp_id,
                'date' => now(),
                'offer_letter_type' => "1",
                'status' => '1',
                'content' => $request->content,
                'basic_salary' => $request->basic_salary,
                'hra' => $request->hra,
                'conveyance' => $request->conveyance,
                'medical_reimbursement' => $request->medical_reimbursement,
                'special_allowance' => $request->special_allowance,
                'Increment_Percentage' => '1',
                'other_allowance' => $request->other_allowance,
                'st_bonus' => $request->st_bonus,
                'take_home' => $request->take_home,
                'designation' => $request->designation,
                'old_ctc' => $cfis->ctc,
                'old_designation' => $cfis->designation,
                'effective_date' => now(),
                'pf_percentage' => $request->pf_percentage,
                'emp_pf' => $request->emp_pf,
                'esic_percentage' => $request->esic_percentage,
                'gross_salary' => $request->gross_salary,
                'emp_esic' => $request->emp_esic,
                'pt' => $request->pt,
                'lwf' => $request->lwf,
                'total_deduction' => $request->total_deduction,
                'employer_pf_percentage' => $request->employer_pf_percentage,
                'employer_pf' => $request->employer_pf,
                'employer_esic_percentage' => $request->employer_esic_percentage,
                'employer_esic' => $request->employer_esic,
                'mediclaim' => $request->mediclaim,
                'ctc' => $request->ctc,
                'emp_name' => $request->emp_name,
            ]);
            $pdf = Pdf::loadView('admin.adms.increment_letter.format', ['increment' => $increment]);

            $fileName = 'increment_letter_' . $increment->id . '.pdf';
            $filePath = 'incrementletter/' . $fileName;

            Storage::disk('public')->put($filePath, $pdf->output());

            $increment->update([
                'increment_path' => $filePath
            ]);

            // Update CFIS Table if Record Exists
            $cfis->update([
                'basic_salary' => $request->basic_salary,
                'hra' => $request->hra,
                'conveyance' => $request->conveyance,
                'medical_reimbursement' => $request->medical_reimbursement,
                'special_allowance' => $request->special_allowance,
                'other_allowance' => $request->other_allowance,
                'st_bonus' => $request->st_bonus,
                'pf_percentage' => $request->pf_percentage,
                'emp_pf' => $request->emp_pf,
                'esic_percentage' => $request->esic_percentage,
                'gross_salary' => $request->gross_salary,
                'emp_esic' => $request->emp_esic,
                'pt' => $request->pt,
                'lwf' => $request->lwf,
                'total_deduction' => $request->total_deduction,
                'employer_pf_percentage' => $request->employer_pf_percentage,
                'employer_pf' => $request->employer_pf,
                'employer_esic_percentage' => $request->employer_esic_percentage,
                'employer_esic' => $request->employer_esic,
                'mediclaim' => $request->mediclaim,
                'ctc' => $request->ctc,
            ]);

            DB::commit();
            return redirect()->route('admin.increment_letter')->with('success', 'Increment Letter has been Created!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function viewpdf($id)
    {
        $increment = $this->model()->findOrFail($id);

        if (!empty($increment->increment_path)) {
            $filePath = storage_path('app/public/' . str_replace('storage/', '', $increment->increment_path));

            if (file_exists($filePath)) {
                return response()->file($filePath);
            }
        }
        $data = ['increment' => $increment];

        $pdf = PDF::loadView('admin.adms.increment_letter.format', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->stream("increment_{$increment->emp_id}_{$increment->month}_{$increment->year}.pdf");
    }
    public function destroy($id)
    {
        $increment = $this->model()->find($id);
        if ($increment && $increment->increment_path) {
            Storage::disk('public')->delete($increment->increment_path);
        }
        $increment->delete();
        return redirect()->route('admin.increment_letter')->with('success', 'Increment Letter has been deleted');
    }
}
