<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\CFISModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ShowcauseLetter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Imports\ADMSShowCauseImport;
use Illuminate\Support\Facades\Storage;

class AdmsShowcauseLetterController extends Controller
{
    public function model()
    {
        return new ShowcauseLetter();
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

        $query = $this->model()->with('showcauseletter');

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

        $showcause = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(100)->appends(request()->query());
        return view('admin.adms.showcause_letter.index', compact('showcause'));
    }
    public function create()
    {
        return view('admin.adms.showcause_letter.create');
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
            $showLetter = $this->model()->create([
                'emp_id' => $request->emp_id,
                'status' => '1',
                'date' => $request->date,
                'content' => $request->content,
                'date_of_update' => now(),
            ]);
            $pdf = Pdf::loadView('admin.adms.showcause_letter.format', ['showLetter' => $showLetter]);

            $fileName = 'showcase_letter' . $showLetter->id . '.pdf';
            $filePath = 'showcase_letter/' . $fileName;

            Storage::disk('public')->put($filePath, $pdf->output());

            $showLetter->update([
                'showcause_letter_path' => $filePath
            ]);


            DB::commit();
            return redirect()->route('admin.showcause_letter')->with('success', 'ShowCause Letter has been Created!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function viewpdf($id)
    {
        $showcause = $this->model()->findOrFail($id);

        if (!empty($showcause->showcause_letter_path)) {
            $filePath = storage_path('app/public/' . str_replace('storage/', '', $showcause->showcause_letter_path));

            if (file_exists($filePath)) {
                return response()->file($filePath);
            }
        }
        $data = ['showLetter' => $showcause];

        $pdf = PDF::loadView('admin.adms.showcause_letter.format', $data)
            ->setPaper('A4', 'portrait');


        return $pdf->stream("Showcause_Cause_Letter{$showcause->emp_id}.pdf");
    }

    public function edit($id)
    {
        $showcause = $this->model()->findOrFail($id);
        return view('admin.adms.showcause_letter.update', compact('showcause'));
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
            $showLetter = $this->model()->findOrFail($id);

            if ($showLetter->showcause_letter_path && Storage::disk('public')->exists($showLetter->showcause_letter_path)) {
                Storage::disk('public')->delete($showLetter->showcause_letter_path);
            }

            $showLetter->update([
                'emp_id' => $request->emp_id,
                'status' => '1',
                'date' => $request->date,
                'content' => $request->content,
                'date_of_update' => now(),
            ]);
            $pdf = Pdf::loadView('admin.adms.showcause_letter.format', ['showLetter' => $showLetter]);

            $fileName = 'showcase_letter' . $showLetter->id . '.pdf';
            $filePath = 'showcase_letter/' . $fileName;

            Storage::disk('public')->put($filePath, $pdf->output());

            $showLetter->update([
                'showcause_letter_path' => $filePath
            ]);

            DB::commit();
            return redirect()->route('admin.showcause_letter')->with('success', 'ShowCause Letter has been Updated!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function delete($id)
    {
        $showcause = $this->model()->findOrFail($id);
        if ($showcause && $showcause->showcause_letter_path) {
            Storage::disk('public')->delete($showcause->showcause_letter_path);
        }
        $showcause->delete();
        return redirect()->route('admin.showcause_letter')->with('success', 'ShowCause Letter has Been Deleted');
    }

    public function bulkUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,txt',
        ]);
        // dd($request->all());
        $file = $request->file('file');

        try {
            if ($request->has('file')) {
                // dd($request->file);
                $fileName = $request->file->getClientOriginalName();
                $fileWithPath = public_path('uploads') . '/' . $fileName;
                // dd($fileWithPath);
                if (!file_exists($fileWithPath)) {
                    $request->file->move(public_path('uploads'), $fileName);
                }
                // dd($fileWithPath);
                Excel::import(new ADMSShowCauseImport(), $fileWithPath);
                if (file_exists($fileWithPath)) {
                    unlink($fileWithPath);
                }
            }
        } catch (Exception $e) {
            dd($e);
        }
        $error = '';
        return redirect()->route('admin.showcause_letter')->with([
            'success' => 'Show Cause Letter added successfully',
            'alert' => $error
        ]);
    }
}
