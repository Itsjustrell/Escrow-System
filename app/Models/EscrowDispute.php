<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EscrowDispute extends Model
{
    protected $fillable = [
        'escrow_id',
        'reason',
        'status',
        'resolved_by',
        'resolution',
    ];

    public function escrow()
    {
        return $this->belongsTo(Escrow::class);
    }

    public function evidences()
    {
        return $this->hasMany(DisputeEvidence::class);
    }

    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
}
