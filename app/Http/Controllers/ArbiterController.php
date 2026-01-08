<?php

namespace App\Http\Controllers;

use App\Models\Escrow;
use App\Models\EscrowDispute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArbiterController extends Controller
{
    public function index()
    {
        // Stats
        $stats = [
            'total' => Escrow::whereIn('status', ['disputed', 'resolved', 'refunded', 'released'])->count(),
            'pending' => Escrow::where('status', 'disputed')->count(),
            'resolved' => Escrow::whereIn('status', ['resolved', 'refunded', 'released'])->count(),
        ];

        // List active disputes
        $escrows = Escrow::where('status', 'disputed')
            ->with(['buyer', 'seller', 'dispute'])
            ->latest()
            ->paginate(10);

        return view('arbiter.dashboard', compact('escrows', 'stats'));
    }

    /**
     * Show history of resolved disputes.
     */
    public function history()
    {
        $escrows = Escrow::whereIn('status', ['resolved', 'refunded', 'released'])
            ->whereHas('dispute') // Only show ones that had a dispute
            ->with(['buyer', 'seller', 'dispute'])
            ->latest()
            ->paginate(10);

        return view('arbiter.history', compact('escrows'));
    }

    /**
     * Show details of a specific disputed escrow.
     */
    public function show(Escrow $escrow)
    {
        if ($escrow->status !== 'disputed') {
            return redirect()->route('arbiter.dashboard')->with('error', 'This escrow is not in dispute.');
        }

        $escrow->load(['buyer', 'seller', 'dispute.evidences', 'transactions', 'statusLogs']);

        return view('arbiter.show', compact('escrow'));
    }

    /**
     * Resolve the dispute.
     */
    public function resolve(Request $request, Escrow $escrow)
    {
        $request->validate([
            'resolution' => 'required|in:refund_buyer,release_seller',
            'notes' => 'required|string|min:10',
        ]);

        if ($escrow->status !== 'disputed') {
            return back()->with('error', 'Escrow is not disputed.');
        }

        DB::transaction(function () use ($escrow, $request) {
            $resolution = $request->resolution;
            $newStatus = ($resolution === 'refund_buyer') ? 'refunded' : 'released';
            
            // 1. Update Escrow Status
            $oldStatus = $escrow->status;
            $escrow->update([
                'status' => $newStatus,
                'delivered_at' => ($newStatus === 'released') ? now() : null, // If released, consider delivered? Or keep original?
            ]);

            // 2. Update Dispute Record
            $escrow->dispute()->update([
                'status' => 'resolved',
                'resolved_by' => auth()->id(),
                'resolution' => $request->notes . " (Decision: " . strtoupper(str_replace('_', ' ', $resolution)) . ")",
            ]);

            // 3. Log Status Change
            $escrow->statusLogs()->create([
                'from_status' => $oldStatus,
                'to_status' => $newStatus,
                'reason' => 'Dispute Resolved by Arbiter: ' . $request->notes,
                'changed_by' => auth()->id()
            ]);
            
            // 4. Record Transaction (Refund or Payout)
            $escrow->transactions()->create([
                'transaction_type' => ($resolution === 'refund_buyer') ? 'refund' : 'payout',
                'amount' => $escrow->amount,
                'reference_id' => 'TXN-' . strtoupper(uniqid()),
                'description' => 'Dispute Resolution: ' . $resolution,
            ]);
        });

        return redirect()->route('arbiter.dashboard')->with('success', 'Dispute resolved successfully as ' . $request->resolution);
    }
}
