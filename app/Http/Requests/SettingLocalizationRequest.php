<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingLocalizationRequest extends FormRequest
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
            'app_timezone'    => 'required|max:255',
            'app_locale'      => 'required|exists:languages,locale|max:255',
            'app_date_locale' => 'required|max:255',
            'app_date_format' => 'required|max:255',
        ];
    }
}
