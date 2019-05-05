<?php
global $amilia_base;
/**
 * Home Options
 * 
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Main Options', 'wp-amilia'),
    'icon' => 'el-icon-dashboard',
    'fields' => array(
        
    )
);
/* Start Dummy Data*/
$msg = $disabled = '';
if (!class_exists('WPBakeryVisualComposerAbstract') or !class_exists('CmssuperheroesCore') or !function_exists('cptui_create_custom_post_types')){
    $disabled = ' disabled ';
    $msg='You should be install visual composer, Cmssuperheroes and Custom Post Type UI plugins to import data.';
}
$this->sections[] = array(
    'icon' => 'el-icon-briefcase',
    'title' => esc_html__('Demo Content', 'wp-amilia'),
    'subsection' => true,
    'fields' => array(
        array(
            'subtitle' => '<input type=\'button\' name=\'sample\' id=\'dummy-data\' '.$disabled.' value=\'Import Now\' /><div class=\'cms-dummy-process\'><div  class=\'cms-dummy-process-bar\'></div></div><div id=\'cms-msg\'><span class="cms-status"></span>'.$msg.'</div>',
            'id' => 'theme',
            'icon' => true,
            'default' => 'amilia',
            'options' => array(
                'amilia' => get_template_directory_uri().'/assets/images/dummy/amilia.jpg'
            ),
            'type' => 'image_select',
            'title' => 'Select Theme'
        )
    )
);
/* End Dummy Data*/

/**
 * Favicon
 */
$this->sections[] = array(
    'title' => esc_html__('Favicon Icon', 'wp-amilia'),
    'icon' => 'el-icon-star',
    'fields' => array(
        array(
            'title' => esc_html__('Icon', 'wp-amilia'),
            'subtitle' => esc_html__('Select a favicon icon (.png, .jpg).', 'wp-amilia'),
            'id' => 'favicon_icon',
            'type' => 'media',
            'url' => true,
            'default' => array(
                'url'=>get_template_directory_uri().'/assets/images/favicon.png'
            )
        ),
    )
);

/**
 * Header Options
 * 
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Header', 'wp-amilia'),
    'icon' => 'el-icon-credit-card',
    'fields' => array(
        array(
            'id' => 'header_layout',
            'title' => esc_html__('Layouts', 'wp-amilia'),
            'subtitle' => esc_html__('Select a layout for header', 'wp-amilia'),
            'default' => '4',
            'type' => 'image_select',
            'options' => array(
                '1' => get_template_directory_uri().'/inc/options/images/header/header2.png',
                '2' => get_template_directory_uri().'/inc/options/images/header/header4.png',
                '3' => get_template_directory_uri().'/inc/options/images/header/header1.png',
                '4' => get_template_directory_uri().'/inc/options/images/header/header3.png',
                '5' => get_template_directory_uri().'/inc/options/images/header/header5.png',
            ),
        ),
        /*array(
            'id'       => 'amilia_header_bg',
            'type'     => 'color',
            'title'    => esc_html__('Header Background Color', 'wp-amilia'), 
            'subtitle' => esc_html__('Pick a background color for header (default: #fff).', 'wp-amilia'),
            'default'  => '#fff',
            'validate' => 'color',
            'output' => array(
                'background-color' => ''
            )
        ),*/
        array(
            'id'       => 'logo_bg',
            'type'     => 'color',
            'title'    => esc_html__('Logo Background Color', 'wp-amilia'), 
            'subtitle' => esc_html__('Pick a background color for logo (default: #414146).', 'wp-amilia'),
            'default'  => '#414146',
            'validate' => 'color',
            'output' => array(
                'background-color' => '.amilia-logo-wrap'
            ),
            'required' => array(
                array('header_layout', 'greater', '2'),
            )
        ),
        array(
            'id'       => 'menu_level1_color',
            'type'     => 'color',
            'title'    => esc_html__('Menu item level 1 Color', 'wp-amilia'), 
            'subtitle' => esc_html__('Pick a color for menu item level 1 (default: #565a60).', 'wp-amilia'),
            'default'  => '#565a60',
            'validate' => 'color',
        ),
        array(
            'id'       => 'menu_level1_color_hover',
            'type'     => 'color',
            'title'    => esc_html__('Menu item level 1 hover color', 'wp-amilia'), 
            'subtitle' => esc_html__('Pick a color for menu item level 1 when hover, active (default: #565a60).', 'wp-amilia'),
            'default'  => '#565a60',
            'validate' => 'color',
        ),
        array(
            'subtitle' => esc_html__('enable sticky mode for menu.', 'wp-amilia'),
            'id' => 'menu_sticky',
            'type' => 'switch',
            'title' => esc_html__('Sticky Header', 'wp-amilia'),
            'default' => false,
        ),
    )
);

