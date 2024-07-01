<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentHours extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'appointment_type',
        'consultation_fees',
        'duration',
        'working_hours',
    ];

    protected $casts = [
        'working_hours' => 'array',
    ];
}
