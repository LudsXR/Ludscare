<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        "mentee_id","mentor_id",'appointment_id',"rating","comments"
    ];
    public function mentor(){
        return $this->hasOne(User::class,'id','mentor_id');
    }
    public function mentee(){
        return $this->hasOne(User::class,'id','mentee_id');
    }
    public function appointment(){
        return $this->hasOne(BookAppointment::class,'id','appointment_id');
    }
}
