<?php
    $testi_bg = (isset($atts['testimonial_bg']) && !empty($atts['testimonial_bg'])) ? $atts['testimonial_bg'] : '#eee';
?>
<div class="cms-carousel owl-carousel cms-carousel-testimonial-layout1 <?php echo esc_attr($atts['template']);?> p-80-cont pt-40" id="<?php echo esc_attr($atts['html_id']);?>">
    <?php
    $posts = $atts['posts'];
    while($posts->have_posts()){
        $posts->the_post();
        $testimonials_meta = amilia_post_meta_data();
    ?>
        <div class="cms-carousel-item <?php //echo (isset($atts['cms_testimonial_container']) && $atts['cms_testimonial_container'] == true ) ? ' container ' : '';  ?>">
                
            <div class="cms-testimonials-wrap">
                <div class="cms-text-container" style="background-color: <?php echo esc_attr($testi_bg); ?>">
                    <?php the_content(); ?>
                </div>
                <div class="cms-small-author-container clearfix">
                    <div class="cms-img-container">
                        <?php 
                            if(has_post_thumbnail() && !post_password_required() && !is_attachment()):
                                $class = 'has-thumbnail cms-grid-testimonials-media';
                                $thumbnail = get_the_post_thumbnail(get_the_ID(), 'thumbnail');
                            else:
                                $class = ' no-image cms-grid-testimonials-media';
                                $thumbnail = '<img src="'.get_template_directory_uri().'/assets/images/no-image.jpg" alt="'.get_the_title().'" />';
                            endif;

                            echo ''.$thumbnail;
                        ?>
                    </div>
                    <div class="cms-small-author">
                        <span class="author-testimonial"><?php the_title(); ?></span>
                        <span class="quote-author-description"><?php echo esc_attr($testimonials_meta->_cms_page_testimonial_position); ?></span>
                    </div>
                </div>
            </div>

        </div>
        <?php //the_terms( get_the_ID(), 'categories-testimonial', '', ' / ' ); ?>
        <?php
    }
    ?>
</div>