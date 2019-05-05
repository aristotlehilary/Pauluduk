<?php
function import(){
    ?>
    <div class="field-rows">
            <?php _e('Choose a option', 'flex-map'); ?>:
    </div>
    <div class="field-rows">
        <input type="radio" id="append" name="over-append" checked> <label for="append"> <?php _e('Append To Old Data', 'flex-map'); ?> </label><br clear="all">
    </div>
    <div class="field-rows">
        <input type="radio" id="override" name="over-append"> <label for="override"> <?php _e('Override To All Old Data ( This options may lost all current map post data )', 'flex-map'); ?></label>
    </div>
    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span><?php _e('Select files...', 'flex-map'); ?></span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files"  accept=".json">
    </span>
    <br>
    <br>
    <!-- The global progress bar -->
    <div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files" class="files"></div>
    <br>
<?php
}

/**
 * Handle ajax to import map data
 *@since 1.0.0
 */
function import_map_ajax() {
    if( isset($_POST['file_content']) && $_POST['file_content'] != '' )
    {
        if( $file_content =  json_decode(stripslashes($_POST['file_content']), true ) ) {
            $result = save_map_post($file_content);
            echo $result;
        } else {
            echo 'content_incorrect';
        }
    } else {
        echo 'file_content_exist';
    }
}
/**
 * Save map post
 */
function save_map_post( $file_content ) {
    $options = get_option('mymaps_options');
    /* Decode and redefine */
    try {
        $_HOST_             = $file_content['_host_'];
        $_MY_STYLES_        = (isset($file_content['_mystyles_']) && $file_content['_mystyles_'] != '' ) ? json_decode(rawurldecode($file_content['_mystyles_']), true) : '';
        $_MAP_POST_         = (isset($file_content['_map_posts_']) && $file_content['_map_posts_'] != '' ) ? json_decode(rawurldecode($file_content['_map_posts_']), true) : '';
        $_ICONS_            = (isset($file_content['_icons_']) && $file_content['_icons_'] != '' ) ? json_decode(rawurldecode($file_content['_icons_']), true) : '';
    } catch(Exception $e ) {
        echo 'content_incorrect'; exit();
    }

    /* check style */
    if( is_array($_MY_STYLES_) && count($_MY_STYLES_) > 0 )
    {
        foreach( $_MY_STYLES_  as $name => $value ) {
            if( !array_key_exists( $name, $options['_mystyles_'] ) )
            {
                $options['_mystyles_'][$name] = $value;
            }
        }
    }

    /* check icon */
    if( is_array($_ICONS_) && count($_ICONS_) > 0 )
    {
        foreach( $_ICONS_ as $value ) {
            if( !in_array( $value, $options['_icons_'] ) )
            {
                $options['_icons_'][] = $value;
            }
        }
    }
    /* check post */
    if( $_POST['append'] !== 'true' ) {
        $options['_map_posts_'] = array();
    }

    $cur_content_dir = (function_exists('content_url')) ? content_url() : plugins_url('.../.../',__FILE__);
    if( is_array($_MAP_POST_) && count($_MAP_POST_) > 0 )
    {
        foreach( $_MAP_POST_ as $value ) {
            try{
                $value['markers'] = str_replace($_HOST_, $cur_content_dir, $value['markers']);
            } catch( Exception $e ){
                return 'fail';
            }
            $options['_map_posts_'][] = $value;
        }
    }
    /* update */
    if( update_option( 'mymaps_options', $options ) ) {
        return 'success';
    } else {
        return 'nothing_change';
    }
}