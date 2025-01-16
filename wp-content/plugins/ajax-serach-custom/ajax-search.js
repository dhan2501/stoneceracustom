jQuery(function($) {
    // Trigger search when the user types in the search field
    $('#wcas-search-input').on('keyup', function() {
        var query = $(this).val();

        if (query.length >= 3) { // Only trigger search if 3 or more characters
            $.ajax({
                url: wcas_params.wcas_ajax_url,
                method: 'POST',
                data: {
                    action: 'wcas_search',
                    nonce: wcas_params.wcas_nonce,
                    query: query,
                },
                success: function(response) {
                    $('#wcas-search-results').html(response);
                }
            });
        } else {
            $('#wcas-search-results').html('');
        }
    });
});
