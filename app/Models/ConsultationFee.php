<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationFee extends Model
{
    //
    protected $table = "consultation_fee";
    protected $fillable = ["appointment_id", "fee", "duration", "consultation_type", "user_id"];
}
