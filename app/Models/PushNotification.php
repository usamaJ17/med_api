<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    protected $table = 'push_notifications';
    protected $fillable = ['title' , 'to_role' , 'body' , 'is_sent' , 'scheduled_at'];
    protected $casts = [
        'scheduled_at' => 'datetime:Y-m-d H:i:s',
    ];
}
