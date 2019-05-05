<?php
/**
 * Variable product add to cart
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $post;
?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo esc_attr($post->ID); ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
	<?php if ( ! empty( $available_variations ) ) : ?>

		<div class="row variations mb-0">
			<div class="col-sm-6">
				<?php $loop = 0; foreach ( $attributes as $name => $options ) : $loop++; ?>
					<?php if ($loop > 0 && $loop%2 == 0) : ?>
						</div><div class="col-sm-6">
					<?php endif; ?>
					
					<select id="<?php echo esc_attr( sanitize_title( $name ) ); ?>" name="attribute_<?php echo sanitize_title( $name ); ?>" data-attribute_name="attribute_<?php echo sanitize_title( $name ); ?>">
						<option value=""><?php echo esc_html__( 'Choose ', 'wp-amilia' ) ?><?php echo wc_attribute_label( $name ); ?></option>
						<?php
							if ( is_array( $options ) ) {

								if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) ) {
									$selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $name ) ];
								} elseif ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) {
									$selected_value = $selected_attributes[ sanitize_title( $name ) ];
								} else {
									$selected_value = '';
								}

								// Get terms if this is a taxonomy - ordered
								if ( taxonomy_exists( $name ) ) {

									$terms = wc_get_product_terms( $post->ID, $name, array( 'fields' => 'all' ) );

									foreach ( $terms as $term ) {
										if ( ! in_array( $term->slug, $options ) ) {
											continue;
										}
										echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
									}

								} else {

									foreach ( $options as $option ) {
										echo '<option value="' . esc_attr( sanitize_title( $option ) ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
									}

								}
							}
						?>
					</select>
					<?php
						if ( sizeof( $attributes ) === $loop ) {
							echo '<a class="reset_variations" href="#reset">' . esc_html__( 'Clear selection', 'wp-amilia' ) . '</a>';
						}
					?>
				<?php endforeach; ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap" style="display:none;">
			<hr class="mt-0 mb-30">

			<?php do_action( 'woocommerce_before_single_variation' ); ?>

			<div class="single_variation cms-product-price-wrap mb-30"></div>

			<div class="variations_button row mb-30">

				<?php woocommerce_quantity_input( array(
					'input_value' => ( isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 )
				) ); ?>
				<div class="col-xs-8 col-sm-10 col-md-6 cms-product-action">
					<div class="cms-add-cart-wrap">
						<button type="submit" class="single_add_to_cart_button cms-button medium gray"><?php echo ''.$product->single_add_to_cart_text(); ?></button>
					</div>
					<?php do_action('cms_product_social'); ?>
				</div>
			</div>

			<input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->id); ?>" />
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
			<input type="hidden" name="variation_id" class="variation_id" value="" />

			<?php do_action( 'woocommerce_after_single_variation' ); ?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<?php else : ?>

		<p class="stock out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'wp-amilia' ); ?></p>

	<?php endif; ?>

</form>
<hr class="mt-0 mb-30">

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
