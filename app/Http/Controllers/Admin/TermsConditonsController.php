<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TermsConditon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;

class TermsConditonsController extends Controller
{
    public function index()
    {
        $terms_conditions = TermsConditon::first();
        return view('new_admin.terms_conditions.update',compact('terms_conditions'));
    }

    public function store(Request $request)
    {
        $rules = [
    		'value' => 'required'
    	];
      $validator = Validator::make($request->all(), [
          'value' => 'required',
      ]);
      if ($validator->fails()) {
          $notify[] = ['errors', $validator->errors()];
          return back()->withNotify($notify);
      }
      $data = $request->all();
      $terms_conditions = TermsConditon::first();
        if($terms_conditions->update($data)){
			$notify[] = ['success', 'Testinomial has been updated'];
        	return view('new_admin.terms_conditions.update',compact('terms_conditions'))->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}
  }
}
