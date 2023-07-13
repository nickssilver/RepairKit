<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SquareGatewayRequest extends FormRequest
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
            'square_state'          => 'required',
            'square_sandbox'        => 'required',
            'square_application_id' => 'required',
            'square_location_id'    => 'required',
            'square_token'          => 'required',
            'square_currency'       => 'required',
        ];
    }
}
