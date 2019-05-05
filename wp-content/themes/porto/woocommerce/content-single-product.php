<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }

global $porto_layout, $porto_settings, $porto_product_layout;

$post_class = join( ' ', get_post_class() );
if ( isset( $porto_product_layout ) && ( $porto_layout === 'widewidth' || $porto_layout === 'wide-left-sidebar' || $porto_layout === 'wide-right-sidebar' ) ) {
    $post_class .= ' m-t-lg m-b-xl';
    if (porto_get_wrapper_type() !=='boxed')
        $post_class .= ' m-r-md m-l-md';
}

if ( !isset( $porto_product_layout ) ) {
    $porto_product_layout = 'default';
}

$post_class .= ' product-layout-' . esc_attr( $porto_product_layout );

$summary_before_classes = array( 'summary-before' );
$summary_classes = array( 'summary', 'entry-summary' );
$summary2_classes = false;
if ( $porto_product_layout == 'default' || $porto_product_layout == 'full_width' || $porto_product_layout == 'sticky_info' || $porto_product_layout == 'left_sidebar' ) {
    $summary_before_classes[] = 'col-lg-6';
    $summary_classes[] = 'col-lg-6';
} else if ( $porto_product_layout == 'transparent' ) {
    $summary_before_classes[] = 'col-lg-7';
    $summary_classes[] = 'col-lg-5';
} else if ( $porto_product_layout == 'grid' ) {
    $summary_before_classes[] = 'col-lg-8';
    $summary_classes[] = 'col-lg-4';
} else if ( $porto_product_layout == 'sticky_both_info' || $porto_product_layout == 'wide_grid' ) {
    $summary_before_classes[] = 'col-lg-6';
    $summary_classes[] = 'col-lg-3';
    $summary2_classes = $summary_classes;
}
?>

<!-- woocommerce_get_product_schema DEPRECATED with NO altertative in 3.0.0 -->
<div itemscope itemtype="<?php //echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" class="<?php echo $post_class ?>">

    <div class="product-summary-wrap">
    <?php if ( 'extended' !== $porto_product_layout ) : ?>
        <?php if ( 'sticky_both_info' === $porto_product_layout ) : ?>
            <div class="porto-woocommerce-summary-before">
                <?php
                    /**
                     * porto_woocommerce_before_single_product_summary hook.
                     */
                    do_action( 'porto_woocommerce_before_single_product_summary' );
                ?>
            </div>
        <?php endif; ?>
        <div class="row">
    <?php endif; ?>
            <div class="<?php echo implode( ' ', $summary_before_classes ); ?>">
            <?php if ( 'full_width' == $porto_product_layout ) : ?>
                <div class="porto-sticky-info">
            <?php endif; ?>
                <?php
                    /**
                     * woocommerce_before_single_product_summary hook.
                     *
                     * @hooked woocommerce_show_product_sale_flash - 10
                     * @hooked woocommerce_show_product_images - 20
                     */
                    do_action( 'woocommerce_before_single_product_summary' );
                ?>
            <?php if ( 'full_width' == $porto_product_layout ) : ?>
                </div>
            <?php endif; ?>
            </div>

            <div class="<?php echo implode( ' ', $summary_classes ); ?>">
            <?php if ( 'sticky_info' == $porto_product_layout || 'sticky_both_info' == $porto_product_layout ) : ?>
                <div class="porto-sticky-info" data-padding-top="<?php echo $porto_settings['grid-gutter-width'] - 5; ?>">
            <?php endif; ?>
                <?php
                    /**
                     * woocommerce_single_product_summary hook.
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
            <?php if ( 'sticky_info' == $porto_product_layout || 'sticky_both_info' == $porto_product_layout ) : ?>
                </div>
            <?php endif; ?>
            </div>

        <?php if ( isset( $summary2_classes ) && $summary2_classes ) : ?>
            <div class="<?php echo implode( ' ', $summary2_classes ); ?>">
            <?php if ( 'sticky_both_info' == $porto_product_layout ) : ?>
                <div class="porto-sticky-info" data-padding-top="<?php echo $porto_settings['grid-gutter-width'] - 5; ?>">
            <?php endif; ?>
                <?php
                    /**
                    * porto_woocommerce_single_product_summary2 hook.
                    */

                    do_action( 'porto_woocommerce_single_product_summary2' );
                ?>
            <?php if ( 'sticky_both_info' == $porto_product_layout ) : ?>
                </div>
            <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php if ( 'extended' !== $porto_product_layout ) : ?>
        </div><!-- .summary -->
    <?php endif; ?>
    </div>

	<?php
		/**
		 * woocommerce_after_single_product_summary hook.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
