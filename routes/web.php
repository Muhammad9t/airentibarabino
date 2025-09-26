<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;

Route::get('/', fn () => Inertia::render('Airentibarabino/Home'))->name('home');
$pages = [
    'about'                      => 'About',
    'companies'                  => 'Companies',
    'contact'                    => 'Contact',
    'for_families_and_individuals' => 'ForFamiliesAndIndividuals',
    'for_the_non_profit'         => 'ForTheNonProfit',
    'foreign_companies'          => 'ForeignCompanies',
    'mission_and_values'         => 'MissionAndValues',
    'news_insights'              => 'NewsInsights',
    '404'                        => '404',
];
foreach ($pages as $name => $component) {
    Route::get("/{$name}", fn () => Inertia::render("Airentibarabino/{$component}"))->name($name);
}
Route::get('/service/{service}', [ServiceController::class, 'show'])->name('services.show');


Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'counts'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('services', ServiceController::class)->except(['show']);
    Route::patch('/services/{service}/toggle-status', [ServiceController::class, 'toggleStatus'])->name('services.toggleStatus');

    Route::resource('blogs', BlogController::class);
    Route::patch('/blogs/{blog}/toggle-status', [BlogController::class, 'toggleStatus'])->name('blogs.toggleStatus');

    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::post('/settings/{setting}', [SettingController::class, 'update'])->name('settings.update');

});

require __DIR__.'/auth.php';