/* Logo */
$this->sections[] = array(
    'title' => esc_html__('Logo', 'wp-amilia'),
    'icon' => 'el-icon-picture',
    'subsection' => true,
    'fields' => array(
        array(
            'title' => esc_html__('Select Logo', 'wp-amilia'),
            'subtitle' => esc_html__('Select an image file for your logo.', 'wp-amilia'),
            'id' => 'main_logo',
            'type' => 'media',
            'url' => true,
            'default' => array(
                'url'=>get_template_directory_uri().'/assets/images/logo.png'
            )
        ),
        array(
            'subtitle' => esc_html__('in pixels.', 'wp-amilia'),
            'id' => 'main_logo_height',
            'title' => 'Logo Height',
            'type' => 'dimensions',
            'units' => array( 'px' ), 
            'width' => false,
            'output' => array('#cshero-header-logo a img'),
            'default' => array(
                'height' => '23',
            )
        ),
        array(
            'subtitle' => esc_html__('in pixels.', 'wp-amilia'),
            'id' => 'sticky_logo_height',
            'title' => 'Sticky Logo Height',
            'type' => 'dimensions',
            'units' => array('px'),
            'output' => array('#cshero-header.header-fixed #cshero-header-logo a img'),
            'width' => false,
            'default' => array(
                'height' => '23'
            )
        )
    )
);

/* Menu */
$this->sections[] = array(
    'title' => esc_html__('Menu', 'wp-amilia'),
    'icon' => 'el-icon-tasks',
    'subsection' => true,
    'fields' => array(
        array(
            'subtitle' => 'Menu position.',
            'id' => 'menu_position',
            'options' => array(
                1 => 'Menu Left',
                2 => 'Menu Right',
            ),
            'type' => 'select',
            'title' => 'Menu Position',
            'default' => '2',
        ),
        array(
            'subtitle' => esc_html__('in pixels.', 'wp-amilia'),
            'id' => 'menu_fontsize_first_level',
            'type' => 'typography',
            'title' => 'Menu Font Size - First Level',
            'units' => 'px',
            'output' => '#cshero-header-navigation .main-navigation .menu-main-menu > li > a,
                          #cshero-header-navigation .main-navigation .menu-main-menu > ul > li > a,
                          .cshero-header-cart-search .header a',
            'font-style' => false,
            'font-weight' => false,
            'font-family' => true,
            'subsets' => false,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'default' => array('font-size' => '14px', 'font-family' => 'Oswald')
        ),
        array(
            'subtitle' => esc_html__('in pixels.', 'wp-amilia'),
            'id' => 'menu_fontsize_sub_level',
            'title' => 'Menu Font Size - Sub Level',
            'type' => 'typography',
            'output' => '#cshero-header-navigation .main-navigation .menu-main-menu > li ul a,
                      #cshero-header-navigation .main-navigation .menu-main-menu > ul > li ul a',
            'units' => 'px',
            'font-style' => false,
            'font-weight' => false,
            'font-family' => false,
            'subsets' => false,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'default' => array('font-size' => '13px')
        ),
        array(
            'subtitle' => esc_html__('Enable mega menu.', 'wp-amilia'),
            'id' => 'menu_mega',
            'type' => 'switch',
            'title' => esc_html__('Mega Menu', 'wp-amilia'),
            'default' => false,
        ),
    )
);

