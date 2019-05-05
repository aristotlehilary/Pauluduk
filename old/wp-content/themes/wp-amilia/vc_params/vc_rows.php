<?php
vc_remove_param('vc_row', 'video_bg');
vc_remove_param('vc_row', 'video_bg_url');
vc_remove_param('vc_row', 'parallax');
vc_remove_param('vc_row', 'parallax_image');
vc_remove_param('vc_row', 'video_bg_parallax');
vc_remove_param('vc_row', 'gap');
vc_remove_param('vc_row_inner', 'gap');

vc_add_param('vc_row', array(
    'type' => 'checkbox',
    'heading' => esc_html__("Content Full Width", 'wp-amilia'),
    'param_name' => 'full_width',
    'std' => false,
    'description' => esc_html__("Yes = full width, default content boxed.", 'wp-amilia')
));

vc_add_param("vc_row", array(
    "type" => "textfield",
    "heading" => esc_html__("Offset", 'wp-amilia'),
    "param_name" => "data_offset",
    "description" => esc_html__("Offset for Onepage", 'wp-amilia'),
    "group" => esc_html__("OnePage Options", 'wp-amilia')
));

vc_add_param('vc_row', array(
    'type' => 'dropdown',
    'heading' => esc_html__("Background Style", 'wp-amilia'),
    'param_name' => 'bg_style',
    'value' => array(
        'Default' => '',
        'Image / Parallax' => 'img_parallax',
        'Image / Fixed' => 'img_fixed',
        'Hosted Video' => 'hvideo',
    ),
    'group' => 'Design Options',
    'description' => esc_html__("Select the kind of background would you like to set for this row.", 'wp-amilia')
));
vc_add_param('vc_row', array(
    'type' => 'textfield',
    'heading' => esc_html__("Parallax Speed", 'wp-amilia'),
    'param_name' => 'bd_p_speed',
    'group' => 'Design Options',
    "dependency" => array(
        "element" => "bg_style",
        "value" => array(
            "img_parallax"
        )
    ),
    'description' => esc_html__("Set speed moving for parallax default 0.4 .", 'wp-amilia')
));
vc_add_param('vc_row', array(
    'type' => 'textfield',
    'heading' => esc_html__("MP4 (URL)", 'wp-amilia'),
    'param_name' => 'bg_video_mp4',
    'group' => 'Design Options',
    "dependency" => array(
        "element" => "bg_style",
        "value" => array(
            "hvideo"
        )
    ),
    'description' => esc_html__(".mp4 video.", 'wp-amilia')
));
vc_add_param('vc_row', array(
    'type' => 'textfield',
    'heading' => esc_html__("WEBM (URL)", 'wp-amilia'),
    'param_name' => 'bg_video_webm',
    'group' => 'Design Options',
    "dependency" => array(
        "element" => "bg_style",
        "value" => array(
            "hvideo"
        )
    ),
    'description' => esc_html__(".webm video.", 'wp-amilia')
));
vc_add_param('vc_row', array(
    'type' => 'dropdown',
    'heading' => esc_html__("Overlay Color", 'wp-amilia'),
    'param_name' => 'overlay_row',
    'value' => array(
        'No' => '',
        'Yes' => 'yes'
    ),
    'group' => 'Design Options'
));
vc_add_param("vc_row", array(
    "type" => "colorpicker",
    "class" => "",
    "heading" => esc_html__('Color', 'wp-amilia'),
    "param_name" => "overlay_color",
    'group' => 'Design Options',
    "dependency" => array(
        "element" => "overlay_row",
        "value" => array(
            "yes"
        )
    ),
    "description" => ''
));

vc_add_param("vc_row_inner", array(
    'type' => 'checkbox',
    'heading' => esc_html__( 'Add Features Background', 'wp-amilia' ),
    'param_name' => 'features_bg',
    'std' => false
));