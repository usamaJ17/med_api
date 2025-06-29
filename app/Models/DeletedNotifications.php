<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeletedNotifications extends Model
{
    protected $table = 'deleted_notification';
    protected $fillable = ['email', 'name', 'scheduled_at'];
}
