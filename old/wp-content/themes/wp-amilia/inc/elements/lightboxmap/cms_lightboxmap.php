<?php
vc_map(array(
    "name" => 'CMS Lightbox Map',
    "base" => "cms_lightboxmap",
    "icon" => "cs_icon_for_vc",
    "category" => esc_html__('CmsSuperheroes Shortcodes', 'wp-amilia'),
    "description" => esc_html__('Lightbox Map', 'wp-amilia'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __ ( 'Map Link', 'wp-amilia' ),
            "param_name" => "map_link",
            "value" => ''
        ),
        array (
            "type" => "attach_image",
            "heading" => esc_html__("Image thumbnail",'wp-amilia'),
            "param_name" => "image_thumbnail",
            "description" => esc_html__("Thumbnail for video", 'wp-amilia')
        ),
        array(
            "type" => "textfield",
            "heading" => __ ( "Extra class name", 'wp-amilia' ),
            "param_name" => "el_class",
            "description" => __ ( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'wp-amilia' )
        )
    )
));
class WPBakeryShortCode_cms_lightboxmap extends CmsShortCode
{
    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}
?>