/**
 * Page Title
 *
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Page Title & BC', 'wp-amilia'),
    'icon' => 'el el-credit-card',
);

/* Page Title */
$this->sections[] = array(
    'icon' => 'el-icon-podcast',
    'title' => esc_html__('Page Title', 'wp-amilia'),
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'page_title_layout',
            'type' => 'image_select',
            'title' => esc_html__('Layouts', 'wp-amilia'),
            'subtitle' => esc_html__('select a layout for page title', 'wp-amilia'),
            'options' => array(
                '' => get_template_directory_uri().'/inc/options/images/pagetitle/pt-s-0.png',
                '3' => get_template_directory_uri().'/inc/options/images/pagetitle/pt-s-1.png',
            ),
            'default' => '3'
        ),
        array(
            'id' => 'page_title_typography',
            'type' => 'typography',
            'title' => esc_html__('Typography', 'wp-amilia'),
            'google' => true,
            'font-backup' => true,
            'all_styles' => true,
            'output'  => array('#page-title-text h1'),
            'units' => 'px',
            'subtitle' => esc_html__('Typography option with title text.', 'wp-amilia'),
            'default' => array(
                'color' => '#4b4e53',
                'font-style' => 'normal',
                'font-weight' => '300',
                'font-family' => 'Oswald',
                'google' => true,
                'font-size' => '24px',
                'line-height' => '25px',
                'text-align' => 'left'
            ),
            'required' => array( 
                array('page_title_layout','greater_equal','1')
            )
        ),
        array(
            'subtitle' => esc_html__('in pixels, bottom, ex: 10px', 'wp-amilia'),
            'id' => 'page_title_margin',
            'title' => 'Margin Bottom',
            'type' => 'spacing',
            'mode' => 'margin',
            'top' => false,
            'right' => false,
            'left' => false,
            'units' => array('px'),
            'output' => array('.page-title'),
            'default'            => array(
                'margin-bottom'  => '40px', 
            )
        ),

    )
);
/* Breadcrumb */
$this->sections[] = array(
    'icon' => 'el-icon-random',
    'title' => esc_html__('Breadcrumb', 'wp-amilia'),
    'subsection' => true,
    'fields' => array(
        array(
            'subtitle' => esc_html__('The text before the breadcrumb home.', 'wp-amilia'),
            'id' => 'breacrumb_home_prefix',
            'type' => 'text',
            'title' => esc_html__('Breadcrumb Home Prefix', 'wp-amilia'),
            'default' => 'Home'
        ),
        array(
            'id' => 'breacrumb_typography',
            'type' => 'typography',
            'title' => esc_html__('Typography', 'wp-amilia'),
            'google' => true,
            'font-backup' => true,
            'all_styles' => true,
            'output'  => array('#breadcrumb-text','#breadcrumb-text ul li a'),
            'units' => 'px',
            'subtitle' => esc_html__('Typography option with title text.', 'wp-amilia'),
            'default' => array(
                'color' => '#4b4e53',
                'font-style' => 'normal',
                'font-weight' => '300',
                'font-family' => 'Oswald',
                'google' => true,
                'font-size' => '14px',
                'line-height' => '22px',
                'text-align' => 'right'
            )
        ),
    )
);

