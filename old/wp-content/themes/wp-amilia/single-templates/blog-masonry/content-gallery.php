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

<article id="post-<?php the_ID(); ?>" <?php post_class('cms-blog-item pb-70 clearfix'); ?>>
	<?php amilia_archive_gallery('amilia-portfolio-square'); ?>
	<header class="entry-header">
		<h3 class="entry-title">
	    	<a href="<?php the_permalink(); ?>">
	    		<?php
		    		if(is_sticky()) {
		                echo "<i class='fa fa-thumb-tack'></i>";
		            }
		    	?>
	    		<?php the_title(); ?>
	    	</a>
	    </h3>
	</header>
	<div class="entry-content">
		<?php the_excerpt();
    		wp_link_pages( array(
        		'before'      => '<div class="pagination loop-pagination"><span class="page-links-title">' . esc_html__( 'Pages:','wp-amilia') . '</span>',
        		'after'       => '</div>',
        		'link_before' => '<span class="page-numbers">',
        		'link_after'  => '</span>',
    		) );
		?>
	</div>
	<!-- .entry-content -->
	<footer class="entry-footer">
	    <?php amilia_archive_readmore(); ?>
	    <!-- .readmore link -->
	</footer>
	<!-- .entry-footer -->
</article>
<!-- #post -->