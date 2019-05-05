<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $el_class
 * @var $value
 * @var $units
 * @var $color
 * @var $custom_color
 * @var $label_value
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_Vc_Pie
 */
$title = $el_class = $value = $units = $color = $custom_color = $label_value = $css = '';
$atts = $this->convertOldColorsToNew( $atts );
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$class_to_filter = 'vc_pie_chart wpb_content_element';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
$bar_bg = !empty( $color ) ? $color : '#eee';
$value_bg = !empty( $value_color ) ? $value_color : '#d0d0d0';
$uniqu_id = uniqid().time();
?>
<div id="vc-pie-<?php echo esc_attr($uniqu_id); ?>" class=" <?php echo esc_attr( $css_class ); ?> " 
	data-bgcolor="<?php echo esc_attr( $bar_bg ); ?>" 
	data-fgcolor="<?php echo esc_attr( $value_bg ); ?>" 
	data-percent="<?php echo esc_attr( $value ); ?>" 
	data-fontsize="24" 
	data-width="30" 
	data-info="<?php echo esc_attr( $value ); ?><?php echo esc_attr( $units ); ?>" 
	data-text="<?php echo esc_attr($title); ?>" 
	data-dimension="180">
		
</div>