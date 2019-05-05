<?php
/**
 * The Template for displaying all single posts
 *
 * @package CMSSuperHeroes
 * @subpackage CMS Theme
 * @since 1.0.0
 */

get_header();
amilia_set_post_views(get_the_ID());
$single_layout = amilia_get_value_smofdata('single_layout');
$tracking_layout = (!empty( $single_layout )) ? $single_layout : 'right-sidebar';
?>
<div class="<?php amilia_main_class(); ?>">
    <div class="row">
        <?php if ($tracking_layout == 'left-sidebar'): ?>
            <div class="col-xs-12 col-md-3 left-sidebar-wrap">
                <?php get_sidebar(); ?>
            </div>
        <?php endif ?>
        <div id="primary" class="col-xs-12 col-md-9">
            <div id="content" role="main">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'single-templates/single/content', get_post_format() ); ?>
                    <?php if ($smof_data['show_admin_bio']): ?>
                        <div class="post-author-wrap mb-30">
                            <div class="post-author-inner">
                                <div class="post-author-avatar">
                                    <?php echo get_avatar(get_the_author_meta(get_the_ID()), 92); ?>
                                </div>
                                <div class="post-author-bio">
                                    <div class="author-info">
                                        <?php esc_html_e('Posted By', 'wp-amilia'); ?> <?php the_author_posts_link(); ?>
                                    </div>
                                    <div class="author-bio"><?php echo get_the_author_meta('description'); ?></div>
                                </div>
                            </div>
                        </div>    
                    <?php endif ?>
                    <?php if ($smof_data['show_single_related']): ?>
                        <?php
                        /* Related post */
                        get_template_part( 'single-templates/single/related'); ?>    
                    <?php endif ?>
                    
                    <?php if ( comments_open() ) : ?>
                        <?php if ( !empty($smof_data['comments_post_type']) && $smof_data['comments_post_type'] == 'facebook' ) : ?>
                            <?php do_action('amilia_load_facebook_comment'); ?>
                        <?php elseif (!empty($smof_data['comments_post_type']) && $smof_data['comments_post_type'] == 'default') : ?>
                            <?php comments_template( '', true ); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endwhile; // end of the loop. ?>

            </div><!-- #content -->
        </div><!-- #primary -->
        <?php if ($tracking_layout == 'right-sidebar'): ?>
            <div class="col-xs-12 col-md-3 right-sidebar-wrap">
                <?php get_sidebar(); ?>
            </div>
        <?php endif ?>
    </div>
</div>
<?php if (class_exists('Vc_Manager')) : ?>
    <div class="newsletter-on-single mt-40 mb-40">
        <?php
            echo apply_filters('the_content', '[cms_newsletter]');
        ?>
    </div>
<?php endif; ?>
<?php get_footer(); ?>