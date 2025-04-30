<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Controllers\IControlController;
use App\Interfaces\Controllers\IUsageController;
use App\Interfaces\Controllers\IBudgetController;
use App\Http\Controllers\ControlController;
use App\Http\Controllers\UsageController;
use App\Http\Controllers\BudgetController;
use App\Services\GeminiService;
use App\Services\MockGeminiService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IControlController::class, ControlController::class);
        $this->app->bind(IUsageController::class, UsageController::class);
        $this->app->bind(IBudgetController::class, BudgetController::class);
        
        $this->app->singleton(GeminiService::class, function ($app) {
            if (config('services.gemini.use_mock', true)) {
                return new MockGeminiService();
            }
            return new GeminiService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    // protected $listen = [
    //     SwitchControlEvent::class => [
    //         ESP32MessageListener::class,
    //     ],
    // ];
}
