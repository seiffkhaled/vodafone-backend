<?php

use App\Console\Commands\SendTaskReports;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('reports:send', function () {
    (new SendTaskReports())->handle();
})->dailyAt('00:00');
Artisan::command('reports:send', function () {
    (new SendTaskReports())->handle();
})->weeklyOn(1, '00:00');
Artisan::command('reports:send', function () {
    (new SendTaskReports())->handle();
})->monthlyOn(1, '00:00');
