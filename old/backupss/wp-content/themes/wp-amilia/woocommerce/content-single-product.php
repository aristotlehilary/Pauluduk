<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     9.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $smof_data;
?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class('cms-single-product-wrap'); ?>>

    <div class="container">
   		<div class="row">
			<div class="woo-media-detail-wrap col-md-4 col-sm-12 mb-50">
				<?php
					/**
					 * woocommerce_before_single_product_summary hook
					 *
					 * @hooked woocommerce_show_product_sale_flash - 10
					 * @hooked woocommerce_show_product_images - 20
					 */
					do_action( 'woocommerce_before_single_product_summary' );
				?>
			</div>
			<div class="col-md-7 col-sm-12 col-md-offset-1 mb-50">
				<div class="entry-summary">
					<?php
						/**
						 * woocommerce_single_product_summary hook
						 *
						 * @hooked woocommerce_template_single_title - 5
						 * @hooked woocommerce_template_single_rating - 10
						 * @hooked woocommerce_template_single_price - 10
						 * @hooked woocommerce_template_single_excerpt - 20
						 * @hooked woocommerce_template_single_add_to_cart - 30
						 * @hooked woocommerce_template_single_meta - 40
						 * @hooked woocommerce_template_single_sharing - 50
						 */
						do_action( 'woocommerce_single_product_summary' );
					?>
				</div><!-- .summary -->
		    </div>
		</div>   
		<meta itemprop="url" content="<?php the_permalink(); ?>" />
	</div>

	<div class="container mb-80">
		<?php
	    /**
	     * woocommerce_after_single_product_summary hook
	     *
	     * @hooked woocommerce_output_product_data_tabs - 10
	     * @hooked woocommerce_upsell_display - 15
	     * @hooked woocommerce_output_related_products - 20
	     */
	    do_action( 'woocommerce_after_single_product_summary' );
    ?>
	</div>

	<div class="container amilia-related-product-wrap">
		<?php
            $product_category = '';
            $terms = get_the_terms(get_the_ID(), 'product_cat');
            if(!empty($terms)) {
                
                $product_category = array();
                
                foreach ($terms as $term){
                    $product_category[] = $term->term_id;
                }   
                
                $product_category = '|tax_query:'.implode(',', $product_category);
            } 
            echo apply_filters('the_content', '[cms_carousel xsmall_items="2" small_items="2" medium_items="3" large_items="4" not__in="true" margin="30" nav="false" dots="false" carousel_heading="RELATED PRODUCTS" carousel_vieall="true" carousel_viewall_link="#" source="size:6|order_by:date|post_type:product|'.$product_category.'" cms_template="cms_carousel--woo-product.php"]')
        ?>
	</div>
</div><!-- #product-<?php the_ID(); ?> -->