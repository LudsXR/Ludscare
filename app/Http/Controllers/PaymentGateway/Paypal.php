<?php

namespace App\Http\Controllers\PaymentGateway;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\PaymentMethod;
use App\Http\Controllers\Front\AppointmentBookingController;

class Paypal extends Controller
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
    public function index(Request $request)
    {
    }
    public function setAuthorizationKeys($payment_method)
    {
        foreach ($payment_method as $setting) {
            if ($setting->name == 'secret_key') {
                $secret_key = $setting->value;
            }
            if ($setting->name == 'client_id') {
                $client_id = $setting->value;
                $client_id = base64_encode($client_id);
            }
        }
        $this->headers['Authorization'] = "Basic '$client_id':'$secret_key";
        $this->headers['Accept'] = 'application/json';
        $this->headers['Accept-Language'] = 'en_US';
    }
    public function generateBody($required, $customer)
    {
        $url = url('/');
        $this->headers['Authorization'] = 'Bearer ' . $this->access_token;
          $amnt = $required['total'];
        // $amnt = 10;

        $this->body['intent'] = 'CAPTURE';
        $ammount['currency_code'] = 'USD';
        $ammount['value'] = $amnt;
        $this->body['purchase_units'] = [
            [
                'amount' => $ammount,
            ]
        ];
        $application_context['return_url'] = $url . "/processingPayment";
        $this->body['application_context'] = $application_context;
        return $this->sendRequest();
    }
    public function executePayment($request, $customer)
    {
        $this->request = $request;
        $this->customer = $customer;
        return $this->getAccessToken($request);
    }
    public function getAccessToken($payment_method_info)
    {
        $res = HTTP::withHeaders($this->headers)->asForm()->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
            'grant_type' => 'client_credentials',
        ]);
        if ($res->successful() || $res->ok()) {
            $token = json_decode($res->body());
            $this->access_token = $token->access_token;
            return $this->generateBody($this->request, $this->customer);
        } else {
            $this->Response($res);
        }
    }

    public function sendRequest()
    {
        $res = Http::withHeaders($this->headers)->post('https://api-m.sandbox.paypal.com/v2/checkout/orders', $this->body);
        return $this->Response($res);
    }
    public function authorizeWithoutCapture()
    {
    }
    public function authorizeWithCapture()
    {
    }
    public function Response($res)
    {
        $body = json_decode($res->body());
        if ($res->successful() || $res->ok()) {
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
                if ($link->rel == 'approve') {
                    $response['authorization_url'] = $link->href;
                }
            }
            $response['return_url'] = '';
            $response['status'] = '200';
            return $response;
        } else {
            if ($body->message) {
                $error['message'] = $body->message;
                $response['data'] = $error;
            }
            $response['success'] = false;
            $response['captured'] = false;
            $response['status'] = $res->status();
            return $response;
        }
    }
    public function verifyPayment()
    {
        $token_param = $_GET['token'];

        $payment_method_settings = PaymentMethod::with('settings')->where('code', 'paypal')->first();
        $this->setAuthorizationKeys($payment_method_settings->settings);
        $res = HTTP::withHeaders($this->headers)->asForm()->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
            'grant_type' => 'client_credentials',
        ]);
        if ($res->successful() || $res->ok()) {
            $token = json_decode($res->body());
            $this->access_token = $token->access_token;
            $this->headers['Authorization'] = 'Bearer ' . $this->access_token;
            //    $res = Http::withHeaders($this->headers)->post('https://api.sandbox.paypal.com/v2/checkout/orders/'.$params['token'].'/capture');

            // $url='https://api.sandbox.paypal.com/v2/checkout/orders/'.$token_param.'/capture';
            // dd($url);
            $res = Http::withHeaders($this->headers)->post('https://api.sandbox.paypal.com/v2/checkout/orders/'.$token_param.'/capture');
            $result=$this->Response($res);
            if($result['success']==true  && $result['captured']==true){
                $bookAppointmentId=session('bookAppointmentId');
                $appointment=new AppointmentBookingController();
                $appointment_res=$appointment->updateAppointmentAfterPayment($bookAppointmentId,3);
                session()->forget('bookAppointmentId');
                session()->flush();
                $result="Payment Done Successfully !";
                return view('thank-you',compact('result'));
            }
            $bookAppointmentId=session('bookAppointmentId');
            $result=json_decode($res->body())->message;
            // dd($bookAppointmentId);
            return view('thank-you',compact('result'));
        } else {
            session()->forget('bookAppointmentId');
            session()->flush();
            $result=$this->Response($res);
            return view('thank-you',compact('result'));
        }
    }
}
