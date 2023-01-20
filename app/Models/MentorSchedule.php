<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AppointmentType;
use App\Models\User;
use App\Models\Mentor;

use App\Models\MentorScheduleSlot;
class MentorSchedule extends Model
{
    use HasFactory;
    protected $table = "mentor_schedules";
    protected $fillable = [
        "mentor_id","appointment_type_id","fee",'day','is_holiday','is_active'
    ];
    public  function appointment_type()
    {
        return $this->hasOne(AppointmentType::class,'id','appointment_type_id');
    }
    public  function mentor_user()
    {
        return $this->hasOne(User::class,'id','mentor_id');
    }
    public  function mentor()
    {
        return $this->hasOne(Mentor::class,'user_id','mentor_id');
    }
    public function schedule_slots(){
        return $this->hasMany(MentorScheduleSlot::class,'schedule_id','id');
    }
}
