<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RepairOrderUpdateRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable',
            'address' => 'nullable|max:255',
            'serial_number' => 'nullable|max:50',
            'diagnostics' => 'nullable',
            'sub_total' => 'required|max:25',
            'total_cost' => 'required|max:25',
            'tax' => 'required|max:25',
            'total_charges' => 'required|max:25',
            'profit' => 'required|max:25',
            'repair_priority_id' => 'required',
            'user_id' => 'nullable|sometimes',
            'is_device_collected' => 'sometimes|boolean',
            'additional_amount' => 'nullable|numeric',
            'send_notification' => 'boolean',
            'is_archive' => 'boolean',
            'is_lock' => 'boolean',
            'has_warranty' => 'boolean',
            'pre_paid' => 'required',
        ];
        if ($this->is_manual) {
            $rules['brand_info'] = 'required';
            $rules['device_info'] = 'required';
            $rules['defects_info'] = 'required';
            $rules['is_manual'] = 'required';
        } else {
            $rules['defects'] = 'required';
            $rules['brand_id'] = 'required';
            $rules['device_id'] = 'required';
        }
        return $rules;
    }
}
