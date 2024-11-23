$(document).ready(function() {
    $(document).on('input', '#invoice_date', function() {
        var invoice_date = $("#invoice_date").val();
        if (invoice_date != '') {
            $(".start_invoice_date").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        } else {
            $(".start_invoice_date").html('<smal style="color: red);">*</small>');
        }
    });
    $(document).on('change', '#is_has_customer', function() {
        var is_has_customer = $("#is_has_customer option:selected").val();
        if (is_has_customer == 2) {
            $("#customer_id").prop('disabled', true);
            $(".start_customer_id").html('<smal></small>');
        } else {
            $("#customer_id").prop('disabled', false);
            var customer_id = $("#customer_id :selected").val();
            if (customer_id != '') {
                $(".start_customer_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
            } else {
                $(".start_customer_id").html('<smal style="color: red);">*</small>');
            }
        }
    });
    $(document).on('change', '#customer_id', function() {
        var customer_id = $("#customer_id :selected").val();
        if (customer_id != '') {
            $(".start_customer_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        } else {
            $(".start_customer_id").html('<smal style="color: red);">*</small>');
        }
    });
    $(document).on('change', '#delegate_id', function() {
        var delegate_id = $("#delegate_id :selected").val();
        if (delegate_id != '') {
            $(".start_delegate_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        } else {
            $(".start_delegate_id").html('<smal style="color: red);">*</small>');
        }
    });
    $(document).on('change', '#sales_matrial_type_id', function() {
        var sales_matrial_type_id = $("#sales_matrial_type_id option:selected").val();
        if (sales_matrial_type_id != '') {
            $(".start_sales_matrial_type_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        } else {
            $(".start_sales_matrial_type_id").html('<smal style="color: red);">*</small>');
        }
    });
    $(document).on('change', '#item_card_id', function() {
        //get item cards
        get_uom();
        var item_card_id = $("#item_card_id :selected").val();
        if (item_card_id != '') {
            $(".start_item_card_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        } else {
            $(".start_item_card_id").html('<smal style="color: red);">*</small>');
        }
    });
    $(document).on('change', '#store_id', function() {
        //get item cards
        get_uom();
        var store_id = $("#store_id :selected").val();
        if (store_id != '') {
            $(".start_store_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        } else {
            $(".start_store_id").html('<smal style="color: red);">*</small>');
        }
    });
    $(document).on('change', '#uom_id', function() {
        get_itemcard_batches();
        get_unit_cost_price();
    });
    $(document).on('change', '#sales_type', function() {
        get_unit_cost_price();
    });
    $(document).on('input', '#unit_cost_price', function() {
        recalculate_item_total();
        var unit_cost_price = $("#unit_cost_price").val();
        if (unit_cost_price != '' && unit_cost_price != 0) {
            $(".start_unit_cost_price").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        } else {
            $(".start_unit_cost_price").html('<smal style="color: red);">*</small>');
        }
    });
    $(document).on('input', '#quentity', function() {
        recalculate_item_total();
        var batch_quentity_quantity = $("#itemcard_batche option:selected").data("quantity");
        var quentity = $("#quentity").val();
        if (quentity != '' && quentity != 0 && parseFloat(batch_quentity_quantity) >= quentity) {
            $(".start_quentity").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        } else {
            $(".start_quentity").html('<smal style="color: red);">*</small>');
        }
    });
    $(document).on('click', '.remove_item_row', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
        recalcualte();
    });
    $(document).on('change', '#itemcard_batche', function() {
        //itemcard_batche
        var batch_quentity_quantity = $("#itemcard_batche option:selected").data("quantity");
        if (parseFloat(batch_quentity_quantity) === 0) {
            $(".start_itemcard_batche").text('*');
        } else {
            $(".start_itemcard_batche").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
            $(".start_quentity").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        }
    });
    // $(document).on('mouseenter', '#AddItemToInvoiceDetailsAdd', function(e) {
    //    get_itemcard_batches();
    //});
    //validation
    $(document).on('click', '#AddItemToInvoiceDetailsAdd', function(e) {
        e.preventDefault();
        //invoice date
        var invoice_date = $("#invoice_date").val();
        if (invoice_date == '') {
            $(".start_invoice_date").text('*');
            toastr.error('من فضلك ادخل تاريخ الفاتورة');
            return false;
        }
        //is has customer 
        var is_has_customer = $("#is_has_customer option:selected").val();
        if (is_has_customer == 1) {
            //customer
            var customer_id = $("#customer_id option:selected").val();
            if (customer_id == '') {
                $(".start_customer_id").text('*');
                toastr.error('من فضلك اخنر العميل');
                return false;
            }
        }
        //delegate
        var delegate_id = $("#delegate_id option:selected").val();
        if (delegate_id == '') {
            $(".start_delegate_id").text('*');
            toastr.error('من فضلك اختر المندوب');
            return false;
        }
        //sales_matrial_type
        var sales_matrial_type_id = $("#sales_matrial_type_id option:selected").val();
        if (sales_matrial_type_id == '') {
            $(".start_sales_matrial_type_id").text('*');
            toastr.error('من فضلك اختر فئة الفاتورة');
            return false;
        }
        //item_card
        var item_card_id = $("#item_card_id option:selected").val();
        if (item_card_id == '') {
            $(".start_item_card_id").text('*');
            toastr.error('من فضلك أختر الصنف');
            return false;
        }
        //store
        var store_id = $("#store_id option:selected").val();
        if (store_id == '') {
            $(".start_store_id").text('*');
            toastr.error('من فضلك أختر المخزن');
            return false;
        }
        //uom
        var uom_id = $("#uom_id option:selected").val();
        if (uom_id == '') {
            $(".start_uom_id").text('*');
            toastr.error('من فضلك أختر وحدة البيع');
            return false;
        }
        //itemcard batches
        var itemcard_batche = $("#itemcard_batche :selected").val();
        if (itemcard_batche == '') {
            $(".start_itemcard_batche").text('*');
            toastr.error('عفوا لا توجد كميات بالمخزن');
            return false;
        }
        //is bounce or other
        var is_bounce_or_other = $("#is_bounce_or_other :selected").val();
        if (is_bounce_or_other == '') {
            $(".start_is_bounce_or_other").text('*');
            toastr.error('من فضلك أختر حالة البيع');
            return false;
        }
        //unit cost price
        var unit_cost_price = $("#unit_cost_price").val();
        if (unit_cost_price == '' || unit_cost_price <= 0) {
            $(".start_unit_cost_price").text('*');
            toastr.error('من فضلك ادخل سعر الصنف');
            return false;
        }
        //sales matrial type
        var sales_type = $("#sales_type option:selected").val();
        if (sales_type == '') {
            $(".start_sales_type").text('*');
            toastr.error('من فضلك أختر نوع البيع');
            return false;
        }
        //quentity
        var quentity = $("#quentity").val();
        if (quentity == '' || quentity <= 0) {
            $(".start_quentity").text('*');
            toastr.error('من فضلك ادخل كمية الصنف');
            return false;
        }
        var batch_quentity = $("#itemcard_batche option:selected").data("quantity");
        if (parseFloat(quentity) > parseFloat(batch_quentity)) {
            $(".start_quentity").text('*');
            //$(".start_itemcard_batche").text('*');
            toastr.error('عفوا الكمية المطلوبة اكبر من الكمية الموجودة بالمخزن');
            return false;
        } else {
            $(".start_quentity").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
            //$(".start_itemcard_batche").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        }
        var item_card_id_find = 0;
        $(".item_card_id_array").each(function() {
            if (item_card_id === $(this).val()) {
                item_card_id_find = 1;
                return false;
            }
        });
        if (item_card_id_find === 1) {
            $(".start_item_card_id").text('*');
            toastr.error('عفوا الصنف موجود بالفعل');
            return false;
        }
        //save row
        $("#overlady").fadeIn();
        var item_card_id = $("#item_card_id :selected").val();
        var item_card_name = $("#item_card_id option:selected").text();
        var store_name = $("#store_id option:selected").text();
        var uom_name = $("#uom_id option:selected").text();
        var sales_type_name = $("#sales_type option:selected").text();
        var is_bounce_or_other_name = $("#is_bounce_or_other option:selected").text();
        var is_parent_uom = $("#uom_id option:selected").data("is_parent");
        var total_price = $("#total_price").val();
        var index = $(".item_card_id_array").length;
        var token = $("#token").val();
        var get_new_item_row_url = $("#get_new_item_row_url").val();
        jQuery.ajax({
            url: get_new_item_row_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                invoice_date: invoice_date,
                customer_id: customer_id,
                delegate_id: delegate_id,
                item_card_name: item_card_name,
                store_name: store_name,
                uom_name: uom_name,
                sales_type_name: sales_type_name,
                is_bounce_or_other_name: is_bounce_or_other_name,
                is_parent_uom: is_parent_uom,
                item_card_id: item_card_id,
                store_id: store_id,
                sales_type: sales_type,
                uom_id: uom_id,
                itemcard_batche: itemcard_batche,
                quentity: quentity,
                unit_cost_price: unit_cost_price,
                sales_type: sales_type,
                is_bounce_or_other: is_bounce_or_other,
                total_price: total_price,
                index: index,
                "_token": token
            },
            success: function(data) {
                $("#itemRow").append(data);
                recalcualte();
                $("#save_sale_invoice_add").show();
                $("#overlady").fadeOut();
                toastr.success('تم اضافة الصنف الى الفاتورة');
            },
            error: function() {
                toastr.error('حدث خطاء ما الرجاء المحاولة لاحقا');
            },
        });
    });
    $(document).on('input', '#tax_percent', function(e) {
        var tax_percent = $("#tax_percent").val();
        if (tax_percent == 0) {
            tax_percent = 0;
        }
        if (tax_percent > 100) {
            toastr.error('عفوا لا يمكن ان تكون نسبة الضريبة اكبر من 100%');
            $("#tax_percent").val(0);
        }
        recalcualte();
    });
    $(document).on('input', '#discount_percent', function(e) {
        var discount_percent = parseFloat($("#discount_percent").val());
        var discount_value = parseFloat($("#discount_value").val());
        var discount_type = $("#discount_type").val();
        var total_befor_discount = parseFloat($("#total_befor_discount").val());
        if (discount_percent == 0) {
            discount_percent = 0;
        }
        if (discount_type == 1) {
            if (discount_percent > 100) {
                toastr.error('عفوا لا يمكن ان تكون نسبة الخصم اكبر من 100%');
                $("#discount_percent").val(0);
                $("#discount_value").val(0);
                return false;
            }
        } else if (discount_type == 2) {
            if (parseFloat(discount_value) >= parseFloat(total_befor_discount)) {
                toastr.error('عفوا قيمة الخصم لا يجب ان تكون اكبر من القيمة الاجمالية');
                $("#discount_percent").val(0);
                $("#discount_value").val(0);
                return false;
            }
        }
        recalcualte();
    });
    $(document).on('change', '#discount_type', function(e) {
        var discount_type = $("#discount_type").val();
        if (discount_type != "") {
            $("#discount_percent").attr("readonly", false);
            $("#discount_percent").val(0);
            $("#discount_value").val(0);
        } else {
            $("#discount_percent").attr("readonly", true);
            $("#discount_percent").val(0);
            $("#discount_value").val(0);
        }
        recalcualte();
    });
    $(document).on('change', '#pill_type', function(e) {
        recalcualte();
    });
    $(document).on('input', '#what_paid', function(e) {
        var total_cost = $("#total_cost").val();
        var what_paid = $(this).val();
        if (what_paid == "") {
            what_paid = 0;
        }
        if (parseFloat(what_paid) > parseFloat(total_cost)) {
            toastr.error('عفوا لا يمكن ان يكون المبلغ المحصل اكبر من اجمالي الفاتورة');
            recalcualte();
            return false;
        }
        var what_remain = parseFloat(total_cost) - parseFloat(what_paid);
        if (what_paid == total_cost) {
            toastr.error('عفوا لا يمكن تحصيل كل المبلع لنوع الفاتورة الاجل');
            recalcualte();
            return false;
        }
        $("#what_remain").val(what_remain * 1);
    });
    $(document).on('mouseenter', '#save_sale_invoice_add', function(e) {
        var approve_invoice_now_url = $("#approve_invoice_now_url").val();
        var token = $("#token").val();
        jQuery.ajax({
            url: approve_invoice_now_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token
            },
            success: function(data, status, msg) {
                $("#treasury_money").val(parseFloat(data) * 1);
            },
            error: function() {
                toastr.error('حدث خطاء غير معروف');
            },
        });
    });
    //$(document).on('click', '#save_sale_invoice_add', function(e) {
    //e.preventDefault();
    //store
    //var invoice_date = $("#invoice_date").val();
    //var customer_id = $("#customer_id option:selected").val();
    //var delegate_id = $("#delegate_id option:selected").val();
    //var sales_matrial_type_id = $("#sales_matrial_type_id option:selected").val();
    //var is_has_customer = $("#is_has_customer option:selected").val();
    //var pill_type = $("#pill_type option:selected").val();
    //var item_card_id_array = $(".item_card_id_array").val();
    //
    //var item_card_id_array = '';
    //$(".item_card_id_array").each(function() {
    //    item_card_id_array + $(this).val();
    //});
    //
    //var token = $("#token").val();
    //var store_url = $("#store_url").val();
    //jQuery.ajax({
    //url: store_url,
    //type: 'post',
    //dataType: 'html',
    //cache: false,
    //data: {
    //invoice_date: invoice_date,
    //customer_id: customer_id,
    //delegate_id: delegate_id,
    //sales_matrial_type_id: sales_matrial_type_id,
    //is_has_customer: is_has_customer,
    //pill_type: pill_type,
    //item_card_id_array: item_card_id_array,
    //"_token": token
    //},
    //success: function(data) {
    //toastr.success('تم الحفظ بنجاح');
    //alert(data);
    //},
    //error: function() {
    //toastr.error('حدث خطاء ما الرجاء المحاولة لاحقا');
    //},
    //});
    //});

});

function get_uom() {
    //var item_type = $("#item_card_id").children("option:selected").data("item_type");
    $("#overlady").fadeIn();
    var item_card_id = $("#item_card_id :selected").val();
    var token = $("#token").val();
    var ajax_get_uom_url = $("#ajax_get_uom_url").val();
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
                $(".DivUom").html(data);
                $("#TdDivUom").show();
                $("#TdStoreId").show();
                get_itemcard_batches();
                get_unit_cost_price();
                $("#overlady").fadeOut();
            },
            error: function() {
                $(".DivUom").html('');
                $("#TdDivUom").hide();
                toastr.error('حدث خطاء ربما تم حذف وحدة الصنف المختار الرجاء تعديل وحدة الصنف ثم حاول مرة اخرة');
                //$(".start_item_card_id").html('<smal style="color: red;">*</small>');
            },
        });
    } else {
        $(".DivUom").html('');
        $("#TdDivUom").hide();
        $("#overlady").fadeOut();
        //$(".start_item_card_id").html('<smal style="color: red;">*</small>');
    }
}

function get_itemcard_batches() {
    $("#overlady").fadeIn();
    var item_card_id = $("#item_card_id :selected").val();
    var uom_id = $("#uom_id :selected").val();
    var store_id = $("#store_id :selected").val();
    var token = $("#token").val();
    var get_item_card_batches_url = $("#get_item_card_batches_url").val();
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
                $(".DivBatche").html(data);
                $("#TdDivBatche").show();
                var itemcard_batche = $("#itemcard_batche option:selected").val();
                var batch_quentity_quantity = $("#itemcard_batche option:selected").data("quantity");
                if (parseFloat(batch_quentity_quantity) === 0 || itemcard_batche === "") {
                    $(".start_itemcard_batche").text('*');
                } else {
                    $(".start_itemcard_batche").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
                }
                $("#overlady").fadeOut();
            },
            error: function() {
                $(".DivBatche").html('');
                $("#TdDivBatche").hide();
                toastr.error('حدث خطاء ربما تم حذف وحدة الصنف المختار الرجاء تعديل وحدة الصنف ثم حاول مرة اخرة');
                //$(".start_item_card_id").html('<smal style="color: red;">*</small>');
            },
        });

    } else {
        $(".DivBatche").html('');
        $("#TdDivBatche").hide();
        $("#overlady").fadeOut();
    }
}

