<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MentorAssignCategory;
class MentorCategory extends Model
{
    use HasFactory;

    protected $table = "mentor_category";
    protected $fillable = [
        "parent_id","name","image_path","description","slug"
    ];
    public function category(){
        return $this->hasOne(MentorAssignCategory::class,'category_id','id');
    }
    public function parentCategory(){
        return $this->belongsTo(MentorCategory::class,'parent_id','id');
    }
    public function subCategories(){
        return $this->hasMany(MentorCategory::class,'parent_id');
    }
}
