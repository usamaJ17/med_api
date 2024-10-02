<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummaryDynamicField extends Model
{
    use HasFactory;
    protected $table = 'summary_dynamic_fields';
    protected $fillable = ['user_id','fields'];
}
