<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuplierWithOrderApproveBursahseRequest extends FormRequest
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
            'total_cost_items' => 'required',
            'tax_percent' => 'required|max:100',
            'tax_value' => 'required',
            'total_befor_discount' => 'required',
            //'discount_type' => 'required',//'required_if:start_balance_status,1,2',
            'discount_percent' => 'required_if:discount_type,1,2',
            'discount_value' => 'required_if:discount_type,1,2',
            'total_cost' => 'required',
            'treasury_name' => 'required',
            'treasury_id' => 'required',
            'treasury_money' => 'required',
            'pill_type' => 'required',
            'what_paid' => 'required',
            'what_remain' => 'required',
        ];
    }

    public function messages()
    {
        return [
            //'name.required' => '',
            //'name.max' => '',
            //'account_id.required_if' => '',
            //'account_type_id.required' => '',
            //'start_balance_status.required' => '',
            //'start_balance.required_if' => '',
            //'is_archived.required' => '',
            //'is_parent.required' => '',
        ];
    }
}
