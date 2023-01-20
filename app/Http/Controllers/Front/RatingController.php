<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\EasypaisaMerchant;
use Illuminate\Http\Request;
use App\Models\Rating;
use Illuminate\Support\Facades\Validator;
use App\Models\BookAppointment;
use Illuminate\Support\Facades\Session;

class RatingController extends Controller
{

    public function createRating(Request $request){
        $validator = Validator::make($request->all(), [
            'mentee_id' => 'required',
            'mentor_id' => 'required',
            'rating'=>'required',
            'comments'=>'required|string',
            'appointment_id'=>'required'


        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $mentor_id=$request->mentor_id;
            $mentee_id=$request->mentee_id;
            $rating=$request->rating;
            $comment=$request->comments;
            $created=Rating::create([
                'mentor_id'=>$mentor_id,
                'mentee_id'=>$mentee_id,
                'appointment_id'=>$request->appointment_id,
                'rating'=>$rating,
                'comments'=>$comment
            ]);

            $obj=["Status"=>true,"success"=>1,"msg"=>"Successfully created rating"];

            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    public function getRatings(Request $request){
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',

        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $ratingAvg=Rating::where('mentor_id',$request->mentor_id)->avg('rating');


            $obj=["Status"=>true,"success"=>1,"data"=>["rating"=>round($ratingAvg)],"msg"=>"Successfully Got rating"];

            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    //Rating Exist for appointment
    public function ratingExistAppointment(Request $request){
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
            'appointment_id'=>'required'

        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $ratingExist=Rating::where([['mentor_id',$request->mentor_id],['appointment_id',$request->appointment_id]])->exists();




            $obj=["Status"=>true,"success"=>1,"data"=>["ratingExist"=>$ratingExist],"msg"=>"Successfully Got rating"];

            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    //get Ratings Detail
    public function getRatingDetails(Request $request){
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',

        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $avgRatings=Rating::where('mentor_id',$request->mentor_id)->avg('rating');

            $totalRatings=Rating::where('mentor_id',$request->mentor_id)->count();
            $fiveRatings=Rating::where([['mentor_id',$request->mentor_id]
            ,['rating',5]
            ])->count();
            $fourRatings=Rating::where([['mentor_id',$request->mentor_id]
            ,['rating',4]
            ])->count();
            $threeRatings=Rating::where([['mentor_id',$request->mentor_id]
            ,['rating',3]
            ])->count();
            $twoRatings=Rating::where([['mentor_id',$request->mentor_id]
            ,['rating',2]
            ])->count();
            $oneRatings=Rating::where([['mentor_id',$request->mentor_id]
            ,['rating',1]
            ])->count();



            $obj=["Status"=>true,"success"=>1,"data"=>["totalRatings"=>$totalRatings,'avgRatings'=>is_null($avgRatings)?0:round($avgRatings)
            ,'fiveRatings'=>$fiveRatings,'fourRatings'=>$fourRatings,'threeRatings'=>$threeRatings,'twoRatings'=>$twoRatings,'oneRatings'=>$oneRatings
        ],"msg"=>"Successfully Got rating"];

            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
  


}
