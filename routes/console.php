<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// Manually register your scheduled tasks via app()->booted()
app()->booted(function () {
    $schedule = app(Schedule::class);

    $schedule->command('queue:work --stop-when-empty')
        ->everyMinute()
        ->withoutOverlapping();
});


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
