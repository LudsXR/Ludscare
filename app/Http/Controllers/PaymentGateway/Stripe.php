<?php

namespace App\Http\Controllers\PaymentGateway;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\PaymentMethod;
use App\Http\Controllers\Front\AppointmentBookingController;
class Stripe extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public $headers;
    public $body;
    public $payment_method;
    public $response;
    public $request;
    public $customer;

    public function __construct()
    {

    }
    // Posts
    public function index(Request $request){

    }
    public function setAuthorizationKeys($payment_method){
      foreach ($payment_method as $setting) {
        if($setting->name == 'secret_key'){
          $secret_key = $setting->value;
          break;
        }
      }
      $this->headers['Authorization'] = 'bearer '.$secret_key;
    }
    public function generateBody($required,$customer){
      //shipipng details its optional
      $url = url('/');
      $addres['line1'] = $required['shipping_address']['address'];
      $shipping_details['address'] = $addres;
      $shipping_details['name'] = $required['shipping_address']['first_name'].' '.$required['shipping_address']['last_name'];
      $shipping_details['phone'] = $required['shipping_address']['phone'];
      $shipping_details['tracking_number'] = 'tracking_number';
        //$metadata details its optional
      $metadata['order_id'] = 162431;
      $this->body['metadata'] = $metadata;
      $this->body['amount'] = $required['total'] * 100;
    //   $this->body['amount'] = 1*100;

      $this->body['currency'] = 'usd';
      $this->body['payment_method_types'] = ['card'];
      $this->body['confirm'] = 'true';
      $this->body['return_url'] = $url."/processingPaymentStripe";
      if($customer->email){
        $this->body['receipt_email'] = $customer->email;
      }
      $this->body['payment_method'] = $this->payment_method->id;
      $this->body['shipping'] = $shipping_details;
      return $this->sendRequest();

    }
    public function executePayment($request,$customer){
      $this->request = $request;
      $this->customer = $customer;
      return $this->generatePaymentMethod($request);
    }
    public function generatePaymentMethod($payment_method_info){
      $payment_method = Http::withHeaders($this->headers)->asForm()->post('https://api.stripe.com/v1/payment_methods',[
        'type' => 'card',
        'card' => $payment_method_info['cardInfo']
        ]);
        // return $payment_method;
        if($payment_method->successful()){
          $this->payment_method = json_decode($payment_method->body());
          return $this->generateBody($this->request,$this->customer);
        }else{
          return $this->Response($payment_method);
        }
    }

    public function sendRequest(){
      $res = Http::withHeaders($this->headers)->asForm()->post('https://api.stripe.com/v1/payment_intents',$this->body);
    //   return response()->json($res);
      return $this->Response($res);
    }
    public function authorizeWithoutCapture(){

    }
    public function authorizeWithCapture(){

    }
    public function Response($res){
      $body = json_decode($res->body());
      if($res->successful() || $res->ok()){
        $data['receipt_email'] = $body->receipt_email;
        $data['metadata'] = $body->metadata;
        $data['intent_id'] = $body->id;
        $data['capture_id'] = $body->id;
        $data['shipping_details'] = $body->shipping;
        $response['data'] = $data;
        if($body->status == 'requires_action' && $body->next_action != null){
          $response['success'] = true;
          $response['captured'] = false;
          $response['authorization_required'] = true;
          $response['return_url'] = $body->next_action->redirect_to_url->return_url;
          $response['authorization_url'] = $body->next_action->redirect_to_url->url;
        }else{
          if($body->status == 'requires_payment_method'){
              $error['message'] = $body->last_payment_error->message;
              $response['data'] = $error;
              $response['success'] = true;
              $response['captured'] = false;
              $response['status'] = $res->status();
            return $response;
          }else{
            $response['success'] = true;
            $response['captured'] = true;
            $response['authorization_required'] = false;
            $response['return_url'] = '';
            $response['authorization_url'] = '';
            if($body->charges->data[0]->receipt_url){
              $invoice['url'] = $body->charges->data[0]->receipt_url;
              $data['invoice'] = $invoice;
            }
          }
        }
        $response['status'] = '200';
        return $response;
      }else{
        if($body->error){
          $error['message'] = $body->error->message;
          $response['data'] = $error;
        }
          $response['success'] = false;
          $response['captured'] = false;
          $response['status'] = '400';
        return $response;
      }
    }
    public function verifyPayment(){
        $payment_intent = $_GET['payment_intent'];

        $payment_method_settings = PaymentMethod::with('settings')->where('code', 'stripe')->first();
        $this->setAuthorizationKeys($payment_method_settings->settings);
    //   $res = Http::withHeaders($this->headers)->asForm()->get('https://api.stripe.com/v1/payment_intents/'.$params['payment_intent']);
      $res = Http::withHeaders($this->headers)->asForm()->get('https://api.stripe.com/v1/payment_intents/'.$payment_intent);
      $result=$this->Response($res);
      if($result['success']==true && $result['captured']==true ){
        $bookAppointmentId=session('bookAppointmentId');
        $appointment=new AppointmentBookingController();
        $appointment_res=$appointment->updateAppointmentAfterPayment($bookAppointmentId,4);
        session()->forget('bookAppointmentId');
        session()->flush();
        $result="Payment Done Successfully !";
        return view('thank-you',compact('result'));
      }else {
        session()->forget('bookAppointmentId');
        session()->flush();
        $body = json_decode($res->body());

        $result=$body->last_payment_error->message;
        return view('thank-you',compact('result'));

      }
      return $this->Response($res);
    }
}
