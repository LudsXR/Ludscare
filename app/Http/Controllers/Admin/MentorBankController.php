<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MentorBank;
use Illuminate\Http\Request;
class MentorBankController extends Controller
{
    public function showMentorBankList()
    {
        $banks = MentorBank::all();
        return view('new_admin.mentor_bank.list',compact('banks'));
    }
    public function saveMentorBank(Request $request)
    {
        $rules = [
    		'name' => 'required|unique:mentor_banks,name'
    	];

    	$request->validate($rules);


        $data = $request->all();


        if($created = MentorBank::create($data)){

			$notify[] = ['success', 'Mentor Bank has been Created'];
        	return redirect()->route('admin.mentor.bank.list')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}

    }


    public function mentorBankUpdate(Request $request){

    	$data = $request->all();

		$bank = MentorBank::find($request->id);
		if($bank->update($data)){
			$notify[] = ['success', 'Mentor Bank has been updated'];
        	return redirect()->route('admin.mentor.bank.list')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}
    }


    public function mentorBankDelete($id){
    	$bank = MentorBank::find($id);
    	if($bank->delete()){

			$notify[] = ['success', 'Mentor Bank has been deleted'];
        	return back()->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}
    }
}
