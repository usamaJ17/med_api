<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payouts extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'rejected_reason',
        'completed_at',
        'method',
        'bank_name',
        'branch_address',
        'account_number',
        'account_holder_name',
        'phone_number',
        'mobile_network',
        'crypto_currency',
        'crypto_network',
        'crypto_address',
    ];
    protected $table = 'payouts';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
