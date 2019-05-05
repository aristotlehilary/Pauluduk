<?php
function mymaps_tabs( $tabs_array )
{

    $contents = $frame_tab  = ''; $tab_name_array = array();
    echo '<div class="mymaps-tabs tabs-frame mymaps-effect-fade'.$tabs_array['frame_name'].'">';
    foreach( $tabs_array as $frame_tab => $tabs_properties )
    {
        /* Check is frame name*/
        if( $frame_tab == 'frame_name' )
        {
            $frame_name = $tabs_properties;

        } else {

                /* Check the element that contain tab's properties is array */
                if( is_array($tabs_properties) )
                {
                    /* Check tab's property to get value */
                    $tab_id_class = $frame_tab;
                    $checked = ( isset($tabs_properties['checked']) && $tabs_properties['checked'] == 'true' )? ' checked="checked" ' : '';
                    $icon = ( isset($tabs_properties['icon']) && $tabs_properties['icon'] != '')? $tabs_properties['icon'] : '';
                    $name = ( isset($tabs_properties['tab_name']) && $tabs_properties['tab_name']!= '')? $tabs_properties['tab_name'] : '';
                    $label = ( isset($tabs_properties['tooltips']) && $tabs_properties['tooltips']!='' )? '<div class="text">'.$tabs_properties['tooltips'] . '</div>': '';
                    $label_class = ( isset($tabs_properties['tooltips']) )? 'class="tooltips"': '';
                    /* push to tab name array to generate css code */
                    $tab_name_array[] = $frame_tab;
                    if( $tab_id_class != '' )
                    {
                        echo '
                        <input type="radio" id="' . esc_attr($tab_id_class) . '" class="' . esc_attr($tab_id_class) . '" name="' . esc_attr($frame_name) . '" ' . $checked . '>
                                <label for="' . esc_attr($tab_id_class) . '" ' . $label_class . '>
                                ' . $label . '
                                  <span>' . $icon . $name .'</span>
                                </label>';
                    }
                }
        }
    }
    echo '<ul>';
    /* Foreach content */
    foreach( $tabs_array as $frame_tab => $tabs_properties )
    {
        /* Check is frame name*/
        if( $frame_tab == 'frame_name' )
        {
            $frame_name = $tabs_properties;
        } else {

            /* Check the element that contain tab's properties is array */
            if( is_array($tabs_properties) )
            {
                /* Check tab's property to get value */
                $tab_id_class = $frame_tab;
                $name = ( isset($tabs_properties['tab_name']) && $tabs_properties['tab_name']!= '')? $tabs_properties['tab_name'] : '';
                /* push to tab name array to generate css code */
                $tab_name_array[] = $frame_tab;
                if( $tab_id_class != '' )
                {
                    /*************
                     * GET CONTENT
                     *************/
                    /* Extract to get rows array in tab */
                    if( isset( $tabs_properties['rows'] ) && is_array( $tabs_properties['rows'] ) )
                    {
                        /* (Begin content tag) */
                        echo '<li class="' . esc_attr( $tab_id_class ) . '">';

                        /* Extract to get each row */
                        foreach( $tabs_properties['rows'] as $row )
                        {
                            /* Use blah function to handle each row */
                            print_each_row( $row );
                        }
                        echo '</li>';
                    }
                }
            }
        }
    }
    echo '</ul>';
    echo ' <div class="wait waiting-style-map"><div class="background-waiting"></div><div class="circles-loader">' . __('Loading...', 'flex-map') . '</div></div>';
    echo '</div>';
    echo generate_css( $tab_name_array );
}

function generate_css( $tab_name_array )
{

    $tab_name_none = '';
   $css = '<style>';
    foreach( $tab_name_array as $key => $tab_name )
    {
        $comma_first = ($key < (count($tab_name_array)- 1) )? ',' : '';
        $tab_name_none .= '.mymaps-tabs.mymaps-effect-none .' . $tab_name . ':checked ~ ul > .' . $tab_name . $comma_first;

        $css .= '.mymaps-tabs .' . $tab_name . ':checked ~ ul > .' . $tab_name . $comma_first;
    }
   $css .= '{
            position: relative;
            visibility: visible;
            -ms-transform: translate(0, 0) scale(1);
            -webkit-transform: translate(0, 0) scale(1) rotateX(0) rotateY(0);
            transform: translate(0, 0) scale(1) rotateX(0) rotateY(0);
            opacity: 1;
            top: 0;
            left: 0;
            -webkit-transition: 0.6s opacity 0.2s ease, 0.6s -webkit-transform 0.2s ease, 0.6s visibility 0.2s ease, 0s top ease, 0s left ease;
            transition: 0.6s opacity 0.2s ease, 0.6s transform 0.2s ease, 0.6s visibility 0.2s ease, 0s top ease, 0s left ease;
        }
        ';

   $css .= '.mymaps-tabs.mymaps-effect-none > ul > li,';
   $css .= $tab_name_none;
   $css .= '{
            -webkit-transition: none;
            transition: none;
            }
    </style>';
    return $css;
}
function print_each_row( $row )
{


    if( is_array( $row ) )
    {
        /* (Begin row) */
        echo '<div class="mymaps-row">';

        /* Check layout */
        if ( isset( $row['layout']) && isset($row['params']) )
        {

            /* Extract layout */
            $layout_cols = extract_layout($row['layout']);

            /* Use function to print params in each columns of layout */
            foreach($layout_cols as $col_pos => $col_number )
            {
                echo '<div class="mymaps-col c-' . (int) $col_number . '">';

                /* Extract params */
                foreach ( $row['params'] as $param_properties )
                {
                    print_params( $param_properties['type'], $param_properties, $col_pos );
                }

                echo '</div>';
            }
        }
        /* (End row) */
        echo '</div>';
    }
}

/**
 * Rendering param's html code depend on field type
 *
 * since 1.0.0
 * @param string $param_type
 * @param array $param_properties
 * @return string $render
 */
function print_params( $param_type, $param_properties, $col_pos = 0)
{
    $plugin_dir = apply_filters('mm_dir_path', plugin_dir_path(__FILE__) );
    if( ( (int)$param_properties['col_pos'] == $col_pos ) || ($col_pos == 0 && !isset($param_properties['col_pos']) ) )
    {
        if( file_exists($plugin_dir. 'params/' . $param_type . '.php') )
        {
            require_once $plugin_dir. 'params/' . $param_type . '.php';
            $render = $param_type( $param_properties );
        }
    }
}

/**
 * Extract layout from string
 *
 * @param string $layout_str
 * @return array $layout_arr
 */
function extract_layout( $layout_str )
{
    $layout_str = trim($layout_str, '/');
    if( strpos( $layout_str, '/') === false )
    {
        if( is_numeric( $layout_str ) )
        {
            return array( $layout_str );
        }
    } else {
        $layout_arr = explode('/', $layout_str);
        $layout_arr = array_filter($layout_arr);
        if( count($layout_arr) > 0 )
        {
            return $layout_arr;
        } else {
            return false;
        }
    }

}