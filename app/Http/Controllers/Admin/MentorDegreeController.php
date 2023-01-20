<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MentorDegree;
use Illuminate\Http\Request;
class MentorDegreeController extends Controller
{
    public function showMentorDegreeList()
    {
        $degrees = MentorDegree::all();
        return view('new_admin.mentor_degree.list',compact('degrees'));
    }
    public function saveMentorDegree(Request $request)
    {
        $rules = [
    		'name' => 'required|unique:mentor_degrees,name'
    	];

    	$request->validate($rules);


        $data = $request->all();


        if($created = MentorDegree::create($data)){

			$notify[] = ['success', 'Mentor Degree has been Created'];
        	return redirect()->route('admin.mentor.degree.list')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}

    }


    public function mentorDegreeUpdate(Request $request){

    	$data = $request->all();

		$occupation = MentorDegree::find($request->id);
		if($occupation->update($data)){
			$notify[] = ['success', 'Mentor Degree has been updated'];
        	return redirect()->route('admin.mentor.degree.list')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}
    }


    public function mentorDegreeDelete($id){
    	$occupation = MentorDegree::find($id);
    	if($occupation->delete()){

			$notify[] = ['success', 'Mentor Degree has been deleted'];
        	return back()->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}
    }
}
