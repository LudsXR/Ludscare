<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Role;

class RoleUser extends Model
{
    use HasFactory;
    protected $table = "users_roles";
    protected $fillable = [
        'user_id','role_id'
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function role(){
        return $this->hasOne(Role::class,'id','role_id');
    }

}
