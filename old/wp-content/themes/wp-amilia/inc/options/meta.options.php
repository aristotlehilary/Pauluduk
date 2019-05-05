<?php
/**
 * Meta options
 * 
 * @author Fox
 * @since 1.0.0
 */
class CMSMetaOptions
{
    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('admin_enqueue_scripts', array($this, 'admin_script_loader'));
    }
    /* add script */
    function admin_script_loader()
    {
        global $pagenow;
        if (is_admin() && ($pagenow == 'post-new.php' || $pagenow == 'post.php')) {
            wp_enqueue_style('metabox', get_template_directory_uri() . '/inc/options/css/metabox.css');
            
            wp_enqueue_script('easytabs', get_template_directory_uri() . '/inc/options/js/jquery.easytabs.min.js');
            wp_enqueue_script('metabox', get_template_directory_uri() . '/inc/options/js/metabox.js');
        }
    }
    /* add meta boxs */
    public function add_meta_boxes()
    {
        $this->add_meta_box('template_page_options', esc_html__('Setting', 'wp-amilia'), 'page');
        $this->add_meta_box('team_page_options', esc_html__('Team Position', 'wp-amilia'), 'team');
        $this->add_meta_box('team_page_social', esc_html__('Team Social', 'wp-amilia'), 'team');
        $this->add_meta_box('testimonial_page_options', esc_html__('Testimonial Position', 'wp-amilia'), 'testimonial');
        $this->add_meta_box('pricing_page_option', esc_html__('Pricing Option', 'wp-amilia'), 'pricing');
        $this->add_meta_box('portfolio_single_option', esc_html__('Portfolio Options', 'wp-amilia'), 'portfolio');
    }
    
    public function add_meta_box($id, $label, $post_type, $context = 'advanced', $priority = 'default')
    {
        add_meta_box('_cms_' . $id, $label, array($this, $id), $post_type, $context, $priority);
    }
    /* --------------------- PAGE ---------------------- */

    function testimonial_page_options(){
        ?>
        <div class="team-position">
            <?php
                cms_options(array(
                    'id' => 'page_testimonial_position',
                    'label' => esc_html__('Testimonial Position','wp-amilia'),
                    'type' => 'text',
                ));
            ?>
        </div>
        <?php
    }

    function template_page_options() {
        ?>
        <div class="tab-container clearfix">
	        <ul class='etabs clearfix'>
	           <li class="tab"><a href="#tabs-general"><i class="fa fa-server"></i><?php esc_html_e('General', 'wp-amilia'); ?></a></li>
	           <li class="tab"><a href="#tabs-header"><i class="fa fa-diamond"></i><?php esc_html_e('Header', 'wp-amilia'); ?></a></li>
	           <li class="tab"><a href="#tabs-page-title"><i class="fa fa-connectdevelop"></i><?php esc_html_e('Page Title', 'wp-amilia'); ?></a></li>
               <li class="tab"><a href="#tabs-footer"><i class="fa fa-connectdevelop"></i><?php esc_html_e('Footer', 'wp-amilia'); ?></a></li>
               <li class="tab"><a href="#tabs-one-page"><?php esc_html_e('One Page', 'wp-amilia'); ?></a></li>
	        </ul>
	        <div class='panel-container'>
                <div id="tabs-general">
                <?php
                    cms_options(array(
                        'id' => 'full_width',
                        'label' => esc_html__('Full Width','wp-amilia'),
                        'type' => 'switch',
                        'options' => array('on'=>'1','off'=>''),
                    ));
                    cms_options(array(
                        'id' => 'custom_revolution',
                        'label' => esc_html__('Custom Revolution','wp-amilia'),
                        'type' => 'switch',
                        'options' => array('on'=>'1','off'=>''),
                        'follow' => array('1'=>array('#custom-revolution-wrap'))
                    ));
                    ?>
                        <div id="custom-revolution-wrap">
                            <?php
                                cms_options(array(
                                    'id' => 'get_revslide',
                                    'label' => esc_html__('Revolution','wp-amilia'),
                                    'type' => 'select',
                                    'options' => amilia_get_list_rev_slider(),
                                ));
                                cms_options(array(
                                    'id' => 'revslide_padding_bottom',
                                    'label' => esc_html__('Revolution slider padding bottom','wp-amilia'),
                                    'type' => 'switch',
                                    'options' => array('on'=>'1','off'=>''),
                                ));
                                cms_options(array(
                                    'id' => 'revslide_position',
                                    'label' => esc_html__('Revolution slider position','wp-amilia'),
                                    'type' => 'select',
                                    'options' => array(
                                        'atop-pagetitle' => 'Atop of page title',
                                        'atop-primary-menu' => 'Atop of primary menu'
                                    ),
                                ));
                            ?>
                        </div>
                    <?php
                    

                    cms_options(array(
                        'id' => 'page_general_custom_class',
                        'label' => esc_html__('Body Custom Class','wp-amilia'),
                        'type' => 'text',
                    ));
                ?>
                </div>
                <div id="tabs-header">
                <?php
                /* header. */
                cms_options(array(
                    'id' => 'header',
                    'label' => esc_html__('Custom','wp-amilia'),
                    'type' => 'switch',
                    'options' => array('on'=>'1','off'=>''),
                    'follow' => array('1'=>array('#page_header_enable'))
                ));
                ?>  <div id="page_header_enable"><?php
                cms_options(array(
                    'id' => 'header_layout',
                    'label' => esc_html__('Layout','wp-amilia'),
                    'type' => 'imegesselect',
                    'options' => array(
                        '1' => get_template_directory_uri().'/inc/options/images/header/header2.png',
                        '2' => get_template_directory_uri().'/inc/options/images/header/header4.png',
                        '3' => get_template_directory_uri().'/inc/options/images/header/header1.png',
                        '4' => get_template_directory_uri().'/inc/options/images/header/header3.png',
                        '5' => get_template_directory_uri().'/inc/options/images/header/header5.png',
                    )
                ));
                cms_options(array(
                    'id' => 'page_logo_custom',
                    'label' => esc_html__('Logo','wp-amilia'),
                    'type' => 'image',
                    'default' => '',
                ));
                /*cms_options(array(
                    'id' => 'custom_page_header_bg_color',
                    'label' => esc_html__('Background Color','wp-amilia'),
                    'type' => 'color',
                    'default' => '#fff',
                    'rgba' => true
                ));
                cms_options(array(
                    'id' => 'custom_page_header_menu_color',
                    'label' => esc_html__('Menu Color - First Level','wp-amilia'),
                    'type' => 'color',
                    'default' => '',
                    'rgba' => true
                ));
                cms_options(array(
                    'id' => 'custom_page_header_menu_color_hover',
                    'label' => esc_html__('Menu Hover Color - First Level','wp-amilia'),
                    'type' => 'color',
                    'default' => '',
                    'rgba' => true
                ));*/

                cms_options(array(
                    'id' => 'enable_header_fixed',
                    'label' => esc_html__('Header Fixed','wp-amilia'),
                    'type' => 'switch',
                    'options' => array('on'=>'1','off'=>''),
                    'follow' => array('1'=>array('#page_header_fixed_enable'))
                ));
                ?> <div id="page_header_fixed_enable"><?php
                    //Code here
                ?></div>
                <?php
                    $menus = array();
                    $menus[''] = 'Default';
                    $obj_menus = wp_get_nav_menus();
                    foreach ($obj_menus as $obj_menu) {
                        $menus[$obj_menu->term_id] = $obj_menu->name;
                    }
                    $navs = get_registered_nav_menus();
                    foreach ($navs as $key => $mav) {
                        cms_options(array(
                        'id' => $key,
                        'label' => $mav,
                        'type' => 'select',
                        'options' => $menus
                        ));
                    }
                ?>
                </div>
                </div>
                <div id="tabs-page-title">
                    <?php
                    /* page title. */
                    cms_options(array(
                        'id' => 'page_title',
                        'label' => esc_html__('Custom','wp-amilia'),
                        'type' => 'switch',
                        'options' => array('on'=>'1','off'=>''),
                        'follow' => array('1'=>array('#page_title_enable'))
                    ));
                    ?> 
                    <div id="page_title_enable">
                        <?php
                            cms_options(array(
                                'id' => 'page_title_type',
                                'label' => esc_html__('Page Title Style','wp-amilia'),
                                'type' => 'imegesselect',
                                'options' => array(
                                    '' => get_template_directory_uri().'/inc/options/images/pagetitle/pt-s-0.png',
                                    '3' => get_template_directory_uri().'/inc/options/images/pagetitle/pt-s-1.png',
                                )
                            ));

                            cms_options(array(
                                'id' => 'page_title_text',
                                'label' => esc_html__('Title','wp-amilia'),
                                'type' => 'text',
                            ));
                        ?>
                    </div>
                </div>
                    
                <div id="tabs-footer">
                    <?php
                        /* Footer. */
                        cms_options(array(
                            'id' => 'footer',
                            'label' => esc_html__('Custom Footer','wp-amilia'),
                            'type' => 'switch',
                            'options' => array('on'=>'1','off'=>''),
                            'follow' => array('1'=>array('#page_footer_enable'))
                        ));
                    ?>  
                    <div id="page_footer_enable">
                        <?php
                            cms_options(array(
                                'id' => 'disable_bottom',
                                'label' => esc_html__('Hide Bottom Area','wp-amilia'),
                                'type' => 'select',
                                'options' => array(
                                    'inherit' => esc_html__('Inherit','wp-amilia'),
                                    'hide' => esc_html__('Hide','wp-amilia'),
                                ),
                            ));
                            cms_options(array(
                                'id' => 'footer_layout',
                                'label' => esc_html__('Layout','wp-amilia'),
                                'type' => 'imegesselect',
                                'options' => array(
                                    '1' => get_template_directory_uri().'/inc/options/images/footer/footer-1.png',
                                    '2' => get_template_directory_uri().'/inc/options/images/footer/footer-2.png',
                                    '3' => get_template_directory_uri().'/inc/options/images/footer/footer-3.png',
                                    '4' => get_template_directory_uri().'/inc/options/images/footer/footer-4.png',
                                )
                            ));
                            cms_options(array(
                                'id' => 'footer_animate',
                                'label' => esc_html__('Footer Animate','wp-amilia'),
                                'type' => 'switch',
                                'options' => array('on'=>'1','off'=>''),
                            ));
                        ?>
                    </div>
                </div>

                <div id="tabs-one-page">
                    <?php
                    cms_options(array(
                        'id' => 'one_page',
                        'label' => esc_html__('Enable','wp-amilia'),
                        'type' => 'switch',
                        'options' => array('on'=>'1','off'=>''),
                        'follow' => array('1'=>array('#one-page-enable'))
                    ));
                    ?>
                    <div id="one-page-enable">
                        <?php
                        cms_options(array(
                            'id' => 'one_page_speed',
                            'label' => esc_html__('Speed','wp-amilia'),
                            'type' => 'text',
                            'placeholder' => '1000'
                        ));
                        cms_options(array(
                            'id' => 'one_page_easing',
                            'label' => esc_html__('Easing','wp-amilia'),
                            'type' => 'select',
                            'options' => array(
                                '' => '',
                                'easeInQuad' => 'easeInQuad',
                                'easeOutQuad' => 'easeOutQuad',
                                'easeInOutQuad' => 'easeInOutQuad',
                                'easeInCubic' => 'easeInCubic',
                                'easeOutCubic' => 'easeOutCubic',
                                'easeInOutCubic' => 'easeInOutCubic',
                                'easeInQuart' => 'easeInQuart',
                                'easeOutQuart' => 'easeOutQuart',
                                'easeInOutQuart' => 'easeInOutQuart',
                                'easeInQuint' => 'easeInQuint',
                                'easeOutQuint' => 'easeOutQuint',
                                'easeInOutQuint' => 'easeInOutQuint',
                                'easeInSine' => 'easeInSine',
                                'easeOutQuad' => 'easeOutQuad',
                                'easeOutSine' => 'easeOutSine',
                                'easeInOutSine' => 'easeInOutSine',
                                'easeInExpo' => 'easeInExpo',
                                'easeOutExpo' => 'easeOutExpo',
                                'easeInOutExpo' => 'easeInOutExpo',
                                'easeInCirc' => 'easeInCirc',
                                'easeOutCirc' => 'easeOutCirc',
                                'easeInOutCirc' => 'easeInOutCirc',
                                'easeInElastic' => 'easeInElastic',
                                'easeOutElastic' => 'easeOutElastic',
                                'easeInOutElastic' => 'easeInOutElastic',
                                'easeInBack' => 'easeInBack',
                                'easeOutBack' => 'easeOutBack',
                                'easeInOutBack' => 'easeInOutBack',
                                'easeInBounce' => 'easeInBounce',
                                'easeOutBounce' => 'easeOutBounce',
                                'easeInOutBounce' => 'easeInOutBounce'
                            )
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    /* Pricing Option */
    function pricing_page_option() {
        echo '<div class="pricing-option-wrap">';
        cms_options(array(
            'id' => 'price',
            'label' => esc_html__('Price','wp-amilia'),
            'type' => 'text',
        ));
        cms_options(array(
            'id' => 'cents',
            'label' => esc_html__('Cents','wp-amilia'),
            'type' => 'text',
        ));
        cms_options(array(
            'id' => 'time',
            'label' => esc_html__('Time','wp-amilia'),
            'type' => 'text',
        ));
        cms_options(array(
            'id' => 'value',
            'label' => esc_html__('Value','wp-amilia'),
            'type' => 'text',
        ));
        cms_options(array(
            'id' => 'option1',
            'label' => esc_html__('Option 1','wp-amilia'),
            'type' => 'text',
        ));
        cms_options(array(
            'id' => 'option2',
            'label' => esc_html__('Option 2','wp-amilia'),
            'type' => 'text',
        ));
        cms_options(array(
            'id' => 'option3',
            'label' => esc_html__('Option 3','wp-amilia'),
            'type' => 'text',
        ));
        cms_options(array(
            'id' => 'option4',
            'label' => esc_html__('Option 4','wp-amilia'),
            'type' => 'text',
        ));
        cms_options(array(
            'id' => 'option5',
            'label' => esc_html__('Option 5','wp-amilia'),
            'type' => 'text',
        ));
        cms_options(array(
            'id' => 'option6',
            'label' => esc_html__('Option 6','wp-amilia'),
            'type' => 'text',
        ));
        cms_options(array(
            'id' => 'option7',
            'label' => esc_html__('Option 7','wp-amilia'),
            'type' => 'text',
        ));
        cms_options(array(
            'id' => 'option8',
            'label' => esc_html__('Option 8','wp-amilia'),
            'type' => 'text',
        ));
        cms_options(array(
            'id' => 'option9',
            'label' => esc_html__('Option 9','wp-amilia'),
            'type' => 'text',
        ));
        cms_options(array(
            'id' => 'option10',
            'label' => esc_html__('Option 10','wp-amilia'),
            'type' => 'text',
        ));
        cms_options(array(
            'id' => 'button_url',
            'label' => esc_html__('Button Url','wp-amilia'),
            'type' => 'text',
        ));
        cms_options(array(
            'id' => 'button_text',
            'label' => esc_html__('Button Text','wp-amilia'),
            'type' => 'text',
        ));
        cms_options(array(
            'id' => 'is_feature',
            'label' => esc_html__('Is feature','wp-amilia'),
            'type' => 'switch',
            'options' => array('on'=>'1','off'=>''),
        ));
        /*cms_options(array(
            'id' => 'best_value',
            'label' => esc_html__('Best Value','wp-amilia'),
            'type' => 'text',
        ));*/
        echo '</div>';
    }

    function team_page_options(){
        ?>
        <div class="team-position">
            <?php
                cms_options(array(
                    'id' => 'page_team_position',
                    'label' => esc_html__('Team Position','wp-amilia'),
                    'type' => 'text',
                ));
            ?>
        </div>
        <?php
    }
    function team_page_social(){
        ?>
        <div class="team-social">
            <?php
                cms_options(array(
                    'id' => 'icon1',
                    'label' => esc_html__('Icon 1','wp-amilia'),
                    'type' => 'text',
                ));
                cms_options(array(
                    'id' => 'link1',
                    'label' => esc_html__('Link 1','wp-amilia'),
                    'type' => 'text',
                ));
                cms_options(array(
                    'id' => 'icon2',
                    'label' => esc_html__('Icon 2','wp-amilia'),
                    'type' => 'text',
                ));
                cms_options(array(
                    'id' => 'link2',
                    'label' => esc_html__('Link 2','wp-amilia'),
                    'type' => 'text',
                )); 
                cms_options(array(
                    'id' => 'icon3',
                    'label' => esc_html__('Icon 3','wp-amilia'),
                    'type' => 'text',
                ));
                cms_options(array(
                    'id' => 'link3',
                    'label' => esc_html__('Link 3','wp-amilia'),
                    'type' => 'text',
                ));
                cms_options(array(
                    'id' => 'icon4',
                    'label' => esc_html__('Icon 4','wp-amilia'),
                    'type' => 'text',
                ));
                cms_options(array(
                    'id' => 'link4',
                    'label' => esc_html__('Link 4','wp-amilia'),
                    'type' => 'text',
                ));
                cms_options(array(
                    'id' => 'icon5',
                    'label' => esc_html__('Icon 5','wp-amilia'),
                    'type' => 'text',
                ));
                cms_options(array(
                    'id' => 'link5',
                    'label' => esc_html__('Link 5','wp-amilia'),
                    'type' => 'text',
                )); 
                cms_options(array(
                    'id' => 'icon6',
                    'label' => esc_html__('Icon 6','wp-amilia'),
                    'type' => 'text',
                ));
                cms_options(array(
                    'id' => 'link6',
                    'label' => esc_html__('Link 6','wp-amilia'),
                    'type' => 'text',
                ));
            ?>
        </div>
        <?php
    }

    function portfolio_single_option(){
        ?>
        <div class="single-portfolio">
            <?php
                cms_options(array(
                    'id' => 'single_portfolio_client',
                    'label' => esc_html__('Client','wp-amilia'),
                    'type' => 'text',
                ));
                cms_options(array(
                    'id' => 'single_portfolio_skills',
                    'label' => esc_html__('Skills','wp-amilia'),
                    'type' => 'text',
                ));
                cms_options(array(
                    'id' => 'single_portfolio_url',
                    'label' => esc_html__('Link to project','wp-amilia'),
                    'type' => 'text',
                ));
            ?>
        </div>
        <?php
    }
}
new CMSMetaOptions();