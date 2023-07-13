<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingGeneralRequest extends FormRequest
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
            'app_url'                   => 'required|url|max:255',
            'app_name'                  => 'required|max:255',
            'app_https'                 => 'nullable|boolean',
            'app_address'               => 'nullable|max:255',
            'app_phone'                 => 'nullable|max:255',
            'app_about'                 => 'required',
            'is_accepting_repair_order' => 'boolean',
            'is_processing_without_pay' => 'boolean',
            'portfolio_status'          => 'required|boolean',
            'send_notification'         => 'required|boolean',
        ];
    }
}
