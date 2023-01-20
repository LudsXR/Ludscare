<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'message','sender_id','sender_name','receiver_id','receiver_name'
    ];

    public  function mentee()
    {
        return $this->belongsTo(User::class,'sender_id','id');
    }
    public  function mentor()
    {
        return $this->belongsTo(User::class,'sender_id','id');
    }

}
