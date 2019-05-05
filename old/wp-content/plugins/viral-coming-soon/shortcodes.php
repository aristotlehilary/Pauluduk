<?php
global $viral_coming_soon;

/**
 * Checks if a Shortcode is already defined
 **/
if ( ! function_exists( 'viral_coming_soon_shortcode_exists' ) ) :
    function viral_coming_soon_shortcode_exists( $shortcode = false ) {
        
        global $shortcode_tags;
     
        if ( ! $shortcode )
            return false;
     
        if ( array_key_exists( $shortcode, $shortcode_tags ) )
            return true;
     
        return false;

    }
endif;

/**
 Confirmation & Thank You Page
 **/
if ( ! function_exists('viral_coming_soon_counter') ) {
    function viral_coming_soon_counter() {
        return '<div class="clock"></div>';
    }
}

if ( ! function_exists('viral_coming_soon_gmail') ) {
    function viral_coming_soon_gmail() {
        global $viral_coming_soon;

        if ( $viral_coming_soon['gmail-link'] && ! empty($viral_coming_soon['gmail-from']) && isset($_GET['gmail']) && $_GET['gmail'] == true ) {
            return '<p class="gmail">If you use Gmail, <a href="https://mail.google.com/mail/#search/from:' . $viral_coming_soon['gmail-from'] . '" title="Go directly to your Gmail Inbox">click here to go straight to your confirmation email</a>!</p>';
        }
    }
}

if ( ! function_exists('viral_coming_soon_like') ) {
    function viral_coming_soon_like() {
        global $viral_coming_soon;
        if ( ! empty($viral_coming_soon['facebook-url']) ) {
            if ( $viral_coming_soon['facebook-type'] ) {
                return '<div class="fb-like" data-href="' . $viral_coming_soon['facebook-url'] . '" data-layout="box_count" data-action="like" data-show-faces="false" data-share="false"></div>';
            } else {
                return '<div class="fb-page" data-href="' . $viral_coming_soon['facebook-url'] . '" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/habitualmente/"><a href="https://www.facebook.com/habitualmente/">Habitualmente</a></blockquote></div></div>';
            }
            
        }
    }
}

if ( ! function_exists('viral_coming_soon_download') ) {
    function viral_coming_soon_download() {
        global $viral_coming_soon;

        if ( ! empty($viral_coming_soon['leadbribe']) ) {
            return '<a href="' . $viral_coming_soon['leadbribe'] . '" target="_blank" title="Download now" class="button large">Download now <i class="fa fa-cloud-download"></i></a>';
        }

    }
}

if ( ! function_exists('viral_coming_soon_share') ) {
    function viral_coming_soon_share() {
        global $viral_coming_soon;

        if ( $viral_coming_soon['page-type'] == '1' ) {
            $url = get_home_url();
        } else {
            $url = get_permalink($viral_coming_soon['page-type-url']);
        }

        if ( ! empty( $viral_coming_soon['twitter-username'] ) ) {
            $via = $viral_coming_soon['twitter-username'];
        }
        ob_start();
        ?>
        <span class="columns large-6"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($url); ?>" class="button facebook expand" target="_blank">Share now <i class="fa fa-facebook-official"></i></a></span><span class="columns large-6"><a href="https://twitter.com/home?status=<?php echo urlencode($viral_coming_soon['click-to-tweet']); ?>%20<?php echo urlencode($url); if ( ! empty( $viral_coming_soon['twitter-username']) ) { echo '%20via%20%40' . urlencode($via); } ?>" class="button twitter expand" target="_blank">Click to tweet <i class="fa fa-twitter"></i></a></span>
        <?php
        $output = ob_get_clean();
        return $output;
     }
}
