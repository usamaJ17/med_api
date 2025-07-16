<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusFlag extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_id',
        'user_id',
        'reason',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
