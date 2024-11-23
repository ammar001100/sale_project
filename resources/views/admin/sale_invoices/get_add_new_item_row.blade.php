@if (isset($recleved_data) && count($recleved_data) > 0)
<tr>
    <td>{{ $recleved_data['store_name'] }}
        <input type="hidden" name="items_array[{{ $recleved_data['index'] }}][item_card_id]" value="{{ $recleved_data['item_card_id'] }}" class="item_card_id_array">
        <input type="hidden" name="items_array[{{ $recleved_data['index'] }}][store_id]" value="{{ $recleved_data['store_id'] }}" class="store_id_array">
        <input type="hidden" name="items_array[{{ $recleved_data['index'] }}][sales_type]" value="{{ $recleved_data['sales_type'] }}" class="sales_type">
        <input type="hidden" name="items_array[{{ $recleved_data['index'] }}][uom_id]" value="{{ $recleved_data['uom_id'] }}" class="uom_id_array">
        <input type="hidden" name="items_array[{{ $recleved_data['index'] }}][itemcard_batche]" value="{{ $recleved_data['itemcard_batche'] }}" class="itemcard_batche_array">
        <input type="hidden" name="items_array[{{ $recleved_data['index'] }}][quentity]" value="{{ $recleved_data['quentity'] }}" class="quentity_array">
        <input type="hidden" name="items_array[{{ $recleved_data['index'] }}][unit_cost_price]" value="{{ $recleved_data['unit_cost_price'] }}" class="unit_cost_price_array">
        <input type="hidden" name="items_array[{{ $recleved_data['index'] }}][is_bounce_or_other]" value="{{ $recleved_data['is_bounce_or_other'] }}" class="is_bounce_or_other_array">
        <input type="hidden" name="items_array[{{ $recleved_data['index'] }}][total_price]" value="{{ $recleved_data['total_price'] }}" class="total_price_array">
        <input type="hidden" name="items_array[{{ $recleved_data['index'] }}][is_parent_uom]" value="{{ $recleved_data['is_parent_uom'] }}" class="is_parent_uom_array">
        <input type="hidden" name="items_array[{{ $recleved_data['index'] }}][total_price]" value="{{ $recleved_data['total_price'] }}" class="is_parent_uom_array">
        <input type="hidden" name="total_cost_items_array[]" value="{{ $recleved_data['total_price'] }}" class="total_cost_items_array">
    </td>
    <td>{{ $recleved_data['sales_type_name'] }}</td>
    <td>{{ $recleved_data['item_card_name'] }}</td>
    <td>{{ $recleved_data['uom_name'] }}</td>
    <td>{{ $recleved_data['quentity'] * 1}}</td>
    <td>{{ $recleved_data['unit_cost_price'] * 1}}</td>
    <td>{{ $recleved_data['total_price'] }}</td>
    <td>
        <button type="button" class="btn btn-danger btn-sm remove_item_row">
            <i class="fas fa-trash"></i>
        </button>
    </td>
</tr>
@else
<div class="card_title_center">
    <p class="btn btn-danger btn-sm">
        عفوا لاتوجد بيانات
    </p>
</div>
@endif
