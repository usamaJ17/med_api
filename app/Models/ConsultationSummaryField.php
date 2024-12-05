<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationSummaryField extends Model
{    
    protected $table = "consultation_summary_fields";
    protected $fillable = ["name", 'is_required'];
}
