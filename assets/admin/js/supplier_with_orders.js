$(document).ready(function () {
    //get item cards
    $(document).on('change', '#item_card_id', function (e) {
        var item_card_id = $("#item_card_id :selected").val();
        var type = $("#item_card_id :selected").data('type');
        if (item_card_id != '') {
            if (type == 2) {
                $(".ex_date").show();
                $(".pro_date").show();
                $(".start_item_card_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
            } else {
                $(".ex_date").hide();
                $(".pro_date").hide();
                $(".start_item_card_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
            }
            var token = $("#token").val();
            var ajax_get_uom_url = $("#ajax_get_uom_url").val();
            jQuery.ajax({
                url: ajax_get_uom_url,
                type: 'post',
                dataType: 'html',
                cache: false,
                data: {
                    item_card_id: item_card_id,
                    "_token": token
                },
                success: function (data) {
                    $(".DivUom").html(data);
                    $(".uom_price").show();
                },
                error: function () {
                    $(".DivUom").html('');
                    $(".ex_date").hide();
                    $(".pro_date").hide();
                    $(".uom_price").hide();
                    toastr.error('حدث خطاء ربما تم حذف وحدة الصنف المختار الرجاء تعديل وحدة الصنف ثم حاول مرة اخرة');
                    $(".start_item_card_id").html('<smal style="color: red;">*</small>');
                },
            });
        } else {
            $(".DivUom").html('');
            $(".ex_date").hide();
            $(".pro_date").hide();
            $(".uom_price").hide();
            $(".start_item_card_id").html('<smal style="color: red;">*</small>');
        }
    });

    // get total price
    function get_total_price() {
        var quantity = $("#quantity").val();
        var price = $("#price").val();
        if (quantity == '') { quantity = 0; };
        if (price == '') { price = 0; };
        $("#total").val(parseFloat(quantity * parseFloat(price)));
        var total = $("#total").val();
        if (total <= 0 || total == '') {
            $(".start_total").html('<smal style="color: red);">*</small>');
        } else {
            $(".start_total").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        }
    }
    //ajax add uom
    function ajax_add_uom() {
        var supplier_with_order_id = $("#supplier_with_order_id").val();
        var item_card_id = $("#item_card_id :selected").val();
        var item_type = $("#item_card_id :selected").data('type');
        var is_parent_uom = $("#uom_id :selected").data('is_parent');
        var quantity = $("#quantity").val();
        var price = $("#price").val();
        var total = $("#total").val();
        var uom_id = $("#uom_id :selected").val();
        var pro_date = $("#pro_date").val();
        var ex_date = $("#ex_date").val();
        var ajax_add_uom_url = $("#ajax_add_uom_url").val();
        var token = $("#token").val();
        jQuery.ajax({
            url: ajax_add_uom_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                supplier_with_order_id: supplier_with_order_id,
                is_parent_uom: is_parent_uom,
                item_type: item_type,
                quantity: quantity,
                price: price,
                total: total,
                uom_id: uom_id,
                pro_date: pro_date,
                ex_date: ex_date,
                item_card_id: item_card_id,
                "_token": token
            },
            success: function (data) {
                toastr.success('تم اضافة الصنف الى الفاتورة بنجاح');
                $("#loade_page").html(data);
            },
            error: function () {
                toastr.error('حدث خطاء غير معروف');
            },
        });
    }
    //delete item card 
    $(document).on('click', '#delete_item_card', function (e) {
        var is_approved = $("#supplier_with_order_is_approved").val();
        if (is_approved == 1) {
            toastr.error('عفوا لا يمكن حذف تفاصيل فاتورة معتمدة');
            return false;
        }
        var delete_item_card_url = $("#delete_item_card_url").val();
        var supplier_with_order_id = $("#supplier_with_order_id").val();
        var id = $(this).val();
        var token = $("#token").val();
        jQuery.ajax({
            url: delete_item_card_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                supplier_with_order_id: supplier_with_order_id,
                id: id,
                "_token": token
            },
            success: function (data, status, msg) {
                //alert(msg);
                //if (msg == 0) {
                //   toastr.error(msg.msg);
                //   return false;
                //} else {
                $("#loade_page").html(data);
                toastr.success('تم حذف الصنف من الفاتورة بنجاح');
                //}
            },
            error: function () {
                toastr.error('حدث خطاء غير معروف');
            },
        });
    });

    //validation
    $(document).on('change', '#uom_id', function (e) {
        var name = $("#uom_id :selected").val();
        if (name != '') {
            $(".start_uom_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        } else {
            $(".start_uom_id").html('<smal style="color: red);">*</small>');
        }
    });
    $(document).on('input', '#quantity', function (e) {
        var name = $("#quantity").val();
        if (name != '' && name != 0) {
            $(".start_quantity").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        } else {
            $(".start_quantity").html('<smal style="color: red);">*</small>');
        }
        //get total price function
        get_total_price();
    });
    $(document).on('input', '#price', function (e) {
        var name = $("#price").val();
        if (name != '' && name != 0) {
            $(".start_price").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        } else {
            $(".start_price").html('<smal style="color: red);">*</small>');
        }
        //get total price function
        get_total_price();
    });
    $(document).on('input', '#pro_date', function (e) {
        var name = $("#pro_date").val();
        if (name != '' && name != 0) {
            $(".start_pro_date").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        } else {
            $(".start_pro_date").html('<smal style="color: red);">*</small>');
        }
    });
    $(document).on('input', '#ex_date', function (e) {
        var name = $("#ex_date").val();
        if (name != '' && name != 0) {
            var pro_date = $("#pro_date").val();
            if (name < pro_date) {
                $(".start_ex_date").html('<smal style="color: red);">*</small>');
                return false;
            }
            $(".start_ex_date").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        } else {
            $(".start_ex_date").html('<smal style="color: red);">*</small>');
        }
    });
    $(document).on('click', '#add_item_card', function (e) {
        //item  card
        var name = $("#item_card_id").val();
        if (name == '') {
            $(".start_item_card_id").html('<smal style="color: red);">*</small>');
            toastr.error('من فضلك اختر الصنف');
            //var name = $("#item_card_id").focus();
            return false;
        } else {
            $(".start_item_card_id").text('');
            $(".start_item_card_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        }
        //quantity
        var name = $("#quantity").val();
        if (name == '' || name == 0) {
            $(".start_quantity").html('<smal style="color: red);">*</small>');
            toastr.error('من فضلك ادخل كمية الصنف المستلمة');
            return false;
        } else {
            $(".start_quantity").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        }
        //pro date ex date
        var type = $("#item_card_id :selected").data('type');
        if (type == 2) {
            var name = $("#pro_date").val();
            if (name == '') {
                $(".start_pro_date").html('<smal style="color: red);">*</small>');
                toastr.error('من فضلك ادخل تاريخ انتاج الصنف');
                return false;
            } else {
                $(".start_pro_date").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
            }
            var name = $("#ex_date").val();
            var pro_date = $("#pro_date").val();
            if (name < pro_date) {
                $(".start_ex_date").html('<smal style="color: red);">*</small>');
                toastr.error('من فضلك يجب ان يكون تاريخ الانتاج اقل من تاريخ الانتهاء');
                return false;
            }
            if (name == '') {
                $(".start_ex_date").html('<smal style="color: red);">*</small>');
                toastr.error('من فضلك ادخل تاريخ انتهاء الصنف');
                return false;
            } else {
                $(".start_ex_date").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
            }
        }
        //uom
        var name = $("#uom_id").val();
        if (name == '') {
            $(".start_uom_id").html('<smal style="color: red);">*</small>');
            toastr.error('من فضلك اختر وحدة الصنف');
            return false;
        } else {
            $(".start_uom_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        }
        //price
        var name = $("#price").val();
        if (name == '' || name == 0) {
            $(".start_price").html('<smal style="color: red);">*</small>');
            toastr.error('من فضلك ادخل سعر الوحدة');
            return false;
        } else {
            $(".start_price").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        }
        //total
        var name = $("#total").val();
        if (name == '' || name == 0) {
            $(".start_total").html('<smal style="color: red);">*</small>');
            toastr.error('من فضلك ادخل اجمالي سعر الصنف');
            return false;
        } else {
            //ajax add uom function
            ajax_add_uom();
            return false;
        }
    });
    $(document).on('click', '#do_close_approve_invoice', function (e) {
        var is_approved = $("#supplier_with_order_is_approved").val();
        if (is_approved == 1) {
            toastr.error('عفوا لا يمكن اعتماد فاتورة معتمدة');
            return false;
        }
        var delete_item_card_url = $("#approve_invoice").val();
        var id = $("#supplier_with_order_id").val();
        var token = $("#token").val();
        jQuery.ajax({
            url: delete_item_card_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                id: id,
                "_token": token
            },
            success: function (data, status, msg) {
                $("#ModelApproveInvoice_body").html(data);
                //$("#ModelApproveInvoice").modal(data);
            },
            error: function () {
                toastr.error('حدث خطاء غير معروف');
            },
        });
    });
    $(document).on('input', '#tax_percent', function (e) {
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
    $(document).on('input', '#discount_percent', function (e) {
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
    $(document).on('change', '#discount_type', function (e) {
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
    $(document).on('change', '#pill_type', function (e) {
        recalcualte();
    });
    function recalcualte() {
        var total_cost_items = $("#total_cost_items").val();
        total_cost_items = parseFloat(total_cost_items);

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
    $(document).on('input', '#what_paid', function (e) {
        var total_cost = $("#total_cost").val();
        var what_paid = $(this).val();
        if (what_paid == "") {
            what_paid = 0;
        }
        if (parseFloat(what_paid) > parseFloat(total_cost)) {
            toastr.error('عفوا لا يمكن ان يكون المبلغ المدفوع اكبر من اجمالي الفاتورة');
            recalcualte();
            return false;
        }
        var what_remain = parseFloat(total_cost) - parseFloat(what_paid);
        if (what_paid == total_cost) {
            toastr.error('عفوا لا يمكن دفع كل المبلع لنوع الفاتورة الاجل');
            recalcualte();
            return false;
        }
        $("#what_remain").val(what_remain * 1);
    });
    $(document).on('mouseenter', '#approve_invoice_now', function (e) {
        var approve_invoice_now_url = $("#approve_invoice_now_url").val();
        var id = $("#supplier_with_order_id").val();
        var token = $("#token").val();
        jQuery.ajax({
            url: approve_invoice_now_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                id: id,
                "_token": token
            },
            success: function (data, status, msg) {
                $("#treasury_money").val(parseFloat(data) * 1);
            },
            error: function () {
                toastr.error('حدث خطاء غير معروف');
            },
        });
    });
    $(document).on('click', '#approve_invoice_now', function (e) {
        var total_cost_items = $("#total_cost_items").val();
        if (total_cost_items == '') {
            toastr.error('من فضلك ادخل قيمة اجمالي الاصناف');
            return false;
        }
        if (total_cost_items == 0) {
            toastr.error('من فضلك يجب اضافة اصناف الى الفاتورة');
            return false;
        }
        var tax_percent = $("#tax_percent").val();
        if (tax_percent == '') {
            toastr.error('من فضلك ادخل نسبة القيمة المضافة');
            return false;
        }
        var tax_value = $("#tax_value").val();
        if (tax_value == '') {
            toastr.error('من فضلك ادخل قيمة القيمة المضافة');
            return false;
        }
        var total_befor_discount = $("#total_befor_discount").val();
        if (total_befor_discount == '') {
            toastr.error('من فضلك ادخل قيمة الاجمالي قبل الخصم');
            return false;
        }
        var discount_type = $("#discount_type").val();
        if (discount_type == 1) {
            var discount_percent = $("#discount_percent").val();
            if (discount_percent > 100) {
                toastr.error('عفوا لا يمكن ان تكون نسبة الخصم اكبر من 100%');
                $("#discount_percent").val(0);
                $("#discount_value").val(0);
                $("#discount_percent").focus();
                return false;
            }
            if (discount_percent == 0) {
                toastr.error('الرجاء ادخال نسبة الخصم لنوع الخصم المأوي');
                $("#discount_percent").focus();
                return false;
            }
        } else if (discount_type == 2) {
            var total_befor_discount = $("#total_befor_discount").val();
            var discount_value = $("#discount_value").val();
            if (parseFloat(discount_value) > parseFloat(total_befor_discount)) {
                toastr.error('عفوا قيمة الخصم لا يجب ان تكون اكبر من القيمة الاجمالية');
                $("#discount_percent").val(0);
                $("#discount_value").val(0);
                $("#discount_percent").focus();
                return false;
            }
            if (discount_value == 0) {
                toastr.error('الرجاء ادخال نسبة الخصم لنوع الخصم اليدوي');
                $("#discount_percent").focus();
                return false;
            }
        } else {
            var discount_value = $("#discount_value").val();
            if (discount_value > 0) {
                toastr.error('عفوا يجب اختيار نوع الخصم اولا');
                return false;
            }
        }
        var total_cost = $("#total_cost").val();
        if (total_cost == '') {
            toastr.error('من فضلك ادخل قيمة الاجمالي بعد الخصم');
            return false;
        }
        var pill_type = $("#pill_type").val();
        if (pill_type == "") {
            toastr.error('اختر نوع الفاتورة');
            return false;
        } else if (pill_type == 2) {
            var what_paid = $("#what_paid").val();
            var total_cost = $("#total_cost").val();
            if (what_paid == "") {
                $("#what_paid").val(0);
            }
        }
        //else if(pill_type == 1) {
        //    var what_paid = $("#what_paid").val();
        //    var total_cost = $("#total_cost").val();
        //    if (what_paid == "" && what_paid <) {
        //        toastr.error('');
        //        return false;
        //    }
        // }else if(pill_type == 2) {
        //    var what_remain = $("#what_remain").val();
        //    var total_cost = $("#total_cost").val();
        //    if (what_remain == "" && what_remain > total_cost) {
        //        toastr.error('');
        //        return false;
        //    }
        // }
        var what_paid = parseFloat($("#what_paid").val());
        var treasury_money = parseFloat($("#treasury_money").val());
        if (what_paid > treasury_money) {
            toastr.error('عفوا رصيد الخزنة غير كافي');
            return false;
        }
    });
});