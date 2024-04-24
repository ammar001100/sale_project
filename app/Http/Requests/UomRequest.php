<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UomRequest extends FormRequest
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
            'name' => 'required | max:25',
            'is_master' => 'required',
            //'address' => 'required | max:50',
            'active' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'اسم الوحدة مطلوب',
            'name.max' => 'اسم الوحدة يجب ان يكون 25 حرف',
            'is_master.required' => 'نوع الوحدة مطلوب',
            //'phones.max' => 'هاتف المخزن يجب ان يكون 30 حرف',
            //'address.required' => 'عنوان المخزن مطلوب',
            //'address.max' => 'عنوان المخزن يجب ان يكون 50 حرف',
            'active.required' => 'حالة التفعيل مطلوبة',
        ];
    }
}
