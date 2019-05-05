<?php
require_once $this -> plugin_dir. '/template/elements.php';
require_once $this -> plugin_dir. '/template/layouts/head.php';

function import_export_page() {
    ?>
    <div class="list-wrapper">
        <div class="inner-list">
            <?php
            if( function_exists('fl_header') ) {
                fl_header( __('Import / Export Data Page', 'flex-map') );
            }
            ?>
            <div class="body-map">
                    <?php
                    mymaps_tabs( array(
                        'frame_name' => 'import-export',
                        'import_tab' => array(
                            'icon' => '<i class="fa spacing fa-download"></i>',
                            'tab_name' => 'Export',
                            'checked' => 'true',
                            'rows' => array(
                                array(
                                    'layout' => '1/10/1',
                                    'params' => array(
                                        array(
                                            'type' => 'htag',
                                            'htype' => 'h3',
                                            'value' => __('Export', 'flex-map'),
                                            'col_pos' => '1'
                                        )
                                    )
                                ),
                                array(
                                    'layout' => '1/10/1',
                                    'params' => array(
                                        array(
                                            'type' => 'export',
                                            'col_pos' => '1'
                                        )
                                    )
                                )
                            )
                        ),
                        'export_tab' => array(
                            'icon' => '<i class="fa spacing fa-upload"></i>',
                            'tab_name' => __('Import', 'flex-map'),
                            'rows' => array(
                                array(
                                    'layout' => '1/10/1',
                                    'params' => array(
                                        array(
                                            'type' => 'htag',
                                            'htype' => 'h3',
                                            'value' => __('Import', 'flex-map'),
                                            'col_pos' => '1'
                                        )
                                    )
                                ),
                                array(
                                    'layout' => '1/10/1',
                                    'params' => array(
                                        array(
                                            'type' => 'import',
                                            'col_pos' => '1'
                                        )
                                    )
                                )
                            )
                        ) /* end tab */
                    ) );
                    ?>
                </div>

            </div>
        </div>
    <?php
}
