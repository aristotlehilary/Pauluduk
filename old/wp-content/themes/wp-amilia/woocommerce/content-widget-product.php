<?php global $product; ?>
<li class="clearfix">
	<a class="cms-featured-wg" href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
		<?php echo ''.$product->get_image(); ?>
	</a>
	<div class="cms-widget-product-desc">
		<a class="product-title" href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>"><?php echo ''.$product->get_title(); ?>
		</a>
		<?php echo ''.$product->get_price_html(); ?>
		<?php /*if ( ! empty( $show_rating ) )*/ echo ''.$product->get_rating_html(); ?>
	</div>
</li>