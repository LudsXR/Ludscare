<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Mentee;
use Illuminate\Support\Facades\Storage;

class MenteeProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'required|string',
            'country' => 'required',
            'city' => 'required|string',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $file_name = '';
            $user = User::find($request->user_id);
            if ($request->hasFile('picture')) {

                $image = $request->file('picture');
                $file_type = $image->getClientOriginalExtension();
                $image_name = time() . '_' . $image->getClientOriginalName();
                $path = public_path('/assets/mentorProfile/');
                $image->move($path, $image_name);
                $file_name = '/assets/mentorProfile/' . $image_name;
            }
            if (!empty($request->email)) {
                $user->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'gender' => $request->gender,
                    'image_path' => !empty($file_name) ? $file_name : $user->image_path,
                    'country' => $request->country,
                    'city' => $request->city,
                    'dob' => date('Y-m-d', strtotime($request->dob))

                ]);
            } else {
                $user->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,

                    'gender' => $request->gender,
                    'image_path' => !empty($file_name) ? $file_name : $user->image_path,
                    'country' => $request->country,
                    'city' => $request->city,
                    'dob' => date('Y-m-d', strtotime($request->dob))

                ]);
            }


            $obj = ["Status" => true, "success" => 1, "msg" => "Successfully Updated Profile"];
            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    public function getMenteeProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $user = User::with('user_country', 'mentee')->find($request->user_id);
            $obj = ["Status" => true, "success" => 1, "data" => ["user" => $user], "msg" => "Successfully Updated Profile"];
            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    public function toggleIdentityVisiblity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'visibility' => 'required'
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $user = Mentee::where('user_id', $request->user_id)->update(['identity_hidden' => $request->visibility]);
            $obj = ["Status" => true, "success" => 1, "msg" => "Successfully Updated Visiblity for Profile"];
            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
}
