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

global $smof_data;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('cms-blog-item cms-single-blog clearfix'); ?>>
	<?php if (has_post_thumbnail() && $smof_data['single_featured_images']) : ?>
		<?php amilia_the_post_thumbnail(); ?>
	<?php endif; ?>
	<?php if ($smof_data['show_single_title']): ?>
		<header class="entry-header">
			<h3 class="entry-title">
		    	<?php
		    		if(is_sticky()){
		                echo "<i class='fa fa-thumb-tack'></i>";
		            }
		    	?>
	    		<?php the_title(); ?>
		    </h3>
		</header>
	<?php endif ?>
	<div class="entry-meta">
		<?php amilia_blog_post_meta(); ?>
	</div>
	<div class="entry-content">
		<?php the_content();
    		wp_link_pages( array(
        		'before'      => '<div class="pagination loop-pagination"><span class="page-links-title">' . esc_html__( 'Pages:','wp-amilia') . '</span>',
        		'after'       => '</div>',
        		'link_before' => '<span class="page-numbers">',
        		'link_after'  => '</span>',
    		) );
		?>
	</div>
	<footer class="entry-footer">
		<?php if ($smof_data['show_tags_post']): ?>
			<?php amilia_single_tagclouds(); ?>
		<?php endif ?>
	  	<?php if ($smof_data['show_social_post']): ?>
	  		<?php amilia_social_share(); ?>
	  	<?php endif ?>
	</footer>
</article>