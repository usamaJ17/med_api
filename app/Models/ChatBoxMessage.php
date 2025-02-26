<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ChatBoxMessage extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'chat_box_messages';
    protected $fillable = ['chat_box_id', 'from_user_id','message_type', 'to_user_id', 'message', 'is_read'];
    protected $appends = ['type'];
    protected $hidden = ['media'];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
    public function chatBox()
    {
        return $this->belongsTo(ChatBox::class, 'chat_box_id');
    }
    public function markRead()
    {
        $this->is_read = 1;
        $this->save();
    }
    public function markUnread()
    {
        $this->is_read = 0;
        $this->save();
    }
    public function getTypeAttribute()
    {
        return $this->from_user_id == auth()->id() ? 'sent' : 'received';
    }
    public function getMessageAttribute()
    {
        $media = $this->getFirstMedia();
        if ($media) {
            return $media->getFullUrl();
        }
        return $this->attributes['message'];
    }
    public function getCreatedAtAttribute(): ?string
    {
        return $this->convertTimezone($this->created_at);
    }

    public function getUpdatedAtAttribute(): ?string
    {
        return $this->convertTimezone($this->updated_at);
    }

    private function convertTimezone($timestamp): ?string
    {
        return config('app.timezone');
        $timezone = auth()->check() && auth()->user()->time_zone
            ? auth()->user()->time_zone
            : config('app.timezone');

        return $timestamp ? Carbon::parse($timestamp)->timezone($timezone)->toDateTimeString() : null;
    }
}
