<?php
/**
 * Template Name: BLog Left Sidebar
 *
 * @package CMSSuperHeroes
 * @subpackage CMS Theme
 * @since 1.0.0
 * @author Fox
 */

get_header(); ?>
<div id="page-left-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 left-sidebar-wrap">
                <?php get_sidebar(); ?>
            </div>
            <div id="primary" class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                <div id="content" role="main">
                    <?php global $wp_query, $paged; ?>

                    <?php $wp_query = new WP_Query( 'post_type=post&showposts='.get_option('posts_per_page').'&paged='.$paged ); ?>
                    
                    <?php if ( have_posts() ) : ?>
                        <?php while ( have_posts() ) : the_post();
                            /* Include the post format-specific template for the content. If you want to
                             * this in a child theme then include a file called called content-___.php
                             * (where ___ is the post format) and that will be used instead.
                             */
                            get_template_part( 'single-templates/content/content', get_post_format() );
                        endwhile; // end of the loop.?>
                        
                        <?php amilia_paging_nav(); ?>
                        
                    <?php else : ?>
                        <?php get_template_part( 'single-templates/content', 'none' ); ?>
                    <?php endif; ?> 

                    <?php wp_reset_query();?>
                </div><!-- #content -->
            </div><!-- #primary -->
        </div><!-- #primary -->
	</div><!-- #primary -->

    <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
    <?php endwhile; // end of the loop. ?>
</div>
<?php get_footer(); ?>