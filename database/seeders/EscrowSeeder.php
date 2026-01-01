<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Escrow;
use App\Models\User;
use App\Enums\EscrowStatus;

class EscrowSeeder extends Seeder
{
    public function run(): void
    {
        $buyer  = User::whereHas('roles', fn ($q) => $q->where('name', 'buyer'))->first();
        $seller = User::whereHas('roles', fn ($q) => $q->where('name', 'seller'))->first();

        if (!$buyer || !$seller) return;

        $escrow = Escrow::create([
            'title'               => 'Test Escrow #1',
            'amount'              => 100000,
            'status'              => EscrowStatus::CREATED->value,
            'confirmation_window' => 3,
            'created_by'          => $buyer->id,
        ]);

        $escrow->participants()->createMany([
            ['user_id' => $buyer->id,  'role' => 'buyer'],
            ['user_id' => $seller->id, 'role' => 'seller'],
        ]);
    }
}
