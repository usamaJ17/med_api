<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyHelp extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'med_id',
        'emergency_type',
        'status',
        'requested_at',
        'amount',
        'method',
        'is_mid_night',
        'description',
        'gender',
        'age',
    ];

    protected $appends = ["chat_id", "chat_status"];

    protected $table = 'emergency_help';
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function med()
    {
        return $this->belongsTo(User::class, 'med_id');
    }


    public function getChatStatusAttribute()
    {
        $chatBox = ChatBox::where(["sender_id" => $this->user_id])->where(["receiver_id" => $this->med_id])->first();
        if ($chatBox) {
            return $chatBox->id;
        } else {
            return null;
        }
    }
    public function getChatIdAttribute()
    {
        $chatBox = ChatBox::where(["sender_id" => $this->user_id])->where(["receiver_id" => $this->med_id])->first();
        if ($chatBox) {
            return $chatBox->id;
        } else {
            return null;
        }
    }
}
