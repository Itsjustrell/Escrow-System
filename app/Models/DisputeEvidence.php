<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisputeEvidence extends Model
{
    protected $fillable = [
        'escrow_dispute_id',
        'file_path',
    ];

    public function dispute()
    {
        return $this->belongsTo(EscrowDispute::class);
    }
}
