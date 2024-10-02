<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentSummary extends Model
{
    use HasFactory;
    protected $table = 'appointment_summary';
    protected $fillable = ['appointment_id', 'summary'];
    public function appointment(){
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }
}
