<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use App\Models\PaymentMethodSetting;




class PaymentMethod extends Model
{

    use HasFactory;
    public $translatable = ['name','description'];
    protected $fillable = ['name','description','code','image_path','is_active','is_default'];

    public function settings(){
      return $this->hasMany(PaymentMethodSetting::class,'payment_method_id');
    }
    public function scopeActive($query)
      {
       return $query->where('is_active',1);
      }
  public function scopeWeb($query)
      {
        return $query->where('is_web',1);
      }
  public function scopeApp($query)
        {
            return $query->where('is_app',1);
      }


}
