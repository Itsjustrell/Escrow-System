<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('auth')->get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = auth()->user();

    if ($user->hasRole('buyer')) {
        return 'Buyer Dashboard';
    }

    if ($user->hasRole('seller')) {
        return 'Seller Dashboard';
    }

    return abort(403);
});


require __DIR__.'/auth.php';
