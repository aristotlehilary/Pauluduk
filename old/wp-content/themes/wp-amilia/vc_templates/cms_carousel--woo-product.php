<?php
    global $product;
    
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

        <div class="cms-product text-center">
            <div class="cms-woo-image">
                <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
                <a href="<?php the_permalink(); ?>">
                    <?php
                        /**
                         * woocommerce_before_shop_loop_item_title hook
                         *
                         * @hooked woocommerce_show_product_loop_sale_flash - 10
                         * @hooked woocommerce_template_loop_product_thumbnail - 10
                         */
                        do_action( 'woocommerce_before_shop_loop_item_title' );
                    ?>
                </a>
            </div>
            <div class="cms-product-title">
                <h3 class="mb-5"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            </div>
            <?php
                /**
                 * woocommerce_after_shop_loop_item_title hook
                 *
                 * @hooked woocommerce_template_loop_rating - 5
                 * @hooked woocommerce_template_loop_price - 10
                 */

                do_action( 'woocommerce_after_shop_loop_item_title' );
            ?>
        </div>

        <?php
    }
    ?>
</div>

