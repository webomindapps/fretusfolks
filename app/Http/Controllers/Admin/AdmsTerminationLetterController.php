<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CFISModel;
use App\Models\TerminationLetter;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdmsTerminationLetterController extends Controller
{
    public function model()
    {
        return new TerminationLetter();
    }
    public function index()
    {
        $searchColumns = ['id', 'emp_id', 'date'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->model()->with('term_letter');

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

        $termination = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());
        return view('admin.adms.termination_letter.index', compact('termination'));
    }

    public function create()
    {
        return view('admin.adms.termination_letter.create');
    }
    public function details(Request $request)
    {
        $warning_letter = CFISModel::where('ffi_emp_id', $request->emp_id)->first();

        if ($warning_letter) {
            return response()->json([
                'success' => true,
                'data' => [
                    'emp_name' => $warning_letter->emp_name,
                    'designation' => $warning_letter->designation,
                ],
            ]);
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'emp_id' => 'required',
            'status' => 'nullable|string',
            'date' => 'required|date',

        ]);
        DB::beginTransaction();
        try {
            $termLetter = $this->model()->create([
                'emp_id' => $request->emp_id,
                'status' => '1',
                'absent_date' => $request->absent_date,
                'show_cause_date' => $request->show_cause_date,
                'termination_date' => $request->termination_date,
                'date' => $request->date,
                'content' => $request->content,
                'date_of_update' => now(),
            ]);
            $pdf = Pdf::loadView('admin.adms.termination_letter.format', ['termLetter' => $termLetter]);

            $fileName = 'termination_letter' . $termLetter->id . '.pdf';
            $filePath = 'termination_letter/' . $fileName;

            Storage::disk('public')->put($filePath, $pdf->output());

            $termLetter->update([
                'termination_letter_path' => $filePath
            ]);


            DB::commit();
            return redirect()->route('admin.termination_letter')->with('success', 'termination Letter has been Created!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function viewpdf($id)
    {
        $termination = $this->model()->findOrFail($id);
    
        if (!empty($termination->termination_letter_path)) {
            $filePath = storage_path('app/public/' . str_replace('storage/', '', $termination->termination_letter_path));
    
            if (file_exists($filePath)) {
                return response()->file($filePath);
            }
        }
    
        $data = ['termLetter' => $termination];
    
        $pdf = PDF::loadView('admin.adms.termination_letter.format', $data)
            ->setPaper('A4', 'portrait');
            
        return $pdf->stream("termination_{$termination->emp_id}_{$termination->month}_{$termination->year}.pdf");
    }
    
    public function edit($id)
    {
        $termination = $this->model()->findOrFail($id);
        return view('admin.adms.termination_letter.update', compact('termination'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'emp_id' => 'required',
            'status' => 'nullable|string',
            'date' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            $termLetter  = $this->model()->findOrFail($id);

            if ($termLetter->termination_letter_path && Storage::disk('public')->exists($termLetter->termination_letter_path)) {
                Storage::disk('public')->delete($termLetter->termination_letter_path);
            }

            $termLetter->update([
                'emp_id' => $request->emp_id,
                'status' => '1',
                'absent_date' => $request->absent_date,
                'show_cause_date' => $request->show_cause_date,
                'termination_date' => $request->termination_date,
                'date' => $request->date,
                'content' => $request->content,
                'date_of_update' => now(),
            ]);
            $pdf = Pdf::loadView('admin.adms.termination_letter.format', ['termLetter' => $termLetter]);

            $fileName = 'termination_letter' . $termLetter->id . '.pdf';
            $filePath = 'termination_letter/' . $fileName;

            Storage::disk('public')->put($filePath, $pdf->output());

            $termLetter->update([
                'termination_letter_path' => $filePath
            ]);

            DB::commit();
            return redirect()->route('admin.termination_letter')->with('success', 'Termination Letter has been Updated!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function delete($id)
    {
        $termination = $this->model()->findOrFail($id);
        if ($termination && $termination->termination_letter_path) {
            Storage::disk('public')->delete($termination->termination_letter_path);
        }
        $termination->delete();
        return redirect()->route('admin.termination_letter')->with('success', 'Termination Letter has been deleted');
    }
}
