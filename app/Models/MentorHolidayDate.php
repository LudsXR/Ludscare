<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentorHolidayDate extends Model
{
    use HasFactory;
    protected $table = "mentor_holiday_date";
    public $timestamps = false;
    protected $fillable = [
        "mentor_id","date","is_holiday",'comment'
    ];

    public  function mentor()
    {
        return $this->hasOne(User::class,'id','mentor_id');
    }

}
