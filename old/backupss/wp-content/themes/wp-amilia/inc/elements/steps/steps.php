<?php
vc_map(array(
    "name" => 'CMS Steps',
    "base" => "cms_steps",
    "icon" => "cs_icon_for_vc",
    "category" => esc_html__('CmsSuperheroes Shortcodes', 'wp-amilia'),
    "description" => esc_html__('List Steps', 'wp-amilia'),
    "params" => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Heading 1', 'wp-amilia' ),
            'admin_label' => true,
            'param_name' => 'step_heading_1',
            'value' => '',
            'description' => esc_html__( 'Enter text for heading step 1.', 'wp-amilia' )
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Heading 2', 'wp-amilia' ),
            'admin_label' => true,
            'param_name' => 'step_heading_2',
            'value' => '',
            'description' => esc_html__( 'Enter text for heading step 2.', 'wp-amilia' )
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Heading 3', 'wp-amilia' ),
            'admin_label' => true,
            'param_name' => 'step_heading_3',
            'value' => '',
            'description' => esc_html__( 'Enter text for heading step 3.', 'wp-amilia' )
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Final Heading', 'wp-amilia' ),
            'admin_label' => true,
            'param_name' => 'step_heading_4',
            'value' => '',
            'description' => esc_html__( 'Enter text for heading final step.', 'wp-amilia' )
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Final Icon', 'wp-amilia' ),
            'param_name' => 'icon_elegant',
            'value' => 'icon_cart_alt',
            'settings' => array(
                'emptyIcon' => true, // default true, display an "EMPTY" icon?
                'type' => 'elegant',
                'iconsPerPage' => 200, // default 100, how many icons per/page to display
            ),
            'description' => esc_html__( 'Select icon from library.', 'wp-amilia' ),
            "group" => esc_html__("Icon Settings", 'wp-amilia')
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Link to final step', 'wp-amilia' ),
            'admin_label' => true,
            'param_name' => 'link_final',
            'value' => '',
            'description' => esc_html__( 'Enter link for final step.', 'wp-amilia' )
        ),
    )
));
class WPBakeryShortCode_cms_steps extends CmsShortCode
{
    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}
?>
