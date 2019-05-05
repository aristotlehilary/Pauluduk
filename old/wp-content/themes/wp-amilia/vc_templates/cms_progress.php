<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Progress
 */

$step_heading_1 = $step_heading_2 = $step_heading_3 = $step_heading_4 = $icon_1 = $icon_2 = $icon_3 = $icon_4 = $css_animation = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
?>
<div class="cms-progress-wrap clearfix">
	<div class="col-xs-12 col-sm-6 col-md-3 <?php echo esc_attr($css_animation); ?>">
		<div class="progress-item">
			<i class="progress-icon <?php echo esc_attr($icon_1) ?>"></i>
			<h3 class="progress-title"><?php echo esc_attr($step_heading_1); ?></h3>
		</div>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-3 <?php echo esc_attr($css_animation); ?>">
		<div class="progress-item">
			<i class="progress-icon <?php echo esc_attr($icon_2) ?>"></i>
			<h3 class="progress-title"><?php echo esc_attr($step_heading_2); ?></h3>
		</div>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-3 <?php echo esc_attr($css_animation); ?>">
		<div class="progress-item">
			<i class="progress-icon <?php echo esc_attr($icon_3) ?>"></i>
			<h3 class="progress-title"><?php echo esc_attr($step_heading_3); ?></h3>
		</div>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-3 <?php echo esc_attr($css_animation); ?>">
		<div class="progress-item">
			<i class="progress-icon <?php echo esc_attr($icon_4) ?>"></i>
			<h3 class="progress-title"><?php echo esc_attr($step_heading_4); ?></h3>
		</div>
	</div>
</div>