/**
 * Body
 *
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Body', 'wp-amilia'),
    'icon' => 'el-icon-website',
    'fields' => array(
        array(
            'subtitle' => esc_html__('Set layout boxed default(Wide).', 'wp-amilia'),
            'id' => 'body_layout',
            'type' => 'switch',
            'title' => esc_html__('Boxed Layout', 'wp-amilia'),
            'default' => false,
        ),
        array(
            'id'       => 'body_background',
            'type'     => 'background',
            'title'    => esc_html__( 'Background', 'wp-amilia' ),
            'subtitle' => esc_html__( 'body background with image, color, etc.', 'wp-amilia' ),
            'output'   => array('body'),
        ),
        array(
            'subtitle' => esc_html__('in pixels, top right bottom left, ex: 10px 10px 10px 10px', 'wp-amilia'),
            'id' => 'body_margin',
            'title' => 'Margin',
            'type' => 'spacing',
            'mode' => 'margin',
            'units' => array('px'),
            'output' => array('body #page'),
        ),
        array(
            'subtitle' => esc_html__('in pixels, top right bottom left, ex: 10px 10px 10px 10px', 'wp-amilia'),
            'id' => 'body_padding',
            'title' => 'Padding',
            'type' => 'spacing',
            'mode' => 'padding',
            'units' => array('px'),
            'output' => array('body #page'),
        )
    )
);

/**
 * Content
 * 
 * Archive, Pages, Single, 404, Search, Category, Tags .... 
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Content', 'wp-amilia'),
    'icon' => 'el-icon-compass',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'container_background',
            'type'     => 'background',
            'title'    => esc_html__( 'Background', 'wp-amilia' ),
            'subtitle' => esc_html__( 'Container background with image, color, etc.', 'wp-amilia' ),
            'output'   => array('#main'),
        ),
        array(
            'subtitle' => esc_html__('in pixels, top right bottom left, ex: 10px 10px 10px 10px', 'wp-amilia'),
            'id' => 'container_margin',
            'title' => 'Margin',
            'type' => 'spacing',
            'mode' => 'margin',
            'units' => array('px'),
            'output' => array('body #main'),

        ),
        array(
            'subtitle' => esc_html__('in pixels, top right bottom left, ex: 10px 10px 10px 10px', 'wp-amilia'),
            'id' => 'container_padding',
            'title' => 'Padding',
            'type' => 'spacing',
            'mode' => 'padding',
            'units' => array('px'),
            'output' => array('body #main'),
        )
    )
);

/**
 * Blog
 * 
 * Archive, Pages, Single, 404, Search, Category, Tags .... 
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Blog', 'wp-amilia'),
    'icon' => 'el-icon-website',
    'fields' => array(
        array(
            'subtitle' => 'Select main content and sidebar alignment.',
            'id' => 'blog_layout',
            'type' => 'image_select',
            'options' => array(
                'right-sidebar' => get_template_directory_uri().'/assets/images/2cr.png',
                'left-sidebar' => get_template_directory_uri().'/assets/images/2cl.png'
            ),
            'title' => 'Blog Layout',
            'default' => 'right-sidebar'
        ),
        array(
            'id' => 'comments_post_type',
            'type' => 'select',
            'title' => 'Comments Type',
            'options' => array(
                'default' => esc_html__('Default Comments', 'wp-amilia'),
                'facebook' => esc_html__('Facebook Comments', 'wp-amilia'),
                'disqus' => esc_html__('Disqus Comments', 'wp-amilia'),
            ),
            'default' => 'default',
        ),
        array(
            'id'       => 'fb_app_id',
            'type'     => 'text',
            'title'    => esc_html__('Facebook App Id', 'wp-amilia'),
            'subtitle' => esc_html__('Facebook App Id, default is my app id: 1621007798158687', 'wp-amilia'),
            'default'  => '1621007798158687',
            'required' => array( 
                array('comments_post_type','equals','facebook')
            )
        ),
    )
);

$this->sections[] = array(
    'title' => esc_html__('Single Blog', 'wp-amilia'),
    'icon' => 'el-icon-livejournal',
    'subsection' => true,
    'fields' => array(
        array(
            'subtitle' => 'Select main content and sidebar alignment.',
            'id' => 'single_layout',
            'type' => 'image_select',
            'options' => array(
                'right-sidebar' => get_template_directory_uri().'/assets/images/2cr.png',
                'left-sidebar' => get_template_directory_uri().'/assets/images/2cl.png'
            ),
            'title' => 'Post Layout',
            'default' => 'right-sidebar'
        ),
        array(
            'title' => 'Show Image Featured',
            'subtitle' => 'Display featured images on archive port.',
            'id' => 'single_featured_images',
            'type' => 'switch',
            'default' => true
        ),
        array(
            'subtitle' => 'Show Post Title',
            'id' => 'show_single_title',
            'type' => 'switch',
            'title' => 'Show Post Title',
            'default' => true
        ),
        array(
            'subtitle' => 'Show Tags Post',
            'id' => 'show_tags_post',
            'type' => 'switch',
            'title' => 'Show Tags',
            'default' => true
        ),
        array(
            'subtitle' => 'Show Socials Icon at bottom of single post',
            'id' => 'show_social_post',
            'type' => 'switch',
            'title' => 'Show Socials Icon',
            'default' => true
        ),
        array(
            'subtitle' => 'Show Admin bio',
            'id' => 'show_admin_bio',
            'type' => 'switch',
            'title' => 'Show Admin bio',
            'default' => true
        ),
        array(
            'subtitle' => 'Show Related Post',
            'id' => 'show_single_related',
            'type' => 'switch',
            'title' => 'Show Related Post',
            'default' => true
        ),
    )
);

$this->sections[] = array(
    'title' => esc_html__('Blog timeline', 'wp-amilia'),
    'icon' => 'el-icon-livejournal',
    'subsection' => true,
    'fields' => array(
        array(
            'title' => esc_html__('Heading of blog timeline', 'wp-amilia'),
            'subtitle' => esc_html__('Heading of blog timeline', 'wp-amilia'),
            'id' => 'blog_timeline_heading',
            'type' => 'text',
            'default' => 'NOVEMBER 2011',
        ),
        array(
            'title' => esc_html__('Load more text', 'wp-amilia'),
            'subtitle' => esc_html__('Load more text of blog timeline', 'wp-amilia'),
            'id' => 'blog_timeline_load',
            'type' => 'text',
            'default' => 'RECENT DAY',
        ),
    )
);

/**
 * Bottom
 *
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Bottom', 'wp-amilia'),
    'icon' => 'el-icon-fork',
    'fields' => array(
        array(
            'subtitle' => esc_html__('Enable Newsletter on Bottom Area.', 'wp-amilia'),
            'id' => 'enable_newsletter_bottom_area',
            'type' => 'switch',
            'title' => esc_html__('Enable Newsletter on Bottom Area.', 'wp-amilia'),
            'default' => true,
        ),

        array(
            'subtitle' => esc_html__('Enable Map on Bottom Area.', 'wp-amilia'),
            'id' => 'enable_map_bottom_area',
            'type' => 'switch',
            'title' => esc_html__('Enable Map on Bottom', 'wp-amilia'),
            'default' => false,
        ),
    )
);

/**
 * Footer
 *
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Footer', 'wp-amilia'),
    'icon' => 'el-icon-credit-card',
);

/* Footer top */
$this->sections[] = array(
    'title' => esc_html__('Footer Layout', 'wp-amilia'),
    'icon' => 'el-icon-fork',
    'subsection' => true,
    'fields' => array(
        array(
            'subtitle' => 'Select footer layout.',
            'id' => 'footer_layout',
            'type' => 'image_select',
            'options' => array(
                '1' => get_template_directory_uri().'/inc/options/images/footer/footer-1.png',
                '2' => get_template_directory_uri().'/inc/options/images/footer/footer-2.png',
                '3' => get_template_directory_uri().'/inc/options/images/footer/footer-3.png',
                '4' => get_template_directory_uri().'/inc/options/images/footer/footer-4.png',
            ),
            'title' => 'Footer Layout',
            'default' => ''
        ),
        array(
            'id' => 'copyright',
            'type' => 'textarea',
            'title' => esc_html__('Copyright', 'wp-amilia'),
            'subtitle' => esc_html__('add copyright in footer', 'wp-amilia'),
            'default' => '&copy; Amilia - Build with Passion by CMS',
        ),
        array(
            'subtitle' => esc_html__('enable button back to top.', 'wp-amilia'),
            'id' => 'footer_botton_back_to_top',
            'type' => 'switch',
            'title' => esc_html__('Back To Top', 'wp-amilia'),
            'default' => false,
        )
    )
);

