<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;
use App\Models\Role;
class RolePermission extends Model
{
    use HasFactory;
    protected $table ='roles_permissions';
    public $timestamps = false;

    protected $fillable = ['role_id','permission_id'];

    public function permissions(){
        return $this->hasMany(Permission::class,'id','permission_id');
    }
    public function roles(){
        return $this->hasMany(Role::class,'id','role_id');
    }
}
