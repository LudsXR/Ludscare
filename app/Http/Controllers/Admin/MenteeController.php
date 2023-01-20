<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Mentee;
use App\Models\User;
use Illuminate\Http\Request;

class MenteeController extends Controller
{
    public function showMenteeList()
    {
        $mentees = Mentee::orderBy('id','DESC')->get();
        return view('new_admin.mentee.list',compact('mentees'));
    }
    public function addMentee()
    {
        $countries = Country::all();
        return view('new_admin.mentee.add', compact('countries'));
    }
    public function saveMentee(Request $request)
    {
        $rules = [
    		// 'first_name' => 'required',
    		// 'last_name' => 'required',
            // 'email' => 'required| regex:/(.+)@(.+)\.(.+)/i | unique:'.'users',
            'phone' => 'required',
            // 'country' => 'required',
            // 'city' => 'required',
            // 'address' => 'required',
            // 'postal_code' => 'required',
            // 'image' => 'required',
    		// 'address' => 'required'
    	];

    	$request->validate($rules);


        $data = $request->all();
        if($request->hasFile('image')){

            $image = $request->file('image');
            $image_name = time().'_'.$image->getClientOriginalName();
            $path = public_path('assets/admin/mentee/');
            $image->move($path,$image_name);

            $data['image_path'] = 'assets/admin/mentee/'.$image_name;

        }

        if($created = User::create($data)){
                $mentee = [
                    'user_id' => $created->id,
                    'is_active' => 1
                ];
                Mentee::create($mentee);
			$notify[] = ['success', 'Mentee has been added'];
        	return redirect()->route('admin.mentee.list')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}

    }
    public function menteeDetail($id)
    {
       $detail = Mentee::find($id);
       $countries = Country::all();
       return view('new_admin.mentee.edit',compact('detail','countries'));
    }

    public function menteeUpdate(Request $request){

    	$data = $request->all();
    	if($request->hasFile('image')){

			$image = $request->file('image');
			$image_name = time().'_'.$image->getClientOriginalName();
			$path = public_path('assets/admin/mentee/');
			$image->move($path,$image_name);
			$data['image_path'] = 'assets/admin/mentee/'.$image_name;
		}
        $mentee = Mentee::find($request->id);
		$user = User::find($mentee->user_id);
		if($user->update($data)){
			$notify[] = ['success', 'Mentee has been updated'];
        	return redirect()->route('admin.mentee.list')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}
    }


    public function menteeDelete($id){
    	$mentee = Mentee::find($id);
        $mentee->user()->delete();
    	if($mentee->delete()){

			$notify[] = ['success', 'Mentee has been deleted'];
        	return back()->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}
    }
}
