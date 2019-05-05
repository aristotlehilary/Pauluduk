<?php
vc_map(array(
    "name" => 'CMS Process',
    "base" => "cms_progress",
    "icon" => "cs_icon_for_vc",
    "category" => esc_html__('CmsSuperheroes Shortcodes', 'wp-amilia'),
    "description" => esc_html__('Process', 'wp-amilia'),
    "params" => array(
        //Step 1
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Heading 1', 'wp-amilia' ),
            'param_name' => 'step_heading_1',
            'value' => '',
            'description' => esc_html__( 'Enter text for heading step 1.', 'wp-amilia' ),
            'std' => 'Heading 1',
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Icon 1', 'wp-amilia' ),
            'param_name' => 'icon_1',
            'value' => 'icon_lightbulb_alt',
            'settings' => array(
                'emptyIcon' => true, // default true, display an "EMPTY" icon?
                'type' => 'elegant',
                'iconsPerPage' => 200, // default 100, how many icons per/page to display
            ),
            'description' => esc_html__( 'Select icon from library.', 'wp-amilia' ),
        ),

        //Step 2
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Heading 2', 'wp-amilia' ),
            'param_name' => 'step_heading_2',
            'value' => '',
            'description' => esc_html__( 'Enter text for heading step 2.', 'wp-amilia' ),
            'std' => 'Heading 2',
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Icon 2', 'wp-amilia' ),
            'param_name' => 'icon_2',
            'value' => 'icon_pens',
            'settings' => array(
                'emptyIcon' => true, // default true, display an "EMPTY" icon?
                'type' => 'elegant',
                'iconsPerPage' => 200, // default 100, how many icons per/page to display
            ),
            'description' => esc_html__( 'Select icon from library.', 'wp-amilia' ),
        ),

        //Step 3
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Heading 3', 'wp-amilia' ),
            'param_name' => 'step_heading_3',
            'value' => '',
            'std' => 'Heading 3',
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Icon 3', 'wp-amilia' ),
            'param_name' => 'icon_3',
            'value' => 'icon_cog',
            'settings' => array(
                'emptyIcon' => true, // default true, display an "EMPTY" icon?
                'type' => 'elegant',
                'iconsPerPage' => 200, // default 100, how many icons per/page to display
            ),
            'description' => esc_html__( 'Select icon from library.', 'wp-amilia' ),
        ),

        //Step 4
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Heading 4', 'wp-amilia' ),
            'param_name' => 'step_heading_4',
            'value' => '',
            'std' => 'Heading 4',
            'description' => esc_html__( 'Enter text for heading step 4.', 'wp-amilia' )
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Icon 4', 'wp-amilia' ),
            'param_name' => 'icon_4',
            'value' => 'icon_archive_alt',
            'settings' => array(
                'emptyIcon' => true, // default true, display an "EMPTY" icon?
                'type' => 'elegant',
                'iconsPerPage' => 200, // default 100, how many icons per/page to display
            ),
            'description' => esc_html__( 'Select icon from library.', 'wp-amilia' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'CSS Animation', 'wp-amilia' ),
            'param_name' => 'css_animation',
            'value' => amilia_animate_lib(),
            'description' => esc_html__( 'Select "animation in" for page transition.', 'wp-amilia' ),
        )
    )
));
class WPBakeryShortCode_cms_progress extends CmsShortCode
{
    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}
?>