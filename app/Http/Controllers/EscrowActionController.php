<?php

namespace App\Http\Controllers;

use App\Models\Escrow;
use App\Models\EscrowTransaction;
use App\Models\EscrowDispute;
use App\Services\EscrowTransitionService;
use App\Enums\EscrowStatus;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EscrowActionController extends Controller
{
    public function fund(Escrow $escrow)
    {
        EscrowTransaction::create([
            'escrow_id'   => $escrow->id,
            'type'        => 'funding',
            'amount'      => $escrow->amount,
            'executed_by' => auth()->id(),
            'executed_at' => Carbon::now(),
        ]);

        EscrowTransitionService::transition(
            $escrow,
            EscrowStatus::FUNDED,
            auth()->id(),
            'Funded by buyer'
        );

        return back();
    }

    public function ship(Escrow $escrow)
    {
        EscrowTransitionService::transition(
            $escrow,
            EscrowStatus::SHIPPING,
            auth()->id(),
            'Shipped by seller'
        );

        return back();
    }

    public function deliver(Escrow $escrow)
    {
        EscrowTransitionService::transition(
            $escrow,
            EscrowStatus::DELIVERED,
            auth()->id(),
            'Delivered by seller'
        );

        return back();
    }

    public function release(Escrow $escrow)
    {
        EscrowTransaction::create([
            'escrow_id'   => $escrow->id,
            'type'        => 'release',
            'amount'      => $escrow->amount,
            'executed_by' => auth()->id(),
            'executed_at' => Carbon::now(),
        ]);

        EscrowTransitionService::transition(
            $escrow,
            EscrowStatus::RELEASED,
            auth()->id(),
            'Released by buyer'
        );

        return back();
    }

    public function dispute(Request $request, Escrow $escrow)
    {
        $request->validate([
            'reason' => 'required|string',
        ]);

        EscrowDispute::create([
            'escrow_id' => $escrow->id,
            'reason'    => $request->reason,
            'status'    => 'open',
        ]);

        EscrowTransitionService::transition(
            $escrow,
            EscrowStatus::DISPUTED,
            auth()->id(),
            'Dispute opened'
        );

        return back();
    }

    public function resolveDispute(Request $request, Escrow $escrow)
    {
        $request->validate([
            'resolution' => 'required|in:release,refund',
        ]);

        $dispute = $escrow->dispute;

        $dispute->update([
            'status'      => 'resolved',
            'resolved_by' => auth()->id(),
            'resolution'  => $request->resolution,
        ]);

        if ($request->resolution === 'refund') {
            EscrowTransaction::create([
                'escrow_id'   => $escrow->id,
                'type'        => 'refund',
                'amount'      => $escrow->amount,
                'executed_by' => auth()->id(),
                'executed_at' => Carbon::now(),
            ]);
        }

        EscrowTransitionService::transition(
            $escrow,
            $request->resolution === 'release'
                ? EscrowStatus::RELEASED
                : EscrowStatus::REFUNDED,
            auth()->id(),
            'Dispute resolved'
        );

        return back();
    }
}
