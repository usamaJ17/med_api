<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ProfessionalDetails extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $table = 'professional_details';

    // Define the fillable attributes
    protected $fillable = [
        'user_id',
        'profession',
        'rank',
        'license_authority',
        'regestraion_number',
        'work_at',
        'experence',
        'bio',
        'degree',
        'institution',
    ];
    
    // Define relationships, if any
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function profession()
    {
        return $this->belongsTo(ProfessionalType::class, 'profession');
    }
    public function rank()
    {
        return $this->belongsTo(Ranks::class, 'rank');
    }
}
