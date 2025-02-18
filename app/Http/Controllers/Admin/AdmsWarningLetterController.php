<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CFISModel;
use App\Models\WarningLetter;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdmsWarningLetterController extends Controller
{
    public function model()
    {
        return new WarningLetter();
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

        $query = $this->model()->with('warningletter');

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

        $warning = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());
        return view('admin.adms.warning_letter.index', compact('warning'));
    }

    public function create()
    {
        return view('admin.adms.warning_letter.create');
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
            'content' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            $warning = $this->model()->create([
                'emp_id' => $request->emp_id,
                'status' => '1',
                'date' => $request->date,
                'content' => $request->content,
                'date_of_update' => now(),
            ]);
            $pdf = Pdf::loadView('admin.adms.warning_letter.format', ['warning' => $warning]);

            $fileName = 'warning_letter' . $warning->id . '.pdf';
            $filePath = 'warning_letter/' . $fileName;

            Storage::disk('public')->put($filePath, $pdf->output());

            $warning->update([
                'warning_letter_path' => $filePath
            ]);


            DB::commit();
            return redirect()->route('admin.warning_letter')->with('success', 'Warning Letter has been Created!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function viewpdf($id)
    {
        $warning = $this->model()->findOrFail($id);

        if (!$warning->warning_letter_path) {
            abort(404, 'PDF not found');
        }

        $filePath = str_replace('storage/', '', $warning->warning_letter_path);

        return response()->file(storage_path('app/public/' . $filePath));
    }
    public function edit($id)
    {
        $warning = $this->model()->findOrFail($id);
        return view('admin.adms.warning_letter.update', compact('warning'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'emp_id' => 'required',
            'status' => 'nullable|string',
            'date' => 'required|date',
            'content' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $warning = $this->model()->findOrFail($id);

            if ($warning->warning_letter_path && Storage::disk('public')->exists($warning->warning_letter_path)) {
                Storage::disk('public')->delete($warning->warning_letter_path);
            }

            $warning->update([
                'emp_id' => $request->emp_id,
                'status' => '1',
                'date' => $request->date,
                'content' => $request->content,
                'date_of_update' => now(),
            ]);

            $pdf = Pdf::loadView('admin.adms.warning_letter.format', ['warning' => $warning]);

            $fileName = 'warning_letter' . $warning->id . '.pdf';
            $filePath = 'warning_letter/' . $fileName;

            Storage::disk('public')->put($filePath, $pdf->output());

            $warning->update([
                'warning_letter_path' => $filePath
            ]);

            DB::commit();
            return redirect()->route('admin.warning_letter')->with('success', 'Warning Letter has been Updated!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function delete($id)
    {
        $warning = $this->model()->findOrFail($id);
        if ($warning && $warning->warning_letter_path) {
            Storage::disk('public')->delete($warning->warning_letter_path);
        }
        $warning->delete();
        return redirect()->route('admin.warning_letter')->with('success', 'Warning Letter has been deleted');
    }
}
