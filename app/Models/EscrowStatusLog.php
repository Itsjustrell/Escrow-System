<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EscrowStatusLog extends Model
{
    protected $fillable = ['escrow_id','from_status','to_status','changed_by','reason'];

    public function escrow()
    {
        return $this->belongsTo(Escrow::class);
    }
}
