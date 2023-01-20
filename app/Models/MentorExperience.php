<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mentor;
class MentorExperience extends Model
{
    use HasFactory;
    protected $table ='mentor_experience';

    protected $fillable = [
        'mentor_id',
        'company',
        'from',
        'to',
        'image_path',
    ];

    public function user(){
        return $this->belongsTo(Mentor::class,'mentor_id','user_id');
    }
}
