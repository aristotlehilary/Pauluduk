<?php
$blog_layout = (!empty($atts['cms_blog_layout'])) ? $atts['cms_blog_layout'] : 'default';
if ($blog_layout != 'masonry') :
?>
<div class="cms-grid-wraper <?php echo esc_attr($atts['template']);?> clearfix" id="<?php echo esc_attr($atts['html_id']);?>">
    <div class="cms-grid <?php echo esc_attr($atts['grid_class'].' '.$blog_layout);?>">
        <?php
        $posts = $atts['posts'];
        while($posts->have_posts()) {
            $posts->the_post();
            switch ($blog_layout) {
                case 'small-thumb':
                    get_template_part( 'single-templates/blog-small-thumb/content', get_post_format() );
                    break;
                case 'fullwidth':
                    get_template_part( 'single-templates/blog-fullwidth/content', get_post_format() );
                    break;
                
                default:
                    get_template_part( 'single-templates/content/content', get_post_format() );
                    break;
            }
        }
        ?>
    </div>
    <?php if (!empty($atts['cms_blog_navigation']) && $atts['cms_blog_navigation'] == true) amilia_paging_nav(); ?>
</div>
<?php else : //Blog style is Masonry ?>
<div class="cms-grid-wraper <?php echo esc_attr($atts['template']);?> clearfix" id="<?php echo esc_attr($atts['html_id']);?>">
    <div class="row cms-grid <?php echo esc_attr($atts['grid_class']);?>">
        <?php
        $posts = $atts['posts'];
        while($posts->have_posts()){
            $posts->the_post();
            ?>
            <div class="cms-grid-item cms-blog-masonry <?php echo esc_attr($atts['item_class']);?>">
                <?php get_template_part( 'single-templates/blog-masonry/content', get_post_format() ); ?>
            </div>
            <?php
        }
        ?>
    </div>
    <?php if (!empty($atts['cms_blog_navigation']) && $atts['cms_blog_navigation'] == true) amilia_paging_nav(); ?>
</div>
<?php endif; ?>