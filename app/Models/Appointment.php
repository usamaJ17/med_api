<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'med_id',
        'appointment_type',
        'consultation_fees',
        'appointment_time',
        'appointment_date',
        'gender',
        'age',
        'problem',
        'is_paid',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function med()
    {
        return $this->belongsTo(User::class);
    }

}
