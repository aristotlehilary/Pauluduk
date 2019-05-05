<?php
vc_add_param("vc_gallery", array (
	'type' => 'dropdown',
	'heading' => esc_html__( 'Gallery type', 'wp-amilia' ),
	'param_name' => 'type',
	'value' => array(
		esc_html__( 'Flex slider fade', 'wp-amilia' ) => 'flexslider_fade',
		esc_html__( 'Flex slider slide', 'wp-amilia' ) => 'flexslider_slide',
		esc_html__( 'Nivo slider', 'wp-amilia' ) => 'nivo',
		esc_html__( 'Image grid', 'wp-amilia' ) => 'image_grid',
		//esc_html__( 'Cms special', 'wp-amilia' ) => 'cms_special',
	),
	'description' => esc_html__( 'Select gallery type.', 'wp-amilia' )
));

vc_add_param("vc_gallery", array(
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