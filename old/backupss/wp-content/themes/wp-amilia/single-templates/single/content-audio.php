<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package CMSSuperHeroes
 * @subpackage CMS Theme
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('cms-blog-item cms-single-blog clearfix'); ?>>
	<?php amilia_audio_html5(); ?>
	<header class="entry-header">
		<h3 class="entry-title">
	    	<a href="<?php the_permalink(); ?>">
	    		<?php
		    		if(is_sticky()){
		                echo "<i class='fa fa-thumb-tack'></i>";
		            }
		    	?>
	    		<?php the_title(); ?>
	    	</a>
	    </h3>
	</header>
	<div class="entry-meta">
		<?php amilia_blog_post_meta(); ?>
	</div>
	<div class="entry-content">
		<?php
			preg_match('/\[audio src="(.*)?"\]/', get_the_content() , $matches);
			if (empty($matches)) {
				the_content();
			} else {
				echo apply_filters('the_content', preg_replace(array('/\[audio(.*)\](.*)\[\/audio\]/', '/\[audio(.*)\]/', '/\[playlist(.*)\]/'), '', get_the_content(), 1));
			}

			wp_link_pages( array(
        		'before'      => '<div class="pagination loop-pagination"><span class="page-links-title">' . esc_html__( 'Pages:','wp-amilia') . '</span>',
        		'after'       => '</div>',
        		'link_before' => '<span class="page-numbers">',
        		'link_after'  => '</span>',
    		) );
		?>
	</div>
	<footer class="entry-footer">
	    <?php amilia_single_tagclouds(); ?>
	    <?php amilia_social_share(); ?>
	</footer>
</article>