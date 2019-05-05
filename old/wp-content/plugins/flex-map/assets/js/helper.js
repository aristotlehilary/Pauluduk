/**
 * The helper file will handle all the process that don't relate with map process
 *
 * @since 1.0.1
 **/
function flx_extract_action( data ) {

    if( matches = data.match(/action\=(.[^&]+)/) ) {
        if( matches[1] ) {
            return matches[1];
        }
    }
    return data;
}
function flx_ajax_accession( options ) {
    var curAction = '';
    if( options['action'] !== undefined ){
        curAction = options['action'];
    } else if( options['data']  !== undefined && options['data'].indexOf("action") ) {
        curAction = flx_extract_action(options['data']);
    } else if( options['url']  !== undefined  && options['url'].indexOf("action") ){
        curAction = flx_extract_action(options['url']);
    } else {
        curAction = '';
    }
    curAction = curAction.trim();

    var arr_action = [
        'flx_save_map',
        'flx_load_styles_libs',
        'flx_load_my_styles',
        'flx_delete_mystyle',
        'flx_save2_mystyles',
        'flx_upload_marker_icon',
        'flx_delete_marker_icon',
        'flx_import_map',
        'flx_delete_map'
    ];

    if( arr_action.indexOf(curAction) !== false ) return true;

    return false;
}
/**
 * AJAX effect loading
 *
 * since 1.0.1
 */
function ajax_loading_icon() {
    jQuery(document).ready(function(){
        jQuery(document)
            .ajaxSend(function( event, xhr, options ) {
                if( flx_ajax_accession(options) === true )
                {
                    jQuery('.waiting-style-map').show();
                    jQuery('#save_map').attr('disabled', 'disabled');
                }
            })
            .ajaxComplete(function( event, xhr, options ) {
                if( flx_ajax_accession(options) === true )
                {
                    jQuery('.waiting-style-map').hide();
                    jQuery('#save_map').removeAttr('disabled');
                }
            });
    });
}

/* Lanching Ajax Effect Loading  */
ajax_loading_icon();