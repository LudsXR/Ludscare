<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentorDegree extends Model
{
    use HasFactory;
    protected $table = "mentor_degrees";
    protected $fillable = [
        "name"
    ];
}
