<div class="cms-carousel owl-carousel cms-carousel-teams-wrap <?php echo esc_attr($atts['template']);?>" id="<?php echo esc_attr($atts['html_id']);?>">
    <?php
    $posts = $atts['posts'];
    while($posts->have_posts()) {
        $posts->the_post();
        $team_meta = amilia_post_meta_data();
        ?>
        <div class="cms-team-item cms-grid-team mb-30 mt-50 <?php echo (isset($atts['css_animation'])) ? $atts['css_animation'] : ''; ?>">
            <?php 
                if(has_post_thumbnail() && !post_password_required() && !is_attachment() &&  wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'amilia-portfolio-square', false)):
                    $class = ' has-thumbnail';
                    $thumbnail = get_the_post_thumbnail(get_the_ID(), 'amilia-portfolio-square');
                else:
                    $class = ' no-image';
                    $thumbnail = '<img src="'.get_template_directory_uri().'/assets/images/no-image.jpg" alt="'.get_the_title().'" />';
                endif;
            ?>
            <div class="cms-team-media">
                <?php echo '<a href="#" lass="team-thumb'.esc_attr($class).'">'.$thumbnail.'</a>'; ?>
                <ul class="team-social">
                    <?php
                        for($i=1;$i<7;$i++) {
                            $icon = $team_meta->{"_cms_icon".$i};
                            $link = $team_meta->{"_cms_link".$i};
                            if(!empty($icon) && !empty($link)): ?>
                                <li>
                                    <a href="<?php echo esc_url($link);?>"><span class="<?php echo esc_attr($icon);?>" aria-hidden="true"></span></a>
                                </li>
                            <?php endif;
                        }
                    ?>    
                </ul>
            </div>
            <h3 class="cms-team-title">
                <?php the_title();?>
            </h3>
            <?php if (!empty($team_meta->_cms_page_team_position)):?>
                <h4 class="cms-team-posi"><?php echo esc_attr($team_meta->_cms_page_team_position); ?></h4>
            <?php endif; ?>
            <?php if (isset($atts['cms_team_desc']) && $atts['cms_team_desc'] == true): ?>
                <?php the_excerpt(); ?>
            <?php endif ?>
        </div>
        <?php
    }
    ?>
</div>