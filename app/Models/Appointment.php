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
        'patient_status',
        'is_paid',
        'diagnosis',
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
    protected $appends = ['patient_name'];
    public function getPatientNameAttribute()
    {
        $user = User::find($this->user_id);
        return $user->first_name . ' ' . $user->last_name;
    }

}
