<?php
require_once $this -> plugin_dir. '/template/elements.php';
require_once $this -> plugin_dir. '/template/layouts/head.php';

if( function_exists('fl_header') ) {
    $state = ( isset($_GET['edit_map']) )? __('Edit Map', 'flex-map') : __('Add Map', 'flex-map');
    fl_header($state);
}
?>
<div class="mymaps-container">
    <div class="mymaps-tabs map-wrap">
        <div class="mymaps-row">
            <div class="mymaps-col c-5">
                <!-- Your Tabs Here -->
                <?php
                mymaps_tabs( array(
                    'frame_name' => 'marker-options',
                    'marker_tab_general' => array(
                        'icon' => '<i class="fa fa-cog"></i>',
                        'tab_name' => '',
                        'checked' => 'true',
                        'tooltips' => 'Generals',
                        'rows' => array(
                            array(
                                'layout' => '12',
                                'params' => array(
                                    array(
                                        'type' => 'htag',
                                        'htype' => 'h3',
                                        'value' => __('General', 'flex-map'),
                                        'col_pos'   => '0'
                                    )
                                )
                            ),
                            array(
                                'layout' => '12',
                                'params' => array(
                                    array(
                                        'type' => 'gnPanel',
                                        'col_pos'   => '0'
                                    )
                                )
                            )
                        )
                    ),
                    'marker_tab_id_1' => array(
                        'icon' => '<i class="fa fa-map-marker"></i>',
                        'tab_name' => '',
                        'tooltips' => __('Markers', 'flex-map'),
                        'rows' => array(
                            array(
                                'layout' => '12',
                                'params' => array(
                                    array(
                                        'type' => 'mkPanel',
                                        'title' => 'Height: ',
                                        'col_pos'   => '0'
                                    )
                                )
                            )
                        )
                    ),
                    'marker_tab_id_2' => array(
                        'icon' => '<i class="fa fa-chevron-up"></i>',
                        'tab_name' => '',
                        'tooltips' => __( 'Draw', 'flex-map' ),
                        'rows' => array(
                            array(
                                'layout' => '12',
                                'params' => array(
                                    array(
                                        'type' => 'drPanel',
                                        'col_pos'   => '0'
                                    )
                                )
                            )
                        )
                    ),
                    'marker_tab_id_6' => array(
                        'icon' => '<i class="fa fa-paint-brush"></i>',
                        'tab_name' => '',
                        'tooltips' => __( 'Styles', 'flex-map' ),
                        'rows' => array(
                            array(
                                'layout' => '12',
                                'params' => array(
                                    array(
                                        'type' => 'stPanel',
                                        'col_pos'   => '0'
                                    )
                                )
                            )
                        )
                    )
                ) );
                ?>
            </div>
            <div class="mymaps-col c-7">
                <div class="map-wraper">
                    <input type="text" class="" id="pac-input" name="pac-input" style="width:100%;margin:0;" placeholder="<?php _e('Search', 'flex-map'); ?>">
                    <div id="map-canvas"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrap-button out-tab">
        <button id="save_map" class="map-btn-out-tab btn-green map-btn"> <i class="fa fa-floppy-o"></i> <?php _e('SAVE MAP', 'flex-map'); ?></button>
    </div>

</div>