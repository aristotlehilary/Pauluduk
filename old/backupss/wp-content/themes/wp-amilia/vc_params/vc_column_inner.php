<?php
vc_add_param("vc_column_inner", array(
    'type' => 'dropdown',
    'heading' => esc_html__( 'CSS Animation', 'wp-amilia' ),
    'param_name' => 'css_animation',
    'value' => amilia_animate_lib(),
    'description' => esc_html__( 'Select "animation in" for page transition.', 'wp-amilia' ),
));

vc_add_param("vc_column_inner", array(
    "type" => "dropdown",
    "class" => "",
    "heading" => esc_html__("Animation Delay Time", 'wp-amilia'),
    "param_name" => "css_animation_delay",
    "value" => amilia_animate_time_delay_lib(),
    "description" => esc_html__('Animation Delay Time', 'wp-amilia'),
));

vc_add_param("vc_column_inner", array(
    "type" => "dropdown",
    "class" => "",
    "heading" => esc_html__("Duration Time", 'wp-amilia'),
    "param_name" => "css_duration",
    "value" => amilia_animate_time_delay_lib(),
    "description" => esc_html__('Duration Time', 'wp-amilia'),
));