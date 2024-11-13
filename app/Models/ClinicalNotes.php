<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalNotes extends Model
{
    use HasFactory;
    protected $fillable = [
        'created_by',
        'note',
        'title',
        'user_id'
    ];
    protected $table = 'clinical_notes';
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }
    // Define the relationship with NotesComment
    public function comments()
    {
        return $this->hasMany(NotesComment::class, 'clinical_note_id');
    }
    public function customFields()
    {
        return $this->hasMany(ClinicalNotesCustomField::class, 'clinical_note_id');
    }
    public function getNoteAttribute()
    {
        return $this->attributes['note'] ? json_decode($this->attributes['note']) : null;
    }
    
}
