$(document).ready(function () {

    $(document).on('input', '#search_by_text', function (e) {
        make_search();
    });

    $(document).on('change', '#supplier_category_id', function (e) {
        make_search();
    });
    $('input[type=radio][name=r3]',).change(function (e) {
        make_search();
    });

    function make_search() {
        var search_by_text = $("#search_by_text").val();
        var supplier_category_id = $("#supplier_category_id").val();
        var search_by_radio = $("input[type=radio][name=r3]:checked").val();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_search_url").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                search_by_text: search_by_text,
                supplier_category_id: supplier_category_id,
                search_by_radio: search_by_radio,
                "_token": token_search
            },
            success: function (data) {
                $("#ajax_responce_searchDiv").html(data);
            },
            error: function () {

            },
        });
    }


    //pagination
    $(document).on('click', '#ajax_pagination_in_search a', function (e) {
        e.preventDefault();
        var search_by_text = $("#search_by_text").val();
        var supplier_category_id = $("#supplier_category_id").val();
        var search_by_radio = $("input[type=radio][name=r3]:checked").val();
        var token_search = $("#token_search").val();
        var pagination_url = $(this).attr("href");
        jQuery.ajax({
            url: pagination_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                search_by_text: search_by_text,
                supplier_category_id: supplier_category_id,
                search_by_radio: search_by_radio,
                "_token": token_search
            },
            success: function (data) {
                $("#ajax_responce_searchDiv").html(data);
            },
            error: function () {
            },
        });
    });
});
