<div class="cms-carousel owl-carousel cms-clients-wrap <?php echo esc_attr($atts['template']);?>" id="<?php echo esc_attr($atts['html_id']);?>">
    <?php
    $posts = $atts['posts'];
    while($posts->have_posts()) {
        $posts->the_post();
        ?>
        <div class="cms-carousel-item cms-client-item">
            <?php 
                if(has_post_thumbnail() && !post_password_required() && !is_attachment() &&  wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'team', false)):
                    $class = ' has-thumbnail';
                    $thumbnail = get_the_post_thumbnail(get_the_ID(),'team');
                else:
                    $class = ' no-image';
                    $thumbnail = '<img src="'.get_template_directory_uri().'/assets/images/no-image.jpg" alt="'.get_the_title().'" />';
                endif;
                echo '<div class="cms-grid-media '.esc_attr($class).'">'.$thumbnail.'</div>';
            ?>
        </div>
        <?php
    }
    ?>
</div>