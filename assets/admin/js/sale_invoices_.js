$(document).ready(function() {
    $(document).on('change', '#item_card_id_', function() {
        //get item cards
        _get_uom();
        var item_card_id = $("#item_card_id_ option:selected").val();
        if (item_card_id != '') {
            $(".start_item_card_id_").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        } else {
            $(".start_item_card_id_").html('<smal style="color: red);">*</small>');
        }
    });
    $(document).on('change', '#store_id_', function() {
        //get item cards
        _get_uom();
        var store_id = $("#store_id_ option:selected").val();
        if (store_id != '') {
            $(".start_store_id_").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        } else {
            $(".start_store_id_").html('<smal style="color: red);">*</small>');
        }
    });
    $(document).on('change', '#uom_id_', function() {
        _get_itemcard_batches();
        _get_unit_cost_price();
    });
    $(document).on('change', '#sales_type_', function() {
        _get_unit_cost_price();
    });
    $(document).on('input', '#unit_cost_price_', function() {
        _recalculate_item_total();
        var unit_cost_price = $("#unit_cost_price_").val();
        if (unit_cost_price != '' && unit_cost_price != 0) {
            $(".start_unit_cost_price_").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        } else {
            $(".start_unit_cost_price_").html('<smal style="color: red);">*</small>');
        }
    });
    $(document).on('input', '#quentity_', function() {
        _recalculate_item_total();
        var quentity = $("#quentity_").val();
        if (quentity != '' && quentity != 0) {
            $(".start_quentity_").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        } else {
            $(".start_quentity_").html('<smal style="color: red);">*</small>');
        }
    });
    $(document).on('click', '.remove_item_row_', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
        _recalcualte();
    });
    // $(document).on('mouseenter', '#AddItemToInvoiceDetails', function(e) {
    //     _get_itemcard_batches();
    // });
    //validation
    $(document).on('click', '#AddItemToInvoiceDetails', function(e) {
        e.preventDefault();
        //item_card_
        var item_card_id = $("#item_card_id_ option:selected").val();
        if (item_card_id == '') {
            $(".start_item_card_id_").text('*');
            toastr.error('من فضلك أختر الصنف');
            return false;
        }
        //store
        var store_id = $("#store_id_ option:selected").val();
        if (store_id == '') {
            $(".start_store_id_").text('*');
            toastr.error('من فضلك أختر المخزن');
            return false;
        }
        //uom
        var uom_id = $("#uom_id_ option:selected").val();
        if (uom_id == '') {
            $(".start_uom_id_").text('*');
            toastr.error('من فضلك أختر وحدة البيع');
            return false;
        }
        //itemcard batches
        var itemcard_batche = $("#itemcard_batche_ option:selected").val();
        if (itemcard_batche == '') {
            $(".start_itemcard_batche_").text('*');
            toastr.error('عفوا لا توجد كميات بالمخزن');
            return false;
        }
        //is bounce or other
        var is_bounce_or_other = $("#is_bounce_or_other_ option:selected").val();
        if (is_bounce_or_other == '') {
            $(".start_is_bounce_or_other_").text('*');
            toastr.error('من فضلك أختر حالة البيع');
            return false;
        }
        //unit cost price
        var unit_cost_price = $("#unit_cost_price_").val();
        if (unit_cost_price == '' || unit_cost_price <= 0) {
            $(".start_unit_cost_price_").text('*');
            toastr.error('من فضلك ادخل سعر الصنف');
            return false;
        }
        //sales matrial type
        var sales_type = $("#sales_type_ option:selected").val();
        if (sales_type == '') {
            $(".sales_type_").text('*');
            toastr.error('من فضلك أختر نوع البيع');
            return false;
        }
        //quentity
        var quentity = $("#quentity_").val();
        if (quentity == '' || quentity <= 0) {
            $(".start_quentity_").text('*');
            toastr.error('من فضلك ادخل كمية الصنف');
            return false;
        }
        var batch_quentity = $("#itemcard_batche_ option:selected").data("quantity");
        if (parseFloat(quentity) > parseFloat(batch_quentity)) {
            $(".start_quentity_").text('*');
            toastr.error('عفوا الكمية المطلوبة اكبر من الكمية الموجودة بالمخزن');
            return false;
        } else {
            $(".start_quentity_").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        }
        var item_card_id_find = 0;
        $(".item_card_id_array_").each(function() {
            if (item_card_id === $(this).val()) {
                item_card_id_find = 1;
                return false;
            }
        });
        if (item_card_id_find === 1) {
            $(".start_item_card_id_").text('*');
            toastr.error('عفوا الصنف موجود بالفعل');
            return false;
        }
        //save row
        var item_card_id = $("#item_card_id_ option:selected").val();
        var item_card_name = $("#item_card_id_ option:selected").text();
        var store_name = $("#store_id_ option:selected").text();
        var uom_name = $("#uom_id_ option:selected").text();
        var sales_type_name = $("#sales_type_ option:selected").text();
        var is_bounce_or_other_name = $("#is_bounce_or_other_ option:selected").text();
        var is_parent_uom = $("#uom_id_ option:selected").data("is_parent_");
        var total_price = $("#total_price_").val();
        var token = $("#token").val();
        var get_new_item_row_url = $("#get_new_item_row_url_").val();
        jQuery.ajax({
            url: get_new_item_row_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                item_card_name: item_card_name,
                store_name: store_name,
                uom_name: uom_name,
                sales_type_name: sales_type_name,
                is_bounce_or_other_name: is_bounce_or_other_name,
                is_parent_uom: is_parent_uom,
                item_card_id: item_card_id,
                store_id: store_id,
                uom_id: uom_id,
                itemcard_batche: itemcard_batche,
                quentity: quentity,
                unit_cost_price: unit_cost_price,
                sales_type: sales_type,
                is_bounce_or_other: is_bounce_or_other,
                total_price: total_price,
                "_token": token
            },
            success: function(data) {
                $("#itemRow_").append(data);
                _recalcualte();
                $("#save_sale_invoice").show();
                toastr.success('تم اضافة الصنف الى الفاتورة');
            },
            error: function() {
                toastr.error('حدث خطاء ما الرجاء المحاولة لاحقا');
            },
        });
    });
    $(document).on('click', '#save_sale_invoice', function(e) {
        e.preventDefault();
        toastr.success('OK');
    });
    $(document).on('input', '#tax_percent_', function(e) {
        var tax_percent = $("#tax_percent_").val();
        if (tax_percent == 0) {
            tax_percent = 0;
        }
        if (tax_percent > 100) {
            toastr.error('عفوا لا يمكن ان تكون نسبة الضريبة اكبر من 100%');
            $("#tax_percent_").val(0);
        }
        _recalcualte();
    });
    $(document).on('input', '#discount_percent_', function(e) {
        var discount_percent = parseFloat($("#discount_percent_").val());
        var discount_value = parseFloat($("#discount_value_").val());
        var discount_type = $("#discount_type_").val();
        var total_befor_discount = parseFloat($("#total_befor_discount_").val());
        if (discount_percent == 0) {
            discount_percent = 0;
        }
        if (discount_type == 1) {
            if (discount_percent > 100) {
                toastr.error('عفوا لا يمكن ان تكون نسبة الخصم اكبر من 100%');
                $("#discount_percent_").val(0);
                $("#discount_value_").val(0);
                return false;
            }
        } else if (discount_type == 2) {
            if (parseFloat(discount_value) >= parseFloat(total_befor_discount)) {
                toastr.error('عفوا قيمة الخصم لا يجب ان تكون اكبر من القيمة الاجمالية');
                $("#discount_percent_").val(0);
                $("#discount_value_").val(0);
                return false;
            }
        }
        _recalcualte();
    });
    $(document).on('change', '#discount_type_', function(e) {
        var discount_type = $("#discount_type_").val();
        if (discount_type != "") {
            $("#discount_percent_").attr("readonly", false);
            $("#discount_percent_").val(0);
            $("#discount_value_").val(0);
        } else {
            $("#discount_percent_").attr("readonly", true);
            $("#discount_percent_").val(0);
            $("#discount_value_").val(0);
        }
        _recalcualte();
    });
    $(document).on('change', '#pill_type_', function(e) {
        _recalcualte();
    });
    $(document).on('input', '#what_paid_', function(e) {
        var total_cost = $("#total_cost_").val();
        var what_paid = $(this).val();
        if (what_paid == "") {
            what_paid = 0;
        }
        if (parseFloat(what_paid) > parseFloat(total_cost)) {
            toastr.error('عفوا لا يمكن ان يكون المبلغ المحصل اكبر من اجمالي الفاتورة');
            _recalcualte();
            return false;
        }
        var what_remain = parseFloat(total_cost) - parseFloat(what_paid);
        if (what_paid == total_cost) {
            toastr.error('عفوا لا يمكن تحصيل كل المبلع لنوع الفاتورة الاجل');
            _recalcualte();
            return false;
        }
        $("#what_remain_").val(what_remain * 1);
    });

});

