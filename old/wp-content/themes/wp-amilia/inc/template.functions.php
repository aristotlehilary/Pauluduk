<?php
/**
 * get value form theme option
 */
function amilia_get_value_smofdata($value) {
    global $smof_data;

    if ($smof_data[$value]) {
        return $smof_data[$value];
    } else {
        return '';
    }
}

/**
 * Return glolbal page metadata
 */
function amilia_get_value_pagemeta() {
    global $amilia_meta;

    return $amilia_meta;
}

/**
 * Page title template
 * @since 1.0.0
 * @author Fox
 */
function amilia_page_title(){
    global $smof_data, $amilia_meta, $amilia_base;
    /* page options */

    $page_title_layout = '';
    $page_title_layout = (!empty($amilia_meta->_cms_page_title)) ? $amilia_meta->_cms_page_title_type : $smof_data['page_title_layout'];
    if (empty($page_title_layout)) {
        $classes[] = 'page-none-pagetitle';    
    }

    if($page_title_layout) {
        ?>
        <div id="page-title" class="page-title">
            <div class="container">
                <div class="page-title-container">
                    <div class="row">
                        <div id="page-title-text" class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><h1><?php $amilia_base->amilia_getPageTitle(); ?></h1></div>
                    </div>
                    <div class="row">
                        <?php 
                            /*
                            * Get content of breadcrumb and check to echo data if it not null
                            */
                            ob_start();
                            $amilia_base->amilia_getBreadCrumb();
                            $br = ob_get_clean();
                        ?>
                        <div id="breadcrumb-text" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 <?php echo (trim(strip_tags($br)) == '')?' empty-breadcrumb':'' ?>"><?php $amilia_base->amilia_getBreadCrumb(); ?></div>
                    </div>
                </div>
            </div>
        </div><!-- #page-title -->
        <?php
    }
}

/**
 * Get Header Layout.
 * 
 * @author Fox
 */
function amilia_header() {
    global $smof_data, $amilia_meta;
    /* header for page */
    if(isset($amilia_meta->_cms_header) && $amilia_meta->_cms_header){
        if(isset($amilia_meta->_cms_header_layout)){
            $smof_data['header_layout'] = $amilia_meta->_cms_header_layout;
        }
    }
    /* load template. */
    get_template_part('inc/header/header', $smof_data['header_layout']);
}

/**
 * Get Footer Layout.
 * 
 * @author Fox
 */
function amilia_footer(){
    global $smof_data, $amilia_meta;
    /* header for page */
    if(isset($amilia_meta->_cms_footer) && $amilia_meta->_cms_footer) {
        if(isset($amilia_meta->_cms_footer_layout) && !empty($amilia_meta->_cms_footer_layout)) {
            $smof_data['footer_layout'] = $amilia_meta->_cms_footer_layout;
        }
    }

    if (empty($smof_data['footer_layout'])) {
        /* load template. */
        get_template_part('inc/footer/footer');        
    } else {
        /* load template. */
        get_template_part('inc/footer/footer', $smof_data['footer_layout']);
    }
}

/**
 * Get menu location ID.
 * 
 * @param string $option
 * @return NULL
 */
function amilia_menu_location($option = '_cms_primary'){
    global $amilia_meta;
    /* get menu id from page setting */
    return (isset($amilia_meta->$option) && $amilia_meta->$option) ? $amilia_meta->$option : null ;
}

function amilia_get_page_loading() {
    global $smof_data;
    
    if($smof_data['enable_page_loadding']){
        echo '<div id="cms-loadding">';
        switch ($smof_data['page_loadding_style']){
            case '2':
                echo '<div class="ball"></div>';
                break;
            default:
                echo '<div class="loader"></div>';
                break;
        }
        echo '</div>';
    }
}

/**
 * Add page class
 * 
 * @author Fox
 * @since 1.0.0
 */
function amilia_page_class(){
    global $smof_data;
    
    $page_class = '';
    /* check boxed layout */
    if($smof_data['body_layout']){
        $page_class = 'cs-boxed';
    } else {
        $page_class = 'cs-wide';
    }
    
    echo apply_filters('amilia_page_class', $page_class);
}

