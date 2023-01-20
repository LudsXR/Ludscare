<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testinomial extends Model
{
    use HasFactory;
    protected $table = "testinomials";
    protected $fillable = [
        "name","description",'image_path','is_featured'
    ];
    public function scopeFeatured($query){
        return $query->where('is_featured', 1);
    }
}