function _get_uom() {
    var item_card_id = $("#item_card_id_ option:selected").val();
    var token = $("#token").val();
    var ajax_get_uom_url = $("#ajax_get_uom_url_").val();
    if (item_card_id != '') {
        jQuery.ajax({
            url: ajax_get_uom_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                item_card_id: item_card_id,
                "_token": token
            },
            success: function(data) {
                $(".DivUom_").html(data);
                $("#TdDivUom_").show();
                $("#TdStoreId_").show();
                _get_itemcard_batches();
                _get_unit_cost_price();
            },
            error: function() {
                $(".DivUom_").html('');
                $("#TdDivUom_").hide();
                toastr.error('حدث خطاء ربما تم حذف وحدة الصنف المختار الرجاء تعديل وحدة الصنف ثم حاول مرة اخرة');
                //$(".start_item_card_id").html('<smal style="color: red;">*</small>');
            },
        });
    } else {
        $(".DivUom_").html('');
        $("#TdDivUom_").hide();
    }
}

function _get_itemcard_batches() {
    var item_card_id = $("#item_card_id_ option:selected").val();
    var uom_id = $("#uom_id_ option:selected").val();
    var store_id = $("#store_id_ option:selected").val();
    var token = $("#token").val();
    var get_item_card_batches_url = $("#get_item_card_batches_url_").val();
    //alert(uom_id);
    if (item_card_id != "" && uom_id != "" && store_id != "") {
        jQuery.ajax({
            url: get_item_card_batches_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                item_card_id: item_card_id,
                uom_id: uom_id,
                store_id: store_id,
                "_token": token,
            },
            success: function(data) {
                $(".DivBatche_").html(data);
                $("#TdDivBatche_").show();
                var itemcard_batche = $("#itemcard_batche_ option:selected").val();
                if (itemcard_batche != '') {
                    $(".start_itemcard_batche_").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
                } else {
                    $(".start_itemcard_batche_").html('<smal style="color: red);">*</small>');
                }
            },
            error: function() {
                $(".DivBatche_").html('');
                $("#TdDivBatche_").hide();
                toastr.error('حدث خطاء ربما تم حذف وحدة الصنف المختار الرجاء تعديل وحدة الصنف ثم حاول مرة اخرة');
            },
        });

    } else {
        $(".DivBatche_").html('');
        $("#TdDivBatche_").hide();
    }
}

