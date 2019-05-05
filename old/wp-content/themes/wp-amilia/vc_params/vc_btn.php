<?php
vc_remove_param( "vc_btn", "shape" );
vc_remove_param( "vc_btn", "i_align" );

vc_add_param("vc_btn", array(
	'type' => 'checkbox',
	'heading' => esc_html__( 'Add icon?', 'wp-amilia' ),
	'param_name' => 'add_icon',
	'dependency' => array(
		'element' => 'style',
		'value' => array('cms-has-icon', 'cms-animatin'),
	),
));

vc_add_param("vc_btn", array(
	'type' => 'dropdown',
	'param_name' => 'style',
	'value' => array(
		esc_html__( 'Default Button', 'wp-amilia' ) => 'cms-default',
		esc_html__( 'Border Button', 'wp-amilia' ) => 'cms-border',
		esc_html__( 'Button with border hover', 'wp-amilia' ) => 'cms-border-hover',
		esc_html__( 'Button with icon', 'wp-amilia' ) => 'cms-has-icon',
		esc_html__( 'Button with animatin', 'wp-amilia' ) => 'cms-animatin',
	),
	'heading' => esc_html__( 'Style', 'wp-amilia' ),
	'description' => esc_html__( 'Select accordion display style.', 'wp-amilia' ),
));

vc_add_param("vc_btn", array(
	'type' => 'dropdown',
	'heading' => esc_html__( 'Color', 'wp-amilia' ),
	'param_name' => 'color',
	'description' => esc_html__( 'Select button color.', 'wp-amilia' ),
	'param_holder_class' => 'vc_colored-dropdown vc_btn3-colored-dropdown',
	'value' => array(
           esc_html__( 'Yellow', 'wp-amilia' ) => 'default',
           esc_html__( 'Gray', 'wp-amilia' ) => 'gray',
           esc_html__( 'Cyan', 'wp-amilia' ) => 'cyan',
           esc_html__( 'Blue', 'wp-amilia' ) => 'blue',
           esc_html__( 'Teal', 'wp-amilia' ) => 'teal',
           esc_html__( 'Green', 'wp-amilia' ) => 'green',
           esc_html__( 'Lime', 'wp-amilia' ) => 'lime',
           esc_html__( 'Deeporange', 'wp-amilia' ) => 'deeporange',
           //esc_html__( 'White', 'wp-amilia' ) => 'white',
           esc_html__( 'Gray Light', 'wp-amilia' ) => 'gray-light',
           esc_html__( 'Gray Light Gr', 'wp-amilia' ) => 'gray-light-gr',
       ),
	'std' => '',
	'dependency' => array(
		'element' => 'style',
		'value' => array(
			'cms-default',
			'cms-border',
			'cms-border-hover',
			'cms-has-icon',
			'cms-animatin',
		),
	),
));

vc_add_param("vc_btn", array(
	'type' => 'dropdown',
	'heading' => esc_html__( 'Size', 'wp-amilia' ),
	'param_name' => 'size',
	'description' => esc_html__( 'Select button display size.', 'wp-amilia' ),
	'std' => 'md',
	'value' => array(
		esc_html__( 'Large', 'wp-amilia' ) => 'lg',
		esc_html__( 'Medium', 'wp-amilia' ) => 'md',
		esc_html__( 'Small', 'wp-amilia' ) => 'sm',
		esc_html__( 'Thin', 'wp-amilia' ) => 'thin',
	)
));

vc_add_param("vc_btn", array(
	'type' => 'dropdown',
	'heading' => esc_html__( 'Animate for icon', 'wp-amilia' ),
	'param_name' => 'css_animation',
	'description' => esc_html__( 'Select button color.', 'wp-amilia' ),
	'value' => array(
           // Btn1 Colors
           esc_html__( 'No', 'wp-amilia' ) => '',
           esc_html__( 'From Top', 'wp-amilia' ) => 'from-top',
           esc_html__( 'From Left', 'wp-amilia' ) => 'from-left',
           esc_html__( 'Right Our', 'wp-amilia' ) => 'right-out',
           esc_html__( 'Right In', 'wp-amilia' ) => 'right-in',
           esc_html__( 'Fade in', 'wp-amilia' ) => 'fade-in',
           esc_html__( 'Fade out', 'wp-amilia' ) => 'fade-out',
           esc_html__( 'Left In', 'wp-amilia' ) => 'hide-left-in',
       ),
	'std' => '',
	'dependency' => array(
		'element' => 'style',
		'value' => array('cms-animatin'),
	),
));

vc_add_param("vc_btn", array(
	'type' => 'checkbox',
	'heading' => esc_html__( 'Block button', 'wp-amilia' ),
	'param_name' => 'set_block',
	'std' => false,
));

vc_add_param("vc_btn", array(
	'type' => 'dropdown',
	'heading' => esc_html__( 'Special hover', 'wp-amilia' ),
	'param_name' => 'set_bg_when_hover',
	'description' => esc_html__( 'Select special background color when hover button.', 'wp-amilia' ),
	'value' => array(
		esc_html__( 'Default', 'wp-amilia' ) => '',
		esc_html__( 'Dark color', 'wp-amilia' ) => 'set-dark-bg-hover',
		esc_html__( 'Primary color', 'wp-amilia' ) => 'set-primary-bg-hover',
	)
));