/**
 * Page Loadding
 * 
 * 
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Page Loadding', 'wp-amilia'),
    'icon' => 'el-icon-compass',
    'subsection' => true,
    'fields' => array(
        array(
            'subtitle' => esc_html__('Enable page loadding.', 'wp-amilia'),
            'id' => 'enable_page_loadding',
            'type' => 'switch',
            'title' => esc_html__('Enable Page Loadding', 'wp-amilia'),
            'default' => false,
        ),
        array(
            'subtitle' => 'Select Style Page Loadding.',
            'id' => 'page_loadding_style',
            'type' => 'select',
            'options' => array(
                '1' => 'Style 1',
                '2' => 'Style 2'
            ),
            'title' => 'Page Loadding Style',
            'default' => 'style-1',
            'required' => array( 0 => 'enable_page_loadding', 1 => '=', 2 => 1 )
        )     
    )
);

/**
 * Styling
 * 
 * css color.
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Styling', 'wp-amilia'),
    'icon' => 'el-icon-adjust',
    'fields' => array(
        array(
            'subtitle' => esc_html__('select presets color.', 'wp-amilia'),
            'id' => 'presets_color',
            'type' => 'image_select',
            'title' => esc_html__('Presets Color', 'wp-amilia'),
            'default' => '0',
            'options' => array(
                '0' => get_template_directory_uri().'/inc/options/images/presets/pr-c-0.png',
                '1' => get_template_directory_uri().'/inc/options/images/presets/pr-c-1.png',
                '2' => get_template_directory_uri().'/inc/options/images/presets/pr-c-2.png',
                '3' => get_template_directory_uri().'/inc/options/images/presets/pr-c-3.png',
                '4' => get_template_directory_uri().'/inc/options/images/presets/pr-c-4.png',
                '5' => get_template_directory_uri().'/inc/options/images/presets/pr-c-5.png',
                '6' => get_template_directory_uri().'/inc/options/images/presets/pr-c-6.png',
            )
        ),
        array(
            'subtitle' => esc_html__('set color main color.', 'wp-amilia'),
            'id' => 'primary_color',
            'type' => 'color',
            'title' => esc_html__('Primary Color', 'wp-amilia'),
            'default' => '#ffea00'
        ),
        array(
            'id' => 'secondary_color',
            'type' => 'color_rgba',
            'title' => esc_html__('Secondary Color', 'wp-amilia'),
            'default'   => array(
                'color'     => '#ffea00',
                'alpha'     => 0.5
            )
        ),
        array(
            'subtitle' => esc_html__('set color for heading (h1, h2, h3, h4, h5, h6).', 'wp-amilia'),
            'id' => 'heading_color',
            'type' => 'color',
            'title' => esc_html__('Heading Color', 'wp-amilia'),
            'output'  => array('h1, h2, h3, h4, h5, h6'),
            'default' => '#4b4e53'
        ),
        array(
            'subtitle' => esc_html__('set color for tags <a></a>.', 'wp-amilia'),
            'id' => 'link_color',
            'type' => 'color',
            'title' => esc_html__('Link Color', 'wp-amilia'),
            'default' => '#4b4e53'
        ),
        array(
            'subtitle' => esc_html__('set color for tags <a></a>.', 'wp-amilia'),
            'id' => 'link_color_hover',
            'type' => 'color',
            'title' => esc_html__('Link Color Hover', 'wp-amilia'),
            'default' => '#deae2e'
        ),
        array(
            'subtitle' => esc_html__('set color for some text.', 'wp-amilia'),
            'id' => 'text_color',
            'type' => 'color',
            'title' => esc_html__('Text Color', 'wp-amilia'),
            'output'  => '',
            'default' => '#414146'
        ),
    )
);

/**
 * Portfolio
 * 
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Portfolio', 'wp-amilia'),
    'icon' => 'el-icon-credit-card',
);

$this->sections[] = array(
    'title' => esc_html__('Single Portfolio', 'wp-amilia'),
    'icon' => 'el el-shopping-cart',
    'subsection' => true,
    'fields' => array(
        array(
            'title' => esc_html__('Enable NewsLetter', 'wp-amilia'),
            'subtitle' => esc_html__('enable newsletter form', 'wp-amilia'),
            'id' => 'portf_newsletter',
            'type' => 'switch',
            'default' => true,
        ),
        array(
            'title' => esc_html__('Enable Clients', 'wp-amilia'),
            'id' => 'portf_clients_info',
            'type' => 'switch',
            'default' => true,
        ),
    )
);

$this->sections[] = array(
    'title' => esc_html__('Portfolio timeline', 'wp-amilia'),
    'icon' => 'el el-shopping-cart',
    'subsection' => true,
    'fields' => array(
        array(
            'title' => esc_html__('Heading of portfolio timeline', 'wp-amilia'),
            'subtitle' => esc_html__('Heading of portfolio timeline', 'wp-amilia'),
            'id' => 'portf_timeline_heading',
            'type' => 'text',
            'default' => 'NOVEMBER 2011',
        ),
        array(
            'title' => esc_html__('Load more text', 'wp-amilia'),
            'subtitle' => esc_html__('Load more text of portfolio timeline', 'wp-amilia'),
            'id' => 'portf_timeline_load',
            'type' => 'text',
            'default' => 'RECENT DAY',
        ),
    )
);

/**
 * Woocommerces
 * 
 * @author Fox
 */

