<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalNotesCustomField extends Model
{
    use HasFactory;
    protected $table= 'clinical_notes_custom_fields';
    protected $fillable = [
        'clinical_note_id',
        'user_id',
        'field_name',
        'field_value'
    ];
}