<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'account_id' => 'required_if:is_parent,1 ',
            'account_type_id' => 'required',
            'start_balance_status' => 'required',
            'start_balance' => 'required_if:start_balance_status,1,2',
            'is_parent' => 'required',
            'is_archived' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم الحساب المالي مطلوب',
            'name.max' => 'اسم الحساب المالي يجب ان يكون 25 حرف',
            'account_id.required_if' => 'من فضلك اختر الحساب الرئيسي',
            'account_type_id.required' => 'من فضلك اختر نوع الحساب المالي',
            'start_balance_status.required' => 'من فضلك اختر حالة الرصيد اول مدة',
            'start_balance.required_if' => 'من فضلك ادخل رصيد اول مدة',
            'is_archived.required' => 'حالة أرشفة الحساب مطلوبة',
            'is_parent.required' => 'من فضلك اختر هل الحساب رئيسي ام فرعي',
        ];
    }
}
