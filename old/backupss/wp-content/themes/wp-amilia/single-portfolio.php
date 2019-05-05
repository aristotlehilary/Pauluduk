<?php
/**
 * The Template for displaying all single posts
 *
 * @package CMSSuperHeroes
 * @subpackage CMS Theme
 * @since 1.0.0
 */

$portfolio_meta = amilia_post_meta_data();
get_header(); ?>
<div class="<?php amilia_main_class(); ?>">
    <div class="row">
        <div id="primary" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div id="content" role="main">

                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'single-templates/single/portfolio'); ?>

                    <div class="portfolio-related-wrap mb-40">
                        <?php
                            $portfolio_category = '';
                            $terms = get_the_terms(get_the_ID(), 'category-portfolio');
                            if(!empty($terms)) {
                                
                                $portfolio_category = array();
                                
                                foreach ($terms as $term){
                                    $portfolio_category[] = $term->term_id;
                                }   
                                
                                $portfolio_category = '|tax_query:'.implode(',', $portfolio_category);
                            } 
                            echo apply_filters('the_content', '[cms_carousel xsmall_items="1" small_items="2" medium_items="3" large_items="4" not__in="true" margin="30" nav="false" dots="false" carousel_heading="OUR WORK" carousel_vieall="true" carousel_viewall_link="#" source="size:6|order_by:date|post_type:portfolio|'.$portfolio_category.'" cms_template="cms_carousel--portfolio.php"]')
                        ?>
                    </div>
                <?php endwhile; // end of the loop. ?>

            </div><!-- #content -->
        </div><!-- #primary -->
    </div>
</div>
<?php $portf_newsletter = amilia_get_value_smofdata('portf_newsletter'); ?>
<?php if ( $portf_newsletter == '1' && is_active_sidebar('bottom-area') ): ?>
    <div class="title-lines-container">
        <div class="container">
            <div class="nl-container nl-lines">
                <div class="nl-icon-container-bg">
                    <div class="nl-icon-container">
                        <i class="icon_mail_alt main-menu-icon" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="nl-main-container-bg">
                    <div class="nl-main-container clearfix">
                        <?php dynamic_sidebar('bottom-area'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php $portf_clients_info = amilia_get_value_smofdata('portf_clients_info'); ?>
<?php if ($portf_clients_info) : ?>
<div class="portf-clients-wrap">
    <div class="container">
        <div class="row">
            <div class="vc_col-sm-12">
            <?php
                echo apply_filters('the_content', '[cms_carousel xsmall_items="1" small_items="2" medium_items="4" large_items="5" margin="0" autoplay="true" nav="false" dots="false" source="size:8|order_by:date|post_type:client" cms_template="cms_carousel--clients.php"]');
            ?>   
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php get_footer(); ?>