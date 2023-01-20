<?php
namespace App\Traits;
use Twilio\Rest\Client;
use Twilio\Http\CurlClient;

trait Custom{

    public function currentDate(){
        $date = date('Y-m-d');
        return $date;
    }

    public function sendMessage($send_to,$body){

        $sid = config('app.twilio.sid');
        $token = config('app.twilio.token');
        $send_from = config('app.twilio.phone');

        $twilio = new Client($sid, $token);
        $curlOptions = [ CURLOPT_SSL_VERIFYHOST => false, CURLOPT_SSL_VERIFYPEER => false];
        $twilio->setHttpClient(new CurlClient($curlOptions));

        $message = $twilio->messages
                        ->create($send_to, // to
                            ["body" => $body, "from" => $send_from]
                    );

        return $message;

    }

}
