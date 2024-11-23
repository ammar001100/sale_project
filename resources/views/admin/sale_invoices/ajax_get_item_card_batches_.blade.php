<div class="form-group">
    <label>الكميات بالمخزن</label>
    @if (old('itemcard_batche_') == '' or $errors->has('itemcard_batche_'))
    <b class="start_itemcard_batche_" style="color: rgb(240, 43, 17);">*</b>
    @endif
    <select class="form-control select2" name="itemcard_batche_" id="itemcard_batche_" style="width: 100%;">
        @if (isset($data) && $data->count() > 0)
        @if($data_uom->is_master == 1)
        @foreach($data as $info)
        @if($data_Item_card->item_type == 2)
        <option data-quantity="{{ $info->quantity*1 }}" value="{{ $info->id }}">عدد {{ $info->quantity*1 }} {{ $data_uom->name }} انتاج {{ $info->pro_date }} بسعر {{ $info->unit_cost_price* 1 }} للوحدة </option>
        @else
        <option data-quantity="{{ $info->quantity*1 }}" value="{{ $info->id }}">عدد {{ $info->quantity*1 }} {{ $data_uom->name }} بسعر {{ $info->unit_cost_price * 1 }} للوحدة </option>
        @endif
        @endforeach
        @else
        @foreach($data as $info)
        @php
        $quantity = $info->quantity * $data_Item_card->retail_uom_quntToparent;
        @endphp
        @if($data_Item_card->item_type == 2)
        <option data-quantity="{{ $quantity*1 }}" value="{{ $info->id }}">عدد {{ $quantity }} {{ $data_uom->name }} انتاج {{ $info->pro_date }} بسعر {{ $info->unit_cost_price / $data_Item_card->retail_uom_quntToparent * 1 }} للوحدة </option>
        @else
        <option data-quantity="{{ $quantity*1 }}" value="{{ $info->id }}">عدد {{ $quantity }} {{ $data_uom->name }} بسعر {{ $info->unit_cost_price / $data_Item_card->retail_uom_quntToparent * 1 }} للوحدة </option>
        @endif
        @endforeach
        @endif
        @else
        <option value="">لا توجد كميات بالمخزن</option>
        @endif
    </select>
</div>
