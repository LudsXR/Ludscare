<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MentorOccupation;
use App\Models\User;
use Illuminate\Http\Request;
class MentorOccupationController extends Controller
{
    public function showMentorOccupationList()
    {
        $occupations = MentorOccupation::all();
        return view('new_admin.mentor_occupation.list',compact('occupations'));
    }
    public function saveMentorOccupation(Request $request)
    {
        $rules = [
    		'name' => 'required|unique:mentor_occupations,name'
    	];

    	$request->validate($rules);


        $data = $request->all();


        if($created = MentorOccupation::create($data)){

			$notify[] = ['success', 'Mentor Occupation has been Created'];
        	return redirect()->route('admin.mentor.occupation.list')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}

    }


    public function mentorOccupationUpdate(Request $request){

    	$data = $request->all();

		$occupation = MentorOccupation::find($request->id);
		if($occupation->update($data)){
			$notify[] = ['success', 'Mentor Occupation has been updated'];
        	return redirect()->route('admin.mentor.occupation.list')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}
    }


    public function mentorOccupationDelete($id){
    	$occupation = MentorOccupation::find($id);
    	if($occupation->delete()){

			$notify[] = ['success', 'Mentor Occupation has been deleted'];
        	return back()->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}
    }
}
