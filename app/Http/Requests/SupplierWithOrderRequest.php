<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierWithOrderRequest extends FormRequest
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
            'supplier_id' => 'required',
            'store_id' => 'required',
            'order_date' => 'required|date',
            'pill_type' => 'required',
            'active' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'supplier_id.required' => 'من فضلك اختر المورد',
            'store_id.required' => 'من فضلك اختر المخزن',
            'order_date.required' => 'من فضلك ادخل تاريخ الفاتورة',
            'order_date.date' => 'من فضلك ادخل تاريخ الفاتورة بشكل صحيح',
            'pill_type.required' => 'من فضلك اختر نوع الفاتورة',
            'active.required' => 'حالة التفعيل مطلوبة',
        ];
    }
}
