<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ReminderUser extends Pivot
{
    protected $table = 'reminder_user';

    protected $fillable = [
        'user_id',
        'reminder_id',
        'is_read',
    ];
}
