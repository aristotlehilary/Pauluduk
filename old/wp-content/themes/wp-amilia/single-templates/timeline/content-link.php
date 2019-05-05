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
<div class="timeline-block cms-blog-item">
    <div class="timeline-icon">
        <?php amilia_archive_post_icon(); ?>
    </div>
    <div class="timeline-content">
    	<?php
			if (get_post_format(get_the_ID()) == 'link') {
				amilia_archive_audio('soundcloud', false);
			}
		?>
        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
        <div class="entry-meta">
			<?php amilia_blog_post_meta(); ?>
		</div>
        <div class="entry-excerpt">
            <?php the_excerpt(); ?>
        </div>
        <footer class="entry-footer">
            <?php amilia_archive_readmore(); ?>
        </footer>
        <div class="entry-date">
            <span class="entry-date-year"><?php the_time('Y');?></span>
            <span class="entry-date-month"><?php the_time('M j');?></span>
        </div>
    </div>
</div>