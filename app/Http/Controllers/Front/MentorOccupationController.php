<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MentorOccupation;
class MentorOccupationController extends Controller
{
    //list Mentor Occupation
    public function list(Request $request){
        $token="123";
        if ($request->token==$token){
            $mentorOccupation=MentorOccupation::all();
            $obj=["Status"=>true,"success"=>1,"data"=>["mentorOccupation"=>$mentorOccupation],"msg"=>"Got Successfully Mentor Occupation"];
            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];

        return response()->json($obj);
    }
}
