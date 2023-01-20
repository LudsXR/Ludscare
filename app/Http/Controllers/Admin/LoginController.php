<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{
    public function loginView()
    {
        return view('new_admin.login.login');
    }

    public function doLogin(Request $request){

        $rules =  [
            "email" => "required",
            "password" => "required"
        ];

        $request->validate($rules);

        $auth = [
            "email" => $request->email,
            "password" => $request->password,
            "admin_user" => 1
        ];

        if(Auth::attempt($auth)){

                // if(Auth::user()->hasRole('admin')){

                    return redirect()->route('admin.dashboard');
                // }
        }else{
            $notify[] = ['error', 'Email or password is invalid'];
            // dd(Auth::attempt($auth));
        	return back()->withNotify($notify);

        }

    }

    public function logout(){

        Auth::logout();

        return redirect()->route('login.view');

    }
    public function createUser(){
        return view('new_admin.admin_users.create');
    }
    public function saveUser(Request $request){
        $rules =  [
            "email" => "required|unique:users",
            "password" => "required",
            "first_name"=>"required",
            "last_name"=>"required"
        ];

        $request->validate($rules);

        $data=$request->all();
        $data['password']=Hash::make($request->password);
        $data['admin_user']=1;

        if($create=User::create($data)){
            $created = RoleUser::create(['user_id'=>$create->id,'role_id'=>1]);
            return redirect()->route('admin.listUser');
        }
        else{

            $notify[] = ['error', 'Internal Server Error'];
        	return back()->withNotify($notify);

        }

    }
    public function listUser(){
        $users=User::where('admin_user',1)->get();
        return view('new_admin.admin_users.list',compact('users'));
    }
    public function editUser($id){
        $user=User::find($id);
        return view('new_admin.admin_users.edit',compact('user'));
    }
    public function updateUser(Request $request){
        $rules =  [
            "email" => "required",
            "password" => "required",
            "first_name"=>"required",
            "last_name"=>"required",
            'id'=>"required"
        ];

        $request->validate($rules);

        $data=$request->all();
        $data['password']=Hash::make($request->password);
        $updated=User::find($request->id)->update([
            'email'=>$request->email,
            'password'=>$data['password'],
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name
        ]);
        if($updated){
            return redirect()->route('admin.listUser');
        }else {
            $notify[] = ['error', 'Internal Server Error'];
        	return back()->withNotify($notify);
        }
    }
    public function deleteUser($id){
        $user=User::destroy($id);
        return redirect()->route('admin.listUser');
    }

}
