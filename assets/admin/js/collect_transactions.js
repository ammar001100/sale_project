$(document).ready(function () {
    //validation
    $(document).on('input', '#mov_date', function (e) {
        var name = $("#mov_date").val();
        if (name != '' && name != 0) {
            $(".start_mov_date").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        } else {
            $(".start_mov_date").html('<smal style="color: red);">*</small>');
        }
    });
    $(document).on('change', '#account_id', function (e) {
        var name = $("#account_id :selected").val();
        if (name != '') {
            $(".start_account_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
            var account_state = $("#account_id :selected").data('account_state');
            if (account_state == 3) {
                $("#account_state").val('متزن');
            }
            if (account_state == 2) {
                $("#account_state").val('مدين');
            }
            if (account_state == 1) {
                $("#account_state").val('دائن');
            }
        } else {
            $(".start_account_id").html('<smal style="color: red);">*</small>');
            $("#account_state").val('');
        }
    });
    $(document).on('input', '#money', function (e) {
        var name = $("#money").val();
        if (name != '' && name != 0) {
            $(".start_money").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        } else {
            $(".start_money").html('<smal style="color: red);">*</small>');
        }
    });
    $(document).on('change', '#mov_type_id', function (e) {
        var name = $("#mov_type_id :selected").val();
        if (name != '') {
            $(".start_mov_type_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        } else {
            $(".start_mov_type_id").html('<smal style="color: red);">*</small>');
        }
    });
    $(document).on('click', '#add_item_card', function (e) {
        //mov date
        var name = $("#mov_date").val();
        if (name == '') {
            $(".start_mov_date").html('<smal style="color: red);">*</small>');
            toastr.error('من فضلك ادخل تاريخ الحركة المالية');
            $("#mov_date").focus();
            return false;
        } else {
            $(".start_mov_date").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        }
        //account
        var name = $("#account_id").val();
        if (name == '') {
            $(".start_account_id").html('<smal style="color: red);">*</small>');
            toastr.error('من فضلك اختر الحساب المالي ');
            $("#account_id").focus();
            return false;
        } else {
            $(".start_account_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        }
        //money
        var name = $("#money").val();
        if (name == '') {
            $(".start_money").html('<smal style="color: red);">*</small>');
            toastr.error('من فضلك ادخل قيمة المبلغ المحصل');
            $("#money").focus();
            return false;
        } else {
            $(".start_money").text('');
            $(".start_money").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        }
        //mov type id
        var name = $("#mov_type_id").val();
        if (name == '') {
            $(".start_mov_type_id").html('<smal style="color: red);">*</small>');
            toastr.error('من فضلك اختر نوع الحركة المالية');
            $("#mov_type_id").focus();
            return false;
        } else {
            $(".start_mov_type_id").text('');
            $(".start_mov_type_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
        }
    });
    $(document).on('change', '#account_id', function (e) {
        var account_id = $(this).val();
        if (account_id == '') {
            $(".start_mov_type_id").html('<smal style="color: red);">*</small>');
            $("#mov_type_id").val("");
        } else {
            var account_type = $("#account_id option:selected").data("type");
            if (account_type == 2) {
                $(".start_mov_type_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
                $("#mov_type_id").val("11");
            } else if (account_type == 3) {
                $(".start_mov_type_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
                $("#mov_type_id").val("10");
            } else if (account_type == 6) {
                $(".start_mov_type_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
                $("#mov_type_id").val("13");
            } else {
                $(".start_mov_type_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
                $("#mov_type_id").val("9");
            }
        }
    });
    $(document).on('change', '#mov_type_id', function (e) {
        var account_id = $("#account_id").val();
        if (account_id == '') {
            toastr.error('من فضلك اختر الحساب المالي اولا');
            $(".start_mov_type_id").html('<smal style="color: red);">*</small>');
            $("#mov_type_id").val("");
            return false;
        }
        var account_type = $("#account_id option:selected").data("type");
        if (account_type == 2) {
            $(".start_mov_type_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
            $("#mov_type_id").val("11");
        } else if (account_type == 3) {
            $(".start_mov_type_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
            $("#mov_type_id").val("10");
        } else if (account_type == 6) {
            $(".start_mov_type_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
            $("#mov_type_id").val("13");
        } else {
            $(".start_mov_type_id").html('<smal style="color: green;"><span class="fa fa-check"></span></small>');
            $("#mov_type_id").val("9");
        }
    });
});