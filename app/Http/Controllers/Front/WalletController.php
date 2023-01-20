<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Bavix\Wallet\Models\Transaction;
use App\Models\BookAppointment;
use PaytmWallet;
use Str;

class WalletController extends Controller
{
    //Deposit into Wallet
    public function depositWallet(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'amount'=>'required'

        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $user=User::find($request->user_id);
            $transaction=$user->deposit($request->amount);
            $obj=["Status"=>true,"success"=>1,"data"=>['transaction'=>$transaction],"msg"=>"Successfully deposit into Wallet"];
            return response()->json($obj);

        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    //withDraw from Wallet
    public function withDrawWallet(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'amount'=>'required'

        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $user=User::find($request->user_id);
            if($user->balanceInt>0 && $user->balanceInt> $request->amount ||$user->balanceInt== $request->amount ){
                $transaction= $user->withdraw($request->amount);
                $obj=["Status"=>true,"success"=>1,"data"=>['transaction'=>$transaction],"msg"=>"Successfully withdraw from Wallet"];
                return response()->json($obj);

            }
            $obj=["Status"=>false,"success"=>0,"msg"=>"Insufficient Funds in your Wallet"];
            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    //Transaction History of Wallet
    public  function transactionsHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',

        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $transactions=Transaction::where('payable_id',$request->user_id)->orderBy('id','DESC')->get();
            foreach($transactions as $transaction){

                $date=date("Y-m-d", strtotime($transaction->created_at));
                $time=date("h:i a", strtotime($transaction->created_at));
                $transaction['date']=$date;
                $transaction['time']=$time;


            }
            $obj=["Status"=>true,"success"=>1,"data"=>['transactions'=>$transactions],"msg"=>"Successfully got Wallet Transactions"];
            return response()->json($obj);

        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);

    }
    //check Balance of Wallet
    public function checkBalance(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',

        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $user=User::find($request->user_id);
            if($user){
                $obj=["Status"=>true,"success"=>1,"data"=>['userBalance'=>$user->balance],"msg"=>"Successfully got Wallet Balance"];
                return response()->json($obj);
            }

            $obj=["Status"=>false,"success"=>0,"msg"=>"No User Found"];
            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    //transfer Credit from Mentee To Mentor and update appointment paid status
    public function transferCredit(Request $request){
        $validator = Validator::make($request->all(), [
            'from_user_id' => 'required',
            "to_user_id"=>'required',
            "amount"=>"required",
            "bookAppointmentId"=>"required"

        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $from_user=User::find($request->from_user_id);
            if($from_user->balanceInt>$request->amount ||$from_user->balanceInt==$request->amount ){
                $to_user=User::find($request->to_user_id);
                $from_user->transfer($to_user,$request->amount);
                $appointment=BookAppointment::find($request->bookAppointmentId);
                $appointment->update([
                    'payment_status_code'=>"1",
                    'payment_response_msg'=>"Successfully done from wallet",
                    'payment_order_ref'=>"from Wallet",
                    'is_paid'=>1,
                    'payment_id'=>3
                ]);
                $obj=["Status"=>true,"success"=>1,"msg"=>"Payment Done Successfully From User Wallet"];
                return response()->json($obj);

            }
            $obj=["Status"=>false,"success"=>0,"msg"=>"Insufficient Funds in your Wallet"];
            return response()->json($obj);

        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    public function depositFromGateway($user_id,$amount){
            $user=User::find($user_id);
            $transaction=$user->deposit($amount);
            $obj=["Status"=>true,"success"=>1,"data"=>['transaction'=>$transaction],"msg"=>"Successfully deposit into Wallet"];
            return response()->json($obj);
    }

    public function payTmorder($amount,$mobile_no,$email)
    {
        $url = config('app.url');
        $payment = PaytmWallet::with('receive');
        $user = User::where('email',$email)->first();
        $payment->prepare([
          'order' => Str::random(20),
          'user' => $user->id,
          'mobile_number' => $mobile_no,
          'email' => $email,
          'amount' => $amount,
          'callback_url' => $url."/wallet-payTm-callback"
        ]);
        $_SESSION["walletUserId"]=  $user->id;
        $_SESSION["walletUserAmount"]=  $amount;

        return $payment->receive();
    }


    public function payTmpaymentCallback()
    {
        $transaction = PaytmWallet::with('receive');

        $reu = $transaction->response(); // To get raw response as array

        if($transaction->isSuccessful()){
            $walletUserId=session('walletUserId');
            $walletUserAmount=session('walletUserAmount');
            $this->depositFromGateway($walletUserId,$walletUserAmount);
            session()->forget('walletUserId');
            session()->forget('walletUserAmount');
            session()->flush();
            $result=$transaction->getResponseMessage();
            return view('thank-you',compact('result'));
        }else if($transaction->isFailed()){
            session()->forget('walletUserId');
            session()->forget('walletUserAmount');
            session()->flush();
            $result=$transaction->getResponseMessage();
            return view('thank-you',compact('result'));
        }else if($transaction->isOpen()){
            session()->forget('walletUserId');
            session()->forget('walletUserAmount');
            session()->flush();
            $result=$transaction->getResponseMessage();
            return view('thank-you',compact('result'));
        }
    }

}
