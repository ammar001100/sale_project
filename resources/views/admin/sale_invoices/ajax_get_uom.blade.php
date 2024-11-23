<div class="form-group">
    <label>وحدات البيع</label>
    @if (old('uom_id') == '' or $errors->has('uom_id'))
        <b class="start_uom_id"><smal style="color: green;"><span class="fa fa-check"></span></small></b>
     @endif
    <select class="form-control select2" name="uom_id" id="uom_id" style="width: 100%;">
        @if (@isset($data->uom) && !@empty($data->uom))
            <option data-is_parent="1" value="{{ $data->uom->id }}">{{ $data->uom->name }} (رئيسية)</option>
        @endif
        @if (@isset($data->retail_uom) && !@empty($data->retail_uom))
            <option data-is_parent="0" value="{{ $data->retail_uom->id }}">
                {{ $data->retail_uom->name }} (تجزئة)</option>
        @endif
    </select>
</div>
