<?php
function gnPanel()
{
    $options = get_option('mymaps_options');
    if( isset($_GET['edit_map']) ) {
        $name = 'Loading...';
        $id   = (int) $_GET['edit_map'];
    } else if( isset($options['_map_posts_']) && is_array($options['_map_posts_'])){
        $get_arr_key = array_keys( $options['_map_posts_'] );
        $id = (int) end( $get_arr_key ) + 1;
        $name   = 'Flex Map ' . $id;
    } else {
        $name = 'Flex Map 1';
        $id   = 1;
    }
    echo '<table class="field-container">
            <tr>
                <td>' . __('Map Name', 'flex-map') . ': </td>
                <td><input type="text" name="map_name" id="map_name" value="' . $name . '"/></td>
            </tr>
            <tr>
                <td>' . __('Short Code', 'flex-map') . ': </td>
                <td><input type="text" name="short_code" id="short_code" readonly value="[flexmap id=\'' . $id . '\']"/></td>
            </tr>
            <tr>
                <td>' . __('Extra Class', 'flex-map') . ': </td>
                <td><input type="text" name="extra_class" id="extra_class" value=""/></td>
            </tr>
            <tr class="mapLayout">
                <td>' . __('Map Layout', 'flex-map') . ': </td>
                <td>
                    <span>
                        <input name="map_layout" id="map_layout_cus" type="radio" value="cus" checked/>
                        <label for="map_layout_cus">' . __('Custom', 'flex-map') . '</label>
                    </span>
                    <span>
                        <input name="map_layout" id="map_layout_res" type="radio" value="res"/>
                        <label for="map_layout_res">' . __('Auto Responsive', 'flex-map') . '</label>
                    </span>
                </td>
            </tr>
            <tr class="heightUn hidden">
                <td><label for="height_unlimited">' . __('Height Unlimited', 'flex-map') . ': </label></td>
                <td>
                    <div class="can-toggle demo-rebrand-2">
                        <input id="height_unlimited" name="height_unlimited" type="checkbox" value="1" >
                        <label for="height_unlimited">
                            <div class="can-toggle__switch" data-checked="Yes" data-unchecked="No"></div>
                        </label>
                    </div>
                </td>
            </tr>
            <tr class="widthTr">
                <td>' . __('Width', 'flex-map') . ': </td>
                <td>
                    <input name="map_width" id="map_width" class="small-box" type="text" value=""/>
                    <select name="unit_width" id="unit_width">
                        <option value="px">px</option>
                        <option value="%">%</option>
                    </select>
                </td>
            </tr>
            <tr class="heightTr">
                <td>
                    '.__('Height', 'flex-map').':
                </td>
                <td>
                    <input name="map_height" class="small-box" id="map_height" type="text" value=""/>
                    <select name="unit_height" id="unit_height">
                        <option value="px">px</option>
                        <option value="%">%</option>
                    </select>
                </td>
            </tr>
            <!-- Current state -->
            <tr class="zoomTr">
                <td>'.__('Zoom', 'flex-map').': </td>
                <td>
                    <input type="hidden" id="map-zoom-hidden" value="0"/>
                    <div id="map-zoom-result">0</div>
                    <!-- Your Tabs Here -->
                    <div class="map-zoom"></div>
                </td>
            </tr>
            <tr>
                <td>'.__('Map type', 'flex-map').': </td>
                <td><select name="curMapType" id="curMapType">
                    <option value="ROADMAP">'.__('ROADMAP', 'flex-map').'</option>
                    <option value="TERRAIN">'.__('TERRAIN', 'flex-map').'</option>
                    <option value="SATELLITE">'.__('SATELLITE', 'flex-map').'</option>
                    <option value="HYBRID">'.__('HYBRID', 'flex-map').'</option>
                </select>
                </td>
            </tr>
            <tr>
                <td><label for="search_box">'.__('Search Box', 'flex-map').':</label></td>
                <td>
                    <div class="can-toggle demo-rebrand-2">
                        <input id="search_box" name="search_box" type="checkbox" value="1" >
                        <label for="search_box">
                            <div class="can-toggle__switch" data-checked="Yes" data-unchecked="No"></div>
                        </label>
                    </div>
                    <i class="tips">'.__('Enable for show the search box in map frame at front end', 'flex-map').'</i>
                </td>
            </tr>
            <tr>
                <td><label for="map_legend">' . __('Map Legend', 'flex-map') . ': </label></td>
                <td>
                    <div class="can-toggle demo-rebrand-2">
                        <input id="map_legend" name="map_legend" type="checkbox" value="1" >
                        <label for="map_legend">
                            <div class="can-toggle__switch" data-checked="Yes" data-unchecked="No"></div>
                        </label>
                    </div>
                </td>
            </tr>

            <!-- Map options -->
            <tr class="draggable">
                <td><label for="draggable">'.__('Draggable All Devices', 'flex-map').': </label></td>
                <td>
                    <div class="can-toggle demo-rebrand-2">
                        <input id="draggable" name="draggable" type="checkbox" value="1" checked="checked">
                        <label for="draggable">
                            <div class="can-toggle__switch" data-checked="Yes" data-unchecked="No"></div>
                        </label>
                    </div>
                </td>
            </tr>
            <tr class="drMobile">
                <td><label for="dr_mobile">' . __('Dragable Mobile', 'flex-map') . ': </label></td>
                <td>
                    <div class="can-toggle demo-rebrand-2">
                        <input id="dr_mobile" name="dr_mobile" type="checkbox" value="1" checked="checked">
                        <label for="dr_mobile">
                            <div class="can-toggle__switch" data-checked="Yes" data-unchecked="No"></div>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label for="scroll_wheel">' . __('Scroll Wheel', 'flex-map') . ':</label> </td>
                <td>
                    <div class="can-toggle demo-rebrand-2">
                        <input id="scroll_wheel" name="scroll_wheel" type="checkbox" value="1" checked="checked">
                        <label for="scroll_wheel">
                            <div class="can-toggle__switch" data-checked="Yes" data-unchecked="No"></div>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label for="scroll_wheel">' . __('Double Click Zoom', 'flex-map') . ': </label></td>
                <td>
                    <div class="can-toggle demo-rebrand-2">
                        <input id="double_click_zoom" name="double_click_zoom" type="checkbox" value="1" checked="checked">
                        <label for="double_click_zoom">
                            <div class="can-toggle__switch" data-checked="Yes" data-unchecked="No"></div>
                        </label>
                    </div>
                </td>
            </tr>
            <!-- Default UI -->
            <tr class="defaultUI">
                <td><label for="df_ui">' . __('Default UI', 'flex-map') . ': </label></td>
                <td>
                    <div class="can-toggle demo-rebrand-2">
                        <input id="df_ui" name="df_ui" type="checkbox" value="1" >
                        <label for="df_ui">
                            <div class="can-toggle__switch" data-checked="Yes" data-unchecked="No"></div>
                        </label>
                    </div>
                </td>
            </tr>
            <tr class="scaleCt hidden">
                <td><label for="scale_control">' . __('Scale Control', 'flex-map') . ': </label></td>
                <td>
                    <div class="can-toggle demo-rebrand-2">
                        <input id="scale_control" name="scale_control" type="checkbox" value="1" >
                        <label for="scale_control">
                            <div class="can-toggle__switch" data-checked="Yes" data-unchecked="No"></div>
                        </label>
                    </div>
                </td>
            </tr>
            <tr class="zoomCt hidden">
                <td><label for="zoom_control">' . __('Zoom Control', 'flex-map') . ': </label></td>
                <td>
                    <div class="can-toggle demo-rebrand-2">
                        <input id="zoom_control" name="zoom_control" type="checkbox" value="1" >
                        <label for="zoom_control">
                            <div class="can-toggle__switch" data-checked="Yes" data-unchecked="No"></div>
                        </label>
                    </div>
                </td>
            </tr>
            <tr class="hidden">
                <td>' . __('Zoom Control Size', 'flex-map') . ': </td>
                <td>
                    <select id="zoom_control_size">
                        <option value="DEFAULT">' . __('DEFAULT', 'flex-map') . '</option>
                        <option value="LARGE">' . __('LARGE', 'flex-map') . '</option>
                        <option value="SMALL">' . __('SMALL', 'flex-map') . '</option>
                    </select>
                </td>
            </tr>
            <tr class="typeCt hidden">
                <td>' . __('Type Control Style', 'flex-map') . ': </td>
                <td>
                    <select name="type_control_style" id="type_control_style">
                        <option value="DEFAULT">' . __('Default', 'flex-map') . '</option>
                        <option value="HORIZONTAL_BAR">' . __('Horizontal Bar', 'flex-map') . '</option>
                        <option value="DROPDOWN_MENU">' . __('Dropdown Menu', 'flex-map') . '</option>
                    </select>
                </td>
            </tr>
            <tr class="typeIds hidden">
                <td>' . __('Type Control IDS', 'flex-map') . ': </td>
                <td>
                    <select name="map_type_id[]" id="map_type_id" multiple="multiple">
                        <option value="ROADMAP">' . __('ROADMAP', 'flex-map') . '</option>
                        <option value="SATELLITE">' . __('SATELLITE', 'flex-map') . '</option>
                        <option value="HYBRID">' . __('HYBRID', 'flex-map') . '</option>
                        <option value="TERRAIN">' . __('TERRAIN', 'flex-map') . '</option>
                    </select>
                    <i class="tips">' . __('Hold control key to choose more', 'flex-map') . '</i>
                </td>
            </tr>
            <tr class="streetCt hidden">
                <td><label for="street_view_control">' . __('Street View Control', 'flex-map') . ': </label></td>
                <td>
                    <div class="can-toggle demo-rebrand-2">
                        <input id="street_view_control" name="street_view_control" type="checkbox" value="1" >
                        <label for="street_view_control">
                            <div class="can-toggle__switch" data-checked="Yes" data-unchecked="No"></div>
                        </label>
                    </div>
                </td>
            </tr>
            <tr class="hidden">
                <td><label for="pan_control">' . __('Pan Control', 'flex-map') . '</label></td>
                <td>
                    <div class="can-toggle demo-rebrand-2">
                        <input id="pan_control" name="pan_control" type="checkbox" value="1" >
                        <label for="pan_control">
                            <div class="can-toggle__switch" data-checked="Yes" data-unchecked="No"></div>
                        </label>
                    </div>
                </td>
            </tr>
            <tr class="hidden">
                <td><label for="overview_control">' . __('Overview Control', 'flex-map') . '</label></td>
                <td>
                    <div class="can-toggle demo-rebrand-2">
                        <input id="overview_control" name="overview_control" type="checkbox" value="1" >
                        <label for="overview_control">
                            <div class="can-toggle__switch" data-checked="Yes" data-unchecked="No"></div>
                        </label>
                    </div>
                </td>
            </tr>
         </table>';
}
/*
 * Handle ajax request for save map post
 */
