<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = [
        'user_id',
        'transaction_id',
        'transaction_type',
        'transaction_status',
        'transaction_amount',
        'transaction_reason',
    ];
}
