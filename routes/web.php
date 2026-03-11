<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\DiagnosticController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LocaleController;

Route::get('/', function () {
    if (auth()->check()) {
        $role = auth()->user()->role;
        return match($role) {
            'serviser'      => redirect()->route('dashboard.serviser'),
            'administrator' => redirect()->route('dashboard.admin'),
            default         => redirect()->route('dashboard.klijent'),
        };
    }
    return redirect('/login');
});

require __DIR__.'/auth.php';

// Klijent rute
Route::middleware(['auth', 'role:klijent'])->group(function () {
    Route::get('/dashboard/klijent', [DashboardController::class, 'klijent'])
        ->name('dashboard.klijent');

    Route::resource('service-requests', ServiceRequestController::class)
        ->only(['create', 'store']);
});

// Serviser rute
Route::middleware(['auth', 'role:serviser'])->group(function () {
    Route::get('/dashboard/serviser', [DashboardController::class, 'serviser'])
        ->name('dashboard.serviser');

    Route::resource('diagnostics', DiagnosticController::class)
        ->only(['index', 'store']);

    Route::get('diagnostics/{serviceRequest}/create', [DiagnosticController::class, 'create'])
        ->name('diagnostics.create');

    Route::resource('repairs', RepairController::class)
    ->only(['index', 'store', 'show']);

    Route::get('repairs/{serviceRequest}/create', [RepairController::class, 'create'])
        ->name('repairs.create');

    
});

// Admin rute
Route::middleware(['auth', 'role:administrator'])->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])
        ->name('dashboard.admin');

    Route::resource('parts', PartController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy']);

    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');

    Route::resource('users', UserController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});

// Zajednicke rute
Route::middleware(['auth', 'role:klijent,serviser,administrator'])->group(function () {
    Route::resource('service-requests', ServiceRequestController::class)
        ->only(['index', 'show']);

    Route::resource('parts', PartController::class)
        ->only(['index']);

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');
});