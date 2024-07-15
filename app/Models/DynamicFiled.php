<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicFiled extends Model
{
    use HasFactory;
    protected $table = 'dynamic_fields';
    protected $fillable = ['name', 'data'];
}
