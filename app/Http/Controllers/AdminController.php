<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function users()
    {
        $users = \App\Models\User::with('roles')->latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function editUser(\App\Models\User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, \App\Models\User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function destroyUser(\App\Models\User $user)
    {
        // Prevent deleting self
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Cannot delete yourself.');
        }

        // Prevent deleting if user has related escrows (integrity constraint)
        $hasEscrows = \App\Models\Escrow::where('created_by', $user->id)->exists();
        $isParticipant = \App\Models\EscrowParticipant::where('user_id', $user->id)->exists();

        if ($hasEscrows || $isParticipant) {
            return back()->with('error', 'Cannot delete user. They have associated transaction history.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    public function exportEscrows()
    {
        $fileName = 'escrows_export_' . date('Y-m-d_H-i') . '.csv';
        $escrows = \App\Models\Escrow::with(['buyer', 'seller'])->latest()->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Title', 'Amount', 'Status', 'Buyer', 'Seller', 'Created At'];

        $callback = function() use($escrows, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($escrows as $escrow) {
                $row['ID']  = $escrow->id;
                $row['Title']    = $escrow->title;
                $row['Amount']    = $escrow->amount;
                $row['Status']  = $escrow->status;
                $row['Buyer']  = $escrow->buyer->name ?? 'N/A';
                $row['Seller']  = $escrow->seller->name ?? 'N/A';
                $row['Created At']  = $escrow->created_at;

                fputcsv($file, array($row['ID'], $row['Title'], $row['Amount'], $row['Status'], $row['Buyer'], $row['Seller'], $row['Created At']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function escrows()
    {
        $escrows = \App\Models\Escrow::with(['buyer', 'seller', 'statusLogs'])
            ->latest()
            ->paginate(10);
            
        return view('admin.escrows', compact('escrows'));
    }

    public function editEscrow(\App\Models\Escrow $escrow)
    {
        return view('admin.escrows.edit', compact('escrow'));
    }

    public function updateEscrow(Request $request, \App\Models\Escrow $escrow)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            // 'status' => 'required|in:created,funded,shipping,delivered,completed,cancelled,disputed,released'
        ]);

        $escrow->update([
            'title' => $validated['title'],
            'amount' => $validated['amount'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('admin.escrows')->with('success', 'Escrow updated successfully.');
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
