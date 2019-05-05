<?php
/**
 * Cart Page
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<div class="table-responsive">
	<form class="form" action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

	<?php do_action( 'woocommerce_before_cart_table' ); ?>
	<div class="mb-60">
		<table class="cms-shop-table table table-striped shopping-cart-table" cellspacing="0">
			<thead>
				<tr>
					<th class="product-number">&nbsp;</th>
					<th class="product-thumbnail"><?php esc_html_e( 'Photo', 'wp-amilia' ); ?></th>
					<th class="product-name"><?php esc_html_e( 'Product', 'wp-amilia' ); ?></th>
					<th class="product-price"><?php esc_html_e( 'Unit Price', 'wp-amilia' ); ?></th>
					<th class="product-quantity"><?php esc_html_e( 'Quantity', 'wp-amilia' ); ?></th>
					<th class="product-subtotal"><?php esc_html_e( 'Total', 'wp-amilia' ); ?></th>
					<th class="product-remove">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php do_action( 'woocommerce_before_cart_contents' ); ?>

				<?php
				$i = 1;
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						?>
						<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

							<td class="text-center"><?php echo esc_attr($i); ?></td>
							<td class="product-thumbnail">
								<?php
									$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

									if ( ! $_product->is_visible() ) {
										echo ''.$thumbnail;
									} else {
										printf( '<a href="%s">%s</a>', esc_url( $_product->get_permalink( $cart_item ) ), $thumbnail );
									}
								?>
							</td>

							<td class="product-name">
								<?php
									if ( ! $_product->is_visible() ) {
										echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
									} else {
										echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', esc_url( $_product->get_permalink( $cart_item ) ), $_product->get_title() ), $cart_item, $cart_item_key );
									}

									// Meta data
									echo WC()->cart->get_item_data( $cart_item );

									// Backorder notification
									if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
										echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'wp-amilia' ) . '</p>';
									}
								?>
							</td>

							<td class="product-price">
								<?php
									echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
								?>
							</td>

							<td class="product-quantity">
								<?php
									if ( $_product->is_sold_individually() ) {
										$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
									} else {
										$product_quantity = woocommerce_quantity_input( array(
											'input_name'  => "cart[{$cart_item_key}][qty]",
											'input_value' => $cart_item['quantity'],
											'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
											'min_value'   => '0'
										), $_product, false );
									}

									echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
								?>
							</td>

							<td class="product-subtotal">
								<?php
									echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
								?>
							</td>
							<td class="product-remove">
								<?php
									echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove icon-close" title="%s"><span class="icon_close" aria-hidden="true"></span></a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), esc_html__( 'Remove this item', 'wp-amilia' ) ), $cart_item_key );
								?>
							</td>
						</tr>
						<?php
						$i ++;
					}
				}

				do_action( 'woocommerce_cart_contents' );
				?>

				<?php do_action( 'woocommerce_after_cart_contents' ); ?>
			</tbody>
		</table>

		<?php do_action( 'woocommerce_after_cart_table' ); ?>
	</div>

	<hr class="mt-0 mb-30">
	<div class="cms-coupon-wrap over-hidden">
		<div class="row">
			<div class="col-sm-8">
				<?php if ( WC()->cart->coupons_enabled() ) { ?>
					<div class="coupon row">
						<div class="col-sm-6 mb-10">
							<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_html_e( 'COUPON CODE', 'wp-amilia' ); ?>" /> 	
						</div>
						<div class="col-sm-6 mb-30">
							<input type="submit" class="cms-button medium gray-light w-100-767" name="apply_coupon" value="<?php esc_html_e( 'APPLY CODE', 'wp-amilia' ); ?>" />	
						</div>
						<?php do_action( 'woocommerce_cart_coupon' ); ?>
					</div>
				<?php } ?>
			</div>
			<div class="col-sm-4 text-right text-center-767 mb-30">
				<input type="submit" class="cms-button medium gray-light w-100-767" name="update_cart" value="<?php esc_html_e( 'UPDATE CART', 'wp-amilia' ); ?>" />
				<?php do_action( 'woocommerce_cart_actions' ); ?>
				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			</div>
		</div>
	</div>
	<hr class="mt-0 mb-60">
	</form>
</div><!-- .table-responsive -->


<div class="cart-collateral row">
	<?php do_action( 'woocommerce_cart_collaterals' ); ?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
