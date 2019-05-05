jQuery(function($) {
    $('#dummy-data').on('click', function () {
        /* Ajax */
        var data = {
            'action'        : 'max_import_map'
        };
        $.post(
            ajaxurl, data, function ( responsive ) {
                if( responsive.trim() == 'content_incorrect' ) {
                    alert('The content of backup map file is incorrect ');
                }
            });
    });
});