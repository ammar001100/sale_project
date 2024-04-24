<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TreasuryRequest extends FormRequest
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
            //unique:Treasuries
            'last_isal_exhcange' => 'required|integer|min:0',
            'last_isal_collect' => 'required|integer|min:0',
            'is_master' => 'required',
            'active' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'الاسم الخزنة مطلوب',
            //'name.unique' => 'عفوا اسم الخزنة موجود مسبقا',
            'name.max' => 'الاسم الخزنة يجب ان يكون 25 حرف',
            'last_isal_exhcange.required' => 'رقم اصال الصرف مطلوب',
            'last_isal_exhcange.integer' => 'رقم اصال الصرف يجب ان يكون رقم',
            'last_isal_collect.required' => 'رقم اصال التحصيل مطلوب',
            'last_isal_collect.integer' => 'رقم  اصال التحصيل يجب ان يكون رقم',

        ];
    }
}
