<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, InteractsWithMedia, SoftDeletes;

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
        'verification_requested_at',
        'dob',
        'parent_id',
        'gender',
        'country',
        'professional_type_id',
        'state',
        'city',
        'language',
        'verification_url',
        'is_live',
        'can_emergency',
        'can_night_emergency',
        'forgot_password',
        'name_title',
        'speak',
        'time_zone',
        'device_token',
        'is_send_for_incomplete',
        'deleted_by'
    ];

    protected $excludeFields = ['id', 'password', 'professional_type_id', 'is_send_for_incomplete' , 'user_id', 'verification_url', 'language', 'parent_id', 'remember_token', 'otp', 'is_verified', 'temp_role', 'created_at', 'updated_at', 'verification_requested_at', 'forgot_password', 'email_verified_at', 'otp_verified_at', 'device_token'];

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
    protected $appends = ['role', 'professional_type_name', 'profile_image', 'followers_count', 'following_count'];

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
        return $this->roles->pluck('name')[0] ?? '';
    }
    public function fullName()
    {
        return $this->name_title . ' ' . $this->first_name . ' ' . $this->last_name;
    }
    public function getProfessionalTypeNameAttribute()
    {
        return $this->professionalType->name ?? '';
    }
    public function getProfileImageAttribute()
    {
        // return $this->getFirstMediaUrl();
        $profileImageUrl = $this->getFirstMediaUrl();
        return $profileImageUrl ?: asset('default-avatar.png');
    }
    /**
     * Get the prepared user data.
     *
     * @return array
     */
    public function prepareUserData()
    {
        $data = $this->attributesToArray();
        $data['balance'] = $this->wallet->balance ?? 0.00 ;
        return $data;
    }
    public function prepareArticleAuthorData()
    {
        $data = $this->attributesToArray();
        if($data['role'] == 'admin'){
            $data['first_name'] = 'Deluxe Care Team';
            $data['last_name'] = '';
            $data['name_title'] = '';
            $data['profile_image'] = url('/uploads/logo.jpeg');
        }
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
        $avg_rating = Review::where('med_id', $this->id)->avg('rating');
        // fix avg rating to 2 decimal places
        $avg_rating = number_format((float)$avg_rating, 2, '.', '');
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
            'averageg_rating' => $avg_rating,
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
    public function MedReviews()
    {
        // return Review::where('med_id', $this->id)->get();
        return $this->hasMany(Review::class, 'med_id'); 
    }
    public function userReviews()
    {
        return Review::where('user_id', $this->id)->get();
    }
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }
    /**
     * Get all fields except the excluded ones.
     *
     * @return array
     */
    public function getAllProfessionalFields()
    {
        // Get all the attributes of the current model
        $allFields = array_keys($this->getAttributes());
        $filteredFields = array_diff($allFields, $this->excludeFields);

        // Get the related ProfessionalDetails model instance
        $professionalDetails = $this->professionalDetails()->first();

        if ($professionalDetails) {
            // Get the attributes of the related model
            $proAllFields = array_keys($professionalDetails->getAttributes());
            $proFilteredFields = array_diff($proAllFields, $this->excludeFields);

            // Merge the fields of the current model with the related model fields
            $filteredFields = array_merge($filteredFields, $proFilteredFields);
        }
        $data = [];
        foreach ($filteredFields as $field) {
            $data[$field] = ucwords(str_replace('_', ' ', $field));
        }
        return $data;
    }
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }
    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }
    public function getFollowersCountAttribute()
    {
        return $this->followers()->count();
    }
    public function getFollowingCountAttribute()
    {
        return $this->following()->count();
    }
    public function GetAllMedia()
    {
        $array = [];
        $med_details = $this->medicalDetails;
        $pro_details = $this->professionalDetails;

        if ($med_details) {
            foreach ($med_details->media as $media) {
                $key = ucfirst(str_replace("file_type_", "", $media->collection_name));
                $array[$key] = $media->getUrl();
            }
        }

        if ($pro_details) {
            foreach ($pro_details->media as $media) {
                $key = ucfirst(str_replace("file_type_", "", $media->collection_name));
                $array[$key] = $media->getUrl();
            }
        }

        return $array;
    }
    public function GetProfileUploads()
    {
        $array = [];
        $media =  $this->getMedia('profile_uploads');
        foreach ($media as $med) {
            $img_data = [
                'name' => $this->fullName(),
                'file_name' => $med->name,
                'created_at' => $med->created_at,
                'url' => $med->getUrl(),
                'comment' => $med->getCustomProperty('comment') ?? null
            ];
            $array[] = $img_data;
        }
        return $array;
    }
    public function reminders(): BelongsToMany
    {
        return $this->belongsToMany(Reminder::class, 'reminder_user')
            ->withPivot('is_read')
            ->using(ReminderUser::class)
            ->withTimestamps();
    }
    public function wallet()
    {
        return $this->hasOne(UserWallet::class);
    }
    public static function getNameWithTrashed($id)
    {
        $user = self::find($id);
        $deleted = false;
        if (!$user) {
            $user = self::withTrashed()->find($id);
            $deleted = $user && $user->trashed();
        }
        if ($user) {
            $name = trim($user->first_name . ' ' . $user->last_name);
            return $deleted ? $name . ' (deleted)' : $name;
        }
        return null;
    }
}
