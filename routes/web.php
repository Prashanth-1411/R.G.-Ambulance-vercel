<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('frontend.home');
Route::get('/about', [App\Http\Controllers\Frontend\AboutController::class, 'index'])->name('frontend.about');
Route::get('/services', [App\Http\Controllers\Frontend\AmbulanceServicesController::class, 'index'])->name('frontend.services');
Route::get('/services/{slug}', [App\Http\Controllers\Frontend\ServiceController::class, 'show'])->name('frontend.services.show');
Route::get('/fleet', [App\Http\Controllers\Frontend\FleetController::class, 'index'])->name('frontend.fleet');
Route::get('/fleet/{slug}', [App\Http\Controllers\Frontend\FleetController::class, 'show'])->name('frontend.fleet.show');
Route::get('/mortuary', [App\Http\Controllers\Frontend\MortuaryController::class, 'index'])->name('frontend.mortuary');
Route::get('/testimonials', [App\Http\Controllers\Frontend\TestimonialController::class, 'index'])->name('frontend.testimonials');
Route::get('/faq', [App\Http\Controllers\Frontend\FaqController::class, 'index'])->name('frontend.faq');
Route::get('/contact', [App\Http\Controllers\Frontend\ContactController::class, 'index'])->name('frontend.contact');
Route::post('/contact', [App\Http\Controllers\Frontend\ContactController::class, 'store'])->name('frontend.contact.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// React SPA fallback for ambulance location pages (not served by Blade)
Route::get('/ambulance-services', function () {
    $file = public_path('frontend/index.html');
    return file_exists($file) ? response(file_get_contents($file))->header('Content-Type', 'text/html') : abort(404);
});

Route::get('/funeral-services', function () {
    $file = public_path('frontend/index.html');
    return file_exists($file) ? response(file_get_contents($file))->header('Content-Type', 'text/html') : abort(404);
});

Route::get('/ambulance-service-in-{slug}', function ($slug) {
    $file = public_path('frontend/index.html');
    return file_exists($file) ? response(file_get_contents($file))->header('Content-Type', 'text/html') : abort(404);
})->where('slug', '.*');

Route::get('/local-ambulance-in-{slug}', function ($slug) {
    $file = public_path('frontend/index.html');
    return file_exists($file) ? response(file_get_contents($file))->header('Content-Type', 'text/html') : abort(404);
})->where('slug', '.*');

Route::get('/ambulance-near-{slug}', function ($slug) {
    $file = public_path('frontend/index.html');
    return file_exists($file) ? response(file_get_contents($file))->header('Content-Type', 'text/html') : abort(404);
})->where('slug', '.*');

Route::get('/{slug}/local-ambulance', function ($slug) {
    $file = public_path('frontend/index.html');
    return file_exists($file) ? response(file_get_contents($file))->header('Content-Type', 'text/html') : abort(404);
})->where('slug', '.*');

Route::get('/{slug}/ambulance-service', function ($slug) {
    $file = public_path('frontend/index.html');
    return file_exists($file) ? response(file_get_contents($file))->header('Content-Type', 'text/html') : abort(404);
})->where('slug', '.*');

Route::get('/{slug}/ambulance-nearby', function ($slug) {
    $file = public_path('frontend/index.html');
    return file_exists($file) ? response(file_get_contents($file))->header('Content-Type', 'text/html') : abort(404);
})->where('slug', '.*');

Route::get('/rg-ambulance-service-{slug}', function ($slug) {
    $file = public_path('frontend/index.html');
    return file_exists($file) ? response(file_get_contents($file))->header('Content-Type', 'text/html') : abort(404);
})->where('slug', '.*');

Route::get('/rg-ambulance-{slug}', function ($slug) {
    $file = public_path('frontend/index.html');
    return file_exists($file) ? response(file_get_contents($file))->header('Content-Type', 'text/html') : abort(404);
})->where('slug', '.*');

require __DIR__.'/auth.php';

// Catch-all for React SPA location pages (flat patterns like /surapet-local-ambulance)
// Must be AFTER auth routes to avoid breaking login/register
Route::get('/{path}', function () {
    $file = public_path('frontend/index.html');
    return file_exists($file) ? response(file_get_contents($file))->header('Content-Type', 'text/html') : abort(404);
})->where('path', '.*');
