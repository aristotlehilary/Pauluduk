<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
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
    <div class="<?php amilia_main_class(); ?>">
        <div class="row">
            <?php if ($blog_layout == 'left-sidebar') : ?>
                <div class="col-xs-12 col-md-3 left-sidebar-wrap">
                    <?php get_sidebar(); ?>
                </div>
            <?php endif; ?>
            <div id="primary" class="col-xs-12 col-md-9">
                <div id="content" role="main">
                    <?php if ( have_posts() ) : ?>

                        <?php /* Start the Loop */ ?>
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php get_template_part( 'single-templates/content/content', get_post_format() ); ?>
                        <?php endwhile; ?>
                        
                        <?php amilia_paging_nav(); ?>

                    <?php else : ?>

                        <article id="post-0" class="post no-results not-found">

                            <?php if ( current_user_can( 'edit_posts' ) ) :
                                // Show a different message to a logged-in user who can add posts.
                                ?>
                                <header class="entry-header">
                                    <h1 class="entry-title"><?php esc_html_e( 'No posts to display', 'wp-amilia' ); ?></h1>
                                </header>

                                <div class="entry-content">
                                    <p><?php wp_kses( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'wp-amilia' ), admin_url( 'post-new.php' ) ); ?></p>
                                </div><!-- .entry-content -->

                            <?php else :
                                // Show the default message to everyone else.
                                ?>
                                <header class="entry-header">
                                    <h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'wp-amilia' ); ?></h1>
                                </header>

                                <div class="entry-content">
                                    <p><?php esc_html_e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'wp-amilia' ); ?></p>
                                    <?php get_search_form(); ?>
                                </div><!-- .entry-content -->
                            <?php endif; // end current_user_can() check ?>

                        </article><!-- #post-0 -->

                    <?php endif; // end have_posts() check ?>

                </div><!-- #content -->
            </div><!-- #primary -->
            <?php if ($blog_layout == 'right-sidebar') : ?>
                <div class="col-xs-12 col-md-3 right-sidebar-wrap">
                    <?php get_sidebar(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php get_footer(); ?>