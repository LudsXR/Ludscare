<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MentorSchedule;
class AppointmentType extends Model
{
    use HasFactory;
    protected $table = "appointment_types";
    protected $fillable = [
        "name","is_schedule_required"
    ];

    public function mentorSchedule(){
        return $this->belongsTo(MentorSchedule::class,'appointment_type_id','id');
    }
}
