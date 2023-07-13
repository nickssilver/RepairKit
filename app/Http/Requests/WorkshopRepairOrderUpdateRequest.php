<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkshopRepairOrderUpdateRequest extends FormRequest
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
            'pre_paid' => 'required|numeric',
            'name' => 'required|max:255',
            'phone' => 'nullable',
            'address' => 'nullable|max:255',
            'serial_number' => 'nullable|max:255',
            'payment_info' => 'nullable',
            'email' => 'required|email|max:255',
            'is_device_collected' => 'required|boolean',
            'additional_amount' => 'nullable|numeric',
            'send_notification' => 'boolean',
            'is_archive' => 'boolean',
            'is_lock' => 'boolean',
            'has_warranty' => 'boolean',
        ];
    }
}
