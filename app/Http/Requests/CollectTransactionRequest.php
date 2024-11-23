<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollectTransactionRequest extends FormRequest
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
            'account_id' => 'required',
            'treasury_id' => 'required',
            'mov_type_id' => 'required',
            'mov_date' => 'required|date',
            'money' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'account_id.required' => 'الرجاء اختيار الحساب المالي',
            'treasury_id.required' => 'الرجاء اختيار الخزنة',
            'mov_type_id.required' => 'الرجاء اختيار نوع الحركة المالية',
            'mov_date.required' => 'الرجاء ادخال تاريخ الحركة المالية',
            'mov_date.date' => 'الرجاء ادخال تاريخ الحركة بشكل صحيح',
            'money.required' => 'الرجاء ادخال قيمة المبلغ المحصل',
        ];
    }
}
