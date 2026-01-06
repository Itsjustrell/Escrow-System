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
            // Stats
            $totalUsers = \App\Models\User::count();
            $activeEscrows = Escrow::whereNotIn('status', ['completed', 'cancelled', 'refunded'])->count();
            $totalEscrowAmount = Escrow::whereNotIn('status', ['created', 'completed', 'cancelled', 'refunded'])->sum('amount');

            // Charts (Last 6 months filled)
            $labels = [];
            $data = [];
            $endDate = now();
            $startDate = now()->subMonths(5);

            $transactions = Escrow::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as date, count(*) as count')
                ->where('created_at', '>=', $startDate->startOfMonth())
                ->groupBy('date')
                ->pluck('count', 'date');

            for ($i = 0; $i <= 5; $i++) {
                $date = $startDate->copy()->addMonths($i)->format('Y-m');
                $labels[] = \Carbon\Carbon::createFromFormat('Y-m', $date)->format('M Y');
                $data[] = $transactions[$date] ?? 0;
            }

            // Tables
            $recentEscrows = Escrow::with(['participants.user'])->latest()->take(5)->get();
            $recentUsers = \App\Models\User::latest()->take(5)->get();

            return view('dashboards.admin', compact(
                'totalUsers',
                'activeEscrows',
                'totalEscrowAmount',
                'labels',
                'data',
                'recentEscrows',
                'recentUsers'
            ));
        }

        if ($user->hasRole('arbiter')) {
            return view('dashboards.arbiter');
        }

        abort(403);
    }
}
