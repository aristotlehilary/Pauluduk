<?php
if(class_exists('CmsShortCode')){
	vc_map(
		array(
			"name" => esc_html__("CMS Countdown", 'wp-amilia'),
		    "base" => "cms_countdown",
		    "class" => "vc-cms-countdown",
		    "category" => esc_html__("CmsSuperheroes Shortcodes", 'wp-amilia'),
		    "params" => array(
		        array(
	            "type" => "textfield",
	            "heading" => esc_html__("Date count down",'wp-amilia'),
	            "param_name" => "date_count_down",
	            "value" => "",
	            "description" => esc_html__("Set date count down (default:2020/10/10)",'wp-amilia'),
	            "group" => esc_html__("General Settings", 'wp-amilia')
		        ),
		    	array(
		            "type" => "cms_template",
		            "param_name" => "cms_template",
		            "admin_label" => true,
		            "heading" => esc_html__("Shortcode Template",'wp-amilia'),
		            "shortcode" => "cms_countdown",
		            "group" => esc_html__("Template", 'wp-amilia'),
		        )
		    )
		)
	);
	class WPBakeryShortCode_cms_countdown extends CmsShortCode{
		protected function content($atts, $content = null){
			/* require js */
			wp_enqueue_script('cms_countdown', get_template_directory_uri() . '/inc/elements/countdown/js/jquery.countdown.js', array( 'jquery' ), '2.0.5', true);
			wp_enqueue_script('cms_countdown_config', get_template_directory_uri() . '/inc/elements/countdown/js/countdown.config.js', array( 'jquery' ), '1.0.0', true);
			//default value
			$atts_extra = shortcode_atts(array(
				'title' => '',	
				    ), $atts);
			$atts = array_merge($atts_extra,$atts);
	        $html_id = cmsHtmlID('cms-countdown');
	        $atts['template'] = 'template-'.str_replace('.php','',$atts['cms_template']);
	        $atts['html_id'] = $html_id;
			return parent::content($atts, $content);
		}
	}
}
?>