<?php
/**
 * Display single product reviews (comments)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     9.0.0
 */
global $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews">
	<div id="comments" class="comments-area">

		<?php if ( have_comments() ) : ?>

			<ol class="comment-list mb-30">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
					'type'      => 'list',
				) ) );
				echo '</nav>';
			endif; ?>

		<?php else : ?>

			<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'wp-amilia' ); ?></p>

		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->id ) ) : ?>

		<div id="review_form_wrapper">
			<div id="review_form">
				<?php
					$commenter = wp_get_current_commenter();

					$comment_form = array(
						'title_reply'          => have_comments() ? esc_html__( 'Add a review', 'wp-amilia' ) : esc_html__( 'Be the first to review', 'wp-amilia' ) . ' &ldquo;' . get_the_title() . '&rdquo;',
						'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'wp-amilia' ),
						'comment_notes_before' => '',
						'comment_notes_after'  => '',
						'fields'               => array(
							'author' => '<div class="col-md-4 mb-30">' .
							            '<input id="author" class="comment-form-author form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" placeholder="'.__( 'NAME', 'wp-amilia' ).'"/></div>',
							'email'  => '<div class="col-md-4 mb-30"> ' .
							            '<input id="email" class="comment-form-email form-control" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" placeholder="' . esc_html__( 'EMAIL', 'wp-amilia' ) . '"/></div>',
						),
						'label_submit'  => esc_html__( 'SEND MESSAGE', 'wp-amilia' ),
						'logged_in_as'  => '',
						'comment_field' => ''
					);

					if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
						$comment_form['comment_field'] = '<div class="col-md-4 mb-30"><select name="rating" id="cms-rating">
							<option value="">' . esc_html__( 'SELECT A RATING', 'wp-amilia' ) . '</option>
							<option value="5">' . esc_html__( '5', 'wp-amilia' ) . '</option>
							<option value="4">' . esc_html__( '4', 'wp-amilia' ) . '</option>
							<option value="3">' . esc_html__( '3', 'wp-amilia' ) . '</option>
							<option value="2">' . esc_html__( '2', 'wp-amilia' ) . '</option>
							<option value="1">' . esc_html__( '1', 'wp-amilia' ) . '</option>
						</select></div>';
					}

					$comment_form['comment_field'] .= '<div class="col-md-12 mb-30"><textarea id="comment" class="comment-form-comment form-control" name="comment" placeholder="'.__('COMMENT', 'wp-amilia').'" maxlength="5000" aria-required="true"></textarea></div>';

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>

	<?php else : ?>

		<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'wp-amilia' ); ?></p>

	<?php endif; ?>

	<div class="clear"></div>
</div>