function ajax_save_map_posts() {
    $general        = stripslashes($_POST['general']);
    $markers        = stripslashes($_POST['markers']);
    $polyLines      = stripslashes($_POST['polyLines']);
    $polyGons       = stripslashes($_POST['polyGons']);
    $circles        = stripslashes($_POST['circles']);
    $recTangles     = stripslashes($_POST['recTangles']);
    $option_save = array( 'general' => $general, 'markers' => $markers, 'polyLines' => $polyLines, 'polyGons' => $polyGons, 'circles' => $circles, 'recTangles' => $recTangles );

    if( $options = get_option('mymaps_options') )
    {
        if( $options!= '' && array_key_exists('_map_posts_', $options ) )
        {
            if( $_POST['map_id'] === 'false' ) {
                /* get last id */
                $id = (int) end(array_keys( $options['_map_posts_'] )) + 1;
                $options['_map_posts_'][$id] = $option_save;
                echo $id;
            } else {
                if( array_key_exists($_POST['map_id'], $options['_map_posts_']) ) {
                    $options['_map_posts_'][$_POST['map_id']] = $option_save;
                    echo $_POST['map_id'];
                }
            }
        } else {
            echo '1';
            $options['_map_posts_'][1] = $option_save;
        }
        update_option( 'mymaps_options', $options );
    } else {
        echo 'save_fail';
    }
}

function flValidateGeneral() {

}
