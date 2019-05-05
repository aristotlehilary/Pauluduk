<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package CMSSuperHeroes
 * @subpackage CMS Theme
 * @since 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="initial-scale=1, width=device-width" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<?php $amilia_favicon = amilia_get_value_smofdata('favicon_icon'); ?>
<?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ): ?>
<link rel="icon" type="image/png" href="<?php echo esc_url($amilia_favicon['url']); ?>"/>
<?php endif; ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php amilia_get_page_loading(); ?>
<div id="page" class="<?php amilia_page_class(); ?>">
	<header id="masthead" class="site-header" role="banner">
		<?php amilia_header(); ?>
	</header><!-- #masthead -->
	<?php
		$amilia_pagemeta = amilia_get_value_pagemeta();
		
		if (is_page() && !empty($amilia_pagemeta->_cms_custom_revolution) && $amilia_pagemeta->_cms_revslide_position == 'atop-pagetitle' && !empty($amilia_pagemeta->_cms_get_revslide)) { ?>
			<div class="amilia-custom-rev" <?php echo (!empty($amilia_pagemeta->_cms_revslide_padding_bottom)) ? 'style="padding-bottom: 30px; background-color: #dfdfdf;"' : ''; ?>>
				<?php echo do_shortcode('[rev_slider_vc alias="'.$amilia_pagemeta->_cms_get_revslide.'"]'); ?>	
			</div>
		<?php
		}
	?>
    <?php amilia_page_title(); ?>
	<div id="main" class="amilia-main">