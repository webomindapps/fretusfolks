<?php

namespace App\Jobs;

use App\Imports\PayslipImport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProcessPayslipChunkJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $month;
    protected $year;
    public $tries = 2;
    public $backoff = 30;

    public function __construct(string $filePath, string $month, string $year)
    {
        $this->filePath = $filePath;
        $this->month = $month;
        $this->year = $year;
    }

    public function handle()
    {
        $fileFullPath = storage_path('app/' . $this->filePath);
        Excel::import(new PayslipImport($this->month, $this->year), $fileFullPath);
        Storage::delete($this->filePath); // cleanup
    }
}