function _get_unit_cost_price() {
    var item_card_id = $("#item_card_id_ option:selected").val();
    var uom_id = $("#uom_id_ option:selected").val();
    var sales_type = $("#sales_type_ option:selected").val();
    var token = $("#token").val();
    var get_unit_cost_price_url = $("#get_unit_cost_price_url_").val();
    jQuery.ajax({
        url: get_unit_cost_price_url,
        type: 'post',
        dataType: 'json',
        cache: false,
        data: {
            item_card_id: item_card_id,
            uom_id: uom_id,
            sales_type: sales_type,
            "_token": token,
        },
        success: function(data) {
            $("#unit_cost_price_").val(data * 1);
            _recalculate_item_total();
            var unit_cost_price = $("#unit_cost_price_").val();
            if (unit_cost_price != '' && unit_cost_price != 0) {
                $(".start_unit_cost_price_").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
            } else {
                $(".start_unit_cost_price_").html('<smal style="color: red);">*</small>');
            }
        },
        error: function() {
            $("#unit_cost_price_").val("");
            toastr.error('حدث خطاء حاول مرة اخرة');
        },
    });
}

function _recalculate_item_total() {
    var quentity = $("#quentity_").val();
    if (quentity == "") {
        quentity = 0;
    }
    var unit_cost_price = $("#unit_cost_price_").val();
    if (unit_cost_price == "") {
        unit_cost_price = 0;
    }
    $("#total_price_").val((parseFloat(quentity) * parseFloat(unit_cost_price) * 1));
}

function _recalcualte() {
    var total_cost_items = 0;
    $(".total_cost_items_array_").each(function() {
        total_cost_items += parseFloat($(this).val());
    });
    $("#total_cost_items_").val(parseFloat(total_cost_items));

    var tax_percent = $("#tax_percent_").val();
    if (tax_percent == "") {
        tax_percent = 0;
    }
    tax_percent = parseFloat(tax_percent);

    var tax_value = total_cost_items * tax_percent / 100;
    tax_value = parseFloat(tax_value);
    $("#tax_value_").val(tax_value * 1);

    var total_befor_discount = total_cost_items + tax_value;
    total_befor_discount = parseFloat(total_befor_discount);
    $("#total_befor_discount_").val(total_befor_discount);

    var discount_type = $("#discount_type_").val();
    if (discount_type != "") {
        if (discount_type == 1) {
            var discount_percent = $("#discount_percent_").val();
            if (discount_percent == "") {
                discount_percent = 0;
            }
            discount_percent = parseFloat(discount_percent);
            var discount_value = total_befor_discount * discount_percent / 100;
            $("#discount_value_").val(discount_value * 1);
            var total_cost = total_befor_discount - discount_value;
            $("#total_cost_").val(total_cost * 1);
        } else {
            var discount_percent = $("#discount_percent_").val();
            if (discount_percent == "") {
                discount_percent = 0;
            }
            discount_percent = parseFloat(discount_percent);
            $("#discount_value_").val(discount_percent * 1);
            var total_cost = total_befor_discount - discount_percent;
            $("#total_cost_").val(total_cost * 1);
        }
    } else {
        var total_cost = total_befor_discount;
        $("#total_cost_").val(total_cost);
    }
    var pill_type = $("#pill_type_").val();
    if (pill_type == 1) {
        $("#what_paid_").val(total_cost * 1);
        $("#what_remain_").val(0);
        $("#what_paid_").attr("readonly", true);
    } else {
        $("#what_paid_").val(0);
        $("#what_remain_").val(total_cost * 1);
        $("#what_paid_").attr("readonly", false);
    }
}