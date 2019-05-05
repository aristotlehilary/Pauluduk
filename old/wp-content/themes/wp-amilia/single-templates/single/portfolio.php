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
	$portfolio_meta = amilia_post_meta_data(); 
    /* get categories */
    $taxo = 'category-portfolio';
    $_category = array();
    if(!isset($atts['cat']) || $atts['cat']==''){
        $terms = get_terms($taxo);
        foreach ($terms as $cat){
            $_category[] = $cat->term_id;
        }
    } else {
        $_category  = explode(',', $atts['cat']);
    }
    $atts['categories'] = $_category;

    $client = !empty($portfolio_meta->_cms_single_portfolio_client) ? $portfolio_meta->_cms_single_portfolio_client : '';
    $skills = !empty($portfolio_meta->_cms_single_portfolio_skills) ? $portfolio_meta->_cms_single_portfolio_skills : '';
    $url = !empty($portfolio_meta->_cms_single_portfolio_url) ? $portfolio_meta->_cms_single_portfolio_url : '#';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('row amilia-single-portfolio mb-40'); ?>>
    <div class="col-md-9">
        <div class="cms-portfolio-item-inner">
            <?php amilia_archive_gallery('amilia-blog-large'); ?>
            <div class="port-title-wrap">
                <h2><?php the_title(); ?></h2>
            </div>
            <div class="port-content">
                <?php 
                    echo apply_filters('the_content', preg_replace('/\[gallery(.*)]/', '', get_the_content(), 1));
                ?>
            </div>
            <footer class="entry-footer">
                <?php amilia_single_portfolio_tax(); ?>
                <?php amilia_social_share(); ?>
            </footer>
        </div>
    </div>
    <div class="col-md-3">
        <h3 class="wg-title">
            <?php esc_html_e('PROJECT DETAIL', 'wp-amilia'); ?>
        </h3>
        <ul class="list-unstyled project-details-list mb-20">
            <?php if (!empty($client)) : ?>
                <li>
                    <b><?php esc_html_e('Clients:', 'wp-amilia'); ?></b> 
                    <?php echo esc_attr($client); ?>    
                </li>
            <?php endif; ?>
            <?php if (!empty($skills)) : ?>
                <li>
                    <b><?php esc_html_e('Skills:', 'wp-amilia'); ?></b> 
                    <?php echo esc_attr($skills); ?>    
                </li>
            <?php endif; ?>
            <li>
                <b><?php esc_html_e('Category:', 'wp-amilia'); ?></b> 
                <?php echo get_the_term_list( get_the_ID(), $taxo, '', ', ', '' ); ?>
            </li>
            <li>
                <b><?php esc_html_e('Date:', 'wp-amilia'); ?></b> 
                <?php echo get_the_date('j F Y'); ?> 
            </li>
        </ul>
        <a target="_self" title="" href="<?php echo esc_url($url); ?>" class="cms-button md block cms-default teal mb-30"><?php esc_html_e('VISIT PROJECT', 'wp-amilia') ?></a>

        <h3 class="wg-title">
            <?php esc_html_e('TAGS', 'wp-amilia'); ?>
        </h3>
        <div class="tagcloud-wrap mb-20">
            <ul class="list-unstyled clearfix">
                <?php echo get_the_term_list( get_the_ID(), 'portfolio-tag', '<li>', '</li><li>', '</li>' ); ?>
            </ul>
        </div>
        <?php if ( is_active_sidebar( 'port-single-area' ) ) : ?>
            <?php dynamic_sidebar('port-single-area') ?>
        <?php endif; ?>
    </div>
</article>
<!-- #post -->