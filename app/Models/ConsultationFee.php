<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationFee extends Model
{
    //
    protected $table = "consultation_fee";
    protected $fillable = ["appointment_id", "fee", "consultation_type", "user_id"];
}
