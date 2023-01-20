<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BlogCategory;
class Blog extends Model
{
    use HasFactory;
    protected $table = "blog";
    protected $fillable = [
        "category_id","slug","title","description",'image_path','featured','is_approved','user_id'
    ];
    public function category(){
        return $this->hasMany(BlogCategory::class,'id','category_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}
