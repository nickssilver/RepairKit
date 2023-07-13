<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingTaxRequest extends FormRequest
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
            'tax_rate' => 'required|numeric',
            'is_tax_fix' => 'boolean',
            'is_tax_included' => 'boolean',
            'is_vat' => 'required|boolean',
        ];
    }
}
