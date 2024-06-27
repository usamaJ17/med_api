<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles , InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'contact',
        'email',
        'password',
        'otp',
        'is_verified',
        'dob',
        'gender',
        'country',
        'state',
        'city',
        'height',
        'weight',
        'language',
        'forgot_password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
     protected $appends = ['role'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function getRoleAttribute()
    {
        return $this->roles->pluck('name')[0] ?? ''  ;
    }
    public function professionalDetails()
    {
        return $this->hasOne(ProfessionalDetails::class);
    }
    public function medicalDetails()
    {
        return $this->hasOne(MedicalDetail::class);
    }
}