$this->sections[] = array(
    'title' => esc_html__('Woocommerces', 'wp-amilia'),
    'icon' => 'el el-shopping-cart',
    'fields' => array(
        array(
            'subtitle' => 'Portfolio Category Layout',
            'id' => 'shop_layout',
            'type' => 'image_select',
            'default' => 'right-sidebar',
            'options' => array(
                'full-width' => get_template_directory_uri().'/assets/images/1col.png',
                'right-sidebar' => get_template_directory_uri().'/assets/images/2cr.png',
                'left-sidebar' => get_template_directory_uri().'/assets/images/2cl.png'
            ),
            'title' => 'Shop Category Layout',
        ),

        array(
            'subtitle' => esc_html__('Number colums per row', 'wp-amilia'),
            'id' => 'shop_number_columns',
            'type' => 'select',
            'options' => array(
                '2' => '2 Columns',
                '3' => '3 Columns',
                '4' => '4 Columns'
            ),
            'title' => 'Number colums',
            'default' => '3',
        ),

        array(
            'title' => esc_html__('Number product', 'wp-amilia'),
            'id' => 'shop_number',
            'type' => 'slider',
            'subtitle' => esc_html__('Number product to show', 'wp-amilia'),
            'default' => 15,
            'min'  => 6,
            'step' => 1,
            'max' => 50,
        ),
        
        array(
            'subtitle' => esc_html__('Enable Newsletter Area', 'wp-amilia'),
            'id' => 'woo_show_newsletter',
            'type' => 'switch',
            'title' => esc_html__('Enable Newsletter Area', 'wp-amilia'),
            'default' => true,
        ),
    )
);

