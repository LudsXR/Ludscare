<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;
    protected $table = "general_setting";
    public $timestamps = false;
    protected $fillable = [
        "logo","tagline","title","seo_Des","seo_keywords","facebook_link","twitter_link",
        "linkden_link","address","phone","company_email","about_company","currency_symbol"
    ];
}
