<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemCardRequestRequest extends FormRequest
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
            'name' => 'required | max:30',
            'item_type' => 'required | integer',
            'itemcard_category_id' => 'required | integer',
            'uom_id' => 'required | integer',
            'price' => 'required ',
            'nos_gomal_price' => 'required ',
            'gomal_price' => 'required ',
            'cost_price' => 'required ',

            'does_has_retailunit' => 'required_if:does_has_retailunit,1',

            'retail_uom_id' => 'required_if:does_has_retailunit,1 ',
            'retail_uom_quntToparent' => 'required_if:does_has_retailunit,1',
            'price_retail' => 'required_if:does_has_retailunit,1',
            'nos_gomal_price_retail' => 'required_if:does_has_retailunit,1',
            'gomal_price_retail' => 'required_if:does_has_retailunit,1',
            'cost_price_retail' => 'required_if:does_has_retailunit,1',

            'item_card_id' => 'required|integer',
            'has_fixced_price' => 'required',
            'active' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم الصنف مطلوب',
            'name.max' => 'اسم الصنف يجب ان يكون 30 حرف',
            'itemcard_category_id.required' => 'فئة الصنف مطلوبة',
            'itemcard_category_id.integer' => 'فئة الصنف يجب ان تكون من نوع رقم',
            'item_type.required' => 'نوع الصنف مطلوب',
            'item_type.integer' => 'نوع الصنف يجب ان يكون من نوع رقم',

            'uom_id.integer' => 'نوع الوحدة الاب يجب ان يكون من نوع رقم',
            'uom_id.required' => 'وحدة القياس الاب مطلوبة',
            'price.required' => 'من فضلك ادخل سعر القطاعي لوحدة القياس الاب',
            'nos_gomal_price.required' => 'من فضلك ادخل سعر نص جملة لوحدة القياس الاب',
            'gomal_price.required' => 'من فضلك ادخل سعر الجملة لوحدة القياس الاب',
            'cost_price.required' => 'من فضلك ادخل سعر الشراء لوحدة القياس الاب',

            'does_has_retailunit.required_if' => 'من فضلك حدد هل الصنف له وحدة قياس جزئية',

            'retail_uom_id.required_if' => 'من فضلك اختر وحدت القياس الجزئية',
            'retail_uom_quntToparent.required_if' => 'من فضلك ادخل عدد وحدات التجزئة',
            'price_retail.required_if' => 'من فضلك ادخل سعر القطاعي للوحدة الجزئية',
            'nos_gomal_price_retail.required_if' => 'من فضلك ادخل سعر نص الجملة للوحدة الجزئية',
            'gomal_price_retail.required_if' => 'من فضلك ادخل سعر الجملة للوحة الجزئية',
            'cost_price_retail.required_if' => 'من فضلك ادخل سعر الشراء للوحدة الجزئية',

            'item_card_id.required' => 'من فضلك اختار الصنف الرئسي اذا كان فرعي',
            'has_fixced_price.required' => 'من فضلك حدد هل للصنف سعر ثابت بالفواتير',
            'active.required' => 'من فضلك اختر حالة التفعيل',
        ];
    }
}
