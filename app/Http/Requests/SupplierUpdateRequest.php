<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierUpdateRequest extends FormRequest
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
            'supplier_category_id' => 'required',
            'active' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم المورد مطلوب',
            'supplier_category_id.required' => 'فئة المورد مطلوبه',
            'name.max' => 'اسم المورد يجب ان يكون 25 حرف',
            'active.required' => 'حالة التفعيل مطلوبة',
        ];
    }
}
