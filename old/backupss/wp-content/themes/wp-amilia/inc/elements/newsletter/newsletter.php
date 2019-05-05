<?php
vc_map(array(
    "name" => 'CMS Newsletter',
    "base" => "cms_newsletter",
    "icon" => "cs_icon_for_vc",
    "category" => esc_html__('CmsSuperheroes Shortcodes', 'wp-amilia'),
    "description" => esc_html__('Newsletter', 'wp-amilia'),
    "params" => array(
    	array(
    		'type' => 'textfield',
	        'heading' => esc_html__( 'Heading 1', 'wp-amilia' ),
	        'admin_label' => true,
	        'param_name' => 'step_heading_1',
	        'value' => '',
	        'description' => esc_html__( 'There are no option for this shortcode, so you need install Newsletter plugin before', 'wp-amilia' ),
    	) 
    )
));

class WPBakeryShortCode_cms_newsletter extends CmsShortCode
{
    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}
?>
