<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusViews extends Model
{
    //
    protected $table = "status_views";

    protected $fillable = [
        'id',
        'user_id',
        'status_id',
        'created_at',
        'updated_at',
    ];

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }


}
