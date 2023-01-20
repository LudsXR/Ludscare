<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\GeneralSetting;


class SettingsController extends Controller
{
    public function notificationSettings(Request $request){
      $token = '123';
      if($request->token == $token){
        $notification_settings=Setting::notifications()->select('name' ,'display_name', 'value' , 'category')->get()->groupBy('category');
        $res = generateResponse($notification_settings,count($notification_settings) > 0 ? true:false,'Fetched Successfully',null,'collection');
        return response()->json($res);
      }
      $res= generateResponse(null,false,'Token Incorrect',null,'collection');
      return response()->json($res);
    }

    public function generalSettings(Request $request){
      $token = '123';
      if($request->token == $token){
        $general_settings=GeneralSetting::first();
        $generals=  Setting::where('category' , 'general')->select('name' , 'value' , 'display_name')->get();
        foreach ($generals as $key => $value) {
          $general_settings->{$value->name} = $value->value;
        }
        $res = generateResponse($general_settings,$general_settings ? true:false,'Fetched Successfully',null,'collection');
        return response()->json($res);
      }
      $res= generateResponse(null,false,'Token Incorrect',null,'collection');
      return response()->json($res);
    }

}
