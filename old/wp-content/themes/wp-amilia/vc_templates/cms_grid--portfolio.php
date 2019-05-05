<?php 
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

    $gutter = (!empty($atts['cms_portfolio_gutter'])) ? $atts['cms_portfolio_gutter'] : 0;
    $cms_portfolio_thumb = (isset($atts['cms_portfolio_thumb'])) ? $atts['cms_portfolio_thumb'] : '';
    switch ($cms_portfolio_thumb) {
        case 'fixed_w':
            $thumb_size = 'amilia-thumbnail-masonry';
            break;
        case 'square':
            $thumb_size = 'amilia-portfolio-square';
            break;
        default:
            $thumb_size = 'amilia-portfolio-wide';
            break;
    }
    $custom_heading = (!empty($atts['grid_heading'])) ? $atts['grid_heading'] : '';
    $view_all_link = (!empty($atts['grid_viewall_link'])) ? $atts['grid_viewall_link'] : '#';
    $amilia_paging_nav = (isset($atts['cms_port_navigation'])) ? $atts['cms_port_navigation'] : false;
?>
<?php if ($custom_heading): ?>
    <div class="grid-custom-heading-wrap owl-custom-heading-wrap mb-30 <?php echo ($atts['filter']!="true" and $atts['layout']=='masonry') ? 'no-filter': ''; ?>">
        <div class="cms-custom-heading heading-with-bg-overlay has-line">
            <h2 class="cms-heading-inner"><span><?php echo esc_attr($custom_heading); ?></span></h2>
        </div>
        <div class="owl-readmore-wrap">
            <?php if (!empty($atts['grid_vieall']) && $atts['grid_vieall'] == true): ?>
                <a href="<?php echo esc_url($view_all_link) ?>" class="cms-button md gray-light">
                    <span><?php esc_html_e('VIEW ALL', 'wp-amilia'); ?></span>
                </a>
            <?php endif ?>
        </div>
    </div>
<?php endif ?>

<div class="cms-grid-wraper <?php echo esc_attr($atts['template']);?> <?php echo ($custom_heading) ? 'has-heading' : ''; ?>" id="<?php echo esc_attr($atts['html_id']);?>">
    <?php if($atts['filter']=="true" and $atts['layout']=='masonry'):?>
        <div class="cms-grid-filter-wrap clearfix">
            <div class="cms-grid-filter-inphone">
                <a href="#"><span><?php esc_html_e('Select Filter', 'wp-amilia');?></span></a>
            </div>
            <ul class="cms-grid-filter list-unstyled list-inline clearfix">
                <li><a class="active" href="#" data-group="all"><?php esc_html_e('All', 'wp-amilia') ?></a></li>
                <?php foreach($atts['categories'] as $category):?>
                    <?php $term = get_term( $category, $taxo );?>
                    <li><a href="#" data-group="<?php echo esc_attr('category-'.$term->slug);?>">
                            <?php echo esc_html($term->name);?>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    <?php endif;?>
    <div class="cms-grid <?php echo esc_attr($atts['grid_class']);?>" style="margin-left: -<?php echo esc_attr($gutter); ?>">
        <?php
        $posts = $atts['posts'];
        while($posts->have_posts()){
            $posts->the_post();
            $groups = array();
            $groups[] = '"all"';
            foreach(cmsGetCategoriesByPostID(get_the_ID(),$taxo) as $category) {
                $groups[] = '"category-'.$category->slug.'"';
            }
            ?>
            <div class="cms-portfolio-item <?php echo esc_attr($atts['item_class']);?>" data-groups='[<?php echo implode(',', $groups);?>]'>
                <div class="cms-portfolio-item-cont" style="margin: 0 0 <?php echo esc_attr($gutter); ?> <?php echo esc_attr($gutter); ?>;">
                    <div class="cms-portfolio-item-inner">
                        <?php amilia_archive_gallery($thumb_size); ?>
                        <h3 class="port-title <?php echo ($gutter == 0) ? 'no-gutter': ''; ?>">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php if ($amilia_paging_nav == true) : ?>
        <div class="portfolio-pagint-wrap <?php echo ($gutter == 0) ? 'mt-30' : '' ?>">
            <?php amilia_paging_nav();  ?>
        </div>
    <?php endif; ?>
</div>
