<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use App\Models\User;
class Country extends Model
{
    use HasFactory;
    protected $table = "countries";
    public $timestamps = false;
    protected $fillable = [
        "name"
    ];
    public function cities(){
        return $this->hasMany(City::class,'country_id','id');
    }
    public  function user()
    {
        return $this->belongsTo(User::class,'id','country');
    }
}
