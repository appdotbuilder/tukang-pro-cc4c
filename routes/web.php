<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CraftsmanController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/craftsmen', [CraftsmanController::class, 'index'])->name('craftsmen.index');
Route::get('/craftsmen/{craftsman}', [CraftsmanController::class, 'show'])->name('craftsmen.show');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isCraftsman()) {
            return redirect()->route('craftsman.dashboard');
        } else {
            return redirect()->route('customer.dashboard');
        }
    })->name('dashboard');

    // Customer routes
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', function () {
            if (!auth()->user()->isCustomer()) {
                abort(403, 'Access denied.');
            }
            return Inertia::render('customer/dashboard');
        })->name('dashboard');
        
        Route::resource('service-requests', ServiceRequestController::class);
    });

    // Craftsman routes
    Route::prefix('craftsman')->name('craftsman.')->group(function () {
        Route::get('/dashboard', function () {
            if (!auth()->user()->isCraftsman()) {
                abort(403, 'Access denied.');
            }
            return Inertia::render('craftsman/dashboard');
        })->name('dashboard');
        
        Route::get('/profile/create', [CraftsmanController::class, 'create'])->name('profile.create');
        Route::post('/profile', [CraftsmanController::class, 'store'])->name('profile.store');
        Route::get('/profile/{craftsman}/edit', [CraftsmanController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile/{craftsman}', [CraftsmanController::class, 'update'])->name('profile.update');
        Route::delete('/profile/{craftsman}', [CraftsmanController::class, 'destroy'])->name('profile.destroy');
    });

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/{admin}', [AdminController::class, 'show'])->name('show');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';