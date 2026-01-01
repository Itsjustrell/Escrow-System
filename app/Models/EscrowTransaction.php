<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EscrowTransaction extends Model
{
    protected $fillable = ['escrow_id','type','amount','executed_by','executed_at'];

    public function escrow()
    {
        return $this->belongsTo(Escrow::class);
    }
}
