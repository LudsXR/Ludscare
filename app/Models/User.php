<?php

namespace App\Models;

use App\Permissions\HasPermissionsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use App\Models\Mentor;
use App\Models\Mentee;
use App\Models\RoleUser;
use App\Models\MentorEducation;
use App\Models\MentorExperience;
use App\Models\MentorCardDetail;
use App\Models\BookAppointment;
use App\Models\UserFcmToken;
use App\Models\Message;
use App\Models\Country;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Interfaces\Wallet;

class User extends Authenticatable implements Wallet
{
    use HasApiTokens, HasFactory, Notifiable,HasPermissionsTrait,HasWallet;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'image_path',
        'country',
        'city',
        'address',
        'postal_code',
        'password',
        'father_name',
        'cnic',
        'gender',
        'religion',
        'dob',
        'occupation',
        "online_status",
        'device_key',
        'admin_user',
        'fb_id',
        'google_id',
        'about'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function messages()
    {
    return $this->hasMany(Message::class);
    }
    public function role(){

        return $this->belongsTo(RoleUser::class, 'id','user_id');

    }
    public function mentee()
    {
        return $this->hasOne(Mentee::class,'user_id','id');
    }
    public function mentor()
    {
        return $this->hasOne(Mentor::class,'user_id','id');
    }
    public function educations(){
        return $this->hasMany(MentorEducation::class,'mentor_id','id');
    }
    public function fcmtokens(){
        return $this->hasMany(UserFcmToken::class,'user_id','id');
    }
    public function experiences(){
        return $this->hasMany(MentorExperience::class,'mentor_id','id');
    }
    public function card_detail(){
        return $this->belongsTo(MentorCardDetail::class,'id','mentor_id');
    }
    public function mentor_appointment(){
        return $this->belongsTo(BookAppointment::class,'id','mentor_id');
    }
    public function mentee_appointment(){
        return $this->belongsTo(BookAppointment::class,'id','mentee_id');
    }

    public function ratings(){
        return $this->belongsTo(Rating::class,'id','mentor_id');
    }
    public  function user_country()
    {
        return $this->hasOne(Country::class,'id','country');
    }
    public function schedule(){
        return $this->hasMany(MentorSchedule::class,'mentor_id');
    }
}
