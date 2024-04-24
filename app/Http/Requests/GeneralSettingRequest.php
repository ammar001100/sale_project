<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneralSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'system_name'=>'required | max:25',
            'address'=>'required | max:30',
            'phone'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'system_name.required'=>'الاسم مطلوب',
            'system_name.max'=>'الاسم يجب ان يكون 25 حرف',
            'address.required'=>'العنوان مطلوب',
            'address.max'=>'العنون يجب ان يكون 30 حرف',
            'phone.required'=>'رقم الهاتف مطلوب',

        ];
    }
}
