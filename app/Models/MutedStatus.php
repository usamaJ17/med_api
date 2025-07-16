<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutedStatus extends Model
{
    //
    protected $table = "muted_statuses";

    protected $fillable = [
        'id',
        'user_id',
        'muted_user_id',
        'created_at',
        'updated_at'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function mutedStatusUser() {
        return $this->belongsTo(User::class, 'id');
    }
}
