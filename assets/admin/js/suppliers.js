$(document).ready(function () {
    $(document).on('change', '#is_parent', function (e) {
        var is_parent = $("#is_parent").val();
        if (is_parent == '1') {
            $(".parentDiv").show();

        } else {
            $(".parentDiv").hide();
        }
    });
    $(document).on('change', '#start_balance_status', function (e) {
        var start_balance_status = $("#start_balance_status").val();
        if (start_balance_status == '3') {
            $(".start_balanceDiv1").hide();
            $(".start_balanceDiv2").show();
            $(".start_start_balance").text('');

        } else {
            $(".start_balanceDiv1").show();
            $(".start_balanceDiv2").hide();
            $(".start_start_balance").text('*');
        }
    });
});
