<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ProfessionalType extends Model implements HasMedia
{
    use HasFactory;
    use interactsWithMedia;
    protected $table = 'professional_types';
    protected $fillable = ['name', 'chat_fee',  'audio_fee',  'video_fee', 'icon' , 'minimum_fee'];


    public function professionals()
    {
        return $this->hasMany(User::class, 'professional_type_id', 'id');
    }
    public function getIconAttribute($value): string
    {
        return $this->getFirstMediaUrl() ?: $value;
    }
}
