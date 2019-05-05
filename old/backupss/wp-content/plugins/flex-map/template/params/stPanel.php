<?php
function stPanel()
{ ?>
    <div class="style-flip-container" id="flip-toggle">
        <div class="flipper">
            <div class="front">
                <div class="styles_map_container">
                    <h3><?php _e('My Styles', 'flex-map'); ?> </h3><br clear="all">
                    <div class="styles">

                    </div>
                </div>
            </div>
            <div class="back">
            </div>
        </div>
        <input type="hidden" name="style_default" id="style_default" value="">
    </div>
<?php
}

function ajax_load_mystyles()
{
    if(get_option('mymaps_options'))
    {
        $mymaps_options = get_option('mymaps_options');
        $array = $mymaps_options['_mystyles_'];
        echo json_encode($array);
    }
}
/*********************************************************
 * HANDLE AFTER AJAX REQUEST TO SAVE STYLE TO MY STYLES
 *******************************************************/
function ajax_save2_mystyles()
{
    if( get_option('mymaps_options') )
    {
        $mymaps_options = get_option('mymaps_options');
        $arr_mystyles   = $mymaps_options['_mystyles_'];
        $style_name     = $_POST['style_name'];
        if ($arr_mystyles == '')
        {
            $arr_mystyles = array(
                $style_name => array(
                    'json' => $_POST['style_json'],
                    'image' => $_POST['style_image']
                )
            );
        } else {
            if( !array_key_exists($style_name, $arr_mystyles))
            {
                $arr_mystyles[$style_name] = array(
                    'json'  => stripslashes($_POST['style_json']),
                    'image' => $_POST['style_image']
                );
            }
        }
        $mymaps_options['_mystyles_'] = $arr_mystyles;
        update_option('mymaps_options', $mymaps_options);
    }
}
/* HANDLE AJAX REQUEST TO DELETE MY STYLE */
function ajax_delete_mystyles() {
    if( $mymaps_options = get_option('mymaps_options') )
    {
        $arr_mystyles = $mymaps_options['_mystyles_'];
        if( array_key_exists($_POST['style_name'], $arr_mystyles ) ) {
            unset( $arr_mystyles[$_POST['style_name']] );
            echo 'deleted';
        }
        $mymaps_options['_mystyles_'] = $arr_mystyles;
        update_option('mymaps_options', $mymaps_options);
    }
}