<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'med_id',
        'appointment_type',
        'consultation_fees',
        'chat_id',
        'appointment_time',
        'appointment_date',
        'gender',
        'age',
        'problem',
        'patient_status',
        'is_paid',
        'gateway',
        'transaction_id',
        'appointment_code',
        'pay_for_me',
        'diagnosis',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
    public function med()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
    protected $appends = ['patient_name', 'fee_int', 'patient_profile_url', 'med_name', 'med_profile_url', 'med_lang', 'patient_lang', 'chat_status'];
    public function getPatientNameAttribute()
    {
        return \App\Models\User::getNameWithTrashed($this->user_id);
    }

    public function getChatStatusAttribute()
    {
        $chatBox = ChatBox::where(["sender_id" => $this->user_id])->where(["receiver_id" => $this->med_id])->first();
        if (!$chatBox) {
             $chatBox = ChatBox::where(["sender_id" => $this->med_id])->where(["receiver_id" => $this->user_id])->first();
        }
        if ($chatBox) {
            return $chatBox->status;
        } else {
            return null;
        }   
    }
    public function getFeeIntAttribute()
    {
        // remove any non integer characters
        return (int)filter_var($this->consultation_fees, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getPatientProfileUrlAttribute()
    {
        $user = User::find($this->user_id);
        return $user->getFirstMediaUrl();
    }
    public function getMedNameAttribute()
    {
        return \App\Models\User::getNameWithTrashed($this->med_id);
    }
    public function getMedProfileUrlAttribute()
    {
        $user = User::find($this->med_id);
        return $user->getFirstMediaUrl();
    }
    public function getMedLangAttribute()
    {
        $user = User::find($this->med_id);
        return $user->language;
    }
    public function getPatientLangAttribute()
    {
        $user = User::find($this->user_id);
        return $user->language;
    }
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function getChatIdAttribute()
    {
        $chatBox = ChatBox::where(["sender_id" => $this->user_id])->where(["receiver_id" => $this->med_id])->first();
        if (!$chatBox) {
             $chatBox = ChatBox::where(["sender_id" => $this->med_id])->where(["receiver_id" => $this->user_id])->first();
        }
        if ($chatBox) {
            return $chatBox->id;
        } else {
            return null;
        }   
    }
}
