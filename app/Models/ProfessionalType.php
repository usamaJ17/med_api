<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalType extends Model
{
    use HasFactory;
    protected $table = 'professsional_types';
    protected $fillable = ['name', 'chat_fee',  'audio_fee',  'video_fee', 'icon' , 'minimum_fee'];

    public function professionals()
    {
        return $this->hasMany(User::class, 'professional_type_id', 'id');
    }
}
