<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commission;
class CommissionController extends Controller
{
    public function index(){
        $commission=Commission::first();
        return view('new_admin.commission.add',compact('commission'));
    }
    public function store(Request $request){
        $rules = [
    		'fix' => 'required',
            'amount'=>'required'
    	];
        $created=null;
    	$request->validate($rules);
        if($request->has('id')){
            $commission=Commission::find($request->id);
            $created=$commission->update([
                'fixed'=>$request->fix,
                'amount'=>$request->amount

            ]);
        }else {
            $created = Commission::create([
                'fixed'=>$request->fix,
                'amount'=>$request->amount
            ]);
        }

        if($created ){

			$notify[] = ['success', 'Commission has been added'];
        	return redirect()->route('admin.commission.add')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}
    }
}
