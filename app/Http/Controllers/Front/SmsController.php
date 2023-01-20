<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Custom;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
class SmsController extends Controller
{
    use Custom;
    public function send_message(Request $request){
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'message'=>'required'

        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $phone='+'.$request->phone;
            $message=$request->message;
            // $this->sendMessage($phone,$message);
            $response = Http::post('https://connect.jazzcmt.com/sendsms_url.html?Username=03053283681&Password=Jazz@123&From=Mashvra&MASK=EVOLUTION&To='.$phone.'&Message='.$message);
            $obj=["Status"=>true,"success"=>1,"msg"=>"Message Sent Successfully"];
            return response()->json($response->body());
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
}
