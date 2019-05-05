<?php
/* Add widget */
add_action( 'widgets_init',  'latets_tweets_widgets_widgets' );

function latets_tweets_widgets_widgets() {
    register_widget('latets_tweets_widgets');
}
if( class_exists('WP_Widget') ) {
    class Latets_tweets_widgets extends WP_Widget {
        function __construct () {
            parent::__construct(
                'latets_tweets_widgets',
                'Latest Tweets',
                array( 'description' =>
                    'Display latest of Twitter' )
            );
        }
        function form( $instance ) {
        // Retrieve previous values from instance
        //    // or set default values if not present
            $twitter_post_number = ( !empty( $instance['twitter_post_number'] )) ?
                $instance['twitter_post_number'] : 1;

            $twitter_user_name = ( !empty( $instance['twitter_user_name'] )) ?
                $instance['twitter_user_name'] : 'abcgomel';

            $twitter_avt_size = ( !empty( $instance['twitter_avt_size'] ) ) ?
                $instance['twitter_avt_size'] : 'false';

            $twitter_loading_text = ( !empty( $instance['twitter_loading_text'] )) ?
                $instance['twitter_loading_text'] : 'loading tweets...';
            ?>
            <!-- Display fields to specify title and item count -->
            <p>
                <label for="<?php echo $this->get_field_id( 'twitter_user_name' ); ?>">
                    <?php echo 'Twitter Username:'; ?>
                </label>
                <input class="widefat"
                       type="text"
                       id="<?php echo $this->get_field_id( 'twitter_user_name' ); ?>"
                       name="<?php echo $this->get_field_name('twitter_user_name'); ?>"
                       value="<?php echo $twitter_user_name; ?>"
                       placeholder="abcgomel">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'twitter_avt_size' ); ?>">
                    <?php echo 'Show Avatar:'; ?>
                </label>
                <select
                    class="widefat"
                    name="<?php echo $this->get_field_name('twitter_avt_size'); ?>"
                    id="<?php echo $this->get_field_id( 'twitter_avt_size' ); ?>"
                    >
                    <option value="true" <?php selected($twitter_avt_size, 'true'); ?> >Yes</option>
                    <option value="false" <?php selected($twitter_avt_size, 'false'); ?> >No</option>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'twitter_post_number' ); ?>">
                    <?php echo 'Post number:'; ?>
                </label>
                <input class="widefat"
                           type="text"
                           id="<?php echo $this->get_field_id( 'twitter_post_number' ); ?>"
                           name="<?php echo $this->get_field_name('twitter_post_number'); ?>"
                           value="<?php echo $twitter_post_number; ?>"
                           placeholder="default is 1">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'twitter_loading_text' ); ?>">
                    <?php echo 'Loading Text:'; ?>
                </label>
                <input class="widefat"
                       type="text"
                       id="<?php echo $this->get_field_id( 'twitter_loading_text' ); ?>"
                       name="<?php echo $this->get_field_name('twitter_loading_text'); ?>"
                       value="<?php echo $twitter_loading_text; ?>"
                       placeholder="loading tweets...">
            </p>
        <?php }
        function widget( $args, $instance ) {
            extract($args);

            $instance['twitter_post_number']    = (empty($instance['twitter_post_number'])) ? 1 : $instance['twitter_post_number'];
            $instance['twitter_avt_size']       = (empty($instance['twitter_avt_size'])) ? false : $instance['twitter_avt_size'];
            $instance['twitter_loading_text']   = (empty($instance['twitter_loading_text'])) ? 'Loading tweets...' : $instance['twitter_loading_text'];
            $instance['url'] = get_template_directory_uri() . '/inc/widgets/twitter/';

            $title = apply_filters('widget_title', esc_html__('Latest Tweets', 'wp-amilia'));

            echo $before_widget;
            echo $before_title.$title.$after_title;

            if( $instance['twitter_user_name'] != '' ) {
                echo '<div class="tweets-container"><div class="tweet"></div></div>';

                wp_enqueue_script('jquery.tweet.js',  get_template_directory_uri() .  '/inc/widgets/twitter/jquery.tweet.js', null, '1.0.0', TRUE);

                wp_enqueue_script('ami.tweet.js', get_template_directory_uri() . '/inc/widgets/twitter/ami.tweet.js', null, '1.0.0', TRUE);
                wp_localize_script('ami.tweet.js', 'ami_tweet', $instance );
                wp_enqueue_script('ami.tweet.js');
            }

            echo $after_widget;
        }
    }
}