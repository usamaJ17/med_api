<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicalNotesField extends Model
{    
    protected $table = "clinical_notes_fields";
    protected $fillable = ["name", 'is_required'];
}
