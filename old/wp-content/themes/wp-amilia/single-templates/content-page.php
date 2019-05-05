<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package CMSSuperHeroes
 * @subpackage CMS Theme
 * @since 1.0.0
 */
?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
			<?php the_content(); ?>
	</div><!-- .entry-content -->
</div><!-- #post -->
