<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Steps
 */

$step_heading_1 = $step_heading_2 = $step_heading_3 = $step_heading_4 = $link_final = $icon = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$icon = (!empty($icon_elegant)) ? $icon_elegant : 'icon_adjust-horiz';
?>

<div class="cms-steps-wrap">
	<div class="cms-step cms-step-1 clearfix">
		<div class="cms-number-wrap">
			<h3>01</h3>
		</div>
		<h3 class="step-heading">
			<?php echo esc_attr($step_heading_1); ?>
		</h3>
	</div>
	<div class="cms-step cms-step-2 clearfix">
		<div class="cms-number-wrap">
			<h3>02</h3>
		</div>
		<h3 class="step-heading">
			<?php echo esc_attr($step_heading_2); ?>
		</h3>
	</div>
	<div class="cms-step cms-step-3 clearfix">
		<div class="cms-number-wrap">
			<h3>03</h3>
		</div>
		<h3 class="step-heading">
			<?php echo esc_attr($step_heading_3); ?>
		</h3>
	</div>
	<div class="cms-step-line"></div>
	<div class="cms-final-step">
		<a href="<?php echo esc_url($link_final); ?>">
			<div onclick="" class="cms-fancybox-item  style6">
                <div class="fancy-box-icon-wrap">
                    <div class="fancy-box-icon-inner">
                        <div class="fancy-box-icon ">
                            <i class="<?php echo esc_attr($icon); ?>"></i>
                        </div>
                    </div>
                </div>
                <div class="fancy-content">
                    <h3 class="fancy-title"><?php echo esc_attr($step_heading_4); ?></h3>
                </div>
            </div>
		</a>
	</div>
</div>