function get_unit_cost_price() {
    $("#overlady").fadeIn();
    var item_card_id = $("#item_card_id :selected").val();
    var uom_id = $("#uom_id :selected").val();
    var sales_type = $("#sales_type :selected").val();
    var token = $("#token").val();
    var get_unit_cost_price_url = $("#get_unit_cost_price_url").val();
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
            $("#unit_cost_price").val(data * 1);
            recalculate_item_total();
            var unit_cost_price = $("#unit_cost_price").val();
            if (unit_cost_price != '' && unit_cost_price != 0) {
                $(".start_unit_cost_price").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
            } else {
                $(".start_unit_cost_price").html('<smal style="color: red);">*</small>');
            }
            $("#overlady").fadeOut();
        },
        error: function() {
            $("#unit_cost_price").val("");
            toastr.error('حدث خطاء حاول مرة اخرة');
        },
    });
}

function recalculate_item_total() {
    var quentity = $("#quentity").val();
    if (quentity == "") {
        quentity = 0;
    }
    var unit_cost_price = $("#unit_cost_price").val();
    if (unit_cost_price == "") {
        unit_cost_price = 0;
    }
    $("#total_price").val((parseFloat(quentity) * parseFloat(unit_cost_price) * 1));
}

function recalcualte() {
    var total_cost_items = 0;
    $(".total_cost_items_array").each(function() {
        total_cost_items += parseFloat($(this).val());
    });
    $("#total_cost_items").val(parseFloat(total_cost_items));

    var tax_percent = $("#tax_percent").val();
    if (tax_percent == "") {
        tax_percent = 0;
    }
    tax_percent = parseFloat(tax_percent);

    var tax_value = total_cost_items * tax_percent / 100;
    tax_value = parseFloat(tax_value);
    $("#tax_value").val(tax_value * 1);

    var total_befor_discount = total_cost_items + tax_value;
    total_befor_discount = parseFloat(total_befor_discount);
    $("#total_befor_discount").val(total_befor_discount);

    var discount_type = $("#discount_type").val();
    if (discount_type != "") {
        if (discount_type == 1) {
            var discount_percent = $("#discount_percent").val();
            if (discount_percent == "") {
                discount_percent = 0;
            }
            discount_percent = parseFloat(discount_percent);
            var discount_value = total_befor_discount * discount_percent / 100;
            $("#discount_value").val(discount_value * 1);
            var total_cost = total_befor_discount - discount_value;
            $("#total_cost").val(total_cost * 1);
        } else {
            var discount_percent = $("#discount_percent").val();
            if (discount_percent == "") {
                discount_percent = 0;
            }
            discount_percent = parseFloat(discount_percent);
            $("#discount_value").val(discount_percent * 1);
            var total_cost = total_befor_discount - discount_percent;
            $("#total_cost").val(total_cost * 1);
        }
    } else {
        var total_cost = total_befor_discount;
        $("#total_cost").val(total_cost);
    }
    var pill_type = $("#pill_type").val();
    if (pill_type == 1) {
        $("#what_paid").val(total_cost * 1);
        $("#what_remain").val(0);
        $("#what_paid").attr("readonly", true);
    } else {
        $("#what_paid").val(0);
        $("#what_remain").val(total_cost * 1);
        $("#what_paid").attr("readonly", false);
    }
}