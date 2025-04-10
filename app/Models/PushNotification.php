<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PushNotification extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $table = 'push_notifications';
    protected $fillable = ['title' , 'to_role' , 'body' , 'is_sent' , 'scheduled_at'];
    protected $casts = [
        'scheduled_at' => 'datetime:Y-m-d H:i:s',
    ];
    /**
     * Register media collections for the model.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('notification_image')
             ->singleFile()
             ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif']);
    }

    /**
     * Get the URL of the notification image.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('notification_image') ?: null;
    }
}
