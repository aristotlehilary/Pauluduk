<?php
vc_add_param("cms_grid", array(
	"type" => "dropdown",
    "class" => "",
    "heading" => esc_html__("Pricing Table Layout", 'wp-amilia'),
    "param_name" => "cms_pricing_layout",
    "value" => array(
    	"Pricing Layout 1" => "pr-default",
        "Pricing Layout 2" => "pr-layout-2",
        "Pricing Layout 2 & Animate" => "pr-layout-2 pr-pricing-animate",
    ),
    'dependency' => array(
		'element' => 'cms_template',
		'value' => 'cms_grid--pricing-layout-1.php',
	),
    "template" => array("cms_grid--pricing-layout-1.php"),
    "description" => esc_html__('Select Pricing Table Layout', 'wp-amilia'),
    "group" => esc_html__("Template", 'wp-amilia')
));
/* End option for pricing layout */

/* Option for team */
vc_add_param("cms_grid", array(
    "type" => "dropdown",
    "class" => "",
    "heading" => esc_html__("Thumbnail Image Size", 'wp-amilia'),
    "param_name" => "cms_team_thumb",
    'value' => array(
        esc_html__( 'Wide', 'wp-amilia' ) => 'default',
        esc_html__( 'Square', 'wp-amilia' ) => 'square',
    ),
    'dependency' => array(
        'element' => 'cms_template',
        'value' => array(
            'cms_grid--team.php'
        ),
    ),
    "template" => array(
        'cms_grid--team.php',
    ),
    "description" => esc_html__('Select thumbnail image size', 'wp-amilia'),
    "group" => esc_html__("Template", 'wp-amilia')
));
vc_add_param("cms_grid", array(
    'type' => 'checkbox',
    'heading' => esc_html__( 'Show description', 'wp-amilia' ),
    'param_name' => 'cms_team_desc',
    'std' => false,
    'description' => esc_html__( 'Show description of team member', 'wp-amilia' ),
    'dependency' => array(
        'element' => 'cms_template',
        'value' => array(
            'cms_grid--team.php'
        ),
    ),
    "group" => esc_html__("Template", 'wp-amilia')
));
/* End option for team */

/* Option for Portfolio */
vc_add_param("cms_grid", array(
    "type" => "textfield",
    "class" => "",
    "heading" => esc_html__("Gutter", 'wp-amilia'),
    "param_name" => "cms_portfolio_gutter",
    "value" => "",
    'dependency' => array(
        'element' => 'cms_template',
        'value' => array(
            'cms_grid--portfolio.php',
        ),
    ),
    "description" => esc_html__('Select guiter for masonry layout in pixel, default is 0px', 'wp-amilia'),
    "group" => esc_html__("Template", 'wp-amilia')
));

vc_add_param("cms_grid", array(
    "type" => "dropdown",
    "class" => "",
    "heading" => esc_html__("Thumbnail Image Size", 'wp-amilia'),
    "param_name" => "cms_portfolio_thumb",
    'value' => array(
        esc_html__( 'Wide', 'wp-amilia' ) => 'wide',
        esc_html__( 'Square', 'wp-amilia' ) => 'square',
        esc_html__( 'Fixed Width', 'wp-amilia' ) => 'fixed_w',
    ),
    'dependency' => array(
        'element' => 'cms_template',
        'value' => array(
            'cms_grid--portfolio.php',
        ),
    ),
    "template" => array(
        'cms_grid--portfolio.php',
    ),
    "description" => esc_html__('Select thumbnail image size', 'wp-amilia'),
    "group" => esc_html__("Template", 'wp-amilia')
));

vc_add_param("cms_grid", array(
    'type' => 'checkbox',
    'heading' => esc_html__( 'Show Pagination', 'wp-amilia' ),
    'param_name' => 'cms_port_navigation',
    'std' => false,
    'description' => esc_html__( 'Show portfolio navigation', 'wp-amilia' ),
    'dependency' => array(
        'element' => 'cms_template',
        'value' => array(
            'cms_grid--portfolio.php',
        ),
    ),
    "group" => esc_html__("Template", 'wp-amilia')
));

vc_add_param("cms_grid", array(
    'type' => 'textfield',
    'heading' => esc_html__( 'Heading', 'wp-amilia' ),
    'param_name' => 'grid_heading',
    'std' => '',
    'description' => esc_html__( 'Heading for this shortcode', 'wp-amilia' ),
    'dependency' => array(
        'element' => 'cms_template',
        'value' => array(
            'cms_grid--portfolio.php',
            'cms_grid--recentposts.php',
        ),
    ),
    "group" => esc_html__("Template", 'wp-amilia')
));

