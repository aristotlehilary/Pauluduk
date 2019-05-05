<?php
require_once 'layouts/head.php';
function list_map() {
        ?>
    <div class="list-wrapper">
        <div class="inner-list">
            <?php
            if( function_exists('fl_header') ) {
                fl_header( __('List All Map', 'flex-map') );
            }
            ?>
        <div class="action-option action-list">
            <div class="inner-action">
                <div class="fixed-button">
                    <a href="<?php echo get_admin_url('', 'admin.php?page=map-post' ); ?>" id="add_map" class="map-btn-big btn-blue"> <i class="fa fa-plus-square"></i> Add Map </a>
                </div>
                <div class="special_options">
                    <button id="edit_map" class="map-btn-big btn-orange"> <i class="fa fa-pencil-square-o"></i> Edit </button>
                    <button id="delete_map" class="map-btn-big btn-red"> <i class="fa fa-trash-o"></i> Delete </button>
                </div>
            </div>
        </div>
        <table class="wp-list-table widefat fixed striped posts map-list-table">
            <thead>
            <tr>
                <td  class="checkbox-list">
                    <label for="check_all">
                        <input id="check_all" type="checkbox" value=""/>
                    </label>
                </td>
                <td>Name</td>
                <td>Shortcode</td>
            </tr>
            </thead>
            <tbody>
            <?php

            if( $options = get_option('mymaps_options'))
            {
                if( $options['_map_posts_'] > 0 ) {
                    foreach( $options['_map_posts_'] as $id => $map ) {
                        $general = json_decode($map['general']);
                        ?>
                        <tr>
                            <td class="checkbox-list">
                                <label for="<?php echo esc_attr( $id ); ?>">
                                    <input type="checkbox" id="<?php echo esc_attr( $id ); ?>" class="post_map" value="<?php echo esc_attr( $id ); ?>">
                                </label>
                            </td>
                            <td>
                                <a href="<?php echo get_admin_url('', 'admin.php?page=map-post&edit_map=' . esc_attr( $id ) ); ?>"><?php echo esc_attr( $general->name ); ?></a>
                            </td>
                            <td><input type="text" value='<?php echo '[flexmap id="' . esc_attr( $id ) . '"]'; ?>' readonly  onClick="this.setSelectionRange(0, this.value.length)" > </td>
                        </tr>
                    <?php
                    }
                }
            }
            ?>
            <tr>
                <td colspan="3">
                    <div class="wait waiting-style-map">
                        <div class="background-waiting"></div>
                        <div class="circles-loader">Loading...</div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        </div>
    </div>
    <?php
}
function ajax_delete_map_posts() {
    if( $options = get_option('mymaps_options') )
    {
        $change = 0;
        $map_id = trim( $_POST['map_id'], ',' );
        $map_ids = explode( ',', $map_id );

        foreach( $map_ids as $value ) {
            $id = (int) $value;
            if( $id !== '' ) {
                $map_post = $options['_map_posts_'];
                unset($map_post[$id]);
                $options['_map_posts_'] = $map_post;
                $change += 1;
            }
        }
        if( $change > 0 ) {
            update_option('mymaps_options', $options );
        } else {
            echo 'fail';
        }
    } else {
        echo 'fail';
    }
}
