<?php
vc_remove_param('cms_fancybox_single', 'title');
vc_remove_param('cms_fancybox_single', 'description');
vc_remove_param('cms_fancybox_single', 'content_align');
vc_remove_param('cms_fancybox_single', 'image');
vc_remove_param('cms_fancybox_single', 'button_type');
vc_remove_param('cms_fancybox_single', 'button_link');
vc_remove_param('cms_fancybox_single', 'button_text');

vc_add_param('cms_fancybox_single', array(
    "type" => "textfield",
    "heading" => esc_html__("Title Item",'wp-amilia'),
    "param_name" => "title_item",
    "value" => "",
    "description" => esc_html__("Title Of Item",'wp-amilia'),
));

vc_add_param('cms_fancybox_single', array(
    "type" => "textarea",
    "heading" => esc_html__("Content Item",'wp-amilia'),
    "param_name" => "description_item",
));

vc_add_param('cms_fancybox_single', array(
    "type" => "textfield",
    "heading" => esc_html__("Extra Class",'wp-amilia'),
    "param_name" => "class",
    "value" => "",
    "description" => esc_html__("",'wp-amilia'),
    "group" => esc_html__("Template", 'wp-amilia'),
));

/* Start Icon */
vc_add_param('cms_fancybox_single', array(
    'type' => 'dropdown',
    'heading' => esc_html__( 'Icon library', 'wp-amilia' ),
    'param_name' => 'icon_type',
    'value' => array(
        esc_html__( 'Font Awesome', 'wp-amilia' ) => 'fontawesome',
        esc_html__( 'Elegant Icon', 'wp-amilia' ) => 'elegant',
        esc_html__( 'P7 Stroke', 'wp-amilia' ) => 'pe7stroke',
    ),
    'description' => esc_html__( 'Select icon library.', 'wp-amilia' ),
    "group" => esc_html__("Icon Settings", 'wp-amilia')
));

vc_add_param('cms_fancybox_single', array(
    'type' => 'iconpicker',
    'heading' => esc_html__( 'Icon Item', 'wp-amilia' ),
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
    "group" => esc_html__("Icon Settings", 'wp-amilia')
));

vc_add_param('cms_fancybox_single', array(
    'type' => 'iconpicker',
    'heading' => esc_html__( 'Icon Item', 'wp-amilia' ),
    'param_name' => 'icon_pe7stroke',
    'value' => '',
    'settings' => array(
        'emptyIcon' => true, // default true, display an "EMPTY" icon?
        'type' => 'pe7stroke',
        'iconsPerPage' => 200, // default 100, how many icons per/page to display
    ),
    'dependency' => array(
        'element' => 'icon_type',
        'value' => 'pe7stroke',
    ),
    'description' => esc_html__( 'Select icon from library.', 'wp-amilia' ),
    "group" => esc_html__("Icon Settings", 'wp-amilia')
));

vc_add_param('cms_fancybox_single', array(
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
    "group" => esc_html__("Icon Settings", 'wp-amilia')
));

vc_add_param('cms_fancybox_single', array(
    "type" => "cms_template",
    "param_name" => "cms_template",
    "admin_label" => false,
    "heading" => esc_html__("Shortcode Template",'wp-amilia'),
    "shortcode" => "cms_fancybox_single",
    "group" => esc_html__("Template", 'wp-amilia'),
));

vc_add_param("cms_fancybox_single", array(
    'type' => 'dropdown',
    'heading' => esc_html__( 'CSS Animation', 'wp-amilia' ),
    'param_name' => 'css_animation',
    'value' => amilia_animate_lib(),
    'description' => esc_html__( 'Select "animation in" for page transition.', 'wp-amilia' ),
    "group" => esc_html__("Template", 'wp-amilia')
));

vc_add_param("cms_fancybox_single", array(
    "type" => "dropdown",
    "class" => "",
    "heading" => esc_html__("Animation Delay Time", 'wp-amilia'),
    "param_name" => "css_animation_delay",
    "value" => amilia_animate_time_delay_lib(),
    "description" => esc_html__('Animation Delay Time', 'wp-amilia'),
    "group" => esc_html__("Template", 'wp-amilia')
));

vc_add_param("cms_fancybox_single", array(
    "type" => "dropdown",
    "class" => "",
    "heading" => esc_html__("Duration Time", 'wp-amilia'),
    "param_name" => "css_duration",
    "value" => amilia_animate_time_delay_lib(),
    "description" => esc_html__('Duration Time', 'wp-amilia'),
    "group" => esc_html__("Template", 'wp-amilia')
));

$params = array(
    array(
        'type' => 'img',
        'admin_label' => true,
        'heading' => esc_html__( 'Fancy Style', 'wp-amilia' ),
        'value' => array(
            'style1' => get_template_directory_uri().'/vc_params/single-fancy/fancy-style1.png',
            'style2' => get_template_directory_uri().'/vc_params/single-fancy/fancy-style2.png',
            'style3' => get_template_directory_uri().'/vc_params/single-fancy/fancy-style3.png',
            'style4' => get_template_directory_uri().'/vc_params/single-fancy/fancy-style4.png',
            'style5' => get_template_directory_uri().'/vc_params/single-fancy/fancy-style5.png',
            'style6' => get_template_directory_uri().'/vc_params/single-fancy/fancy-style6.png',
            'style7' => get_template_directory_uri().'/vc_params/single-fancy/fancy-style7.png',
            'style8' => get_template_directory_uri().'/vc_params/single-fancy/fancy-style8.png',
            'style9' => get_template_directory_uri().'/vc_params/single-fancy/fancy-style9.png',
        ),
        'param_name' => 'fancy_style',
        'description' => esc_html__( 'Select fancy style.', 'wp-amilia' ),
        'weight' => 1,
        "group" => esc_html__("Template", 'wp-amilia'),
    ),
    array(
        'type' => 'checkbox',
        'heading' => esc_html__( 'Use Hover Effect', 'wp-amilia' ),
        'param_name' => 'hover_effect',
        'std' => false,
        'description' => esc_html__( 'Use hover effect', 'wp-amilia' ),
        'weight' => 1,
        'dependency' => array(
            'element' => 'fancy_style',
            'value' => array(
                'style1',
                'style4',
            ),
        ),
        "group" => esc_html__("Template", 'wp-amilia'),
    )
);