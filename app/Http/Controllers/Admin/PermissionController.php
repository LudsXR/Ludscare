<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $permissions=Permission::orderBy('id','DESC')->get();
        return view('new_admin.permission.list',compact('permissions'));
    }
    public function add_view(Request $request){
        return view('new_admin.permission.add');
    }
    public function store(Request $request){
        $request->validate(['name' => 'required','slug'=>'required']);
        $data = $request->all();
        if($created = Permission::create($data)){

			$notify[] = ['success', 'Permission has been added'];
        	return redirect()->route('admin.permission.list')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}

    }
    public function edit($id){
        $permission=Permission::find($id);
        return view('new_admin.permission.edit',compact('permission'));

    }
    public function update(Request $request){
        $request->validate(['name' => 'required','slug'=>'required']);
        $data = $request->all();
        $permission=Permission::find($request->permission_id);
        if($permission->update($data)){
            //dd($permission);
            $notify[] = ['success', 'Permission has been updated'];
        	return redirect()->route('admin.permission.list')->withNotify($notify);
        } else {
            $notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
        }
    }
    public function destory($id){
        $permission=Permission::find($id);
        if($permission->delete()){
            $notify[] = ['success', 'Permission has been deleted'];
        	return redirect()->route('admin.permission.list')->withNotify($notify);
        }else {
            $notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
        }
    }
}
