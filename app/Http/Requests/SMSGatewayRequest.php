<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SMSGatewayRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'sms_status'  => 'required',
            'sms_channel' => 'required',
        ];
        if (request()->has('sms_status') && request('sms_channel') == 'nexmo') {
            $rules['nexmo_key']    = 'required';
            $rules['nexmo_secret'] = 'required';
            $rules['nexmo_from']   = 'required';
        }
        if (request()->has('sms_status') && request('sms_channel') == 'twilio') {
            $rules['twilio_account_sid'] = 'required';
            $rules['twilio_auth_token']  = 'required';
            $rules['twilio_from']        = 'required';
        }
        return $rules;
    }
}
