<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EscrowController;
use App\Http\Controllers\EscrowActionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', fn() => view('home'))->name('home');

// Authenticated
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ==================
    // ESCROW CRUD
    // ==================

    Route::get('/escrows', [EscrowController::class, 'index'])
        ->name('escrows.index');

    // ⚠️ STATIC HARUS DI ATAS PARAMETER
    Route::get('/escrows/create', [EscrowController::class, 'create'])
        ->name('escrows.create');

    Route::post('/escrows', [EscrowController::class, 'store'])
        ->name('escrows.store');

    Route::get('/escrows/{escrow}', [EscrowController::class, 'show'])
        ->name('escrows.show');

    // ==================
    // ESCROW ACTIONS
    // ==================

    Route::post(
        '/escrows/{escrow}/fund',
        [EscrowActionController::class, 'fund']
    )->middleware('escrow.state:created');

    Route::post(
        '/escrows/{escrow}/ship',
        [EscrowActionController::class, 'ship']
    )->middleware('escrow.state:funded');

    Route::post(
        '/escrows/{escrow}/deliver',
        [EscrowActionController::class, 'deliver']
    )->middleware('escrow.state:shipping');

    Route::post(
        '/escrows/{escrow}/release',
        [EscrowActionController::class, 'release']
    )->middleware('escrow.state:delivered');

    Route::post(
        '/escrows/{escrow}/dispute',
        [EscrowActionController::class, 'dispute']
    )->middleware('escrow.state:delivered');

    Route::post(
        '/escrows/{escrow}/dispute/evidence',
        [EscrowActionController::class, 'uploadEvidence']
    )->name('escrows.dispute.evidence');
});

// Auth (Breeze)
require __DIR__ . '/auth.php';
