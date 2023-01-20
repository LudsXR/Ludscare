<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentGatewayRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    public function attributes(){

      $allAttributes = [];
      $allAttributes['payment_method_code'] = "Payment Method";
      $allAttributes['cardInfo.number'] = "Number";
      $allAttributes['cardInfo.exp_month'] = "Expiry Month";
      $allAttributes['cardInfo.exp_year'] = "Expiry Year";
      $allAttributes['cardInfo.cvc'] = "CVC";
      $allAttributes['plateForm'] = "PlatForm";
      $allAttributes['paytm_mode'] = "Paytm Mode";
      return $allAttributes;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'payment_method_code' => 'required|exists:payment_methods,code',
          'cardInfo.number' => 'required_if:payment_method_code,stripe,braintree|nullable|min:16|max:16',
          'cardInfo.exp_month' => 'required_if:payment_method_code,stripe,braintree|nullable|min:2|max:4',
          'cardInfo.exp_year' => 'required_if:payment_method_code,stripe,braintree|nullable|min:2|max:4',
          'cardInfo.cvc' => 'required_if:payment_method_code,stripe,braintree|nullable|min:3|max:3',
          'plateForm' => 'required|string',
          'paytm_mode' => 'required_if:payment_method_code,paytm',
        ];
    }
}
