<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Escrow;
use App\Models\User;
use App\Models\EscrowDispute;
use App\Enums\EscrowStatus;
use App\Models\DisputeEvidence;

class DisputeSeeder extends Seeder
{
    public function run(): void
    {
        $buyer  = User::whereHas('roles', fn ($q) => $q->where('name', 'buyer'))->first();
        $seller = User::whereHas('roles', fn ($q) => $q->where('name', 'seller'))->first();

        if (!$buyer || !$seller) {
            $this->command->error('Buyer or Seller not found. Please run UserSeeder first.');
            return;
        }

        // Create a Disputed Escrow
        $escrow = Escrow::create([
            'title'               => 'Iphone 15 Pro Max (Disputed)',
            'amount'              => 15000000,
            'status'              => 'disputed', // Hardcode status for test
            'confirmation_window' => 3,
            'created_by'          => $buyer->id,
        ]);

        $escrow->participants()->createMany([
            ['user_id' => $buyer->id,  'role' => 'buyer'],
            ['user_id' => $seller->id, 'role' => 'seller'],
        ]);

        // Create the Dispute Record
        $dispute = EscrowDispute::create([
            'escrow_id' => $escrow->id,
            'reason'    => 'Barang yang diterima tidak sesuai deskripsi (Warna salah dan ada lecet).',
            'status'    => 'open',
        ]);

        // Add some dummy evidence
        DisputeEvidence::create([
            'escrow_dispute_id' => $dispute->id,
            'uploaded_by'       => $buyer->id,
            'file_path'         => '', // Dummy path
            'description'       => 'Foto barang saat unboxing yang menunjukkan warna berbeda.',
        ]);
        
        $this->command->info('Disputed Escrow created! Check Arbiter Dashboard.');
    }
}
