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

require __DIR__.'/auth.php';

// ============================================================
// CANONICAL LOCATION PAGE (single canonical URL per area)
// All non-canonical variants 301 redirect to this pattern
// ============================================================
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
})->where('slug', '[a-z0-9-]+');

// ============================================================
// 301 REDIRECTS: All non-canonical location URL patterns
// Redirect to canonical /ambulance-service-in-{slug}
// ============================================================
Route::get('/local-ambulance-in-{slug}', function ($slug) {
    return redirect("/ambulance-service-in-$slug", 301);
})->where('slug', '[a-z0-9-]+');

Route::get('/ambulance-near-{slug}', function ($slug) {
    return redirect("/ambulance-service-in-$slug", 301);
})->where('slug', '[a-z0-9-]+');

Route::get('/{slug}/local-ambulance', function ($slug) {
    return redirect("/ambulance-service-in-$slug", 301);
})->where('slug', '[a-z0-9-]+');

Route::get('/{slug}/ambulance-service', function ($slug) {
    return redirect("/ambulance-service-in-$slug", 301);
})->where('slug', '[a-z0-9-]+');

Route::get('/{slug}/ambulance-nearby', function ($slug) {
    return redirect("/ambulance-service-in-$slug", 301);
})->where('slug', '[a-z0-9-]+');

Route::get('/rg-ambulance-service-{slug}', function ($slug) {
    return redirect("/ambulance-service-in-$slug", 301);
})->where('slug', '[a-z0-9-]+');

Route::get('/rg-ambulance-{slug}', function ($slug) {
    return redirect("/ambulance-service-in-$slug", 301);
})->where('slug', '[a-z0-9-]+');

// ============================================================
// FLAT PATTERN REDIRECTS: {slug}-local-ambulance, {slug}-icu-ambulance, etc.
// Catch them all at the end with a single handler
// ============================================================
$flatSuffixes = [
    '-local-ambulance-service', '-local-ambulance', '-emergency-ambulance',
    '-ambulance-service-nearby', '-icu-ambulance', '-patient-transport',
    '-funeral-service', '-death-ambulance', '-mortuary-van',
    '-24-hour-ambulance', '-bed-ambulance', '-ventilator-ambulance',
    '-oxygen-ambulance',
];

Route::get('/{slug}', function ($slug) {
    // Strip flat suffix patterns and redirect to canonical
    $slugRaw = $slug;
    foreach (['-local-ambulance-service', '-local-ambulance', '-emergency-ambulance',
        '-ambulance-service-nearby', '-icu-ambulance', '-patient-transport',
        '-funeral-service', '-death-ambulance', '-mortuary-van',
        '-24-hour-ambulance', '-bed-ambulance', '-ventilator-ambulance',
        '-oxygen-ambulance'] as $suffix) {
        if (str_ends_with($slugRaw, $suffix)) {
            $area = substr($slugRaw, 0, -strlen($suffix));
            return redirect("/ambulance-service-in-$area", 301);
        }
    }
    // Non-matching paths: return 404 (no longer serve SPA shell for unknown URLs)
    abort(404);
})->where('slug', '[a-z0-9-]+');
