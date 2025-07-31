<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EscrowTransaction extends Model
{
    protected $table = 'escrow_transactions';
    protected $fillable = [
        'user_id',
        'appointment_id',
        'amount',
        'total_fee',
        'added_by_admin',
        'status',
        'release_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
