<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleReadUser extends Model
{
    protected $table = "article_read_user";
    protected $fillable = ["article_id", "user_id"];
}
