<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\WithDrawRequest;
use Illuminate\Support\Facades\Validator;
class WithDrawRequestController extends Controller
{
    public  function createWithDrawRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'amount'=>'required'

        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $user=User::find($request->user_id);
            if($user->balanceInt > $request->amount || $user->balanceInt == $request->amount){
                $created=WithDrawRequest::create([
                    'user_id'=>$request->user_id,
                    'amount'=>$request->amount

                ]);
                if($created){
                    $obj=["Status"=>true,"success"=>1,"msg"=>"Successfully Created WithDraw Request"];
                    return response()->json($obj);
                } else {
                    $obj=["Status"=>false,"success"=>0,"msg"=>"Internal Server Error Please try later"];
                    return response()->json($obj);
                }
            } else {
                $obj=["Status"=>false,"success"=>0,"msg"=>"Insufficient Funds in your Wallet"];
                return response()->json($obj);
            }




        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
}