/**
 * Typography
 * 
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Typography', 'wp-amilia'),
    'icon' => 'el-icon-text-width',
    'fields' => array(
        array(
            'id' => 'font_body',
            'type' => 'typography',
            'title' => esc_html__('Body Font', 'wp-amilia'),
            'google' => true,
            'font-backup' => true,
            'all_styles' => true,
            'output'  => array('body'),
            'units' => 'px',
            'subtitle' => esc_html__('Typography option with each property can be called individually.', 'wp-amilia'),
            'default' => array(
                'color' => '#7e8082',
                'font-style' => 'normal',
                'font-weight' => '400',
                'font-family' => 'Open sans',
                'google' => true,
                'font-size' => '14px',
                'line-height' => '22px',
                'text-align' => ''
            ),
        ),
        array(
            'id' => 'font_h1',
            'type' => 'typography',
            'title' => esc_html__('H1', 'wp-amilia'),
            'google' => true,
            'font-backup' => true,
            'all_styles' => true,
            'output'  => array('h1'),
            'units' => 'px',
            'default' => array(
                'font-style' => 'normal',
                'font-weight' => '300',
                'font-family' => 'Oswald',
                'google' => true,
                'font-size' => '44px',
                'line-height' => '44px',
                'text-align' => ''
            ),
        ),
        array(
            'id' => 'font_h2',
            'type' => 'typography',
            'title' => esc_html__('H2', 'wp-amilia'),
            'google' => true,
            'font-backup' => true,
            'all_styles' => true,
            'output'  => array('h2'),
            'units' => 'px',
            'default' => array(
                'color' => '#4b4e53',
                'font-style' => 'normal',
                'font-weight' => '300',
                'font-family' => 'Oswald',
                'google' => true,
                'font-size' => '36px',
                'line-height' => '42px',
                'text-align' => ''
            ),
        ),
        array(
            'id' => 'font_h3',
            'type' => 'typography',
            'title' => esc_html__('H3', 'wp-amilia'),
            'google' => true,
            'font-backup' => true,
            'all_styles' => true,
            'output'  => array('h3'),
            'units' => 'px',
            'default' => array(
                'color' => '#4b4e53',
                'font-style' => 'normal',
                'font-weight' => '300',
                'font-family' => 'Oswald',
                'google' => true,
                'font-size' => '24px',
                'line-height' => '32px',
                'text-align' => ''
            ),
        ),
        array(
            'id' => 'font_h4',
            'type' => 'typography',
            'title' => esc_html__('H4', 'wp-amilia'),
            'google' => true,
            'font-backup' => true,
            'all_styles' => true,
            'output'  => array('h4'),
            'units' => 'px',
            'default' => array(
                'color' => '#4b4e53',
                'font-style' => 'normal',
                'font-weight' => '300',
                'font-family' => 'Oswald',
                'google' => true,
                'font-size' => '19px',
                'line-height' => '27px',
                'text-align' => ''
            ),
        ),
        array(
            'id' => 'font_h5',
            'type' => 'typography',
            'title' => esc_html__('H5', 'wp-amilia'),
            'google' => true,
            'font-backup' => true,
            'all_styles' => true,
            'output'  => array('h5'),
            'units' => 'px',
            'default' => array(
                'color' => '#4b4e53',
                'font-style' => 'normal',
                'font-weight' => '300',
                'font-family' => 'Oswald',
                'google' => true,
                'font-size' => '16px',
                'line-height' => '18px',
                'text-align' => ''
            ),
        ),
        array(
            'id' => 'font_h6',
            'type' => 'typography',
            'title' => esc_html__('H6', 'wp-amilia'),
            'google' => true,
            'font-backup' => true,
            'all_styles' => true,
            'output'  => array('h6'),
            'units' => 'px',
            'default' => array(
                'color' => '#4b4e53',
                'font-style' => 'normal',
                'font-weight' => '300',
                'font-family' => 'Oswald',
                'google' => true,
                'font-size' => '16px',
                'line-height' => '18px',
                'text-align' => ''
            ),
        )
    )
);

/* extra font. */
$this->sections[] = array(
    'title' => esc_html__('Extra Fonts', 'wp-amilia'),
    'icon' => 'el el-fontsize',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'google-font-1',
            'type' => 'typography',
            'title' => esc_html__('Font 1', 'wp-amilia'),
            'google' => true,
            'font-backup' => false,
            'font-style' => false,
            'color' => false,
            'text-align'=> false,
            'line-height'=>false,
            'font-size'=> false,
            'subsets'=> false,
            'default' => array(
                'font-weight' => '400',
                'font-family' => 'Lato'
            )
        ),
        array(
            'id' => 'google-font-selector-1',
            'type' => 'textarea',
            'title' => esc_html__('Selector 1', 'wp-amilia'),
            'subtitle' => esc_html__('add html tags ID or class (body,a,.class,#id)', 'wp-amilia'),
            'validate' => 'no_html',
            'default' => '',
        ),
        array(
            'id' => 'google-font-2',
            'type' => 'typography',
            'title' => esc_html__('Font 2', 'wp-amilia'),
            'google' => true,
            'font-backup' => false,
            'font-style' => false,
            'color' => false,
            'text-align'=> false,
            'line-height'=>false,
            'font-size'=> false,
            'subsets'=> false,
            'default' => array(
                'font-weight' => '400',
                'font-family' => 'Open Sans'
            )
        ),
        array(
            'id' => 'google-font-selector-2',
            'type' => 'textarea',
            'title' => esc_html__('Selector 2', 'wp-amilia'),
            'subtitle' => esc_html__('add html tags ID or class (body,a,.class,#id)', 'wp-amilia'),
            'validate' => 'no_html',
            'default' => '',
        ),
        array(
            'id' => 'google-font-3',
            'type' => 'typography',
            'title' => esc_html__('Font 3', 'wp-amilia'),
            'google' => true,
            'font-backup' => false,
            'font-style' => false,
            'color' => false,
            'text-align'=> false,
            'line-height'=>false,
            'font-size'=> false,
            'subsets'=> false,
            'default' => array(
                'font-weight' => '300',
                'font-family' => 'Lato'
            )
        ),
        array(
            'id' => 'google-font-selector-3',
            'type' => 'textarea',
            'title' => esc_html__('Selector 3', 'wp-amilia'),
            'subtitle' => esc_html__('add html tags ID or class (body,a,.class,#id)', 'wp-amilia'),
            'validate' => 'no_html',
            'default' => '',
        ),
    )
);

