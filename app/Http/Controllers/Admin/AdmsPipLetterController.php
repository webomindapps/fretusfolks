<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CFISModel;
use App\Models\PipLetter;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdmsPipLetterController extends Controller
{
    public function model()
    {
        return new PipLetter();
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

        $query = $this->model()->with('pip_letters');

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

        return view('admin.adms.pip_letter.index', compact('pip'));
    }

    public function create()
    {
        return view('admin.adms.pip_letter.create');
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
            // 'ffi_emp_id' => 'required',
            'status' => 'nullable|string',
            'emp_id' => 'nullable',
            'date' => 'required|date',
            'observation' => 'required|string',
            'goals' => 'required|string',
            'updates' => 'required|string',
            'timeline' => 'required|string',

        ]);
        DB::beginTransaction();
        try {
            $pipLetter = $this->model()->create([
                'from_name' => $request->from_name,
                'emp_id' => $request->emp_id,
                'status' => '1',
                'date' => $request->date,
                'content' => $request->content,
                'date_of_update' => now(),
                'observation' => $request->observation,
                'goals' => $request->goals,
                'updates' => $request->updates,
                'timeline' => $request->timeline,

            ]);
            $pdf = Pdf::loadView('admin.adms.pip_letter.format', ['pipLetter' => $pipLetter]);

            $fileName = 'pip_letter' . $pipLetter->id . '.pdf';
            $filePath = 'pip_letter/' . $fileName;

            Storage::disk('public')->put($filePath, $pdf->output());

            $pipLetter->update([
                'pip_letter_path' => $filePath
            ]);


            DB::commit();
            return redirect()->route('admin.pip_letter')->with('success', 'Pip Letter has been Created!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function viewpdf($id)
    {
        $pip = $this->model()->findOrFail($id);

        if (!$pip->pip_letter_path) {
            abort(404, 'PDF not found');
        }

        $filePath = str_replace('storage/', '', $pip->pip_letter_path);

        return response()->file(storage_path('app/public/' . $filePath));
    }
    public function edit($id)
    {
        $pip = $this->model()->findOrFail($id);
        return view('admin.adms.pip_letter.update', compact('pip'));
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
            $pipLetter  = $this->model()->findOrFail($id);

            if ($pipLetter->termination_letter_path && Storage::disk('public')->exists($pipLetter->termination_letter_path)) {
                Storage::disk('public')->delete($pipLetter->termination_letter_path);
            }

            $pipLetter->update([
                'from_name' => $request->from_name,
                'emp_id' => $request->emp_id,
                'status' => '1',
                'date' => $request->date,
                'content' => $request->content,
                'date_of_update' => now(),
                'observation' => $request->observation,
                'goals' => $request->goals,
                'updates' => $request->updates,
                'timeline' => $request->timeline,
            ]);
            $pdf = Pdf::loadView('admin.adms.pip_letter.format', ['pipLetter' => $pipLetter]);

            $fileName = 'pip_letter' . $pipLetter->id . '.pdf';
            $filePath = 'pip_letter/' . $fileName;

            Storage::disk('public')->put($filePath, $pdf->output());

            $pipLetter->update([
                'pip_letter_path' => $filePath
            ]);

            DB::commit();
            return redirect()->route('admin.pip_letter')->with('success', 'Pip  Letter has been Updated!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function delete($id)
    {
        $pip = $this->model()->findOrFail($id);

        if ($pip && $pip->pip_letter_path) {
            Storage::disk('public')->delete($pip->pip_letter_path);
        }
        $pip->delete();
        return redirect()->route('admin.pip_letter')->with('success', 'Pip Letter has been deleted');
    }
}
