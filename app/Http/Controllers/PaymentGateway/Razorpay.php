<?php

namespace App\Http\Controllers\PaymentGateway;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Customer;
use App\Http\Resources\CMS\CustomersResource;
use Illuminate\Support\Facades\Http;
use Str;
use App\Http\Controllers\Front\AppointmentBookingController;
use App\Http\Controllers\Front\WalletController;

class Razorpay extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public $headers;
    public $body;
    public $payment_method;
    public $response;
    public $request;
    public $customer;
    public $access_token;
    protected $key_id;
    protected $key_secret;

    public function __construct()
    {

    }
    // Posts
    public function index(Request $request){

    }
    public function setAuthorizationKeys($payment_method){
      foreach ($payment_method as $setting) {
        if($setting->name == 'key_id'){
          $this->key_id = $setting->value;
        }
        if($setting->name == 'key_secret'){
          $this->key_secret = $setting->value;
        }
      }


    }
    public function generateBody($request){
        $ammont = $request['total'];
        // $total = $request['current_currency_total'];
        // $currency = $request['current_currency'];
      $url = config('app.url');
    //   $url = 'http://localhost:8001';

      $this->body = [
        "amount"=> $ammont * 100,
        "currency"=>'USD',
        "expire_by"=> 1691097057,
        "reference_id"=> Str::random(20),
        "description"=> "Payment for your order",
        // "customer"=> [
        //     "name"=> "Gaurav Kumar",
        //     "contact"=> "+919999999999",
        //     "email"=> "gaurav.kumar@example.com"
        // ],
        // "notify"=> [
        //     "sms"=> true,
        //     "email"=> true
        // ],
        "callback_url"=> $url."/processingPaymentRazorpay",
        "callback_method"=> "get"
    ];
    }
    public function executePayment($request,$customer){
      $this->request = $request;
      $this->customer = $customer;
      return $this->sendRequest();
    // dd($this->sendRequest());
    }
    public function sendRequest(){
        $this->generateBody($this->request);
      $res = HTTP::withBasicAuth($this->key_id,$this->key_secret)->post('https://api.razorpay.com/v1/payment_links',$this->body);
        if($res->successful() || $res->ok()){
          $body = json_decode($res->body());

          return $body;
        }else{
          return $res->body();
        }
    }

    public function authorizeWithoutCapture(){

    }
    public function authorizeWithCapture(){

    }
    public function Response($res){
      $body = json_decode($res->body());
      if($res->successful() || $res->ok()){
        $data['receipt_email'] = '';
        $data['metadata'] = '';
        $data['intent_id'] = $body->id;
        $data['capture_id'] = $body->id;
        $data['shipping_details'] = '';
        $response['data'] = $data;
          $response['success'] = true;
          $response['captured'] = false;
          $response['authorization_required'] = true;
          foreach ($body->links as $link) {
              if($link->rel == 'approve'){
                $response['authorization_url'] = $link->href;
              }
          }
        $response['return_url'] = '';
        $response['status'] = '200';
        return $response;
      }else{
        if($body->message){
          $error['message'] = $body->message;
          $response['data'] = $error;
        }
          $response['success'] = false;
          $response['captured'] = false;
          $response['status'] = $res->status();
        return $response;
      }
    }
    public function verifyPayment(){
        if(isset($_GET['razorpay_payment_link_status']) && $_GET['razorpay_payment_link_status']=='paid'){
            $bookAppointmentId=session('bookAppointmentId');
            if ($bookAppointmentId) {
                $appointment=new AppointmentBookingController();
                $appointment_res=$appointment->updateAppointmentAfterPayment($bookAppointmentId,4);
                session()->forget('bookAppointmentId');
                session()->flush();
            }
            $wallat_desposit=session('wallat_desposit');
            if ($wallat_desposit) {
                $user_id=session('user_id');
                $total=session('total');
                $wallet=new WalletController();
                $wallet->depositFromGateway($user_id,$total);
                session()->forget('wallat_desposit');
                session()->forget('user_id');
                session()->forget('total');
                session()->flush();
            }


            $result="Successfully Done Payment !";
            return view('thank-you',compact('result'));
        }else {
            session()->forget('bookAppointmentId');
            session()->flush();
            $body = json_decode($res->body());

            $result=$body->last_payment_error->message;
            return view('thank-you',compact('result'));

          }


    }

}
