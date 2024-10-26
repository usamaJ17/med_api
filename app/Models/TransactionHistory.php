<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_id',
        'transaction_type',
        'transaction_amount',
        'transaction_currency',
        'transaction_description',
        'transaction_date',
        'appointment_id',
        'transaction_gateway',
        'transaction_time',
        'user_id',
    ];
    protected $table = 'transaction_history';
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function appointment(){
        return $this->belongsTo(Appointment::class);
    }
    // comment
}