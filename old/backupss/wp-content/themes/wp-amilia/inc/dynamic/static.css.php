<?php

/**
 * Auto create .css file from Theme Options
 * @author Fox
 * @version 1.0.0
 */
class CMSSuperHeroes_StaticCss
{

    public $scss;
    
    function __construct()
    {   
        /* scss */
        $this->scss = new scssc();
        
        /* set paths scss */
        $this->scss->setImportPaths(get_template_directory() . '/assets/scss/');
             
        /* generate css over time */
		add_action('init', array($this, 'generate_over_time'));
        
        /* save option generate css */
       	add_action("redux/options/smof_data/saved", array(
            $this,
            'generate_file'
        ));
    }
	
    public function generate_over_time(){
    	
    	global $smof_data;
    	
    	if (!isset($smof_data['dev_mode'])) return ;
    	
    	if (!$smof_data['dev_mode']) return ;
    		
    	$this->generate_file();
    }
    /**
     * generate css file.
     *
     * @since 1.0.0
     */
    public function generate_file()
    {
        global $smof_data, $wp_filesystem;
        
        if (! empty($smof_data) && ! empty($wp_filesystem)) {
            
        	$options_scss = get_template_directory() . '/assets/scss/options.scss';
        	
        	/* delete files options.scss */
        	$wp_filesystem->delete($options_scss);
        	
            /* write options to scss file */
            $wp_filesystem->put_contents($options_scss, $this->css_render(), FS_CHMOD_FILE); // Save it
            
            /* minimize CSS styles */
            if (!$smof_data['dev_mode']) {
                $this->scss->setFormatter('scss_formatter_compressed');
            }
            
            /* compile scss to css */
            $css = $this->scss_render();
            
            $file = "static.css";
            
            if(!empty($smof_data['presets_color']) && $smof_data['presets_color']){
                $file = "presets-".$smof_data['presets_color'].".css";
            }
            
            $file = get_template_directory() . '/assets/css/' . $file;
            
            /* delete files static.css */
            $wp_filesystem->delete($file);
            
            /* write static.css file */
            $wp_filesystem->put_contents($file, $css, FS_CHMOD_FILE); // Save it
        }
    }
    
    /**
     * scss compile
     * 
     * @since 1.0.0
     * @return string
     */
    public function scss_render(){
        /* compile scss to css */
        return $this->scss->compile('@import "master.scss"');
    }
    
    /**
     * main css
     *
     * @since 1.0.0
     * @return string
     */
    public function css_render()
    {
        global $smof_data, $amilia_base;
        
        ob_start();
        
        /* google fonts. */
        if(isset($smof_data['google-font-1'])){
            $amilia_base->amilia_setGoogleFont($smof_data['google-font-1'], $smof_data['google-font-selector-1']);
        }
        if(isset($smof_data['google-font-2'])){
            $amilia_base->amilia_setGoogleFont($smof_data['google-font-2'], $smof_data['google-font-selector-2']);
        }
         if(isset($smof_data['google-font-3'])){
            $amilia_base->amilia_setGoogleFont($smof_data['google-font-3'], $smof_data['google-font-selector-3']);
        }
        /* forward options to scss. */
        
        if(!empty($smof_data['primary_color'])){
            echo '$primary_color:'.esc_attr($smof_data['primary_color']).';';
        }
        if ( !empty($smof_data['secondary_color']['rgba']) ) {
            echo '$secondary_color:'.esc_attr($smof_data['secondary_color']['rgba']).';';
        }
        if ( !empty($smof_data['link_color']) ) {
            echo '$link_color:'.esc_attr($smof_data['link_color']).';';
        }
        if ( !empty($smof_data['link_color_hover']) ) {
            echo '$link_color_hover:'.esc_attr($smof_data['link_color_hover']).';';
        }
        if ( !empty($smof_data['heading_color']) ) {
            echo '$heading_color:'.esc_attr($smof_data['heading_color']).';';
        }
        if ( !empty($smof_data['text_color']) ) {
            echo '$text_color:'.esc_attr($smof_data['text_color']).';';
        }

        /* Presets */
        

        /* style from Theme Option */
        if ( !empty($smof_data['font_body']['font-family']) ) {
            echo '$font_body:'.esc_attr($smof_data['font_body']['font-family']).', Arial,Helvetica,sans-serif;';
        }

        if ( !empty($smof_data['font_h1']['font-family']) ) {
            echo '$font_heading:'.esc_attr($smof_data['font_h1']['font-family']).', Arial,Helvetica,sans-serif ;';
        }
        
        return ob_get_clean();
    }
}

new CMSSuperHeroes_StaticCss();