<?php

/**
 * Array presets.
 * 
 * @return multitype:multitype:string
 * @author Fox
 */
function cms_presets()
{
    return array(
        'primary_color',
        'secondary_color',
        'heading_color',
        'link_color',
        'link_color_hover',
        'text_color',
    );
}

/**
 * Load presets script.
 */
add_action('admin_enqueue_scripts', 'cms_presets_scripts');

function cms_presets_scripts()
{
    if (isset($_REQUEST['page']) && $_REQUEST['page'] == '_options') {
        wp_register_script('cmssuperheroes-presets', get_template_directory_uri() . '/inc/options/js/presets.js', 'jquery', '1.0.0', TRUE);
        wp_localize_script('cmssuperheroes-presets', 'data_presets', cms_presets());
        wp_enqueue_script('cmssuperheroes-presets');
    }
}

/**
 * Redux saved.
 * Save options generate presets.
 *
 * @author Fox
 */

add_action("redux/options/smof_data/saved", 'cms_preset_save_options');

function cms_preset_save_options()
{
    global $smof_data;
    
    $theme_info = wp_get_theme();
    
    if (isset($smof_data['presets_color'])) {
        
        $preset_name = "_" . $theme_info->get("TextDomain") . "_preset_" . $smof_data['presets_color'];
        
        $preset_data = array();
        
        $preset_items = cms_presets();
        foreach ($preset_items as $value) {
            $preset_data[$value] = $smof_data[$value];
        }
        
        $preset_data = json_encode($preset_data);
        
        /* update options. */
        update_option($preset_name, $preset_data);
    }
}

/**
 * Ajax get preset options.
 *
 * @author Fox
 */

add_action('wp_ajax_cms_get_preset_options', 'cms_get_preset_options_callback');

function cms_get_preset_options_callback()
{
    header('Content-Type: application/json');
    
    $preset = ! empty($_REQUEST['preset']) ? $_REQUEST['preset'] : '0';
    
    $theme_info = wp_get_theme();
    
    $preset = get_option("_" . $theme_info->get("TextDomain") . "_preset_" . $preset, null);
    
    die($preset);
}