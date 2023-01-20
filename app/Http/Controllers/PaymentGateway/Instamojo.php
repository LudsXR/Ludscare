<?php

namespace App\Http\Controllers\PaymentGateway;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Customer;
use App\Http\Resources\CMS\CustomersResource;
use Illuminate\Support\Facades\Http;

class Instamojo extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public $headers;
    public $body;
    public $payment_method;
    public $response;
    public $request;
    public $customer;
    public $access_token;

    public function __construct()
    {

    }
    // Posts
    public function index(Request $request){

    }
    public function setAuthorizationKeys($payment_method){
      return response()->json("Under COnstruction");
      foreach ($payment_method as $setting) {
        if($setting->name == 'client_secret'){
          $client_secret = $setting->value;
        }
        if($setting->name == 'client_id'){
          $client_id = $setting->value;
        }
      }
      $this->headers['client_id'] = $client_id;
      $this->headers['client_secret'] = $client_secret;
      $this->headers['grant_type'] = 'client_credentials';

    }
    public function generateBody($required,$customer){
      $this->headers = '';
      $url = config('app.url');
      $this->headers['Authorization'] = 'Bearer '.$this->access_token;
      $amnt = $required['orderDetails']['ammount']/100;
      $this->body['purpose'] = 'Order_id_here_or_any_unique_id';
      $this->body['amount'] = $amnt;
      $this->body['buyer_name'] = $customer->name;
      $this->body['email'] = $customer->email;
      $this->body['phone'] = $customer->phone;
      $this->body['redirect_url'] = $url."/processingPayment";
      $this->body['send_email'] = 'True';
      $this->body['send_sms'] = 'True';
      $this->body['allow_repeated_payments'] = 'False';
      return $this->sendRequest();
    }
    public function executePayment($request,$customer){
      $this->request = $request;
      $this->customer = $customer;
      return $this->getAccessToken($request);
    }
    public function getAccessToken($payment_method_info){
      $res = HTTP::asForm()->post('https://api.instamojo.com/oauth2/token/',$this->headers);
        if($res->successful() || $res->ok()){
          $token = json_decode($res->body());
          $this->access_token = $token->access_token;
          return $this->generateBody($this->request,$this->customer);
        }else{
          $this->Response($res);
        }
    }

    public function sendRequest(){
      $res = Http::withHeaders($this->headers)->asForm()->post('https://api.instamojo.com/v2/payment_requests' , $this->body);
      return $this->Response($res);
    }
    public function authorizeWithoutCapture(){

    }
    public function authorizeWithCapture(){

    }
    public function Response($res){
      $body = json_decode($res->body());
      if($res->successful() || $res->ok()){
        $data['receipt_email'] = $body->email;
        $data['metadata'] = $body->purpose;
        $data['intent_id'] = $body->id;
        $data['capture_id'] = $body->id;
        if($res->status == 'Pending'){
          $response['success'] = true;
          $response['captured'] = false;
          $response['authorization_required'] = true;
          $response['authorization_url'] = $body->longurl;
          $response['return_url'] = $body->redirect_url;
        }
        if($res->status){
          $response['success'] = true;
          $response['captured'] = true;
          $response['authorization_required'] = false;
          $response['authorization_url'] = '';
          $response['return_url'] = '';
        }
        $data['shipping_details'] = '';
        $response['data'] = $data;
        $response['status'] = '200';
        return $response;
      }else{
        if($body->purpose){
          $error['message'] = $body->purpose;
          $response['data'] = $error;
        }
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
    public function verifyPayment($params){
      $res = HTTP::asForm()->post('https://api.instamojo.com/oauth2/token/',$this->headers);
        if($res->successful() || $res->ok()){
          $token = json_decode($res->body());
          $this->access_token = $token->access_token;
          $this->headers['Authorization'] = 'Bearer '.$this->access_token;
          $res = Http::withHeaders($this->headers)->post('https://api.instamojo.com/v2/payments/'.$params['payment_id']);
          return $this->Response($res);
        }else{
          $this->Response($res);
        }

    }
}
