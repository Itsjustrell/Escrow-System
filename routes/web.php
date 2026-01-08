<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EscrowController;
use App\Http\Controllers\EscrowActionController;
use App\Http\Controllers\AdminController;

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

    Route::get(
        '/escrows/{escrow}/pay',
        [EscrowActionController::class, 'paymentView']
    )->name('escrows.pay');

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



// ARBITER ROUTES
Route::middleware(['auth', 'role:arbiter'])->prefix('arbiter')->name('arbiter.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\ArbiterController::class, 'index'])->name('dashboard');
    Route::get('/history', [App\Http\Controllers\ArbiterController::class, 'history'])->name('history');
    Route::get('/disputes/{escrow}', [App\Http\Controllers\ArbiterController::class, 'show'])->name('show');
    Route::post('/disputes/{escrow}/resolve', [App\Http\Controllers\ArbiterController::class, 'resolve'])->name('resolve');
});

// ADMIN ROUTES
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
    Route::get('/export/escrows', [AdminController::class, 'exportEscrows'])->name('export.escrows');
    Route::get('/escrows', [AdminController::class, 'escrows'])->name('escrows');
    Route::post('/escrows/{escrow}/cancel', [AdminController::class, 'cancelEscrow'])->name('escrows.cancel');
});

// Auth (Breeze)
require __DIR__ . '/auth.php';
