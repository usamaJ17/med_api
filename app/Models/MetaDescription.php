<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaDescription extends Model
{
    protected $table = 'meta_description';
    protected $fillable = [
        'uid',
        'title',
        'description',
    ];
}
