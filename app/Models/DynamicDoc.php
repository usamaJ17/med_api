<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicDoc extends Model
{
    use HasFactory;
    protected $table = 'dynamic_docs';
    protected $fillable = ['title', 'doc_type'];
}
