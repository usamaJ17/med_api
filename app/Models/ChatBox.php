<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatBox extends Model
{
    use HasFactory;

    /**
     * @var \Illuminate\Support\HigherOrderCollectionProxy|int|mixed
     */
    protected $table = 'chat_box';
    protected $fillable = ['sender_id', 'receiver_id', 'status','appointment_id','notification_to' , 'unread_count'];
    protected $appends = ['notification','name','last_message'];
    protected $hidden = ['notification_to'];


    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function messages()
    {
        return $this->hasMany(ChatBoxMessage::class, 'chat_box_id');
    }
    public function getNotificationAttribute()
    {
        return $this->notification_to == auth()->id() ? true : false;
    }
    public function getNameAttribute()
    {
        return $this->sender_id == auth()->id() ? $this->receiver->first_name : $this->sender->first_name;
    }
    public function getLastMessageAttribute()
    {
        return $this->messages->last();
    }
}
