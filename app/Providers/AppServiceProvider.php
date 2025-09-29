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
            'services' => fn () => Service::active()
                ->with(['subServices' => function($query) {
                    $query->where('status', 'active')
                        ->orderBy('sort_order')
                        ->select(['id', 'service_id', 'title', 'title_translations', 'status', 'sort_order']);
                }])
                ->orderBy('menu_order')
                ->select(['id', 'name', 'name_translations', 'slug', 'description', 'description_translations', 'status', 'menu_order'])
                ->get()
        ]);
        Vite::prefetch(concurrency: 3);
    }
}
