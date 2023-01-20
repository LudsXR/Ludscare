<?php

namespace App\Http\Controllers\PaymentGateway;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class Braintree extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public $headers;
    public $body;
    public $payment_method;
    public $response;
    public $merchant_id;
    public $public_key;
    public $private_key;
    public $customer;
    public $request;
    public $nonce;
    public $env;

    public function __construct()
    {

    }
    // Posts
    public function index(Request $request){

    }
    public function setAuthorizationKeys($payment_method){
      foreach ($payment_method as $setting) {
        if($setting->name == 'merchant_id'){
          $this->merchant_id = $setting->value;
        }
        if($setting->name == 'public_key'){
          $this->public_key = $setting->value;
        }
        if($setting->name == 'private_key'){
          $this->private_key = $setting->value;
        }
        if($setting->name == 'mode'){
          $this->env = $setting->value;
        }
      }
      $gateway = new \Braintree\Configuration([
        'environment' => $this->env,
        'merchantId' => $this->merchant_id,
        'publicKey' => $this->public_key,
        'privateKey' => $this->private_key
      ]);
      $this->headers = new \Braintree\Gateway($gateway);
    }
    public function executePayment($request,$customer){

            $this->request = $request;
            $res = $this->headers->customer()->create([
              'firstName' => !is_null($customer->first_name)?$customer->first_name:'test',
              'lastName' => !is_null($customer->last_name)?$customer->last_name:'test',
              'email' => !is_null($customer->email)?$customer->email:'test@ccs.com',
              'phone' => !is_null($customer->phone)?$customer->phone:'00923476914936',
            ]);

            if($res->success){
              $this->customer = $res->customer;
              return $this->generatePaymentMethod($request);
            }else{
              return $this->Response($res);
            }
    }
    public function generatePaymentMethod($payment_method_info){
    $res = $this->headers->creditCard()->create([
      'customerId' => $this->customer->id,
      'number' => $payment_method_info['cardInfo']['number'],
      'expirationMonth' => $payment_method_info['cardInfo']['exp_month'],
      'expirationYear' => $payment_method_info['cardInfo']['exp_year'],
      'cvv' => $payment_method_info['cardInfo']['cvc'],
      'options' => [
        'verifyCard' => true,
        ]
    ]);
          if($res->success){
                $this->payment_method = $res;
                $res = $this->headers->paymentMethodNonce()->create($this->payment_method->creditCard->token);
                        if($res->success){
                                $this->nonce = $res->paymentMethodNonce->nonce;
                                  $this->generateBody($this->request,$this->customer);
                                  return $this->sendRequest();
                      }else{
                        return $this->Response($res);
                    }
          }else{
            return $this->Response($res);
          }
    }
    public function generateBody($required,$customer){
        $ammont = $required['total'];
        // $ammont = 10;

      $this->body['amount'] = $ammont;
      $this->body['paymentMethodNonce'] = $this->nonce;
      $options['skipAdvancedFraudChecking'] = true;
      $options['submitForSettlement'] = true;
      $this->body['options'] = $options;
    }
    public function sendRequest(){
      $res = $this->headers->transaction()->sale($this->body);
      if($res->success){
               return $this->Response($res);
             }else{
        return $this->Response($res);
      }
    }
    public function authorizeWithoutCapture(){

    }
    public function authorizeWithCapture(){

    }
    public function Response($res){
      $body = $res->transaction;
      if($res->success)
      {
        $data['receipt_email'] = $body->customer['email'];
      /*  if($body->metadata){
          $data['metadata'] = $body->metadata;
        }
        */
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
          }
        }
        $response['status'] = '200';
        return $response;
      }else{
        if($res->message){
          $error['message'] = $res->message;
          $response['data'] = $error;
        }
          $response['success'] = false;
          $response['captured'] = false;
          $response['status'] = '400';
        return $response;
      }
    }
    public function verifyPayment($params){

    }
}
