<?php
vc_add_param("vc_tta_tabs", array(
	'type' => 'dropdown',
	'param_name' => 'style',
	'value' => array(
		esc_html__('Default', 'wp-amilia' ) => 'border-bold'
	),
	'heading' => esc_html__( 'Style', 'wp-amilia' ),
	'description' => esc_html__( 'Select accordion display style.', 'wp-amilia' ),
));

vc_remove_param( "vc_tta_tabs", "color" );
vc_remove_param( "vc_tta_tabs", "shape" );