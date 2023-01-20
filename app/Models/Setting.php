<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = "settings";
    protected $fillable = ["name","display_name","value","category","is_specific"];

    public function scopeNotifications($query)
    {
       return $query->where('is_specific',1);
    }
}
