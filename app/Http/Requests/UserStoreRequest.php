<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'name'     => 'required|max:255',
            'status'   => 'required|boolean',
            'password' => 'required|min:6',
            'role_id'  => 'required|exists:user_roles,id',
            'email'    => 'required|email|max:255|unique:users',
            'phone'    => 'nullable',
        ];
    }
}
