<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusReactions extends Model
{
    //
    protected $table = "status_reactions";

    protected $fillable = [
        'id',
        'user_id',
        'status_id',
        'emoji',
        'created_at',
        'updated_at',
    ];

        public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id', 'id');
    }


}
