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

<article id="post-<?php the_ID(); ?>" <?php post_class('cms-blog-item blog-small-image mb-50 clearfix'); ?>>
	<div class="row">   
        <div class="col-xs-12 col-sm-6 col-md-4">
        	<?php amilia_archive_gallery('amilia-portfolio-square'); ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-8">
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
				<p><?php echo wp_trim_words(get_the_excerpt(),30,'') ?></p>
				<?php
		    		wp_link_pages( array(
		        		'before'      => '<div class="pagination loop-pagination"><span class="page-links-title">' . esc_html__( 'Pages:','wp-amilia') . '</span>',
		        		'after'       => '</div>',
		        		'link_before' => '<span class="page-numbers">',
		        		'link_after'  => '</span>',
		    		) );
				?>
			</div>
			<footer class="entry-footer">
			    <?php amilia_archive_readmore(); ?>
			</footer>
        </div>
    </div>
</article>