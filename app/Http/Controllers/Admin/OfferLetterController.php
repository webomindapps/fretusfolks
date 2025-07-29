<?php

namespace App\Http\Controllers\Admin;

// use Barryvdh\DomPDF\PDF;
use Exception;
use App\Models\CFISModel;
use App\Models\OfferLetter;
use Illuminate\Http\Request;
use App\Models\LetterContent;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Imports\ADMSOfferImport;
use App\Models\ClientManagement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Jobs\GenerateOfferLetterZip;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class OfferLetterController extends Controller
{
    public function model()
    {
        return new OfferLetter();
    }

    public function index()
    {
        $searchColumns = ['id', 'employee_id', 'emp_name', 'entity_name', 'date', 'phone1', 'email', 'employee.client_emp_id'];
        $search = request()->search;
        $from_date = request()->from_date;
        $to_date = request()->to_date;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->model()->with('employee');

        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        if ($search != '') {
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) {
                    if ($value === 'employee.client_emp_id') {
                        $q->orWhereHas('employee', function ($subQuery) use ($search) {
                            $subQuery->where('client_emp_id', 'LIKE', '%' . $search . '%');
                        });
                    } else {
                        $key == 0
                            ? $q->where($value, 'LIKE', '%' . $search . '%')
                            : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                    }
                }
            });
        }


        if ($order == '') {
            $query->orderByDesc('id');
        } else {
            $query->orderBy($order, $orderBy);
        }
        $clients = ClientManagement::get();
        $offer = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(100)->appends(request()->query());

        return view("admin.adms.offer_letter.index", compact("offer", "clients"));
    }
    public function edit($id)
    {
        $employee = $this->model()->findOrFail($id);
        return view("admin.adms.offer_letter.edit", compact('employee'));
    }
    public function generateOfferLetterPdf($id)
    {
        $offerLetter = $this->model()->with('employee')->findOrFail($id);

        // Return existing file if already generated
        if (!empty($offerLetter->offer_letter_path)) {
            $filePath = storage_path('app/public/' . str_replace('storage/', '', $offerLetter->offer_letter_path));

            if (file_exists($filePath)) {
                return response()->file($filePath);
            }
        }

        // View mapping based on offer_letter_type
        $viewMap = [
            1 => 'admin.adms.offer_letter.format1',
            2 => 'admin.adms.offer_letter.format2',
            3 => 'admin.adms.offer_letter.format3',
            4 => 'admin.adms.offer_letter.format4',
            5 => 'admin.adms.offer_letter.format5',
        ];

        $view = $viewMap[$offerLetter->offer_letter_type] ?? 'admin.adms.offer_letter.format1';

        $data = ['offerLetter' => $offerLetter];

        $pdf = PDF::loadView($view, $data)->setPaper('A4', 'portrait');

        return $pdf->stream("Offer_Letter_{$offerLetter->employee_id}.pdf");
    }


    public function destroy($id)
    {
        $this->model()->destroy($id);
        return redirect()->route('admin.offer_letter')->with('success', 'Successfully deleted!');
    }
    public function create()
    {
        $content = LetterContent::where('type', 1)->first();
        return view('admin.adms.offer_letter.create', compact('content'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company_id' => 'required|integer',
            'employee_id' => 'required|string',
            'emp_name' => 'required|string|max:255',
            'phone1' => 'nullable|string|max:20',
            'entity_name' => 'nullable|string|max:255',
            'joining_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'tenure_month' => 'nullable|integer',
            'offer_letter_type' => 'required|integer',
            'status' => 'nullable|string|max:50',
            'basic_salary' => 'nullable|numeric',
            'hra' => 'nullable|numeric',
            'conveyance' => 'nullable|numeric',
            'medical_reimbursement' => 'nullable|numeric',
            'special_allowance' => 'nullable|numeric',
            'other_allowance' => 'nullable|numeric',
            'st_bonus' => 'nullable|numeric',
            'gross_salary' => 'nullable|numeric',
            'emp_pf' => 'nullable|numeric',
            'emp_esic' => 'nullable|numeric',
            'pt' => 'nullable|numeric',
            'lwf' => 'nullable|numeric',
            'total_deduction' => 'nullable|numeric',
            'take_home' => 'nullable|numeric',
            'employer_pf' => 'nullable|numeric',
            'employer_esic' => 'nullable|numeric',
            'employer_lwf' => 'nullable|numeric',
            'mediclaim' => 'nullable|numeric',
            'ctc' => 'nullable|numeric',
            'leave_wage' => 'nullable|numeric',
            'email' => 'nullable|email|max:255',
            'notice_period' => 'nullable|string|max:255',
            'salary_date' => 'nullable|date',
            'designation' => 'nullable|string|max:255',
            'gender_salutation' => 'nullable|string',
        ]);

        $client = ClientManagement::find($validatedData['company_id']);
        if ($client) {
            $validatedData['entity_name'] = $client->client_name;
        }

        DB::beginTransaction();
        try {
            $offerLetter = new OfferLetter();
            $offerLetter->fill($validatedData);
            $offerLetter->date = now();
            $offerLetter->tenure_date = now();
            $offerLetter->status = 1;
            $offerLetter->save();

            // View selection based on type
            $viewMap = [
                1 => 'admin.adms.offer_letter.format1',
                2 => 'admin.adms.offer_letter.format2',
                3 => 'admin.adms.offer_letter.format3',
                4 => 'admin.adms.offer_letter.format4',
                5 => 'admin.adms.offer_letter.format5',
            ];
            $view = $viewMap[$offerLetter->offer_letter_type] ?? 'admin.offer_letter.format1';

            // Generate PDF
            $pdf = Pdf::loadView($view, ['offerLetter' => $offerLetter])->setPaper('A4', 'portrait');

            // Save to storage
            $fileName = 'offer_letter_' . $offerLetter->employee_id . '_' . time() . '.pdf';
            $filePath = 'offer_letters/' . $fileName;

            Storage::disk('public')->put($filePath, $pdf->output());

            $offerLetter->update([
                'offer_letter_path' => $filePath
            ]);

            DB::commit();
            return redirect()->route('admin.offer_letter')->with('success', 'Offer Letter has been Created!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('OfferLetter Store Error: ' . $e->getMessage());
            return back()->withErrors('Something went wrong while creating the offer letter.');
        }
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
                Excel::import(new ADMSOfferImport(), $fileWithPath);
                if (file_exists($fileWithPath)) {
                    unlink($fileWithPath);
                }
            }
        } catch (Exception $e) {
            dd($e);
        }
        $error = '';
        return redirect()->route('admin.offer_letter')->with([
            'success' => 'Offer Letter added successfully',
            'alert' => $error
        ]);
    }

    public function bulkDownload(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'client_id' => 'required',
        ]);

        $client = ClientManagement::findOrFail($request->client_id);
        $clientName = $client->client_name;

        $letters = OfferLetter::where('entity_name', $clientName)
            ->whereBetween('date', [$request->from_date, $request->to_date])
            ->whereIn('offer_letter_type', [1, 2, 3, 4, 5])
            ->pluck('id')  // ✅ pass only IDs
            ->toArray();

        if (empty($letters)) {
            return back()->with('error', 'No offer letters found.');
        }

        $zipFileName = 'OfferLetters_' . now()->format('Ymd_His') . '.zip';

        // ✅ Dispatch Job
        GenerateOfferLetterZip::dispatch($letters, $clientName, $zipFileName);

        // ✅ Pass file name to session to trigger download link
        return back()->with([
            'success' => 'ZIP is being prepared. Please refresh and download shortly.',
            'zip_file' => $zipFileName
        ]);
    }
    public function offerZip($file)
    {
        $path = storage_path("app/temp/{$file}");

        if (!file_exists($path)) {
            return back()->with('error', 'File not ready or expired.');
        }

        return response()->download($path)->deleteFileAfterSend(true); // ✅ auto delete after download
    }


}
