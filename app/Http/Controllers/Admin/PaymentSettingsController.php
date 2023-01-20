<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethodSetting;
use App\Models\PaymentMethod;
class PaymentSettingsController extends Controller
{
    public function add(){
        $payment_methods=PaymentMethod::all();
        return view('new_admin.payment_gateway.payment_setting.add',compact('payment_methods'));
    }
    public function store(Request $request){
        $rules = [
            'payment_method_id' => 'required',
            'name' => 'required',
            'value' => 'required',
        ];

        $request->validate($rules);
        $data = $request->all();
        if ($created = PaymentMethodSetting::create($data)) {

            $notify[] = ['success', 'Payment Method Settings  has been added'];
            return redirect()->route('admin.payment_settings.list')->withNotify($notify);
        } else {
            $notify[] = ['error', 'Something problem in internal system'];
            return back()->withNotify($notify);
        }
    }
    public function list(){
        $payment_settings=PaymentMethodSetting::with('payment_method')->orderBy('id','DESC')->get();
        return view('new_admin.payment_gateway.payment_setting.list',compact('payment_settings'));
    }
    public function edit($id){
        $payment_setting=PaymentMethodSetting::find($id);
        $payment_methods=PaymentMethod::all();
        return view('new_admin.payment_gateway.payment_setting.edit',compact('payment_setting','payment_methods'));
    }
    public function update(Request $request){
        $data=$request->all();
        $payment_method=PaymentMethodSetting::find($request->id);
        if ($payment_method->update($data)) {

            $notify[] = ['success', 'Payment Method Settings  has been Updated'];
            return redirect()->route('admin.payment_settings.list')->withNotify($notify);
        } else {
            $notify[] = ['error', 'Something problem in internal system'];
            return back()->withNotify($notify);
        }
    }
}
