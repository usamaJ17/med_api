<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'type',
        'from_user_id',
        'to_user_id',
        'is_read',
    ];
    protected $table="notifications";
}
