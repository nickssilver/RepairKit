<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StripeGatewayRequest extends FormRequest
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
        return [
            'stripe_state'    => 'required',
            'stripe_pk'       => 'required',
            'stripe_sk'       => 'required',
            'stripe_currency' => 'required',
        ];
    }
}
