@if (isset($recleved_data) && count($recleved_data) > 5)
<tr>
    <td>{{ $recleved_data['store_name'] }}
        <input type="hidden" name="item_card_id_array_[]" value="{{ $recleved_data['item_card_id'] }}" class="item_card_id_array_">
        <input type="hidden" name="store_id_array_[]" value="{{ $recleved_data['store_id'] }}">
        <input type="hidden" name="uom_id_array_[]" value="{{ $recleved_data['uom_id'] }}">
        <input type="hidden" name="itemcard_batche_array_[]" value="{{ $recleved_data['itemcard_batche'] }}">
        <input type="hidden" name="quentity_array_[]" value="{{ $recleved_data['quentity'] }}">
        <input type="hidden" name="unit_cost_price_array_[]" value="{{ $recleved_data['unit_cost_price'] }}">
        <input type="hidden" name="is_bounce_or_other_array_[]" value="{{ $recleved_data['is_bounce_or_other'] }}">
        <input type="hidden" name="total_price_array_[]" value="{{ $recleved_data['total_price'] }}">
        <input type="hidden" name="is_parent_uom_array_[]" value="{{ $recleved_data['is_parent_uom'] }}">
        <input type="hidden" name="total_cost_items_array_[]" value="{{ $recleved_data['total_price'] }}" class="total_cost_items_array_">
    </td>
    <td>{{ $recleved_data['sales_type_name'] }}</td>
    <td>{{ $recleved_data['item_card_name'] }}</td>
    <td>{{ $recleved_data['uom_name'] }}</td>
    <td>{{ $recleved_data['quentity'] * 1}}</td>
    <td>{{ $recleved_data['unit_cost_price'] * 1}}</td>
    <td>{{ $recleved_data['total_price'] }}</td>
    <td>
        <button type="button" class="btn btn-danger btn-sm remove_item_row_">
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
