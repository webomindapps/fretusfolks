<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Imports\CandidatesImport;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ImportCandidatesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    /**
     * Create a new job instance.
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**x
     * Execute the job.
     */
    public function handle(): void
    {
        $fullPath = storage_path('app/' . $this->filePath);

        if (!file_exists($fullPath)) {
            \Log::error('Import file not found: ' . $fullPath);
            return;
        }

        Excel::import(new CandidatesImport, $fullPath);

        Storage::delete($this->filePath);
    }
}

