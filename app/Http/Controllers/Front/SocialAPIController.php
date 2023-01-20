<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Socialite;
use Exception;
use Auth;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use App\Models\Mentor;
use App\Models\Mentee;
class SocialAPIController extends Controller
{
    public function loginWithGoogle(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'id' => 'required|string'
        ]);
        try {
            $user = User::where('google_id', $request->id)->orWhere('email',$request->email)->first();
            if ($user) {
                $user->update(['google_id' => $request->id]);
            } else {
                $user = User::create([
                    'email' => $request->email,
                    'google_id' =>  $request->id,
                    'first_name' =>  $request->name
                ]);
                if($request->role=="Mentor"){
                    Mentor::create(['user_id'=>$user->id]);
                }else if($request->role=="Mentee"){
                    Mentee::create(['user_id'=>$user->id]);
                }
            }
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            // if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();
            $role='';
            if($request->role=="Mentor"){
                $mentor=Mentor::where('user_id',$user->id)->first();
                if($mentor){
                    $role='Mentor';
                }else {
                    $obj = [
                        "Status" => false, "success" => 0,

                        'msg'=>'Selected Wrong Role'
                    ];
                    return response()->json($obj);
                }
            }else if($request->role=="Mentee"){
                $mentee=Mentee::where('user_id',$user->id)->first();
                if($mentee){
                    $role='Mentee';
                }else {
                    $obj = [
                        "Status" => false, "success" => 0,

                        'msg'=>'Selected Wrong Role'
                    ];
                    return response()->json($obj);
                }
            }
            $obj = [
                "Status" => true, "success" => 1,
                'AccessToken' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
                "data"=>["user"=>$user,'role'=>$role],
                'msg'=>'Successfully Login'
            ];
            return response()->json($obj);

        } catch (Exception $exception) {
            $obj = [
                "Status" => false, "success" => 0,
                "data"=>null,
                'msg'=>$exception->getMessage()
            ];
            return response()->json($obj);

        }
    }

    public function loginWithFacebook(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'id' => 'required|string'
        ]);
        try {
            $user = User::where('fb_id', $request->id)->orWhere('email',$request->email)->first();
            if ($user) {
                $user->update(['fb_id' => $request->id]);
            } else {
                $user = User::create([
                    'email' => $request->email,
                    'fb_id' =>  $request->id,
                    'first_name' =>  $request->name
                ]);
                if($request->role=="Mentor"){
                    Mentor::create(['user_id'=>$user->id]);
                }else if($request->role=="Mentee"){
                    Mentee::create(['user_id'=>$user->id]);
                }
            }
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            // if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();
            $role='';
            if($request->role=="Mentor"){
                $mentor=Mentor::where('user_id',$user->id)->first();
                if($mentor){
                    $role='Mentor';
                }else {
                    $obj = [
                        "Status" => false, "success" => 0,

                        'msg'=>'Selected Wrong Role'
                    ];
                    return response()->json($obj);
                }
            }else if($request->role=="Mentee"){
                $mentee=Mentee::where('user_id',$user->id)->first();
                if($mentee){
                    $role='Mentee';
                }else {
                    $obj = [
                        "Status" => false, "success" => 0,

                        'msg'=>'Selected Wrong Role'
                    ];
                    return response()->json($obj);
                }
            }
            $obj = [
                "Status" => true, "success" => 1,
                'AccessToken' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
                "data"=>["user"=>$user,'role'=>$role],
                'msg'=>'Successfully Login'
            ];
            return response()->json($obj);

        } catch (Exception $exception) {
            $obj = [
                "Status" => false, "success" => 0,
                "data"=>null,
                'msg'=>$exception->getMessage()
            ];
            return response()->json($obj);

        }
    }


}
