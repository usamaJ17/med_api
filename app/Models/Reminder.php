<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;
    protected $table = 'reminder';
    protected $fillable = [
        'title',
        'note',
        'status',
        'role'
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'reminder_user')
            ->withPivot('is_read')
            ->using(ReminderUser::class)
            ->withTimestamps();
    }
}
