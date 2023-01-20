<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testinomial;

class TestinomialsController extends Controller
{
    public function allTestinomials(Request $request){
      $token = '123';
      if($request->token == $token){
        $testinomials=Testinomial::featured()->get();
        $res = generateResponse($testinomials,count($testinomials) > 0 ? true:false,'Fetched Successfully',null,'collection');
        return response()->json($res);
      }
      $res= generateResponse(null,false,'Token Incorrect',null,'collection');
      return response()->json($res);
    }

}
