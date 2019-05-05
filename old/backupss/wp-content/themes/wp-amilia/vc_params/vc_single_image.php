<?php
vc_add_param("vc_single_image", array(
	'type' => 'dropdown',
	'heading' => esc_html__( 'CSS Animation', 'wp-amilia' ),
	'param_name' => 'css_animation',
	'value' => amilia_animate_lib(),
	'description' => esc_html__( 'Select "animation in" for page transition.', 'wp-amilia' ),
));

vc_add_param("vc_single_image", array(
	'type' => 'dropdown',
	'heading' => esc_html__( 'On click action', 'wp-amilia' ),
	'param_name' => 'onclick',
	'value' => array(
		esc_html__( 'None', 'wp-amilia' ) => '',
		esc_html__( 'Link to large image', 'wp-amilia' ) => 'img_link_large',
		esc_html__( 'Open Magnific Popup', 'wp-amilia' ) => 'link_image',
		esc_html__( 'Open custom link', 'wp-amilia' ) => 'custom_link',
		esc_html__( 'Zoom', 'wp-amilia' ) => 'zoom',
	),
	'description' => esc_html__( 'Select action for click action.', 'wp-amilia' ),
	'std' => ''
));