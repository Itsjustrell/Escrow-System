<?php

namespace App\Services;

use App\Models\Escrow;
use App\Models\EscrowStatusLog;
use App\Enums\EscrowStatus;
use Carbon\Carbon;

class EscrowTransitionService
{
    /**
     * Satu-satunya pintu untuk mengubah status escrow
     */
    public static function transition(
        Escrow $escrow,
        EscrowStatus $toStatus,
        ?int $userId = null,
        ?string $reason = null
    ): void {
        $fromStatus = $escrow->status;

        // Update escrow utama
        $escrow->update([
            'status' => $toStatus->value,
            'delivered_at' => $toStatus === EscrowStatus::DELIVERED
                ? Carbon::now()
                : $escrow->delivered_at,

            'confirm_deadline' => $toStatus === EscrowStatus::DELIVERED
                ? Carbon::now()->addDays($escrow->confirmation_window)
                : $escrow->confirm_deadline,
        ]);

        // Audit log (WAJIB untuk sistem escrow)
        EscrowStatusLog::create([
            'escrow_id'   => $escrow->id,
            'from_status' => $fromStatus,
            'to_status'   => $toStatus->value,
            'changed_by'  => $userId,
            'reason'      => $reason,
        ]);
    }
}
