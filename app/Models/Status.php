<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //
    protected $table = "statuses";

    protected $fillable = [
        'id',
        'user_id',
        'file_path',
        'caption',
        'expires_at',
        'created_at',
        'updated_at',
    ];

    public function healthProfessional() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function views()
    {
        return $this->hasMany(StatusViews::class, 'status_id', 'id');
    }

    public function reactions() {
        return $this->hasMany(StatusReactions::class);
    }

    public function flagged() {
        return $this->hasMany(StatusFlagged::class);
    }

}
