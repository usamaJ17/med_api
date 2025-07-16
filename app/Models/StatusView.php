<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusView extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_id',
        'viewer_id',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function viewer()
    {
        return $this->belongsTo(User::class, 'viewer_id');
    }
}
