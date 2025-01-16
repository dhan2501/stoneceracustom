jQuery(document).ready(function($) {
    // Trigger AJAX search on form submission
    $('#woocommerce-ajax-search-form').submit(function(e) {
        e.preventDefault();

        var searchInput = $('#search-input').val();

        $.ajax({
            url: ajax_search_params.ajax_url,
            type: 'POST',
            data: {
                action: 'woocommerce_ajax_product_search',
                nonce: ajax_search_params.nonce,
                search_input: searchInput
            },
            success: function(response) {
                $('#ajax-search-results').html(response);
            }
        });
    });
});
