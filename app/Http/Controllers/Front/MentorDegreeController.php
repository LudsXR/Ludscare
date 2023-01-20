<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MentorDegree;

class MentorDegreeController extends Controller
{
    //List Mentor Degrees
    public function list(Request $request){
        $token="123";
        if ($request->token==$token){
            $mentorDegrees=MentorDegree::all();
            $obj=["Status"=>true,"success"=>1,"data"=>["mentorDegrees"=>$mentorDegrees],"msg"=>"Got Successfully Mentor Degrees"];
            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];

        return response()->json($obj);
    }
}
