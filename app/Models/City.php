<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
class City extends Model
{
    use HasFactory;
    protected $table = "cities";
    public $timestamps = false;
    protected $fillable = [
        "name"
    ];
    public function country(){
        return $this->belongsTo(Country::class,'country_id','id');
    }
}
