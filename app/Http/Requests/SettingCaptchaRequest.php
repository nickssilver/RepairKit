<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingCaptchaRequest extends FormRequest
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
            'recaptcha_enabled' => 'required|boolean',
            'recaptcha_public'  => 'required_if:recaptcha_enabled,true',
            'recaptcha_private' => 'required_if:recaptcha_enabled,true',
        ];
    }
}
