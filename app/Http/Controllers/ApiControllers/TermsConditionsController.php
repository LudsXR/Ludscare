<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermsConditon;

class TermsConditionsController extends Controller
{
    public function getTermsConditions(Request $request){
      $token = '123';
      if($request->token == $token){
        $terms_conditions=TermsConditon::select('value')->first();
        $res = generateResponse($terms_conditions,$terms_conditions ? true:false,'Fetched Successfully',null,'collection');
        return response()->json($res);
      }
      $res= generateResponse(null,false,'Token Incorrect',null,'collection');
      return response()->json($res);
    }

}
