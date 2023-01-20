<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Str;
class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles=Role::all();
        return view('new_admin.role.list',compact('roles'));
    }
    public function add_view(Request $request){
        return view('new_admin.role.add');
    }
    public function store(Request $request){
        $request->validate(['name' => 'required','slug'=>'required']);
        $data = $request->all();
        if($created = Role::create($data)){

			$notify[] = ['success', 'Role has been added'];
        	return redirect()->route('admin.role.list')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}

    }
    public function edit($id){
        $role=Role::find($id);
        return view('new_admin.role.edit',compact('role'));

    }
    public function update(Request $request){
        $request->validate(['name' => 'required','slug'=>'required']);
        $data = $request->all();
        $role=Role::find($request->role_id);
        if($role->update($data)){
            $notify[] = ['success', 'Role has been updated'];
        	return redirect()->route('admin.role.list')->withNotify($notify);
        } else {
            $notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
        }
    }
    public function destory($id){
        $role=Role::find($id);
        if($role->delete()){
            $notify[] = ['success', 'Role has been deleted'];
        	return redirect()->route('admin.role.list')->withNotify($notify);
        }else {
            $notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
        }
    }
}
