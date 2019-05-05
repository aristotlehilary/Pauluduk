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
    $cms_portfolio_thumb = 'amilia-portfolio-square';
?>

<div class="<?php echo esc_attr($atts['grid_class']);?> portfolio-related-owl">
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
        <div class="<?php echo esc_attr($atts['item_class']);?>">
            <div class="cms-portfolio-item-cont">
                <div class="cms-portfolio-item-inner">
                    <?php amilia_archive_gallery($cms_portfolio_thumb); ?>
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
