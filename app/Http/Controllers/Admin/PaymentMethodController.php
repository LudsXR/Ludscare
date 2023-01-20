<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodSetting;
use App\Http\Resources\PaymentMethodsResource;
use Session;
use Illuminate\Support\Facades\Validator;
use View;

class PaymentMethodController extends Controller
{
    public function index(Request $request)
    {
      $validator = Validator::make($request->all(), [
          'platform' => "required|in:web,app",
      ]);
      if ($validator->fails()) {
        $res = generateResponse(null,false,'Fields Required',$validator->errors(),'collection');
          return response()->json($res);
      }
        $token="123";
      if ($request->token==$token){
        if($request->platform == 'web'){
          $payment_methods = PaymentMethod::active()->web()->get();
        }else{
          $payment_methods = PaymentMethod::active()->app()->get();
        }
        $payment_methods = PaymentMethodsResource::collection($payment_methods);
      $res = generateResponse($payment_methods,count($payment_methods) > 0 ? true:false,'Fetched Successfully',null,'collection');
        return response()->json($res);
      }
      $res= generateResponse(null,false,'Token Incorrect',null,'collection');
      return response()->json($res);
    }

    public function add()
    {
        // dd(123);
        return view('new_admin.payment_gateway.add');
    }


    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'image_id' => 'required',
        ];

        $request->validate($rules);
        $data = $request->all();
        if ($request->hasFile('image_id')) {

            $image = $request->file('image_id');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $path = public_path('assets/admin/payment/');
            $image->move($path, $image_name);

            $data['image_id'] = 'assets/admin/payment/' . $image_name;
        }
        if ($created = PaymentMethod::create($data)) {
            // $mentee = [
            //     'user_id' => $created->id,
            //     'is_active' => 1
            // ];
            // Mentee::create($mentee);
            $notify[] = ['success', 'Payment Method has been added'];
            notify()->success('Payment Method has been added!');
            return redirect()->route('admin.payment_gateway.list')->withNotify($notify);
        } else {
            $notify[] = ['error', 'Something problem in internal system'];
            return back()->withNotify($notify);
        }
    }
    public function list(){
        $paymentMethods=PaymentMethod::all();
        return view('new_admin.payment_methods.list',compact('paymentMethods'));
    }


    public function edit($id){
        $paymentMethod=PaymentMethod::with('settings')->find($id);
        return view('new_admin.payment_methods.edit',compact('paymentMethod'));
    }

    public function update(Request $request){

        $data = $request->all();
          $payment_method=PaymentMethod::find($request->id);
        if ($request->hasFile('image_path')) {

            $image = $request->file('image_path');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $path = public_path('assets/images/payment/');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $image->move($path, $image_name);
            $data['image_path'] = 'assets/images/payment/' . $image_name;
            $payment_method->update(['image_path' => $data['image_path']]);

        }
        foreach ($data as $key => $value) {
          $updated_settings = PaymentMethodSetting::where('name',$key)->where('payment_method_id',$request->id)->update([
            'value' => $value
          ]);
            $this->changeEnv([strtoupper($key) => $value]);
        }
            $notify[] = ['success', 'Payment Method has been Updated'];
            return redirect()->route('admin.payment_gateway.list')->withNotify($notify);
    }
    public function setDefault(PaymentMethod $payment_method){
      if($payment_method->is_default){
        $notify[] = ['error', 'One payment method must be default'];
          return redirect()->route('admin.payment_gateway.list')->withNotify($notify);
        }
        else{
          PaymentMethod::where('is_default',1)->update([
            'is_default' => 0
          ]);
          $payment_method->update([
            'is_default' => 1,
            'is_active' => 1
          ]);
          $notify[] = ['success', 'Updated'];
        return redirect()->route('admin.payment_gateway.list')->withNotify($notify);
    }
  }

    public function updateStatus(PaymentMethod $payment_method){
      if($payment_method->is_default){
        $notify[] = ['error', 'Cant Update Default'];
        return redirect()->route('admin.payment_gateway.list')->withNotify($notify);
      }
          $payment_method->update([
          'is_active' => $payment_method->is_active == 1 ? 0:1
        ]);
        $notify[] = ['success', 'Updated'];
        return redirect()->route('admin.payment_gateway.list')->withNotify($notify);
          // $res = generateResponse(null,true,'Successfully',null,'collection');
          // return response()->json($res);
    }
    public function destroy($id){

        $payment_method=PaymentMethod::destroy($id);
        $notify[] = ['success', 'Payment Method has been Deleted'];
        return redirect()->route('admin.payment_gateway.list')->withNotify($notify);
    }
    protected function changeEnv($data = array()){
        if(count($data) > 0){
            $env = file_get_contents(base_path() . '/.env');
            $env = preg_split('/\s+/', $env);;
            foreach((array)$data as $key => $value){
                foreach($env as $env_key => $env_value){
                    $entry = explode("=", $env_value, 2);
                    if($entry[0] == $key){
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        $env[$env_key] = $env_value;
                    }
                }
            }
            $env = implode("\n", $env);
            file_put_contents(base_path() . '/.env', $env);
            return true;
        } else {
            return false;
        }
    }
}
