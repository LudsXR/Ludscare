<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class WithDrawRequest extends Model
{
    use HasFactory;
    protected $table ='withdraw_request';

    protected $fillable = [
        'user_id',
        'amount',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
