<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentorOccupation extends Model
{
    use HasFactory;
    protected $table = "mentor_occupations";
    protected $fillable = [
        "name"
    ];
}
