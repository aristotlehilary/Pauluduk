<?php
/**
 * Single Product Rating
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.3.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
	return;
}

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();


echo '<div class="row">';
echo '<div class="col-xs-6 pull-right text-right cms-product-rating-wrap">';
if ( $rating_count > 0 ) : ?>

	<div class="woocommerce-product-rating clearfix" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
		<?php if ( comments_open() ) : ?><a href="#reviews" class="woocommerce-review-link" rel="nofollow"><small><?php printf( _n( '%s review', '%s reviews', $review_count, 'wp-amilia' ), '<span itemprop="reviewCount" class="count">' . $review_count . '</span>' ); ?></small></a><?php endif ?>
		<div class="star-rating" title="<?php printf( esc_html__( 'Rated %s out of 5', 'wp-amilia' ), $average ); ?>">
			<span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
				<strong itemprop="ratingValue" class="rating"><?php echo esc_html( $average ); ?></strong> <?php printf( esc_html__( 'out of %s5%s', 'wp-amilia' ), '<span itemprop="bestRating">', '</span>' ); ?>
				<?php printf( _n( 'based on %s customer rating', 'based on %s customer ratings', $rating_count, 'wp-amilia' ), '<span itemprop="ratingCount" class="rating">' . $rating_count . '</span>' ); ?>
			</span>
		</div>
	</div>

<?php endif; ?>
</div>