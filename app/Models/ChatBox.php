<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatBox extends Model
{
    use HasFactory;

    /**
     * @var \Illuminate\Support\HigherOrderCollectionProxy|mixed
     */

    /**
     * @var \Illuminate\Support\HigherOrderCollectionProxy|int|mixed
     */
    protected $table = 'chat_box';
    protected $fillable = ['sender_id', 'receiver_id', 'status','appointment_id','notification_to' , 'expired_at' ,'unread_count_sender' , 'unread_count_receiver'];
    protected $appends = ['notification','name','last_message' , 'unread_count'];
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
    public function getCreatedAtAttribute()
    {
        return $this->messages->last()->updated_at;
    }

    public function appointment(){
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function getUnreadCountAttribute(){
        if(auth()->user()->id == $this->sender_id){
            return $this->unread_count_sender;
        }else{
            return $this->unread_count_receiver;
        }
    }
}
