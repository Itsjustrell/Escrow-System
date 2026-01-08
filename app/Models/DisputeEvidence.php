<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisputeEvidence extends Model
{
    protected $table = 'dispute_evidences';
    
    protected $fillable = [
        'escrow_dispute_id',
        'uploaded_by',
        'file_path',
        'description',
    ];

    public function dispute()
    {
        return $this->belongsTo(EscrowDispute::class);
    }
}
