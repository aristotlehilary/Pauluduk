<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     9.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $breadcrumb, $pagetitle, $smof_data;

$primary_column = $secord_col = $tracking_layout = '';
$tracking_layout = (isset($_GET['shop-layout'])) ? trim($_GET['shop-layout']) : $smof_data['shop_layout'];

if ($tracking_layout == 'full-width') {
    $primary_column = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
} else {
    $primary_column = 'col-xs-12 col-md-9 col-lg-9';
    $secord_col = 'col-xs-12 col-md-3 col-lg-3';
}

get_header( 'shop' ); ?>
<section id="primary" class="content-area<?php if($breadcrumb == '0'){ echo ' no_breadcrumb'; }; ?> <?php if(!$pagetitle){ echo ' no_page_title'; }; ?>">
    <main id="main" class="site-main" role="main">    
        <div class="<?php echo get_post_meta(get_the_ID(), 'cs_layout', true) ? 'no-container' : 'container'; ?>">
            <div class="row">
                <?php if ($tracking_layout == 'left-sidebar') : ?>
                    <div class="left-sidebar-wrap <?php echo esc_attr($secord_col); ?>">
                        <?php if ( is_active_sidebar( 'woocommerce_sidebar' ) ) : ?>
                            <div id="secondary" class="widget-area woocommerce-widget clearfix" role="complementary">
                                <?php dynamic_sidebar( 'woocommerce_sidebar' ); ?>
                            </div><!-- #secondary -->
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="<?php echo esc_attr($primary_column); ?>">
                    	<?php
                    		/**
                    		 * woocommerce_before_main_content hook
                    		 *
                    		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
                    		 * @hooked woocommerce_breadcrumb - 20
                    		 */
                    		do_action( 'woocommerce_before_main_content' );
                    	?>
                    
                
                		<?php do_action( 'woocommerce_archive_description' ); ?>
                
                		<?php if ( have_posts() ) : ?>
                            <div class="before-shop-loop mb-40 clearfix">
                			<?php
                				/**
                				 * woocommerce_before_shop_loop hook
                				 *
                				 * @hooked woocommerce_result_count - 20
                				 * @hooked woocommerce_catalog_ordering - 30
                				 */
                				do_action( 'woocommerce_before_shop_loop' );
                			?>
                            </div>
                
                			<?php woocommerce_product_loop_start(); ?>
                
                				<?php woocommerce_product_subcategories(); ?>
                
                				<?php while ( have_posts() ) : the_post(); ?>
                
                					<?php wc_get_template_part( 'content', 'product' ); ?>
                
                				<?php endwhile; // end of the loop. ?>
                
                			<?php woocommerce_product_loop_end(); ?>
                
                			<?php
                				/**
                				 * woocommerce_after_shop_loop hook
                				 *
                				 * @hooked woocommerce_pagination - 10
                				 */
                				do_action( 'woocommerce_after_shop_loop' );
                			?>
                
                		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
                
                			<?php wc_get_template( 'loop/no-products-found.php' ); ?>
                
                		<?php endif; ?>
                
                	<?php
                		/**
                		 * woocommerce_after_main_content hook
                		 *
                		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                		 */
                		do_action( 'woocommerce_after_main_content' );
                	?>
                </div>
                <?php if ($tracking_layout == 'right-sidebar') : ?>
                    <div class="right-sidebar-wrap <?php echo esc_attr($secord_col); ?>">
                        <?php if ( is_active_sidebar( 'woocommerce_sidebar' ) ) : ?>
                            <div id="secondary" class="widget-area woocommerce-widget clearfix" role="complementary">
                                <?php dynamic_sidebar( 'woocommerce_sidebar' ); ?>
                            </div><!-- #secondary -->
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main><!-- #main -->
</section><!-- #primary -->
<?php get_footer( 'shop' ); ?>
