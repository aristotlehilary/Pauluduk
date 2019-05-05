<?php
/**
 * The template for displaying Author Archive pages
 *
 * Used to display archive-type pages for posts by an author.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package CMSSuperHeroes
 * @subpackage CMS Theme
 * @since 1.0.0
 */

get_header(); 

$blog_layout = amilia_get_value_smofdata('blog_layout');
?>
<div class="container">
    <div class="row">
		<?php if ($blog_layout == 'left-sidebar') : ?>
            <div class="col-xs-12 col-md-3 left-sidebar-wrap">
                <?php get_sidebar(); ?>
            </div>
        <?php endif; ?>
        <section id="primary" class="col-xs-12 col-md-9">
            <div id="content" role="main">
				<?php if ( have_posts() ) : ?>
					<?php
						/* Queue the first post, that way we know
						 * what author we're dealing with (if that is the case).
						 *
						 * We reset this later so we can run the loop
						 * properly with a call to rewind_posts().
						 */
						the_post();
					?>

					<header class="archive-header">
						<h1 class="archive-title"><?php printf( esc_html__( 'Author Archives: %s', 'wp-amilia' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h1>
					</header><!-- .archive-header -->

					<?php
						/* Since we called the_post() above, we need to
						 * rewind the loop back to the beginning that way
						 * we can run the loop properly, in full.
						 */
						rewind_posts();
					?>

					<?php
					// If a user has filled out their description, show a bio on their entries.
					if ( get_the_author_meta( 'description' ) ) : ?>
						<div class="post-author-wrap mb-30">
	                        <div class="post-author-inner">
	                            <div class="post-author-avatar">
	                                <?php echo get_avatar( get_the_author_meta( 'user_email' ), 92 ); ?>
	                            </div>
	                            <div class="post-author-bio">
	                                <div class="author-info">
	                                    <?php printf( esc_html__( 'About %s', 'wp-amilia' ), get_the_author() ); ?>
	                                </div>
	                                <div class="author-bio"><?php the_author_meta( 'description' ); ?></div>
	                            </div>
	                        </div>
	                    </div> 
					<?php endif; ?>

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'single-templates/content/content', get_post_format() ); ?>
					<?php endwhile; ?>
					<div class="clearfix mb-80">
						<?php amilia_paging_nav(); ?>
					</div>
				<?php else : ?>
					<?php get_template_part( 'single-templates/content', 'none' ); ?>
				<?php endif; ?>

			</div><!-- #content -->
        </section><!-- #primary -->
        <?php if ($blog_layout == 'right-sidebar') : ?>
            <div class="col-xs-12 col-md-3 right-sidebar-wrap">
                <?php get_sidebar(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php get_footer(); ?>