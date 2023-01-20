<?php

namespace App\Http\Controllers\PaymentGateway;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Customer;
use App\Http\Resources\CMS\CustomersResource;
use Illuminate\Support\Facades\Http;
use paytm\checksum\PaytmChecksumLibrary;
use paytm\paytmchecksum\PaytmChecksum;

class Paytm extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public $headers;
    public $body;
    public $payment_method;
    public $response;
    public $request;
    public $customer;
    private $mid;
    private $web_name;
    private $checksum;

    public function __construct()
    {

    }
    // Posts
    public function index(Request $request){

    }
    public function setAuthorizationKeys($payment_method){
    //   return response()->json("Under COnstruction");
    // $headers=[];
      foreach ($payment_method as $setting) {
        if($setting->name == 'merchant_id'){
          $this->mid = $setting->value;
        }
        if($setting->name == 'website_name'){
          $this->web_name = $setting->value;
        }
      }
      $this->headers['Content-Type'] = 'application/json';
    }
    public function generateBody($request,$customer){
      $url = config('app.url');
    //   dd($request['paytm_mode']);
      if($request['paytm_mode'] == 'card'){
        $this->body = array();
        $this->body["body"] = array(
            "requestType"   => "Payment",
            "mid"           => $this->mid,
            "websiteName"   => $this->web_name,
            "orderId"       => "123541",
            "callbackUrl"   => $url."/processingPayment",
            "txnAmount"     => array(
                "value"     => "100.00",
                "currency"  => "INR",
            ),
            "userInfo"      => array(
                "custId"    => "CUST_001",
                "mobile"    => $customer->phone,
                "email"     => $customer->email,
                "firstName"     => $customer->first_name,
                "lastName"     => $customer->last_name,
            ),
        );
        $this->checksum = PaytmChecksum::generateSignature(json_encode($this->body["body"], JSON_UNESCAPED_SLASHES), $this->mid);
        $this->body["head"] = array(
            "signature"    => $this->checksum
              );
        return $this->sendRequest();
      }else{
        return response()->json("Payment Mode Under Construction");
      }


    }
    // public function executePayment($request,$customer){
    //   $this->request = $request;
    //   $this->customer = $customer;
    //   return $this->generateBody($this->request,$this->customer);
    //   return $this->generatePaymentMethod($request);
    // }
    // public function generatePaymentMethod($payment_method_info){
    //   $payment_method = Http::withHeaders($this->headers)->asForm()->post('https://api.stripe.com/v1/payment_methods',[
    //     'type' => 'card',
    //     'card' => $payment_method_info['cardInfo']]);
    //     if($payment_method->successful()){
    //       $this->payment_method = json_decode($payment_method->body());
    //       return $this->generateBody($this->request,$this->customer);
    //     }else{
    //       return $this->Response($payment_method);
    //     }
    // }

    public function sendRequest(){
      $post_data = json_encode($this->body);
    //   var_dump($this->headers);
    //   die(1);


    // $client = new Client();
$this->headers = [
  'Content-Type' => 'application/json'
];
// $body = '{
//   "body": {
//     "requestType": "Payment",
//     "mid": "{{paytm-mid}}",
//     "orderId": "PYTM_ORDR_1658217058",
//     "websiteName": "{{paytm-website}}",
//     "txnAmount": {
//       "value": "1.00",
//       "currency": "INR"
//     },
//     "userInfo": {
//       "custId": "CUST_001"
//     },
//     "callbackUrl": "https://merchant-website.com/callback"
//   },
//   "head": {
//     "signature": "{{paytm-checksum}}"
//   }
// }';
// dd($this->body);
$result =Http::withHeaders($this->headers)->asForm()->post('https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=$this->mid&orderId=$this->body["body"]["orderId"]', $this->body);
// $request = new Request('POST', 'https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=$this->mid&orderId=$this->body["body"]["orderId"]', $this->headers, $post_data);
// $res = $client->sendAsync($request)->wait();
dd($result);
return $result->body();
    //   $res = Http::withHeaders($this->headers)->asForm()->post("https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=$this->mid&orderId=$this->body['body']['orderId']",$this->body);
    //   return $res;
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
    public function verifyPayment($params){
      $res = Http::withHeaders($this->headers)->asForm()->get('https://api.stripe.com/v1/payment_intents/'.$params['payment_intent']);
      return $this->Response($res);
    }
}
