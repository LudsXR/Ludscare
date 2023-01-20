<?php

namespace App\Http\Controllers\Front;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function fetchMessages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required',
            'sender_id' => 'required'
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $receiver = $request->receiver_id;
            $sender = $request->sender_id;
            // session('')
            $messages = Message::where(function ($q) use ($request) {

                $q->orWhere('sender_id', $request->sender_id);
                $q->orWhere('receiver_id', $request->sender_id);
            })->where(function ($q) use ($request) {

                $q->orWhere('sender_id', $request->receiver_id);
                $q->orWhere('receiver_id', $request->receiver_id);
            })->get();

            $obj = ["Status" => true, "success" => 1, "data" => ["messages" => $messages], "msg" => "Successfully got  Messages"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required',
            'sender_id' => 'required',
            'message' => 'required|string'
        ]);

        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {

            $message = Message::create([
                'message' => $request->message,
                'receiver_id' => $request->receiver_id, 'sender_id' => $request->sender_id
            ]);
            $obj = ["Status" => true, "success" => 1, "msg" => "Message Sent Successfully"];
            broadcast(new MessageSent($message))->toOthers();
            return response()->json($obj);
        }

        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
}
