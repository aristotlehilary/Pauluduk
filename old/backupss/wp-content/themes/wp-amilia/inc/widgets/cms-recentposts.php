<?php
/**
 * Class CmsRecentPosts
 */
class CmsRecentPosts extends WP_Widget {
    /**
     * Widget Setup
     */
    function __construct() {
        $widget_ops = array('classname' => 'cms-recent-posts', 'description' => esc_html__('A widget that displays recent posts.', 'wp-amilia') );
        $control_ops = array('id_base' => 'cms_recent_posts');
        parent::__construct('cms_recent_posts', esc_html__('CMS Recent Posts', 'wp-amilia'), $widget_ops, $control_ops);
    }

    /**
     * Display Widget
     * @param array $args
     * @param array $instance
     */
    function widget($args, $instance) {
        extract($args);
        $title = $instance['title'];
        $posts = $instance['posts'];

        $args_query = array(
            'orderby' => 'ID',
            'order' => 'DESC',
            'posts_per_page' => $posts
        );
        $cms_recentposts = new WP_Query($args_query);

        echo ''.$before_widget;
        if($title) {
            echo $before_title.esc_attr($title).$after_title;
        }
        ?>
        <?php if ($cms_recentposts->have_posts()) : ?>
            <div class="latest-post-footer-wrap">
                <ul class="latest-post-footer clearfix">
                <?php while($cms_recentposts->have_posts()): $cms_recentposts->the_post(); global $post; ?>
                    <li class="latest-post-footer-item">
                        <a href="<?php the_permalink(); ?>">
                            <div class="post-icon-footer"><?php amilia_archive_post_icon(); ?></div>
                            <div class="entry-wrap">
                                <h4 class="entry-title"><?php the_title(); ?></h4>
                                <span class="entry-date"><?php the_time('F d, Y') ?></span>
                            </div>
                        </a>
                    </li>
                <?php endwhile; ?>
                </ul>
            </div>
        <?php endif; ?>
        <!-- END WIDGET -->
        <?php
        echo ''.$after_widget;
        wp_reset_postdata();
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['posts'] = $new_instance['posts'];
        
        return $instance;
    }

    function form($instance) {


        $defaults = array('title' => 'Recent Posts', 'categories' => 'all', 'posts' => 3, 'show_featured' => true, 'show_author' => true, 'date_fomat' => '');
        $instance = wp_parse_args((array) $instance, $defaults); ?>

        <p>
            <label for="<?php echo ''.$this->get_field_id('title'); ?>"><?php esc_html_e('Title:', 'wp-amilia') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo ''.$this->get_field_name('title'); ?>" value="<?php echo ''.$instance['title']; ?>" />
        </p>
        <p>
            <label for="<?php echo ''.$this->get_field_id('posts'); ?>"><?php esc_html_e('Number of posts:', 'wp-amilia') ?></label>
            <input type="text" class="widefat" id="<?php echo ''.$this->get_field_id('posts'); ?>" name="<?php echo ''.$this->get_field_name('posts'); ?>" value="<?php echo ''.$instance['posts']; ?>" />
        </p>
    <?php
    }
}

register_widget('CmsRecentPosts');
?>