<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'start_balance_status' => 'required',
            'start_balance' => 'required_if:start_balance_status,1,2',
            'active' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم المورد مطلوب',
            'supplier_category_id.required' => 'فئة المورد مطلوبه',
            'name.max' => 'اسم المورد يجب ان يكون 25 حرف',
            'start_balance_status.required' => 'من فضلك اختر حالة الرصيد اول مدة',
            'start_balance.required_if' => 'من فضلك ادخل رصيد اول مدة',
            'active.required' => 'حالة التفعيل مطلوبة',
        ];
    }
}
