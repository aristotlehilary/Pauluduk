<?php
vc_map(array(
    "name" => 'CMS Dropcaps',
    "base" => "cms_dropcaps",
    "icon" => "cs_icon_for_vc",
    "category" => esc_html__('CmsSuperheroes Shortcodes', 'wp-amilia'),
    "description" => esc_html__('Dropcap', 'wp-amilia'),
    "params" => array(
        array(
                "type" => "textarea",
                "heading" => __ ( 'Content', 'wp-amilia' ),
                "param_name" => "dropcap_content",
                "value" => ''
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Dropcap Box",'wp-amilia'),
            "param_name" => "dropcap_box",
            "value" => array(
                "No" => "",
                "Yes" => "yes"
            )
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Dropcap Type",'wp-amilia'),
            "param_name" => "dropcap_type",
            "value" => array(
                "Square" => "square",
                "Circle" => "circle"
            ),
            'dependency' => array(
                'element' => 'dropcap_box',
                'value' => 'yes',
            ),
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Dropcap Box Color",'wp-amilia'),
            "param_name" => "dropcap_box_color",
            "value" => "",
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Dropcap Box Background",'wp-amilia'),
            "param_name" => "dropcap_box_bg",
            "value" => "",
            'dependency' => array(
                'element' => 'dropcap_box',
                'value' => 'yes',
            ),
        ),
        array(
            "type" => "textfield",
            "heading" => __ ( "Extra class name", "wp-amilia" ),
            "param_name" => "el_class",
            "description" => __ ( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'wp-amilia' )
        )
    )
));
class WPBakeryShortCode_cms_dropcaps extends CmsShortCode
{
    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}
?>