/**
 * Add main class
 * 
 * @author Fox
 * @since 1.0.0
 */
function amilia_main_class(){
    global $amilia_meta;
    
    $main_class = '';
    /* chect content full width */
    if(is_page() && isset($amilia_meta->_cms_full_width) && $amilia_meta->_cms_full_width){
        /* full width */
        $main_class = "no-container";
    } else {
        /* boxed */
        $main_class = "container";
    }
    
    echo apply_filters('amilia_main_class', $main_class);
}

/**
 * Archive detail
 * 
 * @author Fox
 * @since 1.0.0
 */
function amilia_blog_post_meta() {
    ?>
    <ul class="entry-meta-inner clearfix">
        <li class="entry-date">
            <i class="icon_clock_alt" aria-hidden="true"></i>
            <?php echo get_the_date('j F Y'); ?>
        </li>
        <li class="entry-author">
            <i class="icon_profile" aria-hidden="true"></i>
            <?php the_author_posts_link(); ?>
        </li>
        <li class="entry-comments">
            <i class="icon_comment_alt" aria-hidden="true"></i>
            <a href="<?php the_permalink(); ?>"><?php comments_number(esc_html__('0 Comment','wp-amilia'), esc_html__('1 Comment','wp-amilia'), esc_html__('% Comments','wp-amilia')); ?></a>
        </li>
        <li class="entry-views">
            <i class="icon_circle-slelected" aria-hidden="true"></i>
            <?php echo amilia_get_post_views(get_the_ID()); ?> <?php esc_html_e('Views', 'wp-amilia') ?>
        </li>
        <li class="entry-tags">
            <?php the_tags('<i class="icon_tags_alt" aria-hidden="true"></i>', ', ' ); ?>
        </li>
    </ul>
    <?php
}

/**
 * Archive readmore
 * 
 * @author Fox
 * @since 1.0.0
 */
function amilia_archive_readmore(){
    echo '<a class="cms-button md cms-border gray-light-gr" href="'.get_the_permalink().'" title="'.get_the_title().'" >'.esc_html__('Read more', 'wp-amilia').'</a>';
}

/**
 * Media Audio.
 * 
 * @param string $before
 * @param string $after
 */
function amilia_archive_audio($tag = '') {
	global $amilia_base;
    /* get shortcode audio. */
    $shortcode = $amilia_base->amilia_getShortcodeFromContent($tag, get_the_content());
    
    if($shortcode != ''){
        echo '<div class="entry-feature entry-feature-media clearfix mb-20">'.do_shortcode($shortcode).'</div>';
        ?>
        <div class="entry-date-cont hidden">
            <div class="date"><?php echo get_the_date('j'); ?></div>
            <div class="month"><?php echo get_the_date('M'); ?></div>
        </div>
        <?php
        return true;
    } else {
        if(has_post_thumbnail()){
            amilia_the_post_thumbnail();
        }
        return false;
    }
}

/**
 * Rename post format, link to soudcloud
 * 
 */
if (function_exists('soundcloud_shortcode')) {
    function amilia_rename_post_formats( $safe_text ) {
        if ( $safe_text == 'Link' )
            return 'SoundCloud';

        return $safe_text;
    }
    add_filter( 'esc_html', 'amilia_rename_post_formats' );

    //rename Link in posts list table to SoundCloud
    function amilia_live_rename_formats() {
        global $current_screen;

        if ( $current_screen->id == 'edit-post' ) { ?>
            <script type="text/javascript">
            jQuery('document').ready(function() {

                jQuery("span.post-state-format").each(function() { 
                    if ( jQuery(this).text() == "Link" )
                        jQuery(this).text("SoundCloud");             
                });

            });      
            </script>
    <?php }
    }
    //add_action('admin_head', 'amilia_live_rename_formats');  
}

/**
 * Html 5 Audio
 * 
 * @param string $before
 * @param string $after
 */
function amilia_audio_html5() {
    /* get shortcode audio. */
    preg_match('/\[audio src="(.*)?"\]/', get_the_content() , $matches);

    if ( !empty($matches[1]) ) {
        ?>
            <div class="entry-feature entry-feature-media">
                <audio controls="controls" class="mb-20" style="overflow: hidden; float: left;">
                    <source type="audio/ogg" src="<?php echo esc_url($matches[1]) ?>" />
                    <source type="audio/mpeg" src="<?php echo esc_url($matches[1]) ?>" />
                </audio>

                <div class="entry-date-cont hidden">
                    <div class="date"><?php echo get_the_date('j'); ?></div>
                    <div class="month"><?php echo get_the_date('M'); ?></div>
                </div>
            </div>
        <?php
    } elseif (has_post_thumbnail()) {
        amilia_the_post_thumbnail();
    }
}

/**
 * Media Video.
 *
 * @param string $before
 * @param string $after
 */
function amilia_archive_video() {
    
    global $wp_embed, $amilia_base;
    /* Get Local Video */
    $local_video = $amilia_base->amilia_getShortcodeFromContent('video', get_the_content());
    
    /* Get Youtobe or Vimeo */
    $remote_video = $amilia_base->amilia_getShortcodeFromContent('embed', get_the_content());
    
    if($local_video){
        /* view local. */
        echo '<div class="mb-20">'.do_shortcode($local_video).'</div>';
        ?>
            <div class="entry-date-cont hidden">
                <div class="date"><?php echo get_the_date('j'); ?></div>
                <div class="month"><?php echo get_the_date('M'); ?></div>
            </div>
        <?php
        return true;
        
    } elseif ($remote_video) {
        /* view youtobe or vimeo. */
        echo '<div class="mb-20">'.do_shortcode($wp_embed->run_shortcode($remote_video)).'</div>';
        ?>    
            <div class="entry-date-cont hidden">
                <div class="date"><?php echo get_the_date('j'); ?></div>
                <div class="month"><?php echo get_the_date('M'); ?></div>
            </div>
        <?php
        return true;
        
    } elseif (has_post_thumbnail()) {
        /* view thumbnail. */
        amilia_the_post_thumbnail();
    } else {
        return false;
    }
    
}

/**
 * Gallerry Images
 * 
 * @author Fox
 * @since 1.0.0
 */
function amilia_archive_gallery($thumnail = '') {
	global $amilia_base;

    $thumnail = (!empty($thumnail)) ? $thumnail : 'amilia-blog-large';

    /* get shortcode gallery. */
    $shortcode = $amilia_base->amilia_getShortcodeFromContent('gallery', get_the_content());
    
    if($shortcode != ''){
        preg_match('/\[gallery.*ids=.(.*).\]/', $shortcode, $ids);
        
        if(!empty($ids)){
        
            $array_id = explode(",", $ids[1]);
            $gallery_id = rand(0, 999);
            ?>
            <div id="carousel-gallery-<?php echo esc_attr($gallery_id); ?>" class="carousel slide carousel-fade mb-20" data-ride="carousel">
                <div class="entry-date-cont hidden">
                    <div class="date"><?php echo get_the_date('j'); ?></div>
                    <div class="month"><?php echo get_the_date('M'); ?></div>
                </div>
                <ol class="carousel-indicators">
                    <?php $j = 0; ?>
                    <?php foreach ($array_id as $image_id): ?>
                        <li data-target="#carousel-gallery-<?php echo esc_attr($gallery_id); ?>" class="<?php if( $j == 0 ){ echo 'active'; } ?>" data-slide-to="<?php echo esc_attr($j); ?>"></li>
                    <?php $j++; endforeach; ?>
                </ol>
                <div class="carousel-inner cms-popup-gallery">
                    <?php $i = 0; ?>
                    <?php foreach ($array_id as $image_id): ?>
            			<?php
                        $attachment_image = wp_get_attachment_image_src($image_id, $thumnail, false);
                        $image = wp_get_attachment_image_src( $image_id, 'full' );
                        if($attachment_image[0] != ''):?>
            				<div class="item entry-feature-image <?php if( $i == 0 ){ echo 'active'; } ?>">
                                <a class="lightbox" href="<?php echo esc_url($image[0]); ?>">
                            		<img style="width:100%;" src="<?php echo esc_url($attachment_image[0]);?>" alt="" />
                                    <div class="overlay">
                                        <span class="icon_search" aria-hidden="true"></span>
                                    </div>
                                </a>
                        	</div>
                        <?php $i++; endif; ?>
                    <?php endforeach; ?>
                </div>
                <a class="left carousel-control" href="#carousel-gallery-<?php echo esc_attr($gallery_id); ?>" role="button" data-slide="prev">
        		    <span class="arrow_carrot-left"></span>
        		</a>
        		<a class="right carousel-control" href="#carousel-gallery-<?php echo esc_attr($gallery_id); ?>" role="button" data-slide="next">
        		    <span class="arrow_carrot-right"></span>
        		</a>
        	</div>
            <?php
            
            return true;
        
        } else {
            return false;
        }
    } else {
        if(has_post_thumbnail()) {
            amilia_the_post_thumbnail($thumnail);
        }
    }
}

/**
 * Quote Text.
 * 
 * @author Fox
 * @since 1.0.0
 */
function amilia_archive_quote() {
    /* get text. */
    preg_match('/\<blockquote\>(.*)\<\/blockquote\>/', get_the_content(), $blockquote);
    
    if(!empty($blockquote[0])){
        echo ''.$blockquote[0].'';
        return true;
    } else {
        if(has_post_thumbnail()){
            the_post_thumbnail();
        }
        return false;
    }
}

/**
 * TagCloud on Single post
 *
 * @author Duong Tung
 * @since 1.0.0
 */
function amilia_single_tagclouds() {
    ob_start();
    the_tags('<li>', '</li><li>' ,'</li>' );
    $amilia_tags = ob_get_clean();

    if (trim(strip_tags($amilia_tags)) != '') { ?>
        <div class="tagcloud-wrap">
            <ul class="clearfix">
                <?php echo ''.$amilia_tags; ?>
            </ul>    
        </div>
    <?php
    }
}

/**
 * Taxonomy on Portfolio
 *
 * @author Duong Tung
 * @since 1.0.0
 */
function amilia_single_portfolio_tax($taxo = '') {
    $taxo = !empty($taxo) ? $taxo : 'portfolio-tag';
    
    ob_start();
    echo get_the_term_list( get_the_ID(), $taxo, '<li>', '</li><li>', '</li>' );
    $amilia_tags = ob_get_clean();

    if (trim(strip_tags($amilia_tags)) != '') { ?>
        <div class="tagcloud-wrap">
            <ul class="clearfix">
                <?php echo ''.$amilia_tags; ?>
            </ul>    
        </div>
    <?php
    }
}

/**
 * Social Share
 *
 * @author Duong Tung
 * @since 1.0.0
 */
function amilia_social_share() {
    $url = get_the_permalink();
    $title = get_the_title();
    ?>
        <div class="social-share-wrap">
            <ul class="social-icon">
                <li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($url);?>"><i aria-hidden="true" class="social_facebook"></i></a></li>
                <li><a target="_blank" href="https://twitter.com/home?status=<?php esc_html_e('Check out this article', 'wp-amilia');?>:%20<?php echo esc_url(get_the_title()) ;?>%20-%20<?php echo urlencode($url);?>"><i aria-hidden="true" class="social_twitter"></i></a></li>
                <li><a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode($url);?>&amp;title=<?php echo urlencode($title);?>"><i aria-hidden="true" class="social_linkedin"></i></a></li>
                <li><a target="_blank" href="https://plus.google.com/share?url=<?php echo urlencode($url);?>"><i aria-hidden="true" class="social_googleplus"></i></a></li>
                <li><a target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode($url);?>"><i aria-hidden="true" class="social_pinterest"></i></a></li>
            </ul>
        </div>
    <?php
}

/**
 * render the post thumbnail function
 * @author Fox
 * @since 1.0.0
 */
function amilia_the_post_thumbnail($thumbnail = '') {
    global $post;

    $thumbnail = (!empty($thumbnail)) ? $thumbnail : 'amilia-blog-large';
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
    ?>
    <div class="entry-feature entry-feature-image mb-20">
        <a class="cms-lightbox" href="<?php echo esc_url($image[0]); ?>">
            <?php the_post_thumbnail( $thumbnail ); ?>
            <div class="overlay">
                <span class="icon_search" aria-hidden="true"></span>
            </div>
        </a>
        <div class="entry-date-cont hidden">
            <div class="date"><?php echo get_the_date('j'); ?></div>
            <div class="month"><?php echo get_the_date('M'); ?></div>
        </div>
    </div>
    <?php
}

/**
 * Build style
 * @author Fox
 * @since 1.0.0
 */

function amilia_build_style($arr = array()) {
    $return = '';
    if(count($arr) > 0){
        $return = 'style="';
        $return .= implode(' ', $arr);
        $return .= '"';
    }
    return $return;
}

/**
 * 
 */
function amilia_new_excerpt_more( $more ) {
    return '';
}
add_filter('excerpt_more', 'amilia_new_excerpt_more');

/**
 * Amilia Animation lib
 */
function amilia_animate_lib() {
    $animate = array(
        esc_html__( 'None', 'wp-amilia' ) => 'cms_animate',
        esc_html__( 'FadeIn', 'wp-amilia' ) => 'cms_animate fadeIn wow',
        esc_html__( 'FadeOut', 'wp-amilia' ) => 'cms_animate fadeOut wow',
        esc_html__( 'zoomIn', 'wp-amilia' ) => 'cms_animate zoomIn wow',
        esc_html__( 'zoomOut', 'wp-amilia' ) => 'cms_animate zoomOut wow',
        esc_html__( 'FadeInUp', 'wp-amilia' ) => 'cms_animate wow fadeInUp',
        esc_html__( 'FadeInDown', 'wp-amilia' ) => 'cms_animate wow fadeInDown',
        esc_html__( 'FadeInLeft', 'wp-amilia' ) => 'cms_animate wow fadeInLeft',
        esc_html__( 'FadeInRight', 'wp-amilia' ) => 'cms_animate wow fadeInRight',
        esc_html__( 'slideInLeft', 'wp-amilia' ) => 'cms_animate wow slideInLeft',
        esc_html__( 'slideInRight', 'wp-amilia' ) => 'cms_animate wow slideInRight',
        esc_html__( 'bounceIn', 'wp-amilia' ) => 'cms_animate wow bounceIn',
    );

    return $animate;
}

/**
 * Amilia Animation time delay lib
 */
function amilia_animate_time_delay_lib() {
    $animate_time = array(
        esc_html__( 'None', 'wp-amilia' ) => '',
        esc_html__( '100ms', 'wp-amilia' ) => '100ms',
        esc_html__( '200ms', 'wp-amilia' ) => '200ms',
        esc_html__( '300ms', 'wp-amilia' ) => '300ms',
        esc_html__( '400ms', 'wp-amilia' ) => '400ms',
        esc_html__( '500ms', 'wp-amilia' ) => '500ms',
        esc_html__( '600ms', 'wp-amilia' ) => '600ms',
        esc_html__( '700ms', 'wp-amilia' ) => '700ms',
        esc_html__( '800ms', 'wp-amilia' ) => '800ms',
        esc_html__( '900ms', 'wp-amilia' ) => '900ms',
        esc_html__( '1s', 'wp-amilia' ) => '1s',
        esc_html__( '1.1s', 'wp-amilia' ) => '1.1s',
        esc_html__( '1.2s', 'wp-amilia' ) => '1.2s',
        esc_html__( '1.3s', 'wp-amilia' ) => '1.3s',
        esc_html__( '1.4s', 'wp-amilia' ) => '1.4s',
        esc_html__( '1.5s', 'wp-amilia' ) => '1.5s',
    );

    return $animate_time;
}

/**
 * Add custom class to body
 * 
 * @author Duong Tung
 * @since 1.0.0
 */
add_filter( 'body_class', 'amilia_class_names' );
function amilia_class_names( $classes ) {
    global $smof_data, $amilia_meta;  
    // add 'class-name' to the $classes array
    if ($smof_data['menu_sticky']) {
        $classes[] = 'amilia-header-sticky';    
    }
    if (!empty($amilia_meta->_cms_page_general_custom_class)) {
        $classes[] = $amilia_meta->_cms_page_general_custom_class;
    }

    $smof_data['header_layout'] = (!empty($amilia_meta->_cms_header) && $amilia_meta->_cms_header_layout) ? $amilia_meta->_cms_header_layout : $smof_data['header_layout'];
    if (!empty($smof_data['header_layout'])) {
        $classes[] = 'page-has-header'.$smof_data['header_layout'];
    }

    $smof_data['single_layout'] = !empty($_GET['sidebar']) ? $_GET['sidebar'] : $smof_data['single_layout'];
    if ($smof_data['single_layout'] == 'left-sidebar') {
        $classes[] = 'single-left-sidebar';
    }

    $page_title_layout = '';
    $page_title_layout = (!empty($amilia_meta->_cms_page_title) && isset($amilia_meta->_cms_page_title_type)) ? $amilia_meta->_cms_page_title_type : $smof_data['page_title_layout'];
    if (empty($page_title_layout)) {
        $classes[] = 'page-none-pagetitle';    
    }

    if(!empty($amilia_meta->_cms_custom_revolution) && !empty($amilia_meta->_cms_get_revslide)) {
        $classes[] = 'has-custom-rev';
    }

    if(!empty($amilia_meta->_cms_custom_revolution) && !empty($amilia_meta->_cms_revslide_position)) {
        $classes[] = $amilia_meta->_cms_revslide_position;
    }

    // return the $classes array
    return $classes;
}

/**
 * Get header style from Theme Option
 */
function amilia_get_header_style() {
    global $smof_data, $amilia_meta;
    $amilia_header_style = '';

    $smof_data['header_layout'] = (!empty($amilia_meta->_cms_header) && $amilia_meta->_cms_header_layout) ? $amilia_meta->_cms_header_layout : $smof_data['header_layout'];

    switch ($smof_data['header_layout']) {
        case '1':
            $amilia_header_style = 'amilia-header-1';
            break;
        case '2':
            $amilia_header_style = 'amilia-header-2';
            break;
        case '3':
            $amilia_header_style = 'amilia-header-3';
            break;
        case '4':
            $amilia_header_style = 'amilia-header-4';
            break;
        
        default:
            $amilia_header_style = 'amilia-header-5';
            break;
    }

    echo apply_filters('amilia_get_header_style', $amilia_header_style);
}

/**
 * Get icon from post format.
 * 
 * @return multitype:string Ambigous <string, mixed>
 * @author Fox
 * @since 1.0.0
 */
function amilia_archive_post_icon() {
    $post_icon = array('icon'=>'fa fa-file-text-o','text'=> __('STANDARD', 'wp-amilia'));
    switch (get_post_format()) {
        case 'gallery':
            $post_icon['icon'] = 'icon_camera_alt';
            $post_icon['text'] = __('GALLERY', 'wp-amilia');
            break;
        case 'link':
            $post_icon['icon'] = 'icon_link';
            $post_icon['text'] = __('LINK', 'wp-amilia');
            break;
        case 'quote':
            $post_icon['icon'] = 'icon_document_alt';
            $post_icon['text'] = __('QUOTE', 'wp-amilia');
            break;
        case 'video':
            $post_icon['icon'] = 'icon_film';
            $post_icon['text'] = __('VIDEO', 'wp-amilia');
            break;
        case 'audio':
            $post_icon['icon'] = 'icon_volume-low_alt';
            $post_icon['text'] = __('AUDIO', 'wp-amilia');
            break;
        default:
            $post_icon['icon'] = 'icon_image';
            $post_icon['text'] = __('STANDARD', 'wp-amilia');
            break;
    }
    echo '<i class="'.$post_icon['icon'].'"></i>';
}


/**
 * Get post views
 *
 * @param $postID
 * @author Duong Tung
 * @since 1.0.0
 */
if (!function_exists('amilia_get_post_views')) {
    function amilia_get_post_views($postID) {
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return 0;
        }
        return $count;
    }
}

