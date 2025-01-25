<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function ($output) {
    $output->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
