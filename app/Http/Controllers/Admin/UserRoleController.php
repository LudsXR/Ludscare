<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoleUser;
use App\Models\User;
use App\Models\Role;
class UserRoleController extends Controller
{
    public function index(){


        $userroles=RoleUser::with(['user','role'])->get();
        return view('new_admin.user_role.list',compact('userroles'));

    }
    public function add(){
        $users=User::where('admin_user',1)->get();
        $roles=Role::all();
        return view('new_admin.user_role.add',compact('users','roles'));
    }
    public function store(Request $request){
        $request->validate(['user' => 'required','role'=>'required']);
        $created = RoleUser::create(['user_id'=>$request->user,'role_id'=>$request->role]);

        if($created){

			$notify[] = ['success', 'User Role has been added'];
        	return redirect()->route('admin.user.role.list')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}
    }
    public function edit($id){
        $userrole=RoleUser::find($id);
        $users=User::all();
        $roles=Role::all();
        return view('new_admin.user_role.edit',compact('users','roles','userrole'));
    }
    public function update(Request $request){
        $request->validate(['user' => 'required','role'=>'required','id'=>"required"]);
        $userrole=RoleUser::find($request->id);
        $updated=$userrole->update(['role_id'=>$request->role,'user_id'=>$request->user]);
        if($updated){

			$notify[] = ['success', 'User Role  has been Updated'];
        	return redirect()->route('admin.user.role.list')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}
    }
    public function destroy($id){
        $rolepermission=RoleUser::find($id);
        if($rolepermission->delete()){

        $notify[] = ['success', 'User Role  has been Deleted'];
        	return redirect()->route('admin.user.role.list')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}
    }

}
