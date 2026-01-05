<?php

namespace App\Http\Controllers;

use App\Models\Escrow;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('buyer')) {
            $escrows = Escrow::where('created_by', $user->id)
                ->latest()
                ->get();

            return view('dashboards.buyer', compact('escrows'));
        }

        if ($user->hasRole('seller')) {

            $escrows = Escrow::whereHas('participants', function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->where('role', 'seller');
            })
                ->latest()
                ->get();

            return view('dashboards.seller', compact('escrows'));
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
