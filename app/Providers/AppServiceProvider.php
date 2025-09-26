<?php

namespace App\Providers;
use Inertia\Inertia;
use App\Models\Service;

use App\Models\Setting;
use Illuminate\Support\Facades\Vite;
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
        Inertia::share([
            'settings' => fn () => Setting::first(),
            'services' => fn () => Service::latest()->get()
        ]);
        Vite::prefetch(concurrency: 3);
    }
}
