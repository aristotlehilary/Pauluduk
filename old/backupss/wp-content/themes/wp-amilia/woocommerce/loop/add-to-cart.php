<?php
/**
 * Loop Add to Cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
echo '<div class="cms-product-action-wrap">';
	echo '<div class="cms-product-action">';
	echo apply_filters( 'woocommerce_loop_add_to_cart_link',
		sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="cms-button medium gray-light %s">%s</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( isset( $quantity ) ? $quantity : 1 ),
			esc_attr( $product->id ),
			esc_attr( $product->get_sku() ),
			esc_attr( isset( $class ) ? $class : '' ),
			esc_html( $product->add_to_cart_text() )
		),
	$product );
	echo '</div>';
	echo '<div class="cms-product-share">';
	do_action('cms_product_social');
	echo '</div>';
echo '</div>';