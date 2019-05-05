<?php
vc_add_param("vc_message", array (
	'type' => 'checkbox',
	'heading' => esc_html__( 'Hide icon ?', 'wp-amilia' ),
	'param_name' => 'message_hide_icon',
	'description' => esc_html__( 'Hide icon', 'wp-amilia' ),
	'value' => array( esc_html__( 'Yes', 'wp-amilia' ) => 'yes' )
));
vc_add_param("vc_message", array (
	'type' => 'checkbox',
	'heading' => esc_html__( 'Alerts closable ?', 'wp-amilia' ),
	'param_name' => 'message_closeable',
	'description' => esc_html__( 'Alerts closable', 'wp-amilia' ),
	'value' => array( esc_html__( 'Yes', 'wp-amilia' ) => 'yes' )
));