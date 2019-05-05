<?php
/**
 * Template Name: Page Shortcodes
 *
 * @package CMSSuperHeroes
 * @subpackage CMS Theme
 * @since 1.0.0
 * @author Fox
 */

get_header();
?>
<div id="page-left-sidebar" class="page-has-sidebar page-shortcodes">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-3 col-lg-3 hidden-xs hidden-sm">
                <?php
                    if ( is_active_sidebar( 'shortcodes-sidebar' ) ) {
                        dynamic_sidebar( 'shortcodes-sidebar' );
                    }
                ?>
            </div>
            <div id="primary" class="col-xs-12 col-md-9 col-lg-9">
                <div id="content" role="main">

                   <?php
                        // Start the loop.
                        while ( have_posts() ) : the_post();

                            // Include the page content template.
                            get_template_part( 'single-templates/content', 'page' );

                            // If comments are open or we have at least one comment, load up the comment template.
                            if ( comments_open() || get_comments_number() ) :
                                comments_template();
                            endif;

                        // End the loop.
                        endwhile;
                        ?>

                </div><!-- #content -->
            </div><!-- #primary -->
        </div><!-- #primary -->
	</div><!-- #primary -->
</div>
<?php if (class_exists('Vc_Manager')) : ?>
    <div class="newsletter-on-single mt-40 mb-40">
        <?php
            echo apply_filters('the_content', '[cms_newsletter]');
        ?>
    </div>
<?php endif; ?>
<?php get_footer(); ?>