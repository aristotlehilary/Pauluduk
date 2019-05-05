<?php
vc_add_param("vc_toggle", array (
	'type' => 'dropdown',
	'param_name' => 'style',
	'value' => array(
		esc_html__( 'Border Heading', 'wp-amilia' ) => 'border-heading',
		esc_html__( 'Background Heading', 'wp-amilia' ) => 'bg-heading',
	),
	'heading' => esc_html__( 'Style', 'wp-amilia' ),
	'description' => esc_html__( 'Select accordion display style.', 'wp-amilia' ),
));

vc_add_param("vc_toggle", array (
	'type' => 'dropdown',
	'param_name' => 'style',
	'value' => array(
		esc_html__( 'Heading with Background', 'wp-amilia' ) => 'bg-heading',
		esc_html__( 'Heading without Background', 'wp-amilia' ) => 'bg-without-heading',
	),
	'heading' => esc_html__( 'Style', 'wp-amilia' ),
	'description' => esc_html__( 'Select accordion display style.', 'wp-amilia' )
));

vc_add_param("vc_toggle", array(
	'type' => 'dropdown',
	'heading' => esc_html__( 'CSS Animation', 'wp-amilia' ),
	'param_name' => 'css_animation',
	'value' => amilia_animate_lib(),
	'description' => esc_html__( 'Select "animation in" for page transition.', 'wp-amilia' ),
));
vc_remove_param('vc_toggle', 'color');
vc_remove_param('vc_toggle', 'size');