<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Models\CurrencyCode;
use App\Models\Setting;

class GeneralSettingsController extends Controller
{
    public function index(){
        $general=GeneralSetting::first();
        $currency_codes = CurrencyCode::all();
        $generals=  Setting::where('category' , 'general')->select('name' , 'value' , 'display_name')->get();
        foreach ($generals as $key => $value) {
          $general->{$value->name} = $value->value;
        }
        return view('new_admin.general_setting.add',compact('general','currency_codes'));
    }
    public function store(Request $request){
        $rules = [
    		'title' => 'required',
            'tagline'=>'required',
            'seo_Des'=>'required',

            'seo_keywords'=>'required',
            'facebook_link'=>'required',
            'twitter_link'=>'required',
            'linkden_link'=>'required',
            // 'logo'=>'required',
            "address"=>'required',
            "phone"=>'required',

            "company_email"=>'required',
            "about_company"=>'required',
            "currency_symbol"=>'required',
            "login_type"=>'required',
            "longitude"=>'required',
            "latitude"=>'required',
    	];
        $created=null;
    	$request->validate($rules);
        $data=$request->all();


        if($request->hasFile('logo')){

			$image = $request->file('logo');
			$image_name = time().'_'.$image->getClientOriginalName();
			$path = public_path('assets/admin/general_settings/');
			$image->move($path,$image_name);

			$data['logo'] = '/assets/admin/general_settings/'.$image_name;

		}
    foreach ($data as $key => $value) {
      Setting::where('name' , $key)->update([
        'value' => $value
      ]);
    }

        if($request->has('id')){
            $general=GeneralSetting::find($request->id);
            $created=$general->update($data);
        }else{
            $created=GeneralSetting::create($data);
        }
        if($created ){

			$notify[] = ['success', 'General Settings has been added'];
        	return redirect()->route('admin.general.add')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}
    }
}
