<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailNotifications extends Model
{
    protected $table = 'email_notifications';
    protected $fillable = ['email', 'name', 'type', 'status', 'sent_at', 'scheduled_at'];
}
