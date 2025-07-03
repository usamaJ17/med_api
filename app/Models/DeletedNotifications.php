<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeletedNotifications extends Model
{
    protected $table = '';
    protected $fillable = ['email', 'name', 'type', 'scheduled_at'];
}
