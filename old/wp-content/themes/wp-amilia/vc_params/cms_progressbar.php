<?php
vc_remove_param('cms_progressbar','icon_type');
vc_remove_param('cms_progressbar','icon_fontawesome');
vc_remove_param('cms_progressbar','icon_openiconic');
vc_remove_param('cms_progressbar','icon_typicons');
vc_remove_param('cms_progressbar','icon_entypo');
vc_remove_param('cms_progressbar','icon_linecons');
vc_remove_param('cms_progressbar','icon_pixelicons');
vc_remove_param('cms_progressbar','icon_pe7stroke');
vc_remove_param('cms_progressbar','color');

vc_add_param("cms_progressbar", array(
	'type' => 'dropdown',
	'param_name' => 'style',
	'value' => array(
		esc_html__( 'Static Layout', 'wp-amilia' ) => 'style1',
		esc_html__( 'Animation Layout', 'wp-amilia' ) => 'style2',
		esc_html__( 'Bootstrap Basic Layout', 'wp-amilia' ) => 'style3',
	),
	'heading' => esc_html__( 'Style', 'wp-amilia' ),
	'description' => esc_html__( 'Select accordion display style.', 'wp-amilia' ),
	'group' => esc_html__( 'Progress Bar Settings', 'wp-amilia' ),
));

vc_add_param("cms_progressbar", array(
	'type' => 'dropdown',
	'param_name' => 'bootstrap_type',
	'value' => array(
		esc_html__( 'Default', 'wp-amilia') => 'default',
		esc_html__( 'Info', 'wp-amilia') => 'progress-bar-info',
		esc_html__( 'Success', 'wp-amilia') => 'progress-bar-success',
		esc_html__( 'Warning', 'wp-amilia') => 'progress-bar-warning',
		esc_html__( 'Active', 'wp-amilia') => 'active'
	),
	'heading' => esc_html__( 'Style', 'wp-amilia' ),
	'dependency' => array(
		'element' => 'style',
		'value' => 'style3',
	),
	'std' => '',
	'description' => esc_html__( 'Select accordion display style.', 'wp-amilia' ),
	'group' => esc_html__( 'Progress Bar Settings', 'wp-amilia' ),
));