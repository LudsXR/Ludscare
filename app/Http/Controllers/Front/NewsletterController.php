<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsLetter;
use Illuminate\Support\Facades\Validator;
class NewsletterController extends Controller
{
    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|string|unique:newsletter_list,email',

        ],['email.unique'=>"Email Already Exist in the List"]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $data=$request->all();
            NewsLetter::create($data);
            $obj=["Status"=>true,"success"=>1,"msg"=>"Successfully subscribed to newsletter"];
            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
}
