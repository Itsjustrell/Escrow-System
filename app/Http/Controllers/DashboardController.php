<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('buyer')) {
            return view('dashboards.buyer');
        }

        if ($user->hasRole('seller')) {
            return view('dashboards.seller');
        }

        if ($user->hasRole('admin')) {
            return view('dashboards.admin');
        }

        if ($user->hasRole('arbiter')) {
            return view('dashboards.arbiter');
        }

        abort(403);
    }
}
