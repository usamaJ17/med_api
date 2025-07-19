<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Status extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'caption',
        'scheduled_at',
        'expires_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // ============================
    // Relationships
    // ============================

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function views()
    {
        return $this->hasMany(StatusView::class);
    }

    public function reactions()
    {
        return $this->hasMany(StatusReaction::class);
    }

    public function flags()
    {
        return $this->hasMany(StatusFlag::class);
    }

    // ============================
    // Helpers
    // ============================

    public function isExpired(): bool
    {
        return now()->greaterThan($this->expires_at);
    }

    public function reactionBy($userId)
    {
        return $this->reactions()->where('user_id', $userId)->first();
    }

    public function wasViewedBy($userId): bool
    {
        return $this->views()->where('viewer_id', $userId)->exists();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('status_media')->singleFile();
    }
}
