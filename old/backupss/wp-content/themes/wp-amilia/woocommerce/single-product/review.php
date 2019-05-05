<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

?>
<li itemprop="review" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

	<div id="comment-<?php comment_ID(); ?>" class="comment_container clearfix">
		<div class="comment-author-image vcard pull-left">
			<?php echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '90' ), '' ); ?>
		</div>
		<div class="comment-main">
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<p class="meta"><em><?php esc_html_e( 'Your comment is awaiting approval', 'wp-amilia' ); ?></em></p>
			<?php else : ?>
				<div class="comment-meta commentmetadata">
					<span class="comment-author" itemprop="author"><?php comment_author(); ?></span>
					<span class="comment-date" itemprop="datePublished" datetime="<?php echo get_comment_date( 'c' ); ?>">
						<?php comment_time('M d, Y, \a\t g:i'); ?>
					</span>
					<?php if ( $rating && get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) : ?>
						<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf( esc_html__( 'Rated %d out of 5', 'wp-amilia' ), $rating ) ?>">
							<span style="width:<?php echo ( $rating / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php echo ''.$rating; ?></strong> <?php esc_html_e( 'out of 5', 'wp-amilia' ); ?></span>
						</div>
					<?php endif; ?>
				</div>
				<div class="comment-text" itemprop="description">
					<?php comment_text(); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
