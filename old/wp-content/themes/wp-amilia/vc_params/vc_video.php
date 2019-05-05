<?php
vc_add_param("vc_video", array (
	'type' => 'checkbox',
	'heading' => esc_html__( 'Use Video Popup ?', 'wp-amilia' ),
	'param_name' => 'use_popup',
	'value' => array( esc_html__( 'Yes', 'wp-amilia' ) => 'yes' ),
	'description' => esc_html__( 'Default is video embed', 'wp-amilia' ),
));

vc_add_param("vc_video", array (
	"type" => "attach_image",
    "heading" => esc_html__("Image thumbnail",'wp-amilia'),
    "param_name" => "image_thumbnail",
    'dependency' => array(
        "element" => "use_popup",
        "value" => 'yes'
    ),
    "description" => esc_html__("Thumbnail for video", 'wp-amilia')
));