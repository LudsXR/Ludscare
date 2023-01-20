<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function notificationSettings(){
        $notification_settings=Setting::notifications()->get()->groupBy('category');
        return view('new_admin.notification_settings.update',compact('notification_settings'));
    }
    public function updateNotificationSettings(Request $request){
      $data = $request->except('_token');
      foreach ($data as $key => $value) {
        $updated_settings = Setting::where('name',$key)->update([
          'value' => $value
        ]);
        $this->changeEnv([strtoupper($key) => $value]);
      }
      $notification_settings=Setting::notifications()->get()->groupBy('category');
      return view('new_admin.notification_settings.update',compact('notification_settings'));
    }

  protected function changeEnv($data = array()){
      if(count($data) > 0){
          $env = file_get_contents(base_path() . '/.env');
          $env = preg_split('/\s+/', $env);;
          foreach((array)$data as $key => $value){
              foreach($env as $env_key => $env_value){
                  $entry = explode("=", $env_value, 2);
                  if($entry[0] == $key){
                      $env[$env_key] = $key . "=" . $value;
                  } else {
                      $env[$env_key] = $env_value;
                  }
              }
          }
          $env = implode("\n", $env);
          file_put_contents(base_path() . '/.env', $env);
          return true;
      } else {
          return false;
      }
  }

}
