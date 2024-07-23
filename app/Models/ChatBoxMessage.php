<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatBoxMessage extends Model
{
    use HasFactory;
    protected $table = 'chat_box_messages';
    protected $fillable = ['chat_box_id', 'from_user_id', 'to_user_id', 'message', 'is_read'];
    protected $appends = ['type'];

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
}
