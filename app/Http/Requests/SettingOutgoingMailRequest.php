<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingOutgoingMailRequest extends FormRequest
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
            'mail_mailer' => 'required',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name' => 'required|max:255',
            'queue_connection' => 'required',
        ];

        if (request('mail_mailer') === 'smtp') {
            $rules['mail_host'] = 'required|max:255';
            $rules['mail_port'] = 'required|numeric';
            $rules['mail_username'] = 'required|max:255';
            $rules['mail_password'] = 'required';
            $rules['mail_encryption'] = 'required';
        }

        if (request('mail_mailer') === 'mailgun') {
            $rules['mailgun_domain'] = 'required';
            $rules['mailgun_secret'] = 'required';
            $rules['mailgun_endpoint'] = 'required';
        }

        return $rules;
    }
}
