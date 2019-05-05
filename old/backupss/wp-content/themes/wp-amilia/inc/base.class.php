<?php

class AmiliaBase
{
    /**
     * Page title
     * 
     * @since 1.0.0
     */
    public static function amilia_getPageTitle(){
        global $amilia_meta;
        
        if (!is_archive()){
            /* page. */
            if(is_page()) :
                /* custom title. */
                if(!empty($amilia_meta->_cms_page_title_text) && $amilia_meta->_cms_page_title_text):
                    echo esc_attr($amilia_meta->_cms_page_title_text);
                else :
                    the_title();
                endif;
            elseif (is_front_page()):
                esc_html_e('Blog', 'wp-amilia');
            /* search */
            elseif (is_search()):
                printf( esc_html__( 'Search Results for: %s', 'wp-amilia' ), '<span>' . get_search_query() . '</span>' );
            /* 404 */ 
            elseif (is_404()):
                esc_html_e( '404', 'wp-amilia');
            /* other */
            else :
                the_title();
            endif;
        } else { 
            /* category. */
            if ( is_category() ) :
                single_cat_title();
            elseif ( is_tag() ) :
            /* tag. */
                single_tag_title();
            /* author. */
            elseif ( is_author() ) :
                printf( esc_html__( 'Author: %s', 'wp-amilia' ), '<span class="vcard">' . get_the_author() . '</span>' );
            /* date */
            elseif ( is_day() ) :
                printf( esc_html__( 'Day: %s', 'wp-amilia' ), '<span>' . get_the_date() . '</span>' );
            elseif ( is_month() ) :
                printf( esc_html__( 'Month: %s', 'wp-amilia' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'wp-amilia' ) ) . '</span>' );
            elseif ( is_year() ) :
                printf( esc_html__( 'Year: %s', 'wp-amilia' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'wp-amilia' ) ) . '</span>' );
            /* post format */
            elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
                esc_html_e( 'Asides', 'wp-amilia' );
            elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
                esc_html_e( 'Galleries', 'wp-amilia');
            elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
                esc_html_e( 'Images', 'wp-amilia');
            elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
                esc_html_e( 'Videos', 'wp-amilia' );
            elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
                esc_html_e( 'Quotes', 'wp-amilia' );
            elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
                esc_html_e( 'Links', 'wp-amilia' );
            elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
                esc_html_e( 'Statuses', 'wp-amilia' );
            elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
                esc_html_e( 'Audios', 'wp-amilia' );
            elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
                esc_html_e( 'Chats', 'wp-amilia' );
            /* woocommerce */
            elseif (class_exists('Woocommerce') && is_woocommerce()):
                woocommerce_page_title();
            else :
            /* other */
                the_title();
            endif;
        }
    }
    /**
     * Breadcrumb
     * 
     * @since 1.0.0
     */
    public static function amilia_getBreadCrumb($separator = '') {
        global $smof_data, $post;
        echo '<ul class="breadcrumbs">';
        /* not front_page */
        if ( !is_front_page() ) {
            echo '<li><a href="';
            echo esc_url(home_url('/'));
            echo '">'.$smof_data['breacrumb_home_prefix'];
            echo "</a></li>";
        }
    
        $params['link_none'] = '';
    
        /* category */
        if (is_category()) {
            $category = get_the_category();
            $ID = $category[0]->cat_ID;
            echo is_wp_error( $cat_parents = get_category_parents($ID, TRUE, '', FALSE ) ) ? '' : '<li>'.$cat_parents.'</li>';
        }
        /* tax */
        if (is_tax()) {
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            $link = get_term_link( $term );
            	
            if ( is_wp_error( $link ) ) {
                echo sprintf('<li>%s</li>', $term->name );
            } else {
                echo sprintf('<li><a href="%s" title="%s">%s</a></li>', $link, $term->name, $term->name );
            }
        }
        /* home */
        
        /* page not front_page */
        if(is_page() && !is_front_page()) {
            $parents = array();
            $parent_id = $post->post_parent;
            while ( $parent_id ) :
            $page = get_page( $parent_id );
            if ( $params["link_none"] )
                $parents[]  = get_the_title( $page->ID );
            else
                $parents[]  = '<li><a href="' . get_permalink( $page->ID ) . '" title="' . get_the_title( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a></li>' . $separator;
            $parent_id  = $page->post_parent;
            endwhile;
            $parents = array_reverse( $parents );
            echo join( '', $parents );
            echo '<li>'.get_the_title().'</li>';
        }
        /* single */
        if(is_single()) {
            $categories_1 = get_the_category($post->ID);
            if($categories_1):
            foreach($categories_1 as $cat_1):
            $cat_1_ids[] = $cat_1->term_id;
            endforeach;
            $cat_1_line = implode(',', $cat_1_ids);
            endif;
            if( isset( $cat_1_line ) && $cat_1_line ) {
                $categories = get_categories(array(
                    'include' => $cat_1_line,
                    'orderby' => 'id'
                ));
                if ( $categories ) :
                foreach ( $categories as $cat ) :
                $cats[] = '<li><a href="' . get_category_link( $cat->term_id ) . '" title="' . $cat->name . '">' . $cat->name . '</a></li>';
                endforeach;
                echo join( '', $cats );
                endif;
            }
            echo '<li>'.get_the_title().'</li>';
        }
        /* tag */
        if( is_tag() ){ echo '<li>'."Tag: ".single_tag_title('',FALSE).'</li>'; }
        /* search */
        if( is_search() ){ echo '<li>'.esc_html__("Search", 'wp-amilia').'</li>'; }
        /* date */
        if( is_year() ){ echo '<li>'.get_the_time('Y').'</li>'; }
        /* 404 */
        if( is_404() ) {
            echo '<li>'.esc_html__("404 - Page not Found", 'wp-amilia').'</li>';
        }
        /* archive */
  		if( is_archive() && is_post_type_archive() ) {
  		    $title = post_type_archive_title( '', false );
  		    echo '<li>'. $title .'</li>';
  		}
        echo "</ul>";
    }
    
    /**
     * Get Shortcode From Content
     * 
     * @param string $shortcode
     * @param string $content
     * @return unknown
     */
    public static function amilia_getShortcodeFromContent($shortcode = '', $content = ''){
        
        preg_match("/\[".$shortcode."(.*)/", $content , $matches);
        
        return !empty($matches[0]) ? $matches[0] : null ;
    }
    
    /**
     * set google font for selecter.
     * 
     * @param array $googlefont
     * @param string $selecter
     */
    public static function amilia_setGoogleFont($googlefont = array(), $selecter = ''){
        
        if(isset($googlefont['font-family'])){
            /* add font selecter. */
            if($selecter){
                echo esc_attr($selecter)."{font-family:'".esc_attr($googlefont['font-family'])."';}";
            }
        }
    }
    
    /**
     * minimize CSS styles
     *
     * @since 1.1.0
     */
    public static function amilia_compressCss($buffer){
    
        /* remove comments */
        $buffer = preg_replace("!/\*[^*]*\*+([^/][^*]*\*+)*/!", "", $buffer);
        /* remove tabs, spaces, newlines, etc. */
        $buffer = str_replace("	", " ", $buffer); //replace tab with space
        $arr = array("\r\n", "\r", "\n", "\t", "  ", "    ", "    ");
        $rep = array("", "", "", "", " ", " ", " ");
        $buffer = str_replace($arr, $rep, $buffer);
        /* remove whitespaces around {}:, */
        $buffer = preg_replace("/\s*([\{\}:,])\s*/", "$1", $buffer);
        /* remove last ; */
        $buffer = str_replace(';}', "}", $buffer);
    
        return $buffer;
    }
}