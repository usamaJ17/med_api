<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportGroup extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'url','type'];
}
