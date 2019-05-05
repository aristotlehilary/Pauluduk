<?php
vc_map(array(
    "name" => 'CMS Landing Item',
    "base" => "cms_landing_item",
    "icon" => "cs_icon_for_vc",
    "category" => esc_html__('CmsSuperheroes Shortcodes', 'wp-amilia'),
    "description" => esc_html__('Landing Item, suitable for Landing Page', 'wp-amilia'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => esc_html__( 'Title', 'wp-amilia' ),
            "param_name" => "landing_title",
            "value" => '',
            'admin_label' => true,
        ),
        array (
            "type" => "attach_image",
            "heading" => esc_html__("Image thumbnail",'wp-amilia'),
            "param_name" => "image_thumbnail",
            "description" => esc_html__("Thumbnail landing item", 'wp-amilia')
        ),
        array(
            'type' => 'vc_link',
            'heading' => esc_html__( 'URL (Link) - link', 'wp-amilia' ),
            'param_name' => 'link',
            'description' => esc_html__( 'Add link to button.', 'wp-amilia' )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__( "Extra class name", "wp-amilia" ),
            "param_name" => "el_class",
            "description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "wp-amilia" )
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'CSS Animation', 'wp-amilia' ),
            'param_name' => 'css_animation',
            'value' => amilia_animate_lib(),
            'description' => esc_html__( 'Select "animation in" for page transition.', 'wp-amilia' ),
        ),
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => esc_html__("Animation Delay Time", 'wp-amilia'),
            "param_name" => "css_animation_delay",
            "value" => array(
                'None' => '0ms',
                '200ms' => '200ms',
                '400ms' => '400ms',
                '600ms' => '600ms',
                '800ms' => '800ms',
                '1000ms' => '1000ms',
            ),
            "description" => esc_html__('Animation Delay Time', 'wp-amilia'),
        ),
    )
));

class WPBakeryShortCode_cms_landing_item extends CmsShortCode
{
    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}