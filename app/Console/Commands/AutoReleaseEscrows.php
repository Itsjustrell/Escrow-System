<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Escrow;
use App\Services\EscrowTransitionService;
use App\Enums\EscrowStatus;
use Carbon\Carbon;

class AutoReleaseEscrows extends Command
{
    protected $signature = 'escrow:auto-release';
    protected $description = 'Auto release escrows past confirmation deadline';

    public function handle(): int
    {
        $expiredEscrows = Escrow::where('status', EscrowStatus::DELIVERED->value)
            ->whereNotNull('confirm_deadline')
            ->where('confirm_deadline', '<', Carbon::now())
            ->get();

        foreach ($expiredEscrows as $escrow) {
            EscrowTransitionService::transition(
                $escrow,
                EscrowStatus::RELEASED,
                null,
                'Auto-released by system (deadline passed)'
            );

            $this->info("Escrow {$escrow->id} auto-released");
        }

        return Command::SUCCESS;
    }
}
