<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class MentorCardDetail extends Model
{
    use HasFactory;
    protected $table = "mentor_card_detail";
    public $timestamps = false;
    protected $fillable = [
        "account_title","account_number","bank","mentor_id"
    ];
    public function mentor(){
        return $this->hasOne(User::class,'id','mentor_id');
    }
}
