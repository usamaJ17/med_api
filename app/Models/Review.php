<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'reviews';
    protected $fillable = [
        'user_id',
        'med_id',
        'given_by',
        'appointment_id',
        'body',
        'rating',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function med()
    {
        return $this->belongsTo(User::class);
    }
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
