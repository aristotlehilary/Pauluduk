<?php
/**
 * Template Name: Blog Masonry Ajax
 *
 * @package CMSSuperHeroes
 * @subpackage wp-amilia
 * @since 1.0.0
 * @author nguyenluan2002
 */

get_header(); ?>
<?php 
    //try add js for masonry and loadmore ajax
    wp_enqueue_script('blog-timeline', get_template_directory_uri(). '/assets/js/blog-timeline.js', array('jquery-shuffle'));
    
?>
<div id="page-front-page">
    <div class="container">
        <div class="row">
            <div id="primary">
                <div id="content" role="main" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <?php global $wp_query, $paged; ?>
                    
                    <?php $wp_query = new WP_Query('post_type=post&showposts='.get_option('posts_per_page').'&paged='.$paged); ?>
                    
                    <?php if ( have_posts() ) : ?>
                    <?php 
                        //load more object for js

                        wp_enqueue_style( 'wp-mediaelement' );
                        wp_enqueue_script( 'wp-mediaelement' );

                        $max = $wp_query->max_num_pages;

                        // Add some parameters for the JS.
                        wp_localize_script(
                            'blog-timeline',
                            'timeline_obj',
                            array(
                                'startPage' => ($paged) ? $paged : 1,
                                'maxPages' => $max,
                                'total' => $wp_query->found_posts,
                                'perpage' => get_option('posts_per_page'),
                                'nextLink' => next_posts($max, false),
                                'masonry' => 'masonry'
                            )
                        );
                        wp_enqueue_script( 'blog-timeline' );
                    ?>
                        <div class="blog-timeline cms-grid-wraper cms-grid-masonry">
                            <?php while ( have_posts() ) : the_post();
                                /* Include the post format-specific template for the content. If you want to
                                 * this in a child theme then include a file called called content-___.php
                                 * (where ___ is the post format) and that will be used instead.
                                 */
                                ?>
                                <div class="timeline-blog-item cms-grid-item cms-blog-masonry col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                    <?php get_template_part( 'single-templates/blog-masonry/content', get_post_format() ); ?>
                                </div>
                                <?php
                            endwhile; // end of the loop.?>
                        </div>
                    <?php else : ?>
                        <?php get_template_part( 'single-templates/content', 'none' ); ?>
                    <?php endif; ?> 
                    <?php wp_reset_query();?>
                </div><!-- #content -->
            </div><!-- #primary -->
            <div class="cms-pagination-masonry"><div class="cms_pagination"></div></div>
        </div>
    </div>
</div>
<?php get_footer(); ?>