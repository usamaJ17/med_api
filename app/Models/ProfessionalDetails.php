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
    protected $appends = ['profession_type', 'rank_name','id_card','signature','degree_file'];
    protected $hidden = ['media'];
    
    // Define relationships, if any
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function professions()
    {
        return $this->belongsTo(Professions::class, 'profession');
    }
    public function ranks()
    {
        return $this->belongsTo(Ranks::class, 'rank');
    }
    public function getProfessionTypeAttribute()
    {
        return ProfessionalType::find($this->profession)->name ?? '';
    }
    public function getRankNameAttribute()
    {
        return Ranks::find($this->rank)->name ?? '';
    }
    public function getIdCardAttribute()
    {
        return $this->getFirstMediaUrl('id_card');
    }
    public function getSignatureAttribute()
    {
        return $this->getFirstMediaUrl('signature');
    }
    public function getDegreeFileAttribute()
    {
        return $this->getFirstMediaUrl('degree_file');
    }
    
}
