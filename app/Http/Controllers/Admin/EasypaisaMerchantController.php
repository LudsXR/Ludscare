<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EasypaisaMerchant;

class EasypaisaMerchantController extends Controller
{

    public function addPayment()
    {
        $detail=EasypaisaMerchant::all();
        return view('new_admin.payment_gateway.easypaisa_config',compact('detail'));
    }

    public function savePayment(Request $request)
    {
        $rules = [
    		'storeId' => 'required',
            'hash' => 'required',
    	];

    	$request->validate($rules);
         $data = $request->all();
        $existing_data = EasypaisaMerchant::first();
        if($existing_data)
        {
            if($existing_data->update($data))
            {
                $notify[] = ['success', 'Payment Configuration has been Updated'];
        	    return redirect()->route('admin.easypaisa_payment_gateway.add')->withNotify($notify);
            }
        }
        if($created = EasypaisaMerchant::create($data)){
			$notify[] = ['success', 'Payment has been added'];
        	return redirect()->route('admin.easypaisa_payment_gateway.add')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}

    }
}
