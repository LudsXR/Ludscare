<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EasypaisaMerchant;
use App\Models\BookAppointment;
use App\Models\User;
use App\Models\PaymentMethod;

class EasypaisaController extends Controller
{
    //MAke easy Paisa Payment
    public function makeEasyPaisaPaymentHash(Request $request){
        // Session::start();
            if(isset($_GET['bookAppointmentId'])){
                $bookAppointmentId=$_GET['bookAppointmentId'];
                $request->session()->put('bookAppointmentId', $bookAppointmentId);
                $request->session()->save();
            }

           $random=rand(10,1000);
        $payment_method_settings = PaymentMethod::with('settings')->where('code', 'easypaisa')->first();
          foreach ($payment_method_settings->settings as $setting) {
            if($setting->name == 'hash'){
              $hashKey = $setting->value;
            }
            if($setting->name == 'storeId'){
              $storeId = $setting->value;
            }
          }
           $amount =number_format($request->amount, 1, '.', '');
           $custEmail = '';
           $custCell =  '';
           $post_back_url=url('')."/easypaisa";
           $currentDate = new \DateTime();
           $currentDate->modify('+ 10 day');
           $expiryDate = $currentDate->format('Ymd His');
           $paymentMethodVal = 'MA_PAYMENT_METHOD';
           $orderId=isset($bookAppointmentId)?"bk".$bookAppointmentId:"bk".$random;
           $autoRedirect=1;
           $hashRequest = '';
            if(strlen($hashKey) > 0 && (strlen($hashKey) == 16 || strlen($hashKey) == 24 || strlen($hashKey) == 32 )) {
                // Create Parameter map
                $paramMap = array();
                $paramMap['storeId']  = $storeId ;
                $paramMap['amount']  = $amount ;
                $paramMap['postBackURL'] = $post_back_url;
                $paramMap['orderRefNum']  = $orderId ;
                $paramMap['autoRedirect']  = $autoRedirect ;
                if($expiryDate != null && $expiryDate != '') {
                    $paramMap['expiryDate'] = $expiryDate;
                }
                if($custEmail != null && $custEmail != '') {
                    $paramMap['emailAddr']  = $custEmail ;
                }

                if($custCell != null && $custCell != '') {
                    $paramMap['mobileNum'] = $custCell;
                }


                if($paymentMethodVal != null && $paymentMethodVal != '') {
                    $paramMap['paymentMethod']  = $paymentMethodVal ;
                }
                $sortedArray = $paramMap;
                ksort($sortedArray);
                $sorted_string = '';
                $i = 1;

                foreach($sortedArray as $key => $value){
                    if(!empty($value))
                    {
                        if($i == 1)
                        {
                            $sorted_string = $key. '=' .$value;
                        }
                        else
                        {
                            $sorted_string = $sorted_string . '&' . $key. '=' .$value;
                        }
                    }
                    $i++;
                }



                $cipher = "aes-128-ecb";
                $crypttext = openssl_encrypt($sorted_string, $cipher, $hashKey, OPENSSL_RAW_DATA);
                $hashRequest = base64_encode($crypttext);
            }

            return view('easypaisa',compact('hashRequest','expiryDate','storeId','amount','orderId','post_back_url','paymentMethodVal'));





    }
    public function easypaisaAfterpayment(Request $request){
        // Session::start();
        $bookAppointmentId=$request->session()->get('bookAppointmentId');
            $appointment=BookAppointment::find($bookAppointmentId);
            if($_GET['message']==''){
                $appointment->update([
                    'payment_status_code'=>$_GET['transactionRefNumber'],
                    'payment_response_msg'=>"successfully done",
                    'payment_order_ref'=>$_GET['orderRefNumber'],
                    'is_paid'=>1

                ]);

            }else if($_GET['message']!='') {
                $appointment->update([
                    'payment_response_msg'=>$_GET['message'],
                    'payment_order_ref'=>$_GET['orderRefNumber']

                ]);
            }
            session()->forget('bookAppointmentId');
            session()->flush();

            $obj=["Status"=>1,"success"=>true,"msg"=>"You May close Page now"];
            echo json_encode($obj);
            exit();
            return response()->json($obj);
    }
    //MAke easy Paisa Payment
    public function makeEasyPaisaPaymentHashForWallet(Request $request){
        // Session::start();
        $url = config('app.url');
            if(isset($_GET['userId']) &&isset($_GET['amount']) ){
                $userId=$_GET['userId'];
                $amount=$_GET['amount'];

                $request->session()->put('userId', $userId);
                $request->session()->put('amount', $amount);

                $request->session()->save();
            }

           $random=rand(10,1000);
           $payment_method_settings = PaymentMethod::with('settings')->where('code', 'easypaisa')->first();
             foreach ($payment_method_settings->settings as $setting) {
               if($setting->name == 'hash'){
                 $hashKey = $setting->value;
               }
               if($setting->name == 'storeId'){
                 $storeId = $setting->value;
               }
             }

           $amount =number_format($request->amount, 1, '.', '');
           $custEmail = '';
           $custCell =  '';
           $post_back_url=url('')."/easypaisa-wallet";
           $currentDate = new \DateTime();
           $currentDate->modify('+ 10 day');
           $expiryDate = $currentDate->format('Ymd His');
           $paymentMethodVal = 'MA_PAYMENT_METHOD';
           $orderId=isset($userId)?"bk".$userId:"bk".$random;
           $autoRedirect=1;
           $hashRequest = '';
            if(strlen($hashKey) > 0 && (strlen($hashKey) == 16 || strlen($hashKey) == 24 || strlen($hashKey) == 32 )) {
                // Create Parameter map
                $paramMap = array();
                $paramMap['storeId']  = $storeId ;
                $paramMap['amount']  = $amount ;
                $paramMap['postBackURL'] = $post_back_url;
                $paramMap['orderRefNum']  = $orderId ;
                $paramMap['autoRedirect']  = $autoRedirect ;
                if($expiryDate != null && $expiryDate != '') {
                    $paramMap['expiryDate'] = $expiryDate;
                }
                if($custEmail != null && $custEmail != '') {
                    $paramMap['emailAddr']  = $custEmail ;
                }

                if($custCell != null && $custCell != '') {
                    $paramMap['mobileNum'] = $custCell;
                }


                if($paymentMethodVal != null && $paymentMethodVal != '') {
                    $paramMap['paymentMethod']  = $paymentMethodVal ;
                }
                $sortedArray = $paramMap;
                ksort($sortedArray);
                $sorted_string = '';
                $i = 1;

                foreach($sortedArray as $key => $value){
                    if(!empty($value))
                    {
                        if($i == 1)
                        {
                            $sorted_string = $key. '=' .$value;
                        }
                        else
                        {
                            $sorted_string = $sorted_string . '&' . $key. '=' .$value;
                        }
                    }
                    $i++;
                }



                $cipher = "aes-128-ecb";
                $crypttext = openssl_encrypt($sorted_string, $cipher, $hashKey, OPENSSL_RAW_DATA);
                $hashRequest = base64_encode($crypttext);
            }

            return view('easypaisa_wallet',compact('hashRequest','expiryDate','storeId','amount','orderId','post_back_url','paymentMethodVal'));
    }
    //Confirm EasyPaisa Payment and Deposit into Wallet
    public function easypaisaAfterpaymentForWallet(Request $request){
        // Session::start();
        $userId=$request->session()->get('userId');
        $amount=$request->session()->get('amount');

        // dd($request->session()->all());
            if(isset($_GET['desc'])&&$_GET['desc']==="0000"){
                $user=User::find($userId);
                $transaction=$user->deposit($amount);
                $request->session()->forget('userId');
                $request->session()->forget('amount');

                $request->session()->flush();
                $obj=["Status"=>true,"success"=>1,"data"=>['transaction'=>$transaction],"msg"=>"Successfully deposit into Wallet You May close Page now"];
                return response()->json($obj);

            }

            // $data=[$_GET['desc'],$_GET['status'],$_GET['orderRefNumber']];

            $obj=["Status"=>false,"success"=>0,"msg"=>" Payment Was not successfull You May close Page now"];
            return response()->json($obj);
    }
}
