<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
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
        'professional_type_id',
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
     protected $appends = ['role','professional_meta_data','professional_type_name'];

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
    /**
     * Get the prepared user data.
     *
     * @return array
     */
    public function prepareUserData()
    {
        $data = $this->attributesToArray();
        $data['profile_image'] = $this->getFirstMediaUrl();
        $data['professional_type_name'] = $this->professionalType->name ?? '';
        unset($data['media']);
        unset($data['roles']);
        unset($data['professional_type']);
        return $data;
    }

    public function getProfessionalMetaDataAttribute()
    {
        if (!$this->hasRole('medical')) {
            return [];
        }
        // get number of unique patients
        $all_patient_count = Appointment::where('med_id', $this->id)->count();
        $new_patient_count = Appointment::where('med_id', $this->id)->distinct('user_id')->count();
        $number_appointment = Appointment::where('med_id', $this->id)->count();
        $done_appointment = Appointment::where('med_id', $this->id)->where('status', 'completed')->count();
        $upcoming_appointment = Appointment::where('med_id', $this->id)->where('status', 'upcoming')->count();
        $cancel_appointment = Appointment::where('med_id', $this->id)->where('status', 'cancelled')->count();
        $total_article = Article::where('user_id', $this->id)->count();
        $completed_consultation = Appointment::where('med_id', $this->id)->where('status', 'completed')->count();
        $data = [
            'all_patient_count' => $all_patient_count,
            'new_patient_count' => $new_patient_count,
            'number_appointment' => $number_appointment,
            'done_appointment' => $done_appointment,
            'upcoming_appointment' => $upcoming_appointment,
            'cancel_appointment' => $cancel_appointment,
            'total_article' => $total_article,
            'completed_consultation' => $completed_consultation,
        ];
        return $data;
    }

    /**
     * Define the relationship to professional details.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function professionalDetails()
    {
        return $this->hasOne(ProfessionalDetails::class);
    }

    /**
     * Define the relationship to medical details.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function medicalDetails()
    {
        return $this->hasOne(MedicalDetail::class);
    }
    public function professionalType()
    {
        return $this->belongsTo(ProfessionalType::class);
    }
}