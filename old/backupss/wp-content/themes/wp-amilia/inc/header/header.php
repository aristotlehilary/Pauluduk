<?php
/**
 * @name : Default
 * @package : CMSSuperHeroes
 * @author : Fox
 */
?>
<?php global $smof_data, $amilia_meta;
    $header_fixed = (is_page() && !empty($amilia_meta->_cms_enable_header_fixed)) ? $amilia_meta->_cms_enable_header_fixed : $smof_data['menu_sticky'];
?>

<?php
    if (is_page() && !empty($amilia_meta->_cms_custom_revolution) && $amilia_meta->_cms_revslide_position == 'atop-primary-menu' && !empty($amilia_meta->_cms_get_revslide)) { ?>
        <div class="amilia-custom-rev" <?php echo (!empty($amilia_meta->_cms_revslide_padding_bottom)) ? 'style="padding-bottom: 30px;"' : ''; ?>>
            <?php echo do_shortcode('[rev_slider_vc alias="'.$amilia_meta->_cms_get_revslide.'"]'); ?>  
        </div>
    <?php
    }
?>

<div id="cshero-header" 
    class="cshero-main-header 
        <?php amilia_get_header_style(); ?>
        <?php if ($header_fixed != '' && $header_fixed == true) {echo 'header-fixed-page';} ?>
    ">
    <div class="container">
        <div class="row">
            <div id="cshero-header-logo" class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <?php
                    $logo_url = $logo_fixed = '';
                    if ( isset($amilia_meta->_cms_page_logo_custom) && $amilia_meta->_cms_page_logo_custom) {
                        $logo_url = wp_get_attachment_url($amilia_meta->_cms_page_logo_custom);
                    } else {
                        $logo_url = $smof_data['main_logo']['url'];
                    }
                ?>
                <div class="amilia-logo-wrap">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <div class="amilia-logo">
                            <img class="logo-follow-option" alt="" src="<?php echo esc_url($logo_url); ?>" <?php echo (isset($amilia_meta->_cms_page_logo_custom_height) && $amilia_meta->_cms_page_logo_custom_height) ? 'style="height: '. $amilia_meta->_cms_page_logo_custom_height.'"' : '' ?>>
                        </div>
                    </a>   
                </div>
            </div>
            <button id="cshero-menu-mobile" data-target="#site-navigation" data-toggle="collapse" class="navbar-toggle btn-navbar collapsed" type="button">   
                <span class="text"><?php esc_html_e('MENU', 'wp-amilia') ?></span>
                <span aria-hidden="true" class="icon_menu main-menu-icon"></span>
            </button>
        </div>
    </div> <!-- End amilia container-->
    <div class="amilia-header-wrap">
        <div class="container">
            <div class="amilia-header-inner">
                <div class="row">
                    <div id="cshero-header-navigation" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 has-search-cart">
                        <nav id="site-navigation" class="main-navigation collapse <?php echo ( $smof_data['menu_position'] && $smof_data['menu_position'] == 2) ? 'pull-right' : '' ?>">
                            <?php
                            
                            $attr = array(
                                'menu' =>amilia_menu_location(),
                                'menu_class' => 'nav-menu menu-main-menu',
                                'menu_id' => 'menu-main-menu'
                            );
                            
                            $menu_locations = get_nav_menu_locations();
                            
                            if(!empty($menu_locations['primary'])){
                                $attr['theme_location'] = 'primary';
                            }
                            
                            /* enable mega menu. */
                            if(class_exists('HeroMenuWalker')){ $attr['walker'] = new HeroMenuWalker(); }
                            
                            /* main nav. */
                            wp_nav_menu( $attr ); ?>
                            <div class="cshero-header-cart-search pull-left">
                                <?php dynamic_sidebar('cart-search-top'); ?>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End amilia-header-wrap -->
</div>
<!-- #site-navigation -->