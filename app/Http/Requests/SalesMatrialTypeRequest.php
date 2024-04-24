<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesMatrialTypeRequest extends FormRequest
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
            'active' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'اسم الفئة مطلوب',
            'name.max' => 'الاسم الفئة يجب ان يكون 25 حرف',
            'active.required' => 'حالة التفعيل مطلوبة',
        ];
    }
}
