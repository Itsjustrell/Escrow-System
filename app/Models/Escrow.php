<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Escrow extends Model
{
    protected $fillable = [
        'title','amount','status','confirmation_window',
        'created_by','delivered_at','confirm_deadline'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants()
    {
        return $this->hasMany(EscrowParticipant::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(EscrowStatusLog::class);
    }

    public function transactions()
    {
        return $this->hasMany(EscrowTransaction::class);
    }

    public function dispute()
    {
        return $this->hasOne(EscrowDispute::class);
    }
}
