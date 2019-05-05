<?php
vc_add_param("vc_separator", array(
	/* Start Icon */
	'type' => 'dropdown',
	'heading' => esc_html__( 'Icon library', 'wp-amilia' ),
	'value' => array(
		esc_html__( 'Font Awesome', 'wp-amilia' ) => 'fontawesome',
		esc_html__( 'Linea Icons', 'wp-amilia' ) => 'lineaicon',
		esc_html__( 'Glyphicons', 'wp-amilia' ) => 'glyphicon',
		esc_html__( 'Elegant Icon', 'wp-amilia' ) => 'elegant',
	),
	'param_name' => 'icon_type',
	'description' => esc_html__( 'Select icon library.', 'wp-amilia' ),
	"group" => esc_html__("Templates", 'wp-amilia')
));

vc_add_param("vc_separator", array(
	'type' => 'iconpicker',
	'heading' => esc_html__( 'Icon', 'wp-amilia' ),
	'param_name' => 'icon_fontawesome',
    'value' => '',
	'settings' => array(
		'emptyIcon' => true, // default true, display an "EMPTY" icon?
		'type' => 'fontawesome',
		'iconsPerPage' => 200, // default 100, how many icons per/page to display
	),
	'dependency' => array(
		'element' => 'icon_type',
		'value' => 'fontawesome',
	),
	'description' => esc_html__( 'Select icon from library.', 'wp-amilia' ),
	"group" => esc_html__("Templates", 'wp-amilia')
	/* End Icon */
));

vc_add_param("vc_separator", array(
	'type' => 'iconpicker',
	'heading' => esc_html__( 'Icon', 'wp-amilia' ),
	'param_name' => 'icon_lineaicon',
    'value' => '',
	'settings' => array(
		'emptyIcon' => true, // default true, display an "EMPTY" icon?
		'type' => 'lineaicon',
		'iconsPerPage' => 200, // default 100, how many icons per/page to display
	),
	'dependency' => array(
		'element' => 'icon_type',
		'value' => 'lineaicon',
	),
	'description' => esc_html__( 'Select icon from library.', 'wp-amilia' ),
	"group" => esc_html__("Templates", 'wp-amilia')
	/* End Icon */
));

vc_add_param("vc_separator", array(
	'type' => 'iconpicker',
	'heading' => esc_html__( 'Icon', 'wp-amilia' ),
	'param_name' => 'icon_glyphicon',
    'value' => '',
	'settings' => array(
		'emptyIcon' => true, // default true, display an "EMPTY" icon?
		'type' => 'glyphicon',
		'iconsPerPage' => 200, // default 100, how many icons per/page to display
	),
	'dependency' => array(
		'element' => 'icon_type',
		'value' => 'glyphicon',
	),
	'description' => esc_html__( 'Select icon from library.', 'wp-amilia' ),
	"group" => esc_html__("Templates", 'wp-amilia')
	/* End Icon */
));

vc_add_param("vc_separator", array(
	'type' => 'iconpicker',
	'heading' => esc_html__( 'Icon', 'wp-amilia' ),
	'param_name' => 'icon_elegant',
    'value' => '',
	'settings' => array(
		'emptyIcon' => true, // default true, display an "EMPTY" icon?
		'type' => 'elegant',
		'iconsPerPage' => 200, // default 100, how many icons per/page to display
	),
	'dependency' => array(
		'element' => 'icon_type',
		'value' => 'elegant',
	),
	'description' => esc_html__( 'Select icon from library.', 'wp-amilia' ),
	"group" => esc_html__("Templates", 'wp-amilia')
	/* End Icon */
));

vc_add_param("vc_separator", array(
	'type' => 'dropdown',
	'heading' => esc_html__( 'Divider Type', 'wp-amilia' ),
	'value' => array(
		esc_html__( 'Divider', 'wp-amilia' ) => 'divider',
		esc_html__( 'Hr', 'wp-amilia' ) => 'hr',
	),
	'param_name' => 'separator_type',
	'description' => '',
	"group" => esc_html__("Templates", 'wp-amilia')
));

vc_add_param("vc_separator", array(
	'type' => 'dropdown',
	'heading' => esc_html__( 'Hr Type', 'wp-amilia' ),
	'value' => array(
		esc_html__( 'Default', 'wp-amilia' ) => '',
		esc_html__( 'Hr short', 'wp-amilia' ) => 'short',
		esc_html__( 'Hr tall', 'wp-amilia' ) => 'tall',
		esc_html__( 'Hr taller', 'wp-amilia' ) => 'taller',
		esc_html__( 'Hr invisible', 'wp-amilia' ) => 'invisible',
	),
	'param_name' => 'separator_hr_type',
	'description' => '',
	"group" => esc_html__("Templates", 'wp-amilia'),
	'dependency' => array(
		'element' => 'separator_type',
		'value' => 'hr',
	)
));

vc_add_param("vc_separator", array(
	'type' => 'dropdown',
	'heading' => esc_html__( 'Hr Background Style', 'wp-amilia' ),
	'value' => array(
		esc_html__( 'Default', 'wp-amilia' ) => '',
		esc_html__( 'Gradient', 'wp-amilia' ) => 'gradient',
	),
	'param_name' => 'separator_hr_bg',
	'description' => 'Hr Background Style',
	"group" => esc_html__("Templates", 'wp-amilia'),
	'dependency' => array(
		'element' => 'separator_type',
		'value' => 'hr',
	)
));