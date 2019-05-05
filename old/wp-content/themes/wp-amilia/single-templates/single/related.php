<?php
$orig_post = $post;  
global $post;  
$tags = wp_get_post_tags($post->ID);  

if ($tags) {
    $tag_ids = array();  
    foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;  
    $args = array(  
        'tag__in' => $tag_ids,  
        'post__not_in' => array($post->ID),  
        'posts_per_page'=>3, // Number of related posts to display.  
        'ignore_sticky_posts'=>1  
    );

    $related_posts = new WP_Query($args);
    if ($related_posts->have_posts()) { ?>
    	<div class="related-post-wrap">
			<div class="vc_custom_heading cms-custom-heading heading-line cms-h3 mb-30">
	            <h3 class="cms-heading-inner"><?php esc_html_e('RELATED POSTS', 'wp-amilia') ?></h3>
	        </div>

	        <div class="row related-posts">
	    	<?php while( $related_posts->have_posts() ) {
		    	$related_posts->the_post();   
		    	?>
		    		<article id="related-post-<?php the_ID(); ?>" <?php post_class('cms-blog-item col-xs-12 col-sm-4 col-md-4 mb-50'); ?>>
						<?php amilia_the_post_thumbnail(); ?>
						<header class="entry-header">
							<h3 class="entry-title">
						    	<a href="<?php the_permalink(); ?>">
						    		<?php the_title(); ?>
						    	</a>
						    </h3>
						</header>
						<div class="entry-meta">
							<ul class="entry-meta-inner clearfix">
						        <li class="entry-date">
						            <i class="icon_clock_alt" aria-hidden="true"></i>
						            <?php echo get_the_date('j F Y'); ?>
						        </li>
						        <li class="entry-comments">
						            <i class="icon_comment_alt" aria-hidden="true"></i>
						            <a href="<?php the_permalink(); ?>"><?php comments_number(esc_html__('0 Comments','wp-amilia'), esc_html__('1 Comments','wp-amilia'), esc_html__('% Comments','wp-amilia')); ?></a>
						        </li>
						   	</ul>
						</div>
						<div class="entry-content">
							<p><?php echo wp_trim_words(get_the_excerpt(),15,'') ?></p>
						</div>
						<footer class="entry-footer">
						    <?php amilia_archive_readmore(); ?>
						</footer>
					</article><!-- #post-## -->
		    	<?php
			}
			echo '</div>';
		echo '</div>';
    }  
}
$post = $orig_post;
wp_reset_postdata();