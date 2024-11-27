<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleReadUser extends Model
{
    protected $table = "artcle_read_users";
    protected $fillable = ["article_id", "user_id"];
}
