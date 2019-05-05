<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package CMSSuperHeroes
 * @subpackage CMS Theme
 * @since 1.0.0
 */

$woo_show_newsletter = amilia_get_value_smofdata('woo_show_newsletter');
?>
<?php
	if ( !empty($woo_show_newsletter) && class_exists('Woocommerce') && (is_checkout() || is_cart() || is_product() || is_shop() || is_woocommerce()) ) {
		echo '<div class="newsletter-on-single mt-80 mb-40">';
		echo apply_filters('the_content', '[cms_newsletter]');
		echo '</div>';
	}
	do_action( 'woocommerce_after_single_product' );
?>
        </div><!-- #main -->
        <div class="footer-offset">
            <?php amilia_footer(); ?>   
        </div>
    </div><!-- #page -->
    <?php wp_footer(); ?>
</body>
</html>