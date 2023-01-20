<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JazzcashMerchantController;

class JazzcashMerchant extends Model
{
    use HasFactory;
    protected $table = "jazzcash_merchant";
    protected $fillable = [
        "merchant_id","password","hash"
    ];
}
