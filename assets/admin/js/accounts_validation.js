$(document).ready(function () {
    //validation
    $(document).on('click', '#do_add_accounts', function (e) {
        //name
        var name = $("#name").val();
        if (name == '') {
            $(".start_name").text('*');
            toastr.error('من فضلك ادخل اسم الحساب المالي');
            return false;
        } else {
            $(".start_name").text('');
        }
        //account type
        var account_type_id = $("#account_type_id").val();
        if (account_type_id == '') {
            $(".start_account_type").text('*');
            toastr.error('من فضلك اختر نوع الحساب المالي');
            return false;
        } else {
            $(".start_account_type").text('');
        }
        var page_name = $("#page_name").val();
        if (page_name != 'account_edit') {
            //start balance status
            var start_balance_status = $("#start_balance_status").val();
            if (start_balance_status == '') {
                $(".start_start_balance_status").text('*');
                toastr.error('من فضلك اختر حالة الرصيد اول مدة');
                return false;
            } else {
                $(".start_start_balance_status").text('');
            }
            //start balance
            var start_balance = $("#start_balance").val();
            var start_balance_status = $("#start_balance_status").val();
            if (start_balance == '' && start_balance_status != '3') {
                $(".start_start_balance").text('*');
                toastr.error('من فضلك ادخل رصيد اول مدة');
                return false;
            } else {
                $(".start_start_balance").text('');
            }
        }
        //is parent
        var name = $("#is_parent").val();
        if (name == '') {
            $(".start_is_parent").text('*');
            toastr.error('من فضلك حدد الحساب المالي رئيسي ام فرعي');
            return false;
        } if (name == 1) {
            $(".start_is_parent").text('');
            //parent account
            var name = $("#account_id").val();
            if (name == '') {
                $(".start_account").text('*');
                toastr.error('من فضلك اختر الحساب المالي الرئيسي');
                return false;
            } else {
                $(".start_account").text('*');
            }
        } else {
            $(".start_is_parent").text('');
        }
        //is archived
        var name = $("#is_archived").val();
        if (name == '') {
            $(".start_is_archived").text('*');
            toastr.error('من فضلك اختر حالة الأرشفة للحساب');
            return false;
        } else {
            $(".start_is_archived").text('');
        }
    });
});
