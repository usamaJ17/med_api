<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotesComment extends Model
{
    use HasFactory;
    protected $fillable = [
        'body',
        'added_by',
        'clinical_note_id',
    ];
    protected $table = 'notes_comments';
    public function clinicalNote()
    {
        return $this->belongsTo(ClinicalNotes::class, 'clinical_note_id');
    }
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
