<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CandidateMasterExport;
use App\Models\CFISModel;
use App\Models\DCSChildren;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;

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
                foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
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




    public function downloadpdf($id)
    {
        $children = DCSChildren::where('emp_id', $id)->get();
        $candidate = $this->model()
            ->with(['client', 'candidateDocuments'])
            ->findOrFail($id);

        $tempDir = storage_path("app/temp");
        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0755, true, true);
        }

        $pdf = Pdf::loadView('admin.adms.compliance.candidate-pdf', compact('candidate', 'children'));
        $pdfPath = $tempDir . "/candidate_details_$id.pdf";
        File::put($pdfPath, $pdf->output());

        $zipFileName = "candidate_documents_$id.zip";
        $zipPath = "$tempDir/$zipFileName";

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {

            $zip->addFile($pdfPath, "candidate_details.pdf");

         
            $this->addDocumentsToZip($zip, $candidate->candidateDocuments, 'Candidate_Documents');

            $zip->close();
        } else {
            return response()->json(['error' => 'Failed to create ZIP file.'], 500);
        }


        if (!File::exists($zipPath)) {
            return response()->json(['error' => 'ZIP file not found.'], 500);
        }


        File::delete($pdfPath);


        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    /**
     * Adds documents to ZIP inside their respective subfolder
     */
    private function addDocumentsToZip(ZipArchive $zip, $documents, $folderName)
    {
     
        foreach ($documents as $document) {
            $docPath = $document->path;

            if (!empty($docPath)) {

                $originalStoragePath = storage_path("app/public/" . $docPath);


                $tempDir = storage_path('app/temp');


                if (!File::exists($tempDir)) {
                    File::makeDirectory($tempDir, 0755, true, true);
                }


                $fileName = basename($docPath);
                $tempFilePath = $tempDir . "/" . $fileName;


                if (File::exists($originalStoragePath)) {

                    File::copy($originalStoragePath, $tempFilePath);
                    $zip->addFile($tempFilePath, "$folderName/$fileName");
                } else {
                    Log::warning("File does not exist in public directory: $originalStoragePath");
                    Log::warning("File is null or missing: $fileName");
                }
            }
        }
    }
    /**
     */
    public function export(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $query = $this->model()->query()->where('hr_approval', 1);

        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        $candidates = $query->get();

        return Excel::download(new CandidateMasterExport($candidates), 'candidates.xlsx');
    }
}
