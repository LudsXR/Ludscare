<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mentor;
use App\Models\MentorCategory;

class MentorAssignCategory extends Model
{
    use HasFactory;
    protected $table = "mentor_assign_categories";
    public $timestamps = false;
    protected $fillable = [
        'mentor_id','category_id'
    ];
    public function mentor(){
        return $this->hasOne(Mentor::class,'user_id','mentor_id');
    }
    public function category(){
        return $this->belongsTo(MentorCategory::class,'category_id','id');
    }
}
