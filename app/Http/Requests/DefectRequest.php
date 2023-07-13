<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DefectRequest extends FormRequest
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
            'title'         => 'required|max:255',
            'required_time' => 'required|max:255',
            'cost'          => 'required|numeric',
            'device_id'     => 'required',
            'price'         => 'required|numeric',
        ];
    }
}
