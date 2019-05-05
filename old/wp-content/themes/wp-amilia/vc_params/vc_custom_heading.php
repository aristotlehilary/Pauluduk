<?php
vc_add_param("vc_custom_heading", array(
    "type" => "dropdown",
    "class" => "",
    "heading" => esc_html__("Custom Heading Type", 'wp-amilia'),
    "admin_label" => true,
    "param_name" => "cms_custom_headding_type",
    "value" => array(
        "Default" => "",
        "Heading with line" => "heading-line",
        "Heading with underline" => "heading-underline",
        "Heading with background boxed" => "heading-with-bg",
        "Heading with background, overlay " => "heading-with-bg-overlay",
        "Heading with background, overlay and line" => "heading-with-bg-overlay has-line",
    ),
    "description" => esc_html__('Select custom heading type', 'wp-amilia'),
    "group" => esc_html__("CMS Custom", 'wp-amilia')
));

vc_add_param("vc_custom_heading", array(
    'type' => 'checkbox',
    'heading' => esc_html__( 'Display Block ?', 'wp-amilia' ),
    'param_name' => 'cms_heading_block',
    'description' => esc_html__( 'Set heading display block, default is inline-block', 'wp-amilia' ),
    "group" => esc_html__("CMS Custom", 'wp-amilia'),
    'std' => false,
));

vc_add_param("vc_custom_heading", array(
    'type' => 'textfield',
    'heading' => esc_html__( 'Letter Spacing', 'wp-amilia' ),
    'param_name' => 'cms_heading_letter_spacing',
    'description' => esc_html__( 'Letter Spacing - in em, pixel', 'wp-amilia' ),
    "group" => esc_html__("CMS Custom", 'wp-amilia')
));