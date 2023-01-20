<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RolePermission;
use App\Models\Permission;
use App\Models\Role;

use App\Models\User;
use Auth;


class RolePermissionController extends Controller
{
    public function index(){


        $rolepermissions=RolePermission::with(['permissions','roles'])->orderBy('id','DESC')->get();
        return view('new_admin.role_permission.list',compact('rolepermissions'));

    }
    public function add(){
        $permissions=Permission::all();
        $roles=Role::all();
        return view('new_admin.role_permission.add',compact('permissions','roles'));
    }
    public function store(Request $request){
        $request->validate(['permissions' => 'required','role'=>'required']);
        $data = $request->all();
        foreach($request->permissions as $permission){
            RolePermission::create(['permission_id'=>$permission,'role_id'=>$request->role]);
        }
        $created =true;

        if($created){

			$notify[] = ['success', 'Role Permission has been added'];
        	return redirect()->route('admin.rolepermission.list')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}
    }
    public function edit($id){
        $rolepermission=RolePermission::find($id);
        $permissions=Permission::all();
        $roles=Role::all();
        return view('new_admin.role_permission.edit',compact('permissions','roles','rolepermission'));
    }
    public function update(Request $request){
        $request->validate(['permission' => 'required','role'=>'required','id'=>"required"]);
        $rolepermission=RolePermission::find($request->id);
        $updated=$rolepermission->update(['role_id'=>$request->role,'permission_id'=>$request->permission]);
        if($updated){

			$notify[] = ['success', 'Role Permission has been Updated'];
        	return redirect()->route('admin.role_permission.list')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}
    }
    public function destroy($id){
        $rolepermission=RolePermission::destroy($id);
        if($rolepermission){

        $notify[] = ['success', 'Role Permission has been Deleted'];
        	return redirect()->route('admin.rolepermission.list')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}
    }



    public function Permission()
    {
    	$dev_permission = Permission::where('slug','create-tasks')->first();
		$manager_permission = Permission::where('slug', 'edit-users')->first();

		//RoleTableSeeder.php
		$dev_role = new Role();
		$dev_role->slug = 'developer';
		$dev_role->name = 'Front-end Developer';
		$dev_role->save();
		$dev_role->permissions()->attach($dev_permission);

		$manager_role = new Role();
		$manager_role->slug = 'manager';
		$manager_role->name = 'Assistant Manager';
		$manager_role->save();
		$manager_role->permissions()->attach($manager_permission);

		$dev_role = Role::where('slug','developer')->first();
		$manager_role = Role::where('slug', 'manager')->first();

		$createTasks = new Permission();
		$createTasks->slug = 'create-tasks';
		$createTasks->name = 'Create Tasks';
		$createTasks->save();
		$createTasks->roles()->attach($dev_role);

		$editUsers = new Permission();
		$editUsers->slug = 'edit-users';
		$editUsers->name = 'Edit Users';
		$editUsers->save();
		$editUsers->roles()->attach($manager_role);

		$dev_role = Role::where('slug','developer')->first();
		$manager_role = Role::where('slug', 'manager')->first();
		$dev_perm = Permission::where('slug','create-tasks')->first();
		$manager_perm = Permission::where('slug','edit-users')->first();

		$developer = new User();
		$developer->first_name = 'Harsukh Makwana';
		$developer->email = 'harsukh21@gmail.com';
		$developer->password = bcrypt('harsukh21');
		$developer->save();
		$developer->roles()->attach($dev_role);
		$developer->permissions()->attach($dev_perm);

		$manager = new User();
		$manager->first_name = 'Jitesh Meniya';
		$manager->email = 'jitesh21@gmail.com';
		$manager->password = bcrypt('jitesh21');
		$manager->save();
		$manager->roles()->attach($manager_role);
		$manager->permissions()->attach($manager_perm);


		return redirect()->back();
    }
}
