<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, CMS Theme already
 * has tag.php for Tag archives, category.php for Category archives, and
 * author.php for Author archives.
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
                /* Start the Loop */
                while ( have_posts() ) : the_post();

                    /* Include the post format-specific template for the content. If you want to
                     * this in a child theme then include a file called called content-___.php
                     * (where ___ is the post format) and that will be used instead.
                     */
                    get_template_part( 'single-templates/content/content', get_post_format() );

                endwhile;

                amilia_paging_nav();
                ?>

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