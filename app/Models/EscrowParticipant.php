<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EscrowParticipant extends Model
{
    protected $fillable = ['escrow_id','user_id','role'];

    public function escrow()
    {
        return $this->belongsTo(Escrow::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
