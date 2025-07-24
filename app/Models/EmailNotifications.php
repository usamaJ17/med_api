<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailNotifications extends Model
{
    protected $table = 'email_notifications';
    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];
    protected $fillable = ['email', 'name', 'type', 'status', 'sent_at', 'scheduled_at'];
}
