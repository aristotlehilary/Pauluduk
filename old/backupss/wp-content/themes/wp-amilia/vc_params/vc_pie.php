<?php
vc_add_param("vc_pie", array(
    'type' => 'colorpicker',
    'heading' => esc_html__('Bar color', 'wp-amilia'),
    'param_name' => 'color',
    'value' => '',
    'description' => esc_html__('Select pie chart background color.', 'wp-amilia'),
));
vc_add_param("vc_pie", array(
    'type' => 'colorpicker',
    'heading' => esc_html__('Value background color', 'wp-amilia'),
    'param_name' => 'value_color',
    'value' => '',
    'description' => esc_html__('Select pie chart background color.', 'wp-amilia'),
));