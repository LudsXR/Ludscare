<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use App\Models\BookAppointment;
use App\Models\JazzcashMerchant;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class JazzcashGatewayController extends Controller
{

    private $merchant_id;
    private $password;
    private $integrity_salt;
    private $currency;
    private $language;
    private $post_url;

    function __construct()
    {
        $payment_method_settings = PaymentMethod::with('settings')->where('code', 'jazzcash')->first();
        foreach ($payment_method_settings->settings as $setting) {
            if ($setting->name == 'password') {
                $this->password = $setting->value;
            }
            if ($setting->name == 'merchant_id') {
                $this->merchant_id = $setting->value;
            }
            if ($setting->name == 'hash') {
                $this->integrity_salt = $setting->value;
            }
        }

        $this->currency         = 'PKR';
        $this->language         = 'EN';
        $this->post_url = 'https://payments.jazzcash.com.pk/ApplicationAPI/API/2.0/Purchase/DoMWalletTransaction';
    }
    public function createCharge(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_no' => 'required|numeric|digits:11',
            'cnic' => 'required|numeric|digits:6',
            'amount' => 'required|numeric',
            // "bookAppointmentId" => 'required|numeric',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            //------------------------------------------------------
            date_default_timezone_set('Asia/Karachi');
            //ini_set('max_execution_time', 60); //60 seconds = 1 minutes
            //------------------------------------------------------

            //------------------------------------------------------
            $DateTime     = new DateTime();
            $pp_TxnDateTime = $DateTime->format('YmdHis');
            //------------------------------------------------------

            //------------------------------------------------------
            //expiry date, add 1 hour to $DateTime
            $ExpiryDateTime = $DateTime;
            $ExpiryDateTime->modify('+' . 1 . ' hours');
            $pp_TxnExpiryDateTime = $ExpiryDateTime->format('YmdHis');
            //------------------------------------------------------

            //------------------------------------------------------
            //transaction number
            $pp_TxnRefNo = 'T' . $pp_TxnDateTime;
            //------------------------------------------------------
            //------------------------------------------------------
            $temp_amount     = $request->amount * 100;
            $amount_array     = explode('.', $temp_amount);
            $pp_Amount     = $amount_array[0];
            //------------------------------------------------------
            $additional_data = array();
            $additional_data['pp_TxnDateTime']          = $pp_TxnDateTime;
            $additional_data['pp_TxnExpiryDateTime'] = $pp_TxnExpiryDateTime;
            $additional_data['pp_TxnRefNo']          = $pp_TxnRefNo;
            $additional_data['pp_Amount']              = $pp_Amount;


            $data_array = $this->get_mobile_payment_array($request, $additional_data);

            $pp_SecureHash = $this->get_SecureHash($data_array);
            $data_array["pp_SecureHash"] = $pp_SecureHash;


            //sends transaction data to Jazz Cash Payment Gateway
            //and receives response
            $make_call = $this->callAPI(json_encode($data_array));
            $result = json_decode($make_call);

            // return response()->json($result);

            $b = (array)json_decode(str_replace('\u0000*\u0000', '', $make_call));
            if (count($b) == 0) {
                $obj = ["Status" => false, "success" => 0, "msg" =>  "No Response from Service Provider."];
                return response()->json($obj);
            }

            //Adding amount to wallet
            if ($request->is_wallet_topup) {
                if ($b['pp_ResponseCode'] == "000") {
                    $wallet = new WalletController();
                    $wallet->depositFromGateway($request->mentee_id, $request->amount);
                    $obj = ["Status" => true, "success" => 1, "msg" => $b['pp_ResponseMessage']];
                } else {
                    if ($b['pp_ResponseCode'] == "999") {
                        $obj = ["Status" => false, "success" => 0, "msg" =>  "The balance in account is insufficient for the transaction."];
                        return response()->json($obj);
                    } else {
                        $obj = ["Status" => false, "success" => 0, "msg" => $b['pp_ResponseMessage']];
                    }
                }
            } else {
                $appointment = BookAppointment::find($request->bookAppointmentId);
                if ($b['pp_ResponseCode'] == "000") {


                    $appointment->update([
                        'payment_status_code' => $b['pp_ResponseCode'],
                        'payment_response_msg' => $b['pp_ResponseMessage'],
                        'payment_order_ref' => $b['pp_RetreivalReferenceNo'],
                        'is_paid' => 1
                    ]);
                    // $make_call = "Connection Failure";
                    $obj = ["Status" => true, "success" => 1, "msg" => $b['pp_ResponseMessage']];
                } else {
                    $appointment->update([
                        'payment_status_code' => $b['pp_ResponseCode'],
                        'payment_response_msg' => $b['pp_ResponseMessage'],
                        'payment_order_ref' => $b['pp_RetreivalReferenceNo']
                    ]);
                    if ($b['pp_ResponseCode'] == "999") {
                        $obj = ["Status" => false, "success" => 0, "msg" =>  "The balance in account is insufficient for the transaction."];
                        return response()->json($obj);
                    } else {
                        $obj = ["Status" => false, "success" => 0, "msg" => $b['pp_ResponseMessage']];
                    }
                }
            }

            return response()->json($obj);
        } else {
            $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
            return response()->json($obj);
        }
    }
    public function createChargeForWallet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_no' => 'required|numeric|digits:11',
            'cnic' => 'required|numeric|digits:6',
            'amount' => 'required|numeric',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            //------------------------------------------------------
            date_default_timezone_set('Asia/Karachi');
            //ini_set('max_execution_time', 60); //60 seconds = 1 minutes
            //------------------------------------------------------

            //------------------------------------------------------
            $DateTime     = new DateTime();
            $pp_TxnDateTime = $DateTime->format('YmdHis');
            //------------------------------------------------------

            //------------------------------------------------------
            //expiry date, add 1 hour to $DateTime
            $ExpiryDateTime = $DateTime;
            $ExpiryDateTime->modify('+' . 1 . ' hours');
            $pp_TxnExpiryDateTime = $ExpiryDateTime->format('YmdHis');
            //------------------------------------------------------

            //------------------------------------------------------
            //transaction number
            $pp_TxnRefNo = 'T' . $pp_TxnDateTime;
            //------------------------------------------------------
            //------------------------------------------------------
            $temp_amount     = $request->amount * 100;
            $amount_array     = explode('.', $temp_amount);
            $pp_Amount     = $amount_array[0];
            //------------------------------------------------------
            $additional_data = array();
            $additional_data['pp_TxnDateTime']          = $pp_TxnDateTime;
            $additional_data['pp_TxnExpiryDateTime'] = $pp_TxnExpiryDateTime;
            $additional_data['pp_TxnRefNo']          = $pp_TxnRefNo;
            $additional_data['pp_Amount']              = $pp_Amount;



            $data_array = $this->get_mobile_payment_array($request, $additional_data);


            $pp_SecureHash = $this->get_SecureHash($data_array);
            $data_array["pp_SecureHash"] = $pp_SecureHash;

            //sends transaction data to Jazz Cash Payment Gateway
            //and receives response
            $make_call = $this->callAPI(json_encode($data_array));
            $result = json_decode($make_call);

            // return response()->json($result);

            if ($result->pp_ResponseCode == "000") {
                $user = User::find($request->user_id);
                $transaction = $user->deposit($request->amount);
                $obj = ["Status" => true, "success" => 1, "data" => ['transaction' => $transaction], "msg" => "Successfully deposit into Wallet"];
                return response()->json($obj);
            }
            if ($result->pp_ResponseCode == "999") {
                $obj = ["Status" => false, "success" => 0, "msg" =>  "The balance in account is insufficient for the transaction."];
                return response()->json($obj);
            }
            $obj = ["Status" => false, "success" => 0, "msg" => $result->pp_ResponseMessage];
            return response()->json($obj);
        } else {
            $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
            return response()->json($obj);
        }
    }

    /*
--------------------------------------------------------------------------------
| NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
| NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
--------------------------------------------------------------------------------
 */
    private function get_SecureHash($data_array)
    {
        ksort($data_array);

        $str = '';
        foreach ($data_array as $key => $value) {
            if (!empty($value)) {
                $str = $str . '&' . $value;
            }
        }

        $str = $this->integrity_salt . $str;

        $pp_SecureHash = hash_hmac('sha256', $str, $this->integrity_salt);



        return $pp_SecureHash;
    }

    /*
--------------------------------------------------------------------------------
| NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
| NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
--------------------------------------------------------------------------------
 */

    private function callAPI($data)
    {
        $curl = curl_init();
        //OPTIONS:
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_URL, $this->post_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json',));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //EXECUTE:
        $result = curl_exec($curl);
        if (!$result) {

            $result = curl_error($curl);
        }
        curl_close($curl);

        return $result;
    }

    /*
--------------------------------------------------------------------------------
| NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
| NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
--------------------------------------------------------------------------------
 */


    private function get_mobile_payment_array($request, $additional_data)
    {
        //Transaction Array Mobile
        $data =  array(
            "pp_Language"             => $this->language,
            "pp_MerchantID"         => $this->merchant_id,
            "pp_SubMerchantID"         => "",
            "pp_Password"             => $this->password,
            "pp_BankID"             => "",
            "pp_ProductID"             => "",
            "pp_TxnRefNo"             => $additional_data['pp_TxnRefNo'],
            "pp_Amount"             => $additional_data['pp_Amount'],
            "pp_TxnCurrency"         => $this->currency,
            "pp_TxnDateTime"         => $additional_data['pp_TxnDateTime'],
            "pp_BillReference"         => "billRef",
            "pp_Description"         => "Description",
            "pp_TxnExpiryDateTime"     => $additional_data['pp_TxnExpiryDateTime'],
            "pp_SecureHash"         => "",
            "ppmpf_1"                 => $request->mobile_no,
            "ppmpf_2"                 => "",
            "ppmpf_3"                 => "",
            "ppmpf_4"                 => "",
            "ppmpf_5"                 => "",
            "pp_MobileNumber"         => $request->mobile_no,
            "pp_CNIC"                 => $request->cnic,
        );

        return $data;
    }

    private function get_card_payment_array($request, $additional_data)
    {
        //Transaction Array Card
        $data =  array(
            "pp_IsRegisteredCustomer"         => "No",
            "pp_ShouldTokenizeCardNumber"     => "No",
            "pp_CustomerID"                 => "test",
            "pp_CustomerEmail"                 => "test@test.com",
            "pp_CustomerMobile"             => "03222852628",
            "pp_TxnType"                     => "MPAY",
            "pp_TxnRefNo"                     => $additional_data['pp_TxnRefNo'],
            "pp_C3DSecureID"                 => "",
            "pp_MerchantID"                 => $this->merchant_id,
            "pp_Password"                     => $this->password,
            "pp_Amount"                     => $additional_data['pp_Amount'],
            "pp_TxnCurrency"                 => $this->currency,
            "pp_TxnDateTime"                 => $additional_data['pp_TxnDateTime'],
            "pp_TxnExpiryDateTime"             => $additional_data['pp_TxnExpiryDateTime'],
            "pp_BillReference"                 => "billRef",
            "pp_Description"                 => "Description of transaction",
            "pp_CustomerCardNumber"         => $request->ccNo,
            "pp_CustomerCardExpiry"         => $request->expMonth . $request->expYear,
            "pp_CustomerCardCvv"             => $request->cvv,
            "pp_SecureHash" => ""
        );

        return $data;
    }
}
