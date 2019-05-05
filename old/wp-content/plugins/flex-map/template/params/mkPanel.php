<?php
function mkPanel( $param_properties )
{
    ?>
    <div class="flip-container" id="flip-toggle">
		<div class="flipper">
			<div class="front">
                <h3><?php _e('Markers', 'flex-map'); ?></h3>
                <div class="wrap-button">
                    <button class="btn-addmarker map-btn btn-blue"> <i class="fa fa-plus"></i> <?php _e('Add Marker', 'flex-map'); ?></button>
                    <button class="btn-addFastMarkers map-btn btn-orange"><i class="fa fa-rocket"></i> Add Fast Markers</button>
                </div>
                <table class="wp-list-table widefat fixed striped marker_list hidden">
                    <thead>
                        <tr>
                            <td><?php _e('Icon', 'flex-map'); ?></td>
                            <td><?php _e('Title', 'flex-map'); ?></td>
                            <td><?php _e('Time Out', 'flex-map'); ?></td>
                            <td><?php _e('Custom', 'flex-map'); ?></td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
			</div>
			<div class="back">
                <div class="mymaps-row">
                <h3></h3>
                <table border="0" class="field-container">
                    <tr class="fast_add_options hidden">
                        <td><?php esc_html_e('Reset field', 'flex-map'); ?>: </td>
                        <td>
                            <div class="can-toggle demo-rebrand-2">
                                <input id="mk_reset_field" name="reset_field" type="checkbox" value="1" >
                                <label for="mk_reset_field">
                                    <div class="can-toggle__switch" data-checked="Yes" data-unchecked="No"></div>
                                </label>
                            </div>
                            <i class="tips"> Reset all field after added a marker.</i>
                        </td>
                    </tr>
                    <tr class="lat_field">
                        <td><?php esc_html_e('Latitude', 'flex-map'); ?>: </td>
                        <td>
                            <div class="field_container">
                                <input type="text" id="latitude" name="latitude" value="" placeholder="Latitude">
                                <a href="javascript:void(0);" class="tooltip question_mark" data-tooltip="<?php esc_html_e('Click on the map to get latitude.', 'flex-map'); ?>"><i class="fa fa-question-circle"></i></a>
                            </div>
                        </td>
                    </tr>
                    <tr class="long_field">
                        <td><?php esc_html_e('Longitude', 'flex-map'); ?>: </td>
                        <td>
                            <div class="field_container">
                                <input type="text" id="longitude" name="longitude" value="" placeholder="Longitude">
                                <a href="javascript:void(0);" class="tooltip question_mark" data-tooltip="<?php _e('Click on the map to get longitude.', 'flex-map'); ?>"><i class="fa fa-question-circle"></i></a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('Title', 'flex-map'); ?>: </td>
                        <td>
                            <div class="field_container">
                                <input type="text" id="marker_title" name="marker_title" value="" placeholder="Title">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('Set Time Out', 'flex-map'); ?>: </td>
                        <td>
                            <div class="field_container">
                                <input type="text" id="marker_timeout" name="marker_timeout" value="" placeholder="Time Out">
                                <a href="javascript:void(0);" class="tooltip question_mark" data-tooltip="<?php _e('Second time ( 1000 = 1s )', 'flex-map'); ?>"><i class="fa fa-question-circle"></i></a>

                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('Marker Icon', 'flex-map'); ?>: </td>
                        <td>
                            <div class="chose_wrapper">
                                <img src="" alt="" width="32" height="37" class="marker_icon_chose"/>
                                <img src="<?php echo plugins_url('../../img/pencil.png', __FILE__) ?>" alt="" class="edit_chose_marker_icon"/>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">

                            <div class="icon_library marker_libs_icon hidden">
                                <br clear="all"><div class="seperator-icon"><?php _e('Base', 'flex-map'); ?></div><br clear="all">
                                <div class="icon-mk-group base-icon">
                                    <?php for($i=1; $i<40; $i++)
                                    {?>
                                    <div class="marker_wrap">
                                        <img src="<?php echo plugins_url('../../img/icons/base/'. $i . '.png', __FILE__) ?>"/>
                                    </div>
                                    <?php } ?>
                                </div>
                                <br clear="all"><div class="seperator-icon"><?php _e('Business', 'flex-map'); ?></div><br clear="all">
                                <div class="icon-mk-group bussiness-icon">
                                    <?php for($i=1; $i< 78; $i++)
                                    {?>
                                        <div class="marker_wrap">
                                            <img src="<?php echo plugins_url('../../img/icons/business/'. $i . '.png', __FILE__) ?>"/>
                                        </div>
                                    <?php } ?>
                                </div>
                                <br clear="all"><div class="seperator-icon"><?php _e('Crisis', 'flex-map'); ?></div><br clear="all">
                                <div class="icon-mk-group crisis-icon">
                                    <?php for($i=1; $i<36; $i++)
                                    {?>
                                        <div class="marker_wrap">
                                            <img src="<?php echo plugins_url('../../img/icons/crisis/'. $i . '.png', __FILE__) ?>"/>
                                        </div>
                                    <?php } ?>
                                </div>
                                <br clear="all"><div class="seperator-icon"><?php _e('Facilities and services', 'flex-map'); ?></div><br clear="all">
                                <div class="icon-mk-group f-a-s-icon">
                                <?php for($i=1; $i< 17; $i++)
                                {?>
                                    <div class="marker_wrap">
                                        <img src="<?php echo plugins_url('../../img/icons/fns/'. $i . '.png', __FILE__) ?>"/>
                                    </div>
                                <?php } ?>
                                </div>
                                <br clear="all"><div class="seperator-icon"><?php _e('Points of interest', 'flex-map'); ?></div><br clear="all">
                                <div class="icon-mk-group p-o-i-icon">
                                    <?php for( $i = 1; $i < 64; $i++ )
                                    {?>
                                        <div class="marker_wrap">
                                            <img src="<?php echo plugins_url('../../img/icons/poi/'. $i . '.png', __FILE__) ?>"/>
                                        </div>
                                    <?php } ?>
                                </div>
                                <br clear="all"><div class="seperator-icon"><?php _e('Recreation', 'flex-map'); ?></div><br clear="all">
                                <div class="icon-mk-group recreation">
                                    <?php for( $i = 1; $i < 34; $i++ )
                                    {?>
                                        <div class="marker_wrap">
                                            <img src="<?php echo plugins_url('../../img/icons/recreation/'. $i . '.png', __FILE__) ?>"/>
                                        </div>
                                    <?php } ?>
                                </div>
                                <br clear="all"><div class="seperator-icon"><?php _e('Transportation', 'flex-map'); ?></div><br clear="all">
                                <div class="icon-mk-group transportation">
                                    <?php for( $i = 1; $i < 28; $i++ )
                                    {?>
                                        <div class="marker_wrap">
                                            <img src="<?php echo plugins_url('../../img/icons/transportation/'. $i . '.png', __FILE__) ?>"/>
                                        </div>
                                    <?php } ?>
                                </div>
                                <br clear="all"><div class="seperator-icon"><?php _e('Weather', 'flex-map'); ?></div><br clear="all">
                                <div class="icon-mk-group weather">
                                    <?php for( $i = 1; $i < 11; $i++ )
                                    {?>
                                        <div class="marker_wrap">
                                            <img src="<?php echo plugins_url('../../img/icons/weather/'. $i . '.png', __FILE__) ?>"/>
                                        </div>
                                    <?php } ?>
                                </div>
                                <br clear="all"><div class="seperator-icon"><?php _e('Custom Icon', 'flex-map'); ?></div><br clear="all">
                                <div class="icon-mk-group custom-group">
                                    <?php
                                        if ( $options = get_option( 'mymaps_options' ) ) {
                                            $image = $options['_icons_'];
                                            if( $image != '' && count($image) > 0 ) {
                                                foreach( $image as $value ) {
                                                    ?>
                                                    <div class="marker_wrap">
                                                        <img src="<?php echo $value['link']; ?>" alt="" width="32" height="37" title="<?php echo $value['title']; ?>">
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                                </div>
                                <br clear="all"/>
                                <button id="meta-image-button" class="btn-blue upload-btn"> <i class="fa fa-plus-square"></i> </button>
                                <button id="delete-icon" class="delete-icon btn-red upload-btn hidden"> <i class="fa fa-trash-o"></i> </button>
                                <input type="hidden" name="marker-upoad-image" id="marker-upoad-image" value="<?php if ( isset ( $prfx_stored_meta['meta-image'] ) ) echo $prfx_stored_meta['meta-image'][0]; ?>" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><?php _e('Effect', 'flex-map'); ?>: </td>
                        <td>
                            <div class="field_container">
                                <select name="marker_effect" id="marker_effect">
                                <option value="NONE"><?php _e('NONE', 'flex-map'); ?></option>
                                <option value="BOUNCE"><?php _e('BOUNCE', 'flex-map'); ?></option>
                                <option value="DROP"><?php _e('DROP', 'flex-map'); ?></option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><?php _e('Open Description', 'flex-map'); ?>: </td>
                        <td>
                            <input id="des_open" type="checkbox"/> <label for="des_open"><?php _e('Enable', 'flex-map'); ?></label>
                            <a href="javascript:void(0);" class="tooltip question_mark" data-tooltip="<?php _e('Open Description when the map is loaded.', 'flex-map'); ?>"><i class="fa fa-question-circle"></i></a>
                        </td>
                    </tr>

                    <tr>
                        <td><?php _e('Description', 'flex-map'); ?>: </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="marker_des_wrapper">
                            <?php
                                wp_editor( '', 'marker_des', array('textarea_name' => 'marker_des','textarea_rows' => 10,) );
                            ?>
                        </td>
                    </tr>
                </table>
                <div class="marker_wrap_button">
                    <button id="save_marker" class="save_marker btn-orange map-btn"><?php _e('Save', 'flex-map'); ?></button>
                    <button id="cancel_marker" class="cancel_marker btn-red map-btn"><?php _e('Cancel', 'flex-map'); ?></button>
                </div>
                <input type="hidden" id="curMarker">
                </div>
			</div>
		</div>

	</div>
<?php
}

/*
 * Handle ajax request for UPLOAD marker icon
 *
 * @since 1.0.0
 */
function ajax_upload_marker_icon() {
    if(isset($_POST['link'])) {
        $link = trim($_POST['link']);
        $image = get_link_title( $link );
        /* Get options */
        if( $options = get_option('mymaps_options') ) {
            /* check option exists */
            if( isset( $options['_icons_'] ) ) {
                /* check option null */
                if( $options['_icons_'] == '' || $options['_icons_'] == null ) {
                    $options['_icons_'][0] = $image;
                } else {
                    $options['_icons_'][] = $image;
                }
            } else { /* if not exists */
                $options['_icons_'][0] = $image;
            }
            update_option( 'mymaps_options', $options );
            echo $image['title'];
        }else { /* if cannot get options */
            echo 'not_get';
        }
    } else { /* if not isset link variable */
        echo 'not_isset';
    }
}
/*
 * Handle ajax request for DELETE marker icon
 *
 * since 1.0.0
 */
function ajax_delete_marker_icon() {
    if(isset( $_POST['link'] ) ) {
        $link = trim($_POST['link']);
        $image = get_link_title( $link );
        /* Get options */
        if( $options = get_option('mymaps_options') ) {
            if( isset($options['_icons_']) && $options['_icons_'] != '' && count($options['_icons_']) > 0 ) {
                if( in_array($image, $options['_icons_']) ) {
                    $key = array_search( $image, $options['_icons_'] );
                    if( is_numeric($key) && $key >= 0 ) {
                        unset($options['_icons_'][$key]);
                        update_option('mymaps_options', $options );
                    }
                }
            }
        }
    }
}
/*
 * Get link and title from link
 *
 * @param string $link
 * @return array: contain file name and link
 */
function get_link_title( $link ) {
    $get_file_name = explode('/', $link);
    $get_file_name = $get_file_name[(count($get_file_name) - 1)];
    $title = explode( '.', $get_file_name );
    $title = $title[(count($title) - 2)];
    $image = array( 'title' => $title, 'link' => $link );
    return $image;
}

