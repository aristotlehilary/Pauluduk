<?php
vc_map(array(
    "name" => 'CMS Callout',
    "base" => "cms_callout",
    "icon" => "cs_icon_for_vc",
    "category" => esc_html__('CmsSuperheroes Shortcodes', 'wp-amilia'),
    "description" => esc_html__('Callout', 'wp-amilia'),
    "params" => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Heading', 'wp-amilia' ),
            'admin_label' => true,
            'param_name' => 'h2',
            'value' => esc_html__( 'Hey! I am first heading line feel free to change me', 'wp-amilia' ),
            'description' => esc_html__( 'Enter text for heading line.', 'wp-amilia' )
        ),
        array(
            'type' => 'textarea',
            'heading' => esc_html__( 'Text', 'wp-amilia' ),
            'param_name' => 'content',
            'value' => esc_html__( 'I am promo text. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'wp-amilia' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Style', 'wp-amilia' ),
            'description' => esc_html__( 'Select Cta display style.', 'wp-amilia' ),
            'param_name' => 'style',
            'value' => array(
                esc_html__( 'Default', 'wp-amilia' ) => 'default',
                esc_html__( 'Animate', 'wp-amilia' ) => 'animate',
            ),
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Add button?', 'wp-amilia' ),
            'param_name' => 'add_button',
            'value' => '',
            'sdt' => true,
        ),
        array(
            'type' => 'vc_link',
            'heading' => esc_html__( 'URL (Link)', 'wp-amilia' ),
            'param_name' => 'link',
            'description' => esc_html__( 'Add link to button.', 'wp-amilia' ),
            'dependency' => array(
                'element' => 'add_button',
                'value' => "true"
            ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Button Text', 'wp-amilia' ),
            'param_name' => 'button_text',
            'value' => esc_html__( 'Text on the button', 'wp-amilia' ),
            'description' => esc_html__( 'Enter text on the button.', 'wp-amilia' ),
            'dependency' => array(
                'element' => 'add_button',
                'value' => "true"
            ),
        ),
    )
));
class WPBakeryShortCode_cms_callout extends CmsShortCode
{
    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}
?>