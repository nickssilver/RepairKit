<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BraintreeGatewayRequest extends FormRequest
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
            'bt_environment' => 'required',
            'bt_merchant_id' => 'required',
            'bt_public_key'  => 'required',
            'bt_private_key' => 'required',
            'bt_state'       => 'sometimes|boolean',
        ];
    }
}
