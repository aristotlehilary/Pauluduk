<?php
    $custom_heading = (!empty($atts['carousel_heading'])) ? $atts['carousel_heading'] : '';
    $view_all_link = (!empty($atts['carousel_viewall_link'])) ? $atts['carousel_viewall_link'] : '#';
?>
<?php if ($custom_heading): ?>
    <div class="owl-custom-heading-wrap mb-30 ">
        <div class="cms-custom-heading heading-with-bg-overlay has-line">
            <h2 class="cms-heading-inner"><span><?php echo esc_attr($custom_heading); ?></span></h2>
        </div>
        <div class="owl-readmore-wrap">
            <?php if (!empty($atts['carousel_vieall']) && $atts['carousel_vieall'] == true): ?>
                <a href="<?php echo esc_url($view_all_link) ?>" class="cms-button md gray-light"><?php esc_html_e('VIEW ALL', 'wp-amilia'); ?></a>
            <?php endif ?>
            <div class="owl-nav-wrap">
                <span class="owl-prev-fake">prev</span>
                <span class="owl-next-fake">next</span>
            </div>
        </div>
    </div>
<?php endif ?>
<div class="<?php echo ($custom_heading) ? 'has-fake-nav' : ''; ?> cms-carousel owl-carousel cms-portfolio-wrap <?php echo esc_attr($atts['template']);?>" id="<?php echo esc_attr($atts['html_id']);?>">
    <?php
    $posts = $atts['posts'];
    while($posts->have_posts()) {
        $posts->the_post();
        ?>
        <div class="cms-carousel-item cms-portfolio-item mb-30">
            <div class="cms-portfolio-item-inner">
                <?php amilia_archive_gallery('amilia-portfolio-square'); ?>
                <h3 class="port-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>
            </div>
        </div>
        <?php
    }
    ?>
</div>

