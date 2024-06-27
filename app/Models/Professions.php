<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professions extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug'];
    protected $table = 'professions';
}
