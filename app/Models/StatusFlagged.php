<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusFlagged extends Model
{
    //
    protected $table = "status_flagged";

    protected $fillable = [
        'id',
        'user_id',
        'status_id',
        'reason',
        'created_at',
        'updated_at',
    ];
}
