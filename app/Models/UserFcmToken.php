<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserFcmToken extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','device_key','device_id'];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class,'id','user_id');
    }
}
