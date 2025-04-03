<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('reminder', function () {
    Artisan::call('reminder:send');
})->purpose('Send sms reminder to tenants')->everyMinute();
