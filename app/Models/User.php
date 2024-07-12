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
        'language',
        'is_live',
        'forgot_password',
        'speak'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'temp_role',
        'professional_type',
        'roles',
        'media'
    ];
     protected $appends = ['role','professional_type_name','profile_image'];

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
    public function getProfessionalTypeNameAttribute()
    {
        return $this->professionalType->name ?? '';
    }
    public function getProfileImageAttribute()
    {
        return $this->getFirstMediaUrl();
    }
    /**
     * Get the prepared user data.
     *
     * @return array
     */
    public function prepareUserData()
    {
        $data = $this->attributesToArray();
        return $data;
    }

    public function professionalMetaData()
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
        // I want count of all appointment with unique users , but only those users whose all appointments have completed status
        $recovered = Appointment::where('med_id', $this->id)->get()->groupBy('user_id')->filter(function ($appointments) {
            return $appointments->where('patient_status', 'recovered')->count() == $appointments->count();
        })->count();
        $in_progress = Appointment::where('med_id', $this->id)->where('patient_status', 'in_progress')->get()->groupBy('user_id')->count();
        $data = [
            'all_patient_count' => $all_patient_count,
            'new_patient_count' => $new_patient_count,
            'number_appointment' => $number_appointment,
            'done_appointment' => $done_appointment,
            'upcoming_appointment' => $upcoming_appointment,
            'cancel_appointment' => $cancel_appointment,
            'total_article' => $total_article,
            'completed_consultation' => $completed_consultation,
            'recovered_patient' => $recovered,
            'intreatment_patient' => $in_progress,
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
    // hide temp_role attribute
}