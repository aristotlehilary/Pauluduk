<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Cta
 */

$heading = $author = $subtext = $css_animation = $css_animation_delay = $css_duration = $type = $slogan_1 = $slogan_2 = $slogan_link = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
?>
<?php if ($type == 'promo') : ?>
<div class="cms-promo-wrap">
	<div class="cms-promo-inner clearfix">
		<div class="<?php echo esc_attr($css_animation); ?>" data-wow-delay="<?php echo esc_attr($css_animation_delay); ?>" data-wow-duration="<?php echo esc_attr($css_duration) ?>">
			<h2>
				<?php echo esc_attr($heading); ?>
			</h2>
			<h3 class="">
				<?php echo esc_attr($author); ?>
				<span>
					<?php echo esc_attr($subtext); ?>
				</span>
			</h2>
		</div>
	</div>
</div>
<?php else : ?>
	<?php
		$slogan1 = explode('|', $slogan_1);
	?>
	<div class="slogan-text-container row clearfix">
		<div class="col-md-4 bg_column_overleft">
			<div class="slogan-text-bg">
				<span class="bold"><?php echo esc_attr(trim($slogan1[0])) ?></span> <?php echo esc_attr(trim($slogan1[1])); ?>				
			</div>
		</div>
		<div class="col-md-8">
			<div class="slogan-text">
				<a href="<?php echo esc_url($slogan_link); ?>"><?php echo esc_attr($slogan_2); ?></a>
			</div>
		</div>
	</div>
<?php endif; ?>