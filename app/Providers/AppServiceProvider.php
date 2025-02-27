<?php

namespace App\Providers;

use App\Events\SwitchControlEvent;
use App\Listeners\ESP32MessageListener;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    protected $listen = [
        SwitchControlEvent::class => [
            ESP32MessageListener::class,
        ],
    ];
}
