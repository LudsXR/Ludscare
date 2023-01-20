<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Events\UserOffline;
use App\Events\UserOnline;
use Illuminate\Support\Facades\Validator;
use App\Models\Mentor;
use App\Models\MentorSchedule;

class UserOfflineController extends Controller
{
    public function update(User $user,Request $request)
    {   $user=User::find($request->user_id);
        if($request->status=="online"){

            $user->online_status = 'online';
            $user->save();

            broadcast(new UserOnline($user));
            $obj=["Status"=>true,"success"=>1,"msg"=>"Successfully Done Status Online"];
            return response()->json($obj);
        }
        else{
            $user->online_status = 'offline';
            $user->save();

            broadcast(new UserOffline($user));
            $obj=["Status"=>true,"success"=>1,"msg"=>"Successfully Done Status Offline"];
            return response()->json($obj);
        }

    }
    public function turnLiveToMentor(Request $request){
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
            'fee' => 'required',
            'appointment_type_id'=>'required'
        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            Mentor::where('user_id',$request->mentor_id)->update([
                'is_live'=>1
            ]);
            $scheduleExist=MentorSchedule::where([
                ['mentor_id',$request->mentor_id],
                ['appointment_type_id',$request->appointment_type_id]
        ])->first();
        if($scheduleExist){
            $scheduleExist->update([
                'fee'=>$request->fee
            ]);
        }else {
            MentorSchedule::create([
                'mentor_id'=>$request->mentor_id,
                'appointment_type_id'=>$request->appointment_type_id,
                'fee'=>$request->fee,
                'day'=>''
            ]);
        }
        
        $obj=["Status"=>true,"success"=>1,"msg"=>"Successfully Updated Availability To Live"];
        return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    public function offLiveToMentor(Request $request){
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            Mentor::where('user_id',$request->mentor_id)->update([
                'is_live'=>0
            ]);
            $obj=["Status"=>true,"success"=>1,"msg"=>"Successfully Updated Availability To  Inactive"];
            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
}