/**
 * Custom CSS
 * 
 * extra css for customer.
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Custom CSS', 'wp-amilia'),
    'icon' => 'el-icon-bulb',
    'fields' => array(
        array(
            'id' => 'custom_css',
            'type' => 'ace_editor',
            'title' => esc_html__('CSS Code', 'wp-amilia'),
            'subtitle' => esc_html__('create your css code here.', 'wp-amilia'),
            'mode' => 'css',
            'theme' => 'monokai',
        )
    )
);
/**
 * Animations
 *
 * Animations options for theme. libs css, js.
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Animations', 'wp-amilia'),
    'icon' => 'el-icon-magic',
    'fields' => array(
        array(
            'subtitle' => esc_html__('Enable animation mouse scroll...', 'wp-amilia'),
            'id' => 'smoothscroll',
            'type' => 'switch',
            'title' => esc_html__('Smooth Scroll', 'wp-amilia'),
            'default' => false
        ),
    )
);
/**
 * Optimal Core
 * 
 * Optimal options for theme. optimal speed
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Optimal Core', 'wp-amilia'),
    'icon' => 'el-icon-idea',
    'fields' => array(
        array(
            'subtitle' => esc_html__('no minimize , generate css over time...', 'wp-amilia'),
            'id' => 'dev_mode',
            'type' => 'switch',
            'title' => esc_html__('Dev Mode (not recommended)', 'wp-amilia'),
            'default' => false
        )
    )
);