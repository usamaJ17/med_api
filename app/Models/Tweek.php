<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweek extends Model
{
    use HasFactory;
    protected $table = 'tweek';
    protected $fillable=[
        'type','value'
    ];
}