vc_add_param("cms_grid", array(
    'type' => 'checkbox',
    'heading' => esc_html__( 'Use View all button', 'wp-amilia' ),
    'param_name' => 'grid_vieall',
    'std' => false,
    'description' => esc_html__( 'Use custom View all button', 'wp-amilia' ),
    'dependency' => array(
        'element' => 'cms_template',
        'value' => array(
            'cms_grid--portfolio.php',
            'cms_grid--recentposts.php',
        ),
    ),
    "group" => esc_html__("Template", 'wp-amilia')
));

vc_add_param("cms_grid", array(
    'type' => 'textfield',
    'heading' => esc_html__( 'View all link', 'wp-amilia' ),
    'param_name' => 'grid_viewall_link',
    'std' => '',
    'description' => esc_html__( 'Custom link for View all button', 'wp-amilia' ),
    "group" => esc_html__("Template", 'wp-amilia'),
    'dependency' => array(
        'element' => 'grid_vieall',
        'value' => "true"
    ),
));
/* End option for Portfolio */

$params = array(
    array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Blog layout', 'wp-amilia' ),
        'param_name' => 'cms_blog_layout',
        'description' => esc_html__( 'Select blog layout, only blog masonry layout can apply Grid Setting', 'wp-amilia' ),
        'value' => array(
            esc_html__( 'Default Layout', 'wp-amilia' ) => 'default',
            esc_html__( 'Small Thumbnail', 'wp-amilia' ) => 'small-thumb',
            esc_html__( 'Full width', 'wp-amilia' ) => 'fullwidth',
            esc_html__( 'Masonry', 'wp-amilia' ) => 'masonry',
        ),
        "template" => array(
            'cms_grid.php',
        ),
        "group" => esc_html__("Template", 'wp-amilia')
    ),

    array(
        'type' => 'checkbox',
        'heading' => esc_html__( 'Show Pagination', 'wp-amilia' ),
        'param_name' => 'cms_blog_navigation',
        'std' => true,
        'description' => esc_html__( 'Show blog navigation', 'wp-amilia' ),
        'dependency' => array(
            'element' => 'cms_template',
            'value' => array(
                'cms_grid.php',
            ),
        ),
        "group" => esc_html__("Template", 'wp-amilia')
    )
);

/* Animate for Team, */
vc_add_param("cms_grid", array(
    'type' => 'dropdown',
    'heading' => esc_html__( 'CSS Animation', 'wp-amilia' ),
    'param_name' => 'css_animation',
    'value' => amilia_animate_lib(),
    'description' => esc_html__( 'Select "animation in" for page transition.', 'wp-amilia' ),
    'dependency' => array(
        'element' => 'cms_template',
        'value' => array(
            'cms_grid--team.php'
        ),
    ),
    "group" => esc_html__("Template", 'wp-amilia')
));

vc_add_param("cms_grid", array(
    "type" => "dropdown",
    "class" => "",
    "heading" => esc_html__("Animation Delay Time", 'wp-amilia'),
    "param_name" => "css_animation_delay",
    "value" => amilia_animate_time_delay_lib(),
    'dependency' => array(
        'element' => 'cms_template',
        'value' => array(
            'cms_grid--team.php'
        ),
    ),
    "description" => esc_html__('Animation Delay Time', 'wp-amilia'),
    "group" => esc_html__("Template", 'wp-amilia')
));

vc_add_param("cms_grid", array(
    "type" => "dropdown",
    "class" => "",
    "heading" => esc_html__("Duration Time", 'wp-amilia'),
    "param_name" => "css_duration",
    "value" => amilia_animate_time_delay_lib(),
    'dependency' => array(
        'element' => 'cms_template',
        'value' => array(
            'cms_grid--team.php'
        ),
    ),
    "description" => esc_html__('Duration Time', 'wp-amilia'),
    "group" => esc_html__("Template", 'wp-amilia')
));

/* For Company timeline */
vc_add_param("cms_grid", array(
    'type' => 'textfield',
    'heading' => esc_html__( 'Heading for start', 'wp-amilia' ),
    'param_name' => 'timeline_start',
    'std' => 'START COMPANY',
    'description' => esc_html__( 'Heading for company start', 'wp-amilia' ),
    "group" => esc_html__("Template", 'wp-amilia'),
    'dependency' => array(
        'element' => 'cms_template',
        'value' => 'cms_grid--timeline.php'
    ),
));

vc_add_param("cms_grid", array(
    'type' => 'textfield',
    'heading' => esc_html__( 'Heading for recent', 'wp-amilia' ),
    'param_name' => 'timeline_recent',
    'std' => 'RECENT DAY',
    'description' => esc_html__( 'Heading for company start', 'wp-amilia' ),
    "group" => esc_html__("Template", 'wp-amilia'),
    'dependency' => array(
        'element' => 'cms_template',
        'value' => 'cms_grid--timeline.php'
    ),
));