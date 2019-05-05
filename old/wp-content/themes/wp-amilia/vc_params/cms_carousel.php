<?php
/* Heading and next, prev button */
vc_add_param("cms_carousel", array(
    'type' => 'textfield',
    'heading' => esc_html__( 'Heading', 'wp-amilia' ),
    'param_name' => 'carousel_heading',
    'std' => '',
    'description' => esc_html__( 'Heading for carousel', 'wp-amilia' ),
    'dependency' => array(
        'element' => 'cms_template',
        'value' => array(
            'cms_carousel--portfolio.php',
            'cms_carousel--recentposts.php',
        ),
    ),
    "group" => esc_html__("Template", 'wp-amilia')
));
vc_add_param("cms_carousel", array(
    'type' => 'checkbox',
    'heading' => esc_html__( 'Use View all button', 'wp-amilia' ),
    'param_name' => 'carousel_vieall',
    'std' => false,
    'description' => esc_html__( 'Use custom View all button', 'wp-amilia' ),
    'dependency' => array(
        'element' => 'cms_template',
        'value' => array(
            'cms_carousel--portfolio.php',
            'cms_carousel--recentposts.php',
        ),
    ),
    "group" => esc_html__("Template", 'wp-amilia')
));
vc_add_param("cms_carousel", array(
    'type' => 'textfield',
    'heading' => esc_html__( 'View all link', 'wp-amilia' ),
    'param_name' => 'carousel_viewall_link',
    'std' => '',
    'description' => esc_html__( 'Custom link for View all button', 'wp-amilia' ),
    "group" => esc_html__("Template", 'wp-amilia'),
    'dependency' => array(
        'element' => 'cms_template',
        'value' => array(
            'cms_carousel--portfolio.php',
            'cms_carousel--recentposts.php',
        ),
    ),
    'dependency' => array(
        'element' => 'carousel_vieall',
        'value' => "true"
    ),
));

/* Recent post */
vc_add_param("cms_carousel", array(
    'type' => 'checkbox',
    'heading' => esc_html__( 'Hide feature thumbnail', 'wp-amilia' ),
    'param_name' => 'hide_feature_thum',
    'std' => false,
    'description' => esc_html__( 'Hide feature thumbnail when you enable this option', 'wp-amilia' ),
    'dependency' => array(
        'element' => 'cms_template',
        'value' => array(
            'cms_carousel--recentposts.php',
        ),
    ),
    "group" => esc_html__("Template", 'wp-amilia')
));

/* Testimonial background config */
vc_add_param("cms_carousel", array(
    'type' => 'colorpicker',
    'heading' => esc_html__( 'Content background', 'wp-amilia' ),
    'param_name' => 'testimonial_bg',
    'std' => '#eee',
    'description' => esc_html__( 'Content background of testimonial', 'wp-amilia' ),
    'dependency' => array(
        'element' => 'cms_template',
        'value' => array(
            'cms_carousel--layout-testimonial-1.php',
        ),
    ),
    "group" => esc_html__("Template", 'wp-amilia')
));

/* Animate */
vc_add_param("cms_carousel", array(
    'type' => 'dropdown',
    'heading' => esc_html__( 'CSS Animation', 'wp-amilia' ),
    'param_name' => 'css_animation',
    'value' => amilia_animate_lib(),
    'description' => esc_html__( 'Select "animation in" for page transition.', 'wp-amilia' ),
    'dependency' => array(
        'element' => 'cms_template',
        'value' => "cms_carousel--team.php"
    ),
    "group" => esc_html__("Template", 'wp-amilia')
));