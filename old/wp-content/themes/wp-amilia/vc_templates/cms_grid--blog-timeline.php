<?php
    global $smof_data;
    /* get categories */
    $taxo = 'category';
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
    /*ajax media*/
    wp_enqueue_style( 'wp-mediaelement' );
    wp_enqueue_script( 'wp-mediaelement' );
    /* js, css for load more */
    
    wp_register_script( 'timeline-loadmore', get_template_directory_uri().'/assets/js/timeline-loadmore.js', array('jquery') ,'1.0',true);
    // What page are we on? And what is the pages limit?
    global $wp_query;
    $max = $wp_query->max_num_pages;
    $limit = $atts['limit'];
    $paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;

    // Add some parameters for the JS.
    $current_id =  str_replace('-','_',$atts['html_id']);
    wp_localize_script(
        'timeline-loadmore',
        'cms_more_obj'.$current_id,
        array(
            'startPage' => $paged,
            'maxPages' => $max,
            'total' => $wp_query->found_posts,
            'perpage' => $limit,
            'nextLink' => next_posts($max, false),
            'masonry' => $atts['layout']
        )
    );
    wp_enqueue_script( 'timeline-loadmore' );

    //$has_animate = (isset($atts['timeline_animate']) && $atts['timeline_animate'] == true) ? 'timeline-animate' : '';
?>

<div class="cms-grid-wraper blog-timeline-wrap <?php echo esc_attr($atts['template']);?>" id="<?php echo esc_attr($atts['html_id']);?>">
    <div class="timeline-start">
        <div class="timeline-start-caption">
            <?php echo esc_attr($smof_data['blog_timeline_heading']); ?>
        </div>
    </div>
    <?php
        $posts = $atts['posts'];

        while($posts->have_posts()) {
            $posts->the_post();
            get_template_part( 'single-templates/timeline/content', get_post_format() );
        }
    ?>
    <div class="timeline-start timeline-final">
        <div class="timeline-pagination cd-timeline-start-caption" data-text="<?php echo esc_attr($smof_data['blog_timeline_load']); ?>">
        </div>
    </div>
</div>