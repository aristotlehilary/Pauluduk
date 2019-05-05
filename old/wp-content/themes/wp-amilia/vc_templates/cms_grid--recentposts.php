<?php
$custom_heading = (!empty($atts['grid_heading'])) ? $atts['grid_heading'] : '';
$view_all_link = (!empty($atts['grid_viewall_link'])) ? $atts['grid_viewall_link'] : '#';
?>

<?php if ($custom_heading): ?>
    <div class="owl-custom-heading-wrap grid-custom-heading-recentpost mb-50 <?php echo ($atts['filter']!="true" and $atts['layout']=='masonry') ? 'no-filter': ''; ?>">
        <div class="cms-custom-heading heading-with-bg-overlay has-line">
            <h2 class="cms-heading-inner"><span><?php echo esc_attr($custom_heading); ?></span></h2>
        </div>
        <div class="owl-readmore-wrap">
            <?php if (!empty($atts['grid_vieall']) && $atts['grid_vieall'] == true): ?>
                <a href="<?php echo esc_url($view_all_link) ?>" class="cms-button md gray-light">
                    <span><?php esc_html_e('VIEW ALL', 'wp-amilia'); ?></span>
                </a>
            <?php endif ?>
        </div>
    </div>
<?php endif ?>
<div class="cms-grid-wraper <?php echo esc_attr($atts['template']);?> mb-50" id="<?php echo esc_attr($atts['html_id']);?>">
    <div class="cms-gird-recentposts <?php echo esc_attr($atts['grid_class']);?>">
        <?php
        $posts = $atts['posts'];
        while($posts->have_posts()){
            $posts->the_post();
            ?>
            <div class="gird-recenpost-item cms-blog-item mb-20 clearfix">
                <div class="col-xs-3 col-sm-3 col-md-2">
                	<div class="row pos-relative">
                		<div class="entry-date-wrap">
                			<div class="date-item"><?php echo get_the_date('d'); ?></div>
                			<div class="month-item"><?php echo get_the_date('M'); ?></div>
                		</div>
                		<?php if (has_post_thumbnail()) : ?>
			                <?php amilia_the_post_thumbnail('amilia-portfolio-square'); ?>
			            <?php endif; ?>
                	</div>
                </div>
                <div class="col-xs-9 col-sm-9 col-md-10">
                	<div class="entry-content-wrap">
                		<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                		<div class="entry-meta">
							<?php amilia_blog_post_meta(); ?>
						</div>
                	</div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>