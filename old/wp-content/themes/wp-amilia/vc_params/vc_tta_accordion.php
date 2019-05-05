<?php
vc_add_param("vc_tta_accordion", array(
	'type' => 'dropdown',
	'param_name' => 'style',
	'value' => array(
		esc_html__( 'Heading with Background', 'wp-amilia' ) => 'bg-heading',
		esc_html__( 'Heading without Background', 'wp-amilia' ) => 'bg-without-heading',
	),
	'heading' => esc_html__( 'Style', 'wp-amilia' ),
	'description' => esc_html__( 'Select accordion display style.', 'wp-amilia' ),
));

vc_remove_param( "vc_tta_accordion", "color" );
vc_remove_param( "vc_tta_accordion", "shape" );
vc_remove_param( "vc_tta_accordion", "no_fill" );