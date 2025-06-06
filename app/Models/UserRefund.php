<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRefund extends Model
{
    use HasFactory;
    protected $table = 'user_refund_history';
    protected $fillable = ['user_id', 'appointment_id','amount','gateway','status'];
    protected $appends = ['gateway_name'];
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function appointment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
    public function getGatewayNameAttribute(): string
    {
        if($this->gateway === 'gateway') {
            return $this->appointment->gateway ?? 'Gateway';
        }
        else{
            return $this->gateway;
        }
    }
}
