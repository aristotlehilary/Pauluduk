<?php
vc_remove_param('cms_counter_single', 'title');
vc_remove_param('cms_counter_single', 'description');
vc_remove_param('cms_counter_single', 'content_align');
vc_add_param('cms_counter_single', array(
    'type' => 'dropdown',
    'heading' => esc_html__( 'Icon library', 'wp-amilia' ),
    'value' => array(
        esc_html__( 'Font Awesome', 'wp-amilia' ) => 'fontawesome',
        esc_html__( 'Elegant Icon', 'wp-amilia' ) => 'elegant',
    ),
    'param_name' => 'icon_type',
    'description' => esc_html__( 'Select icon library.', 'wp-amilia' ),
    "group" => esc_html__("Counters Settings", 'wp-amilia')
));

vc_add_param("cms_counter_single", array(
    'type' => 'iconpicker',
    'heading' => esc_html__( 'Icon Item', 'wp-amilia' ),
    'param_name' => 'icon_elegant',
    'value' => '',
    'settings' => array(
        'emptyIcon' => true, // default true, display an "EMPTY" icon?
        'type' => 'elegant',
        'iconsPerPage' => 200, // default 100, how many icons per/page to display
    ),
    'description' => esc_html__( 'Select icon from library.', 'wp-amilia' ),
    "group" => esc_html__("Counters Settings", 'wp-amilia')
));