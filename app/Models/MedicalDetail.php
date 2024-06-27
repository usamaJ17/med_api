<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MedicalDetail extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    // Specify the table name if it's not the plural of the model name
    protected $table = 'medical_details';

    // Define the fillable attributes
    protected $fillable = [
        'user_id',
        'past_surgical_history',
        'past_medical_history',
        'allergy',
        'drugs_history',
        'gynaecological_history',
        'obstetric_history',
        'recent_hospital_stays',
        'family_history',
        'social_history',
        'occupation',
        'previous_occupation',
    ];

    // Define relationships, if any
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}