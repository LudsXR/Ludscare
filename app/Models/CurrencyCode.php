<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyCode extends Model
{
    use HasFactory;
    protected $table = "currency_codes";
    protected $fillable = [
        "code","symbol"
    ];

}