/**
 * Function to count views.
 *
 * @param $postID
 * @author Duong Tung
 * @since 1.0.0
 */
if (!function_exists('amilia_set_post_views')) {
    function amilia_set_post_views($postID) {
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        }else{
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }
}

/**
 * Appear faceboook app id for fb comments
 */
function amilia_appear_app_id() {
    global $smof_data;
    $app_id = '';
    $app_id = (!empty($smof_data['fb_app_id'])) ? intval($smof_data['fb_app_id']) : '1621007798158687';

    echo '<meta property="fb:app_id" content="'.$app_id.'" />';
}
add_action('wp_head', 'amilia_appear_app_id', 5);

/**
 * Display Disqus comment for demo
 * 
 * @author Duong Tung
 * @since 1.0.0
 */
function disqus_embed($disqus_shortname) {
    global $post;
    wp_enqueue_script('disqus_embed','http://'.$disqus_shortname.'.disqus.com/embed.js');
    echo '<div id="disqus_thread"></div>
    <script type="text/javascript">
        var disqus_shortname = "'.$disqus_shortname.'";
        var disqus_title = "'.$post->post_title.'";
        var disqus_url = "'.get_permalink($post->ID).'";
        var disqus_identifier = "'.$disqus_shortname.'-'.$post->ID.'";
    </script>';
}

/**
 * Remove 'Edit with VC' from Adminbar
 *
 * @author Duong Tung
 * @since 1.0.0
 */
function amilia_remove_wp_admin_bar_button() {
    remove_action( 'admin_bar_menu', array( vc_frontend_editor(), 'adminBarEditLink' ), 1000 );
}
add_action( 'vc_after_init', 'amilia_remove_wp_admin_bar_button' );

/* RevSlider */
function amilia_get_list_rev_slider() {
    if (class_exists('RevSlider')) {

        $slider = new RevSlider();
        $arrSliders = $slider->getArrSliders();

        $revsliders = array(''=>'');
        if ($arrSliders) {
            foreach ($arrSliders as $slider) {
                /* @var $slider RevSlider */
                $revsliders[$slider->getAlias()] = $slider->getTitle();
            }
        } else {
            $revsliders[__('No sliders found', 'wp-amilia')] = 0;
        }
    return $revsliders;
    }
}

/**
 * Load facebook comment
 */
function amilia_load_facebook_comment() {
    ?>
        <div id="fbcomments"><div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:comments href="<?php the_permalink(); ?>" width="100%"></fb:comments></div>
    <?php
}
add_action('amilia_load_facebook_comment', 'amilia_load_facebook_comment');

/**
 * Ajax post like.
 *
 * @since 1.0.0
 */
function amilia_post_like_callback(){
    global $smof_data;

    $post_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;

    $likes = null;

    if($post_id && !isset($_COOKIE['cms_post_like_'. $post_id])){

        /* get old like. */
        $likes = get_post_meta($post_id , '_cms_post_likes', true);

        /* check old like. */
        $likes = $likes ? $likes : 0 ;

        $likes++;

        /* update */
        update_post_meta($post_id, '_cms_post_likes' , $likes);

        /* set cookie. */
        setcookie('cms_post_like_'. $post_id, $post_id, time() * 20, '/');
    }

    echo esc_attr($likes);

    exit();
}

add_action('wp_ajax_cms_post_like', 'amilia_post_like_callback');
add_action('wp_ajax_nopriv_cms_post_like', 'amilia_post_like_callback');

/**
 * replace css to pass validate w3c
 *
 */
function amilia_ValidateStylesheet($src) {
    if( strstr($src,'mm-shortcode-css')|| 
        strstr($src,'wp-mediaelement-css') || 
        strstr($src,'font-awesome-css') || 
        strstr($src,'mediaelement-css') || 
        strstr($src,'bootstrap-progressbar-css') ) {
        return str_replace('rel', 'property="stylesheet" rel', $src);
    }
    else{
        return $src;
    }
}
add_filter('style_loader_tag', 'amilia_ValidateStylesheet');