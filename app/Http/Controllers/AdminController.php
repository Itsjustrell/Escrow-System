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
