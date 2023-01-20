<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BookAppointment;
class Mentee extends Model
{
    use HasFactory;

    protected $table = "mentee";
    protected $fillable = [
        "user_id","identity_hidden","description","wallet_id","wallet_amount","is_active"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function appointments(){
        return $this->belongsTo(BookAppointment::class,'user_id','mentee_id');
    }


}
