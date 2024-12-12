<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Article extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['category_id', 'user_id', 'title', 'body', 'thumbnail','share_count','published'];
    protected $hidden = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(ArticleCategory::class,'category_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    protected $appends = ['author','thumbnail_url','video_url','like_count','comment_count'];

    public function getAuthorAttribute()
    {
        return $this->user ? $this->user->prepareUserData() : null;
    }
    public function getThumbnailUrlAttribute()
    {
        $profileImageUrl = $this->getFirstMediaUrl('thumbnails');
        return $profileImageUrl ?: asset('dashboard/images/article.jpg');
        // return $this->getFirstMediaUrl('thumbnails');
    }
    public function getVideoUrlAttribute()
    {
        return $this->getFirstMediaUrl('video');
    }
    public function getLikeCountAttribute()
    {
        return $this->likes->count();
    }
    public function getCommentCountAttribute()
    {
        return $this->comments->count();
    }
}
