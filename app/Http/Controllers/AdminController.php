<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users()
    {
        $users = \App\Models\User::with('roles')->latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function destroyUser(\App\Models\User $user)
    {
        // Prevent deleting self
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Cannot delete yourself.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    public function escrows()
    {
        $escrows = \App\Models\Escrow::with(['buyer', 'seller', 'statusLogs'])
            ->latest()
            ->paginate(10);
            
        return view('admin.escrows', compact('escrows'));
    }

    public function cancelEscrow(\App\Models\Escrow $escrow)
    {
        // Admin gaboleh cancel kalau sudah RELEASED (uang cair) atau DISPUTED (ranah Arbiter)
        if (in_array($escrow->status, ['completed', 'cancelled', 'refunded', 'released', 'disputed'])) {
            return back()->with('error', 'Cannot cancel this escrow (Status: ' . $escrow->status . ').');
        }

        $oldStatus = $escrow->status;
        $escrow->update(['status' => 'cancelled']);
        
        // Log status change
        $escrow->statusLogs()->create([
            'from_status' => $oldStatus,
            'to_status' => 'cancelled',
            'reason' => 'Force cancelled by Admin',
            'changed_by' => auth()->id()
        ]);

        return back()->with('success', 'Escrow cancelled successfully.');
    }
}
