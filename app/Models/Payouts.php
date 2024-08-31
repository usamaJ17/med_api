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
        'account_info'
    ];
    protected $table = 'payouts';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
