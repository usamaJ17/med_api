<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class VitalSigns extends Model
{
    use HasFactory;
    protected $table='vital_signs';
    protected $fillable =[
        'user_id',
        'pulse_rate',
        'temprature',
        'spo',
        'blood_pressure',
        'respiratory_rate',
        'submited_by'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function submitedBy(){
        return $this->belongsTo(User::class, 'submited_by', 'id');
    }
    // public function getSubmitedByAttribute(){
    //     $user = User::find($this->submited_by);
    //     if($user){
    //         return $user->fullName();
    //     }
    // }
}
