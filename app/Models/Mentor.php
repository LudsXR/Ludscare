<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\MentorAssignCategory;
use App\Models\MentorCardDetail;
use App\Models\MentorSchedule;
use App\Models\Rating;
class Mentor extends Model
{
    use HasFactory;
    protected $table ='mentor';

    protected $fillable = [
        'user_id',
        'mentor_category_id',
        'description',
        'status',
        'payment_type',
        'is_active',
        'is_verified',
        'parent_category_id',
        'fee',
        'is_featured',
        'is_live'
    ];
    public function bank(){
        return $this->belongsTo(MentorCardDetail::class,'user_id','mentor_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function categories(){
        return $this->hasMany(MentorAssignCategory::class,'mentor_id','user_id');
    }
    // public function category(){

    //     return $this->hasOne(MentorCategory::class,'id', 'mentor_category_id');

    // }
    // public function parent_category(){

    //     return $this->hasOne(MentorCategory::class,'id', 'parent_category_id');

    // }
    public function ratings(){
        return $this->hasMany(Rating::class,'mentor_id','user_id');
    }
    public function education()
    {
        return $this->hasMany(MentorEducation::class, 'mentor_id', 'user_id');
    }

    public function experience()
    {
        return $this->hasMany(MentorExperience::class, 'mentor_id', 'user_id');
    }
    public function schedule(){
        return $this->belongsTo(MentorSchedule::class,'user_id','mentor_id');
    }
    public function appointments(){
        return $this->belongsTo(BookAppointment::class,'user_id','mentor_id');
    }

}
