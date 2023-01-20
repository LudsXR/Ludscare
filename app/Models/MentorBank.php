<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentorBank extends Model
{
    use HasFactory;
    protected $table = "mentor_banks";
    protected $fillable = [
        "name"
    ];
}
