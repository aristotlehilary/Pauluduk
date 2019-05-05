<?php
function export() {
?>
    <div class="export-wrapper">
        <strong><?php _e('This tool allows you to export current site personalizations to a file in order to make easy your work of migrating your work to another domain', 'flex-map'); ?></strong>
        <br clear="all">
        <div class="field-rows">
            <input type="checkbox" id="style-export" checked> <label for="style-export"> <?php _e('Export My Styles', 'flex-map'); ?> </label><br clear="all">
        </div>
        <div class="field-rows">
            <input type="checkbox" id="icon-export" checked> <label for="icon-export"> <?php _e('Export Custom Icons ( Just export icon\'s link. When you import data to another site, make sure your icon file also uploaded ).' ); ?> </label><br clear="all">
        </div>
        <div class="field-rows">
            <strong><?php _e('Choose Map Post', 'flex-map');?>:</strong>
        </div>
        <div class="field-rows">
        <div class="mappost-export">
        <div class="post-container">
            <table class="wp-list-table widefat fixed striped posts map-list-table">
            <thead>
            <tr>
                <td  class="checkbox-list">
                    <label for="check_all">
                        <input id="check_all" type="checkbox" value="" checked/>
                    </label>
                </td>
                <td><?php _e('Name', 'flex-map'); ?></td>
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
                        <tr class="selecting">
                            <td class="checkbox-list">
                                <label for="<?php echo esc_attr( $id ); ?>">
                                    <input type="checkbox" id="<?php echo esc_attr( $id ); ?>" class="post_map" value="<?php echo esc_attr( $id ); ?>" checked>
                                </label>
                            </td>
                            <td class="checkbox-name">
                                <label for="<?php echo esc_attr( $id ); ?>">
                                    <?php echo esc_attr( $general->name ); ?>
                                </label>
                            </td>
                        </tr>
                    <?php
                    }
                }
            }
            ?>
            </tbody>
        </table>
        </div>
    </div>
            <div class="field-rows btn-wrap">
                <a id="export-btn" class="map-btn-big btn-green" download="maps_backup_<?php echo date('Y-m-d-h-i-s'); ?>.json"><img src="<?php echo plugins_url('../../img/export.png', __FILE__); ?>"></a>
            </div>
        </div>
    </div>
<?php
}