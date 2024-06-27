<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ranks extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug'];
    protected $table = 'ranks';
}
