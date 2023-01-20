<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\City;
use App\Models\MentorOccupation;
use App\Models\MentorDegree;
use App\Models\MentorBank;
use App\Models\AppointmentType;

class CountryController extends Controller
{
    public function countries_list(Request $request){
        $token="123";
        if ($request->token==$token){
            $countries=Country::all();
            $obj=["Status"=>true,"success"=>1,"data"=>["countries"=>$countries],"msg"=>"Successfully got Countries"];

            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    public function cities_list(Request $request){
        $token="123";
        if ($request->token==$token){
            $cities=City::select('id','name','country_id')->where('country_id',$request->country_id)->get();
            $obj=["Status"=>true,"success"=>1,"data"=>["cities"=>$cities],"msg"=>"Successfully got Cities"];

            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    public function generic_mentor_records(Request $request){
        $token="123";
        if ($request->token==$token){
            $occupations=MentorOccupation::all();
            $degrees=MentorDegree::all();
            $banks=MentorBank::all();
            $appointment_types=AppointmentType::all();
            $countries=Country::select('id','name')->get();
            $obj=["Status"=>true,"success"=>1,"data"=>["occupations"=>$occupations,'degrees'=>$degrees,'banks'=>$banks,'countries'=>$countries,],"msg"=>"Successfully got occupations,degrees,countries and banks "];

            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    public function appointmentTypes(Request $request){
        $token="123";
        if ($request->token==$token){

            $appointment_types=AppointmentType::all();
            $obj=["Status"=>true,"success"=>1,"data"=>['appointmenttype'=>$appointment_types],"msg"=>"Successfully got occupations,degrees,countries and banks "];

            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    public function banks(Request $request){
        $token="123";
        if ($request->token==$token){
            $banks=MentorBank::all();
            $obj=["Status"=>true,"success"=>1,"data"=>['banks'=>$banks],"msg"=>"Successfully got  banks "];

            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
}
