<?php
vc_map(array(
    "name" => 'CMS Promo',
    "base" => "cms_promo",
    "icon" => "cs_icon_for_vc",
    "category" => esc_html__('CmsSuperheroes Shortcodes', 'wp-amilia'),
    "description" => esc_html__('Promo', 'wp-amilia'),
    "params" => array(
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Select shortcode type', 'wp-amilia' ),
            'param_name' => 'type',
            'value' => array(
                esc_html__( 'Promo', 'wp-amilia' ) => 'promo',
                esc_html__( 'Slogan', 'wp-amilia' ) => 'slogan',
            ),
            'description' => esc_html__( 'Select "animation in" for page transition.', 'wp-amilia' ),
        ),

        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Slogan text 1', 'wp-amilia' ),
            'param_name' => 'slogan_1',
            'std' => 'LOREM IPSUM|DOLOR',
            'description' => esc_html__( 'The text before | will has bold style', 'wp-amilia' ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'slogan',
            ),
            "group" => esc_html__("Slogan", 'wp-amilia')
        ),

        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Slogan text 2', 'wp-amilia' ),
            'param_name' => 'slogan_2',
            'std' => 'CONSECTETUR ADIPISCING ELIT',
            'dependency' => array(
                'element' => 'type',
                'value' => 'slogan',
            ),
            "group" => esc_html__("Slogan", 'wp-amilia')
        ),

         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Link target', 'wp-amilia' ),
            'param_name' => 'slogan_link',
            'std' => '',
            'dependency' => array(
                'element' => 'type',
                'value' => 'slogan',
            ),
            "group" => esc_html__("Slogan", 'wp-amilia')
        ),

        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Heading', 'wp-amilia' ),
            'admin_label' => true,
            'param_name' => 'heading',
            'value' => esc_html__( 'Hey! I am first heading line feel free to change me', 'wp-amilia' ),
            'description' => esc_html__( 'Enter text for heading line.', 'wp-amilia' ),
            'std' => '"Believe that life is worth living, and your belief will help create the fact"',
            'dependency' => array(
                'element' => 'type',
                'value' => 'promo',
            ),
            "group" => esc_html__("Promo", 'wp-amilia')
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Author', 'wp-amilia' ),
            'param_name' => 'author',
            'std' => 'William James',
            'dependency' => array(
                'element' => 'type',
                'value' => 'promo',
            ),
            "group" => esc_html__("Promo", 'wp-amilia')
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Sub text', 'wp-amilia' ),
            'param_name' => 'subtext',
            'std' => 'Philosopher and psychologist',
            'dependency' => array(
                'element' => 'type',
                'value' => 'promo',
            ),
            "group" => esc_html__("Promo", 'wp-amilia')
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'CSS Animation', 'wp-amilia' ),
            'param_name' => 'css_animation',
            'value' => amilia_animate_lib(),
            'description' => esc_html__( 'Select "animation in" for page transition.', 'wp-amilia' ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'promo',
            ),
            "group" => esc_html__("Promo", 'wp-amilia')
        ),
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => esc_html__("Animation Delay Time", 'wp-amilia'),
            "param_name" => "css_animation_delay",
            "value" => amilia_animate_time_delay_lib(),
            "description" => esc_html__('Animation Delay Time', 'wp-amilia'),
            'dependency' => array(
                'element' => 'type',
                'value' => 'promo',
            ),
            "group" => esc_html__("Promo", 'wp-amilia')
        ),
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => esc_html__("Duration Time", 'wp-amilia'),
            "param_name" => "css_duration",
            "value" => amilia_animate_time_delay_lib(),
            "description" => esc_html__('Duration Time', 'wp-amilia'),
            'dependency' => array(
                'element' => 'type',
                'value' => 'promo',
            ),
            "group" => esc_html__("Promo", 'wp-amilia')
        )
    )
));
class WPBakeryShortCode_cms_promo extends CmsShortCode
{
    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}
?>