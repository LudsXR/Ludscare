<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ContactUsController extends Controller
{
    //Contact us Api (To save contact us request)
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string|max:191',
            "subject" => 'required|string',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {

            $name = $request->name;
            $email = $request->email;
            $message = $request->message;
            $subject = $request->subject;

            $contactus = ContactUs::create([
                'name' => $name,
                'email' => $email,
                'message' => $message,
                'subject' => $subject
            ]);
            $obj = ["Status" => true, "success" => 1, "data" => ["contactus" => $contactus->id], "msg" => "Successfully created  record"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
}
