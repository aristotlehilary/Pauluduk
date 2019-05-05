<?php

/**
 * Auto create css from Meta Options.
 * 
 * @author Fox
 * @version 1.0.0
 */
class CMSSuperHeroes_DynamicCss
{

    function __construct()
    {
        add_action('wp_head', array($this, 'generate_css'));
    }

    /**
     * generate css inline.
     *
     * @since 1.0.0
     */
    public function generate_css()
    {
        global $smof_data, $amilia_base;
        $css = $this->css_render();
        if (! $smof_data['dev_mode']) {
            $css = $amilia_base->amilia_compressCss($css);
        }
        echo '<style type="text/css" data-type="cms_shortcodes-custom-css">'.$css.'</style>';
    }

    /**
     * header css
     *
     * @since 1.0.0
     * @return string
     */
    public function css_render()
    {
        global $smof_data, $amilia_meta;
        ob_start();

        /*$header_bg_color = ($smof_data['amilia_header_bg']) ? $smof_data['amilia_header_bg'] : '#fff';*/
        $menu_level1_color = ($smof_data['menu_level1_color']) ? $smof_data['menu_level1_color'] : '#565a60';
        $menu_level1_color_hover = ($smof_data['menu_level1_color_hover']) ? $smof_data['menu_level1_color_hover'] : '#565a60';


        if (isset($smof_data['presets_color']) && $smof_data['presets_color'] > 0) {
            /* Header 3,5 */
            echo '.amilia-header-3.cshero-main-header .menu-main-menu > li.current-menu-item > a,
                .amilia-header-3.cshero-main-header .menu-main-menu > li.current-menu-ancestor > a,
                .amilia-header-5.cshero-main-header .menu-main-menu > li.current-menu-item > a,
                .amilia-header-5.cshero-main-header .menu-main-menu > li.current-menu-ancestor > a,
                .amilia-header-3.cshero-main-header .menu-main-menu > li > a:hover,
                .amilia-header-3.cshero-main-header .menu-main-menu > li > a:focus,
                .amilia-header-5.cshero-main-header .menu-main-menu > li > a:focus,
                .amilia-header-5.cshero-main-header .menu-main-menu > li > a:hover,
                .amilia-header-1.cshero-main-header .menu-main-menu > li > a:hover,
                .amilia-header-1.cshero-main-header .menu-main-menu > li > a:focus,
                .amilia-header-4.cshero-main-header .menu-main-menu > li > a:focus,
                .amilia-header-4.cshero-main-header .menu-main-menu > li > a:hover,
                .amilia-header-4.cshero-main-header .menu-main-menu > li.current-menu-item > a,
                .amilia-header-4.cshero-main-header .menu-main-menu > li.current-menu-ancestor > a,
                .amilia-header-2.cshero-main-header .menu-main-menu > li > a:focus,
                .amilia-header-2.cshero-main-header .menu-main-menu > li > a:hover,
                .amilia-header-2.cshero-main-header .menu-main-menu > li.current-menu-item > a,
                .amilia-header-2.cshero-main-header .menu-main-menu > li.current-menu-ancestor > a {
                    color: '.$menu_level1_color_hover.';
                }

                .amilia-header-3.cshero-main-header .menu-main-menu > li.current-menu-item > a i, 
                .amilia-header-3.cshero-main-header .menu-main-menu > li.current-menu-ancestor > a i,
                .amilia-header-5.cshero-main-header .menu-main-menu > li.current-menu-item > a i,
                .amilia-header-5.cshero-main-header .menu-main-menu > li.current-menu-ancestor > a i,
                .amilia-header-5.cshero-main-header .menu-main-menu > li > a:hover i, 
                .amilia-header-3.cshero-main-header .menu-main-menu > li > a:hover i {
                    color: '.$menu_level1_color_hover.';
                    border-color: '.$menu_level1_color_hover.';
                }

                .cshero-header-cart-search .widget_cart_search_wrap .sb-icon-search:hover i {
                    color: '.$menu_level1_color_hover.';
                    border-color: '.$menu_level1_color_hover.';
                    -webkit-transition: all 0s ease 0s;
                    -o-transition: all 0s ease 0s;
                    transition: all 0s ease 0s;   
                }
            ';
        }
        
        /* custom css. */
        if (!empty($smof_data['custom_css'])) {
            echo ''.$smof_data['custom_css'];
        }

        return ob_get_clean();
    }
}

new CMSSuperHeroes_DynamicCss();