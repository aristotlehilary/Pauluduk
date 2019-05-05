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
<div class="cms-carousel owl-carousel cms-carousel-recentposts-wrap <?php echo (!empty($atts['hide_feature_thum'])) ? 'hide-feature' : ''; ?> <?php echo esc_attr($atts['template']);?>" id="<?php echo esc_attr($atts['html_id']);?>">
    <?php
    $posts = $atts['posts'];
    while($posts->have_posts()){
        $posts->the_post();
        ?>
        <div class="cms-carousel-item cms-blog-item mb-30">
            <?php if (has_post_thumbnail() && empty($atts['hide_feature_thum'])) : ?>
                <?php amilia_the_post_thumbnail('amilia-portfolio-square'); ?>
            <?php endif; ?>
            <?php if (!empty($atts['hide_feature_thum'])) : ?>
                <div class="header-hide-feature-wrap">
                    <div class="entry-date-wrap">
                        <div class="date-item">
                            <?php echo get_the_date('d'); ?>
                        </div>
                        <div class="month-item">
                            <?php echo get_the_date('M'); ?>
                        </div>
                    </div>
                    <header class="entry-header">
                        <h3 class="entry-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                    </header> 
                </div>
            <?php endif; ?>
            <?php if (empty($atts['hide_feature_thum'])) : ?>
                <header class="entry-header">
                    <h3 class="entry-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                </header>
            <?php endif; ?>

            <div class="entry-content">
                <?php echo wp_trim_words(get_the_excerpt(), 16, ''); ?>
            </div>
            <footer class="entry-footer">
                <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" class="cms-button md cms-border gray-light-gr"><?php esc_html_e('Read more', 'wp-amilia') ?></a><!-- .readmore link -->
            </footer>
        </div>
        <?php
    }
    ?>
</div>