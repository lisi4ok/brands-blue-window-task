<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\ImageController;

Route::get('/', function (): Response {
    return Inertia::render('Brands', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function (): Response {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function (): void {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/dates', function (Request $request): RedirectResponse {
        $request->validate([
            'date' => ['required', 'date'],
            'datetime' => ['required', 'date'],
        ]);

        return Redirect::back()->with('data', $request->input());
    })->name('dates.update');

    Route::resource('brands', BrandsController::class)->except(['show']);

    Route::delete('image/{id}/{model}', [ImageController::class, 'destroy'])->name('image.destroy');

});

require __DIR__.'/auth.php';
