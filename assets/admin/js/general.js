$(document).ready(function () {
    $(document).on('click', '#update_image', function (e) {
        e.preventDefault();
        //if (!$("#photo").length) {
        $("#old_image").show();
        $("#update_image").hide();
        $("#cancel_update_image").show();
        //}
        return false;
    });
    $(document).on('click', '#cancel_update_image', function (e) {
        e.preventDefault();
        $("#old_image").hide();
        $("#update_image").show();
        $("#cancel_update_image").hide();
        return false;
    });
    $(document).on('click', '.are_you_shue', function (e) {
        var res = confirm("هل انت متاكد ؟");
        if (!res) {
            return false;
        }
    });
});
