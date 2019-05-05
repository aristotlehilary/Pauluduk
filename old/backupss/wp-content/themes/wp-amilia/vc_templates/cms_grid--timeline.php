<?php
    $timeline_start = (!empty($atts['timeline_start'])) ? $atts['timeline_start'] : 'START COMPANY';
    $timeline_recent = (!empty($atts['timeline_start'])) ? $atts['timeline_start'] : 'RECENT DAY';
?>

<div class="cms-grid-wraper blog-timeline-wrap company-timeline-wrap <?php echo esc_attr($atts['template']);?>" id="<?php echo esc_attr($atts['html_id']);?>">
    <div class="timeline-start">
        <div class="timeline-start-caption">
            <?php echo esc_attr($timeline_start); ?>
        </div>
        <div class="timeline-start-date">
            
        </div>
    </div>
    <?php
        $posts = $atts['posts'];
        $index = 0;
        while($posts->have_posts()) {
            $posts->the_post();
            ?>
                <div class="timeline-block cms-blog-item <?php echo ($index == 0) ? 'first-item': ''; ?>" <?php echo ($index == 0) ? 'data-timline-date = "'.get_the_time('F Y').'" ' : ''; ?>>
                    <div class="timeline-icon">
                        <?php amilia_archive_post_icon(); ?>
                    </div>
                    <div class="timeline-content">
                        <h2 class="entry-title"><?php the_title();?></h2>
                        <div class="entry-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        <div class="entry-date">
                            <span class="entry-date-year"><?php the_time('Y');?></span>
                            <span class="entry-date-month"><?php the_time('M j');?></span>
                        </div>
                    </div>
                </div>
            <?php
            $index++;
        }
    ?>
    <div class="timeline-start timeline-final">
        <div class="timeline-pagination cd-timeline-start-caption">
            <?php echo esc_attr($timeline_recent); ?>
        </div>
    </div>
</div>