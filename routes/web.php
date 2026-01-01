<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EscrowActionController;
use App\Http\Controllers\EscrowController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home (public)
Route::get('/', function () {
    return view('home');
})->name('home');

// Dashboard (role-based, via controller)
Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

// Escrow actions (state-guarded)
Route::middleware('auth')->group(function () {

    Route::post('/escrows/{escrow}/fund',
        [EscrowActionController::class, 'fund']
    )->middleware('escrow.state:created');

    Route::post('/escrows/{escrow}/ship',
        [EscrowActionController::class, 'ship']
    )->middleware('escrow.state:funded');

    Route::post('/escrows/{escrow}/deliver',
        [EscrowActionController::class, 'deliver']
    )->middleware('escrow.state:shipping');

    Route::post('/escrows/{escrow}/release',
        [EscrowActionController::class, 'release']
    )->middleware('escrow.state:delivered');

    Route::post('/escrows/{escrow}/dispute',
        [EscrowActionController::class, 'dispute']
    )->middleware('escrow.state:delivered');

    Route::post('/escrows/{escrow}/dispute/resolve',
        [EscrowActionController::class, 'resolveDispute']
    )->middleware('escrow.state:disputed');
});

Route::middleware('auth')->get('/escrows', [EscrowController::class, 'index'])
    ->name('escrows.index');

Route::middleware('auth')->get('/escrows/{escrow}', [EscrowController::class, 'show'])
    ->name('escrows.show');

Route::post('/escrows/{escrow}/dispute/evidence',
    [EscrowActionController::class, 'uploadEvidence']
)->middleware(['auth', 'escrow.state:disputed']);

// Auth routes (Breeze)
require __DIR__.'/auth.php';
