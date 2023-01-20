<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsLetter extends Model
{
    use HasFactory;
    protected $table = "newsletter_list";
    protected $fillable = [
        "email","is_subscriber"
    ];
}
