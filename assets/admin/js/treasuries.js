$(document).ready(function () {
    //search
    $(document).on('input', '#search_by_text', function (e) {
        var search_by_text = $(this).val();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_search_url").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: { search_by_text: search_by_text, "_token": token_search },
            success: function (data) {
                $("#ajax_responce_searchDiv").html(data);
            },
            error: function () {

            },
        });
    });
    //pagination
    $(document).on('click', '#ajax_pagination_in_search a', function (e) {
        e.preventDefault();
        var search_by_text = $("#search_by_text").val();
        var pagination_url = $(this).attr("href");
        var token_search = $("#token_search").val();
        jQuery.ajax({
            url: pagination_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: { search_by_text: search_by_text, "_token": token_search },
            success: function (data) {
                $("#ajax_responce_searchDiv").html(data);
            },
            error: function () {
            },
        });
    });
});
