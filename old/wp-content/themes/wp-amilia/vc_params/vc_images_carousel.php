<?php
vc_remove_param( 'vc_images_carousel', 'mode' );
vc_remove_param( 'vc_images_carousel', 'partial_view' );
vc_remove_param( 'vc_images_carousel', 'speed' );

vc_add_param("vc_images_carousel", array (
	'type' => 'dropdown',
	'heading' => esc_html__( 'On click action', 'wp-amilia' ),
	'param_name' => 'onclick',
	'value' => array(
		esc_html__( 'Open Magnific Popup', 'wp-amilia' ) => 'open_magnific',
		esc_html__( 'None', 'wp-amilia' ) => 'link_no',
		esc_html__( 'Open custom links', 'wp-amilia' ) => 'custom_link',
	),
	'description' => esc_html__( 'Select action for click event.', 'wp-amilia' ),
));

vc_add_param("vc_images_carousel", array (
	'type' => 'dropdown',
	'heading' => esc_html__( 'Pagination position', 'wp-amilia' ),
	'param_name' => 'paging_postition',
	'value' => array(
		esc_html__( 'Inside', 'wp-amilia' ) => 'paging_inside',
		esc_html__( 'Outside', 'wp-amilia' ) => 'paging_outside',
	),
	'description' => esc_html__( 'Select pagination position', 'wp-amilia' ),
));	