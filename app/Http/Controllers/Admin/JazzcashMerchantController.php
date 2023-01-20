<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JazzcashMerchant;

class JazzcashMerchantController extends Controller
{

    public function addPayment()
    {
        $detail=JazzcashMerchant::all();
        return view('new_admin.payment_gateway.jazzcash_config',compact('detail'));
    }

    public function savePayment(Request $request)
    {
        $rules = [
    		'merchant_id' => 'required',
            'password' => 'required',
            'hash' => 'required',
    	];

    	$request->validate($rules);
         $data = $request->all();
        $existing_data = JazzcashMerchant::all();
        if(!$existing_data->isEmpty())
        {
            $found = JazzcashMerchant::find(1)->first();
            if($found->update($data))
            {
                $notify[] = ['success', 'Payment Configuration has been Updated'];
        	    return redirect()->route('admin.payment_gateway.add')->withNotify($notify);
            }

        }
        if($created = JazzcashMerchant::create($data)){

			$notify[] = ['success', 'Payment has been added'];
        	return redirect()->route('admin.payment_gateway.add')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}

    }
}
