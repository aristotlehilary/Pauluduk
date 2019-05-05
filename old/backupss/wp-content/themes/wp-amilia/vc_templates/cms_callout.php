<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Cta
 */

$link = $a_href = $a_title = $a_target = $button_text = $h2 = $color = $style = $callout_image = $image_url = '';
$img = array();
$attributes = array();
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
//parse link
$link = ( '||' === $link ) ? '' : $link;
$link = vc_build_link( $link );
$use_link = false;
if ( strlen( $link['url'] ) > 0 ) {
	$use_link = true;
	$a_href = $link['url'];
	$a_title = $link['title'];
	$a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
}

if ( $use_link ) {
	$attributes[] = 'href="' . esc_url( trim( $a_href ) ) . '"';
	$attributes[] = 'title="' . esc_attr( trim( $a_title ) ) . '"';
	$attributes[] = 'target="' . esc_attr( trim( $a_target ) ) . '"';
}
$attributes = implode( ' ', $attributes );
?>
<?php if ($style == 'animate'): ?>
	<section class="cms-callout-wrap <?php echo esc_attr($style); ?>">
		<div class="callout-content pull-left">
			<h2><?php echo esc_attr($h2); ?></h2>
			<div class="callout-text"><?php echo esc_attr($content) ?></div>
		</div>
		<div class="callout-action pull-right">
			<?php if ($use_link): ?>
				<a <?php echo ''.$attributes; ?> class="cms-callout-button">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/slogan-arrow-black.png" alt="">
					<span class="line1"><?php echo esc_attr($button_text); ?></span>
					<span class="line2"><?php echo esc_attr($button_text); ?></span>
				</a>
			<?php endif; ?>
		</div>
	</section>
<?php else : ?>
	<section class="cms-callout-wrap <?php echo esc_attr($style); ?> row">
		<div class="callout-content col-md-8">
			<h2><?php echo esc_attr($h2); ?></h2>
			<div class="callout-text"><?php echo esc_attr($content) ?></div>
		</div>
		<div class="callout-action col-md-4 text-center">
			<?php if ($use_link): ?>
				<a <?php echo ''.$attributes; ?> class="cms-button lg yellow"><?php echo esc_attr($button_text); ?></a>
			<?php endif ?>
		</div>
	</section>
<?php endif; ?>