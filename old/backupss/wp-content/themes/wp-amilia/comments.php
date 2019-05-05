<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package cshero
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php // You can start editing here -- including this comment! ?>
	<?php if ( have_comments() ) : ?>
        <div class="cms-comments-wrap clearfix">
            <h4 class="comments-title">
                <span><?php comments_number(esc_html__('Comments','wp-amilia'),esc_html__('1 Comments','wp-amilia'),esc_html__('% Comments','wp-amilia')); ?></span>
            </h4>
            <ol class="comment-list">
				<?php wp_list_comments( 'type=comment&callback=amilia_comment' ); ?>
			</ol>
			<?php amilia_comment_nav(); ?>
        </div>
	<?php endif; // have_comments() ?>

	<?php
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name__mail' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$args = array(
			'id_form'           => 'commentform',
			'id_submit'         => 'submit',
			'title_reply'       => '<span>'.esc_html__( 'LEAVE A COMMENT','wp-amilia').'</span>',
			'title_reply_to'    => esc_html__( 'LEAVE A REPLY TO %s','wp-amilia'),
			'cancel_reply_link' => esc_html__( 'CANCEL REPLY','wp-amilia'),
			'label_submit'      => esc_html__( 'SEND MESSAGE','wp-amilia'),
			'comment_notes_before' => '',
			'fields' => apply_filters( 'comment_form_default_fields', array(

					'author' =>
					'<p class="comment-form-author col-md-6">'.
					'<input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
					'" size="30"' . $aria_req . ' placeholder="'.esc_html__('NAME','wp-amilia').'"/></p>',

					'email' =>
					'<p class="comment-form-email col-md-6">'.
					'<input id="email" class="form-control" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
					'" size="30"' . $aria_req . ' placeholder="'.esc_html__('EMAIL','wp-amilia').'"/></p>',
			)
			),
			'comment_field' =>  '<p class="comment-form-comment col-md-12"><textarea id="comment" class="form-control" name="comment" cols="45" rows="8" placeholder="'.esc_html__('MESSAGE','wp-amilia').'" aria-required="true">' .
			'</textarea></p>',
	);
	?>
	<?php comment_form($args); ?>

</div><!-- #comments -->
