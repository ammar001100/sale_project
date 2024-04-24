$(document).ready(function () {
    $(document).on('change', '#uom_id', function (e) {
        var uom_id = $("#uom_id").val();
        if (uom_id == '') {
            $("#does_has_retailunit").val('');
            $(".relatied_retial_counter").hide();
            $(".relatied_parent_counter").hide();
            $(".relatied_price_retial_counter").hide();

        } else {
            var name = $("#uom_id option:selected").text();
            $(".parent_uom_name").text(name);
            $(".relatied_parent_counter").show();
        }
    });

    $(document).on('change', '#does_has_retailunit', function (e) {

        if ($(this).val() == 1) {
            $(".relatied_retial_counter").show();

        } else {
            $("#retail_uom_id").val('');
            $(".relatied_price_retial_counter").hide();
            $(".relatied_retial_counter").hide();
        }
    });

    $(document).on('change', '#retail_uom_id', function (e) {
        var retail_uom_id = $("#retail_uom_id").val();
        if (retail_uom_id == '') {
            $("#child_uom_name").val('');
            $(".relatied_price_retial_counter").hide();
        } else {
            var name = $("#retail_uom_id option:selected").text();
            $(".child_uom_name").text(name);
            $(".relatied_price_retial_counter").show();
        }
    });
    //validation
    $(document).on('click', '#do_add_item_card', function (e) {
        //barcode
        if ($("#barcode_edit").length > 0) {
            var name = $("#barcode_edit").val();
            if (name == '') {
                $(".start_barcode_edit").text('*');
                toastr.error('من فضلك ادخل باركود الصنف');
                return false;
            } else {
                $(".start_barcode_edit").text('');
            }
        }
        //name
        var name = $("#name").val();
        if (name == '') {
            $(".start_name").text('*');
            toastr.error('من فضلك ادخل اسم الصنف');
            return false;
        } else {
            $(".start_name").text('');
        }
        //item type
        var item_type = $("#item_type").val();
        if (item_type == '') {
            $(".start_item_type").text('*');
            toastr.error('من فضلك اختر نوع الصنف');
            return false;
        } else {
            $(".start_item_type").text('');
        }
        // item category
        var itemcard_category_id = $("#itemcard_category_id").val();
        if (itemcard_category_id == '') {
            $(".start_itemcard_category_id").text('*');
            toastr.error('من فضلك اختر فئة الصنف');
            return false;
        } else {
            $(".start_itemcard_category_id").text('');
        }
        //item card uom
        var name = $("#uom_id").val();
        if (name != '') {
            $(".start_uom_id").text('');
            //item card uom price
            var name = $("#price").val();
            if (name == '') {
                $(".start_price").text('*');
                toastr.error('من فضلك ادخل سعر القطاعي للوحدة الاب');
                return false;
            } else {
                $(".start_price").text('');
            }
            //item card uom nos gomal price
            var name = $("#nos_gomal_price").val();
            if (name == '') {
                $(".start_nos_gomal_price").text('*');
                toastr.error('من فضلك ادخل سعر نص جملة للوحدة الاب');
                return false;
            } else {
                $(".start_nos_gomal_price").text('');
            }
            //item card uom gomal price
            var name = $("#gomal_price").val();
            if (name == '') {
                $(".start_gomal_price").text('*');
                toastr.error('من فضلك ادخل سعر الجملة للوحدة الاب');
                return false;
            } else {
                $(".start_gomal_price").text('');
            }
            //item card uom cost price
            var name = $("#cost_price").val();
            if (name == '') {
                $(".start_cost_price").text('*');
                toastr.error('من فضلك ادخل سعر الشراء للوحدة الاب');
                return false;
            } else {
                $(".start_cost_price").text('');
            }
        } else {
            toastr.error('من فضلك اختر وحدة القياس الاب الصنف');
            $(".start_uom_id").text('*');
            return false;
        }
        //item card does has retailunit
        var name = $("#does_has_retailunit").val();
        if (name == '') {
            $(".start_does_has_retailunit").text('*');
            toastr.error('من فضلك حدد هل للصنف وحدة تجزئة');
            return false;
        } if (name == 1) {
            $(".start_does_has_retailunit").text('');
            //item card uom retail
            var name = $("#retail_uom_id").val();
            if (name != '') {
                $(".start_retail_uom_id").text('');
                //item card uom retail quntToparent
                var name = $("#retail_uom_quntToparent").val();
                if (name == '') {
                    $(".start_retail_uom_quntToparent").text('*');
                    toastr.error('من فضلك ادخل عدد وحدات التجزئة');
                    return false;
                } else {
                    $(".start_retail_uom_quntToparent").text('');
                }
                //item card uom retail price
                var name = $("#price_retail").val();
                if (name == '') {
                    $(".start_price_retail").text('*');
                    toastr.error('من فضلك ادخل سعر القطاعي لوحدة التجزئة');
                    return false;
                } else {
                    $(".start_price_retail").text('');
                }
                //item card uom retail nos gomal price
                var name = $("#nos_gomal_price_retail").val();
                if (name == '') {
                    $(".start_nos_gomal_price_retail").text('*');
                    toastr.error('من فضلك ادخل سعر نص جملة لوحدة التجزئة');
                    return false;
                } else {
                    $(".start_nos_gomal_price_retail").text('');
                }
                //item card uom retail gomal price
                var name = $("#gomal_price_retail").val();
                if (name == '') {
                    $(".start_gomal_price_retail").text('*');
                    toastr.error('من فضلك ادخل سعر جملة لوحدة التجزئة');
                    return false;
                } else {
                    $(".start_gomal_price_retail").text('');
                }
                //item card uom retail cost price
                var name = $("#cost_price_retail").val();
                if (name == '') {
                    $(".start_cost_price_retail").text('*');
                    toastr.error('من فضلك ادخل سعر الشراء لوحدة التجزئة');
                    return false;
                } else {
                    $(".start_cost_price_retail").text('');
                }
            } else {
                toastr.error('من فضلك اختر وحدة قياس التجزئة للصنف');
                $(".start_retail_uom_id").text('*');
                return false;
            }
        } else {
            $(".start_does_has_retailunit").text('');
        }
        //active
        var name = $("#active").val();
        if (name == '') {
            $(".start_active").text('*');
            toastr.error('من فضلك اختر حالة تفعيل الصنف');
            return false;
        } else {
            $(".start_active").text('');
        }
        //has fixced price
        var name = $("#has_fixced_price").val();
        if (name == '') {
            $(".start_has_fixced_price").text('*');
            toastr.error('من فضلك حدد هل للصنف سعر ثابت بالفواتير');
            return false;
        } else {
            $(".start_has_fixced_price").text('');
        }
    });
});
