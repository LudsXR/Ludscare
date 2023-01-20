<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Blog;
class BlogCategory extends Model
{
    use HasFactory;

    protected $table = "blog_category";
    protected $fillable = [
        "name","slug","image_path","description"
    ];
    public function blog(){
        return $this->belongsTo(Blog::class,'id','category_id');
    }
}
