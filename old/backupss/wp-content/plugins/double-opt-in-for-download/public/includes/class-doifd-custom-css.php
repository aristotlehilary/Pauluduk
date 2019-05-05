<?php

class DOIFDCustomCSS extends DOIFD {

    protected static $instance = null;
    public $doifd_options;

    public function __construct() {

        $this->doifd_options = $this->get_options();

        add_action( 'wp_head', array( $this, 'add_css_to_head' ) );
    }

    public static function get_instance() {

        if( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function add_css_to_head() {

        if( !empty( $this->doifd_options[ 'form_class_textarea' ] ) ) {

            $form_custom_css = $this->doifd_options[ 'form_class_textarea' ];
        } else {

            $form_custom_css = '';
        }

        if( !empty( $this->doifd_options[ 'widget_class_textarea' ] ) ) {

            $widget_custom_css = $this->doifd_options[ 'widget_class_textarea' ];
        } else {

            $widget_custom_css = '';
        }

        if( (!empty( $form_custom_css ) ) || (!empty( $widget_custom_css ) ) ) {
            echo "\n";
            echo '<style type="text/css" media="screen">' . "\n";
            echo "\n";
            echo '/* DOIFD Form Custom CSS */' . "\n" . "\n";
        }
        if( !empty( $form_custom_css ) ) {
            echo $form_custom_css . "\n";
            echo "\n";
        }
        if( !empty( $widget_custom_css ) ) {
            echo "\n";
            echo $widget_custom_css . "\n";
            echo "\n";
            echo '</style>' . "\n";
        } else {
            echo '</style>' . "\n";
        }
    }

    public function createLegacyFormCSS() {

        $doifd_form_option = get_option( 'doifd_lab_options' );

        $fileName = DOIFD_DIR . 'public/assets/css/doifdLegacyForm.css';
        $file = fopen( "$fileName", "w" );

        $style = '';
        $style.= '.doifd_user_reg_form {' . "\n";
        $style.= 'margin: 15px auto;' . "\n";
        $style.= 'width: ' . ( (isset($doifd_form_option[ "form_padding" ]) && !empty( $doifd_form_option[ "form_width" ] ) ) ? $doifd_form_option[ "form_width" ] : "450" ) . 'px;' . "\n";
        $style.= 'padding: ' . ( (isset($doifd_form_option[ "form_padding" ]) && !empty( $doifd_form_option[ "form_padding" ] ) ) ? $doifd_form_option[ "form_padding" ] : "15" ) . 'px;' . "\n";
        $style.= 'background-color:' . ( (isset($doifd_form_option[ "form_background_color" ]) && !empty( $doifd_form_option[ "form_background_color" ] ) ) ? $doifd_form_option[ "form_background_color" ] : 'transparent' ) . ';' . "\n";
        $style.= 'color: ' . ( (isset($doifd_form_option[ "form_color" ]) && !empty( $doifd_form_option[ "form_color" ] ) ) ? $doifd_form_option[ "form_color" ] : "#000000" ) . ';' . "\n";
        $style.= '-webkit-border-radius: 4px;' . "\n";
        $style.= '-moz-border-radius: 4px;' . "\n";
        $style.= 'border-radius: 8px;' . "\n";
        $style.= '-webkit-box-shadow: inset 0 1px 15px rgba(68,68,68,0.6);' . "\n";
        $style.= '-moz-box-shadow: inset 0 1px 15px rgba(68,68,68,0.6);' . "\n";
        $style.= 'box-shadow: inset 0 1px 15px rgba(68,68,68,0.6);' . "\n";
        $style.= 'text-align: center;' . "\n";
        $style.= '}' . "\n";

        $style.= '.doifd_user_reg_form ul, li{' . "\n";
        $style.= 'list-style: none;' . "\n";
        $style.= 'padding-top: 10px;' . "\n";
        $style.= 'margin: 0 auto;' . "\n";
        $style.= '}' . "\n";

        $style.= '.doifd_user_reg_form label {' . "\n";
        $style.= 'display: block;' . "\n";
        $style.= 'width: auto;' . "\n";
        $style.= 'float: left;' . "\n";
        $style.= 'margin: 2px 4px 6px 4px;' . "\n";
        $style.= 'text-align: right;' . "\n";
        $style.= '}' . "\n";

        $style.= '.doifd_user_reg_form input[type=text]{' . "\n";
        $style.= 'border: 1px solid #006;' . "\n";
        $style.= 'background: ' . (!empty( $doifd_form_option[ "form_input_field_background_color" ] ) ? $doifd_form_option[ "form_input_field_background_color" ] : "transparent" ) . ';' . "\n";
        $style.= 'width: ' . (!empty( $doifd_form_option[ "form_input_field_width" ] ) ? $doifd_form_option[ "form_input_field_width" ] : "70%" ) . ';' . "\n";
        $style.= 'margin-bottom: 10px;' . "\n";
        $style.= '}' . "\n";

        $style.= '.doifd_user_reg_form h4 {' . "\n";
        $style.= 'width: 80%;' . "\n";
        $style.= 'color: ' . (!empty( $doifd_form_option[ "form_title_color" ] ) ? $doifd_form_option[ "form_title_color" ] : "#000000" ) . ';' . "\n";
        $style.= 'margin: 15px auto!important;' . "\n";
        $style.= 'text-align: center;' . "\n";
        $style.= 'font-weight: bold;' . "\n";
        $style.= 'font-size: ' . (!empty( $doifd_form_option[ "form_title_size" ] ) ? $doifd_form_option[ "form_title_size" ] : "1em" ) . ';' . "\n";
        $style.= '}' . "\n";

        $style.= '#doifd_button_holder {' . "\n";
        $style.= 'width: 100%;' . "\n";
        $style.= 'margin: 15px auto;' . "\n";
        $style.= 'text-align: center;' . "\n";
        $style.= '}' . "\n";

        $style.= '.doifd_privacy_link {' . "\n";
        $style.= 'text-align: center;' . "\n";
        $style.= 'font-size: ' . (!empty( $doifd_form_option[ "privacy_link_font_size" ] ) ? $doifd_form_option[ "privacy_link_font_size" ] : "1em" ) . ';' . "\n";
        $style.= 'margin: 15px auto;' . "\n";
        $style.= '}' . "\n";

        fwrite( $file, $style );
        fclose( $file );
    }
    
    public function createLegacyWidgetFormCSS() {
        
        $doifd_widget_option = get_option( 'doifd_lab_options' );

        $fileName = DOIFD_DIR . 'public/assets/css/doifdLegacyWidgetForm.css';
        $file = fopen( "$fileName", "w" );
        
        $style = '';
        $style.= '.widget_doifd_user_reg_form {' . "\n";
        $style.= 'width: ' . (!empty( $doifd_widget_option[ "widget_width" ] ) ? $doifd_widget_option[ "widget_width" ] : "190" ) . 'px;' . "\n";
        $style.= 'margin-top: ' . (!empty( $doifd_widget_option[ "widget_margin_top" ] ) ? $doifd_widget_option[ "widget_margin_top" ] : "25" ) . 'px;' . "\n";
        $style.= 'margin-right: ' . (!empty( $doifd_widget_option[ "widget_margin_right" ] ) ? $doifd_widget_option[ "widget_margin_right" ] : "0" ) . 'px;' . "\n";
        $style.= 'margin-bottom: ' . (!empty( $doifd_widget_option[ "widget_margin_bottom" ] ) ? $doifd_widget_option[ "widget_margin_bottom" ] : "25" ) . 'px;' . "\n";
        $style.= 'margin-left: ' . (!empty( $doifd_widget_option[ "widget_margin_left" ] ) ? $doifd_widget_option[ "widget_margin_left" ] : "0" ) . 'px;' . "\n";
        $style.= '-webkit-border-radius: 4px;' . "\n";
        $style.= '-moz-border-radius: 4px;' . "\n";
        $style.= 'border-radius: 4px;' . "\n";
        $style.= '-webkit-box-shadow: inset 0 1px 15px rgba(68,68,68,0.6);' . "\n";
        $style.= '-moz-box-shadow: inset 0 1px 15px rgba(68,68,68,0.6);' . "\n";
        $style.= 'box-shadow: inset 0 1px 15px rgba(68,68,68,0.6);' . "\n";
        $style.= 'padding: ' . (!empty( $doifd_widget_option[ "widget_inside_padding" ] ) ? $doifd_widget_option[ "widget_inside_padding" ] : "5" ) . 'px;' . "\n";
        $style.= 'background-color: ' . (!empty( $doifd_widget_option[ "widget_background_color" ] ) ? $doifd_widget_option[ "widget_background_color" ] : "transparent" ) . ';' . "\n";
        $style.= '}' . "\n";

        $style.= '.widget_doifd_user_reg_form label {' . "\n";
        $style.= 'color: ' . (!empty( $doifd_widget_option[ "widget_color" ] ) ? $doifd_widget_option[ "widget_color" ] : "#000000" ) . ';' . "\n";
        $style.= '}' . "\n";

        $style.= '.widget_doifd_user_reg_form ul, li {' . "\n";
        $style.= 'list-style-type: none;' . "\n";
        $style.= 'padding: 0px;' . "\n";
        $style.= 'margin: 0px;' . "\n";
        $style.= '}' . "\n";

        $style.= '.widget_doifd_user_reg_form input[type=text] {' . "\n";
        $style.= 'width: ' . (!empty( $doifd_widget_option[ "widget_input_width" ] ) ? $doifd_widget_option[ "widget_input_width" ] : "180" ) . ';' . "\n";
        $style.= 'background: ' . (!empty( $doifd_widget_option[ "widget_input_field_background_color" ] ) ? $doifd_widget_option[ "widget_input_field_background_color" ] : "transparent" ) . ';' . "\n";
        $style.= 'margin-bottom: 10px;' . "\n";
        $style.= '}' . "\n";

        $style.= '.doifd_widget_promo_link {' . "\n";
        $style.= 'font-size: 0.7em !important;' . "\n";
        $style.= 'padding-top: 15px !important;' . "\n";
        $style.= 'text-align: center;' . "\n";
        $style.= '}' . "\n";

        $style.= '.doifd_widget_promo_link a:link,' . "\n";
        $style.= '.doifd_widget_promo_link a:visited,' . "\n";
        $style.= '.doifd_widget_promo_link a:hover,' . "\n";
        $style.= '.doifd_widget_promo_link a:active {' . "\n";
        $style.= 'color: #CCCCCC !important;' . "\n";
        $style.= '}' . "\n";

        $style.= '.doifd_widget_statusmsg {' . "\n";
        $style.= 'margin-bottom: 20px;' . "\n";
        $style.= 'width: 100%;' . "\n";
        $style.= 'font-size: 1em;' . "\n";
        $style.= 'text-align: center;' . "\n";
        $style.= '}' . "\n";

        $style.= '.doifd_widget_waiting {' . "\n";
        $style.= 'color: #767676;' . "\n";
        $style.= 'text-align: center;' . "\n";
        $style.= 'display: none;' . "\n";
        $style.= 'font-family : Arial, sans-serif;' . "\n";
        $style.= 'font-size:0.8em;' . "\n";
        $style.= 'font-weight: bold;' . "\n";
        $style.= 'margin: 100px auto;' . "\n";
        $style.= 'background: transparent;' . "\n";
        $style.= '}' . "\n";

        $style.= '.doifd_widget_h4 {' . "\n";
        $style.= 'margin: 5px auto;' . "\n";
        $style.= 'text-align: center;' . "\n";
        $style.= 'width: 90%;' . "\n";
        $style.= 'color: ' . (!empty( $doifd_widget_option[ "widget_title_color" ] ) ? $doifd_widget_option[ "widget_title_color" ] : "#000000" ) . ';' . "\n";
        $style.= 'font-size: ' . (!empty( $doifd_widget_option[ "widget_title_size" ] ) ? $doifd_widget_option[ "widget_title_size" ] : "1em" ) . ';' . "\n";
        $style.= '}' . "\n";

        $style.= '.doifd_privacy_link {' . "\n";
        $style.= 'text-align: center;' . "\n";
        $style.= 'margin: 15px auto;' . "\n";
        $style.= 'font-size: ' . (!empty( $doifd_widget_option[ "privacy_link_font_size" ] ) ? $doifd_widget_option[ "privacy_link_font_size" ] : "0.9em" ) . ';' . "\n";
        $style.= '}' . "\n";
        
        fwrite( $file, $style );
        fclose( $file );
        
    }
    
    public function createCustomCSSFile($css, $id ) {
        
        /* We only want this to run if the form id is anything but "0"
         * "0" is the legacy form
         */
        
        if($id != '0') {
       
        /* Below creates the css form for the given form */
            
        $fileName = DOIFD_DIR . 'public/assets/css/form' . $id . '.css'; /* Names the css file to open or create */
        $file = fopen("$fileName", "w"); /* Does the opening */
        
        /* if admin put a name in the custom css name field we're gonna assume they are going the custom route */
        if(!empty($css['form_class_name']) && (!empty($css['form_css']))) {
            
            $style = '';
            $style = preg_replace("/<br[^>]*>\s*\r*\n*/is", "\n", $css['form_css'] );  
            
        } else {
            
        /* create a css file based on the option settings */
            
        $style = '';
        $style.= '#doifdForm' . $id . ' .' . $css[ 'forms' ] . $id . ' {' . "\n";
        if(!empty($css[ 'formWidth' ])) {
        $style.= 'width:' . $css[ 'formWidth' ] . ';' . "\n";
        }
        $style.= 'text-align: center;' . "\n";
        if(!empty($css[ 'formInsidePadding' ])) {
        $style.= 'padding: ' . $css[ 'formInsidePadding' ] . ';' . "\n";
        }
        if(!empty($css[ 'formBkgdClr' ])) {
        $style.= 'background: ' . $css[ 'formBkgdClr' ] . ';' . "\n";
        }
        if(!empty($css[ 'formMarginRgt' ])) {
        $style.= 'margin-right: ' . $css[ 'formMarginRgt' ] . ';' . "\n";
        }
        if(!empty($css[ 'formMarginLft' ])) {
        $style.= 'margin-left: ' . $css[ 'formMarginLft' ] . ';' . "\n";
        }
        if(!empty($css[ 'formMarginTop' ])) {
        $style.= 'margin-top: ' . $css[ 'formMarginTop' ] . ';' . "\n";
        }
        if(!empty($css[ 'formMarginBtm' ])) {
        $style.= 'margin-bottom: ' . $css[ 'formMarginBtm' ] . ';' . "\n";
        }
        if(!empty($css[ 'formTxtClr' ])) {
        $style.= 'color: ' . $css[ 'formTxtClr' ] . ';' . "\n";
        }
        $style.= 'font-family: Arial, Helvetica, sans-serif;' . "\n";
        if(!empty($css[ 'formBorderWidth' ] ) && !empty($css['formBorderStyle']) && !empty($css['formBorderClr'])) {
        $style.= 'border: ' . $css[ 'formBorderWidth' ] . ' ' . $css['formBorderStyle'] . ' ' . $css['formBorderClr'] . ';' . "\n";
        }
        if(!empty($css['formBorderRadius'])) {
        $style.= 'border-radius: ' . $css['formBorderRadius'] . ';' . "\n";
        $style.= '-moz-border-radius: ' . $css['formBorderRadius'] . ' ' . $css['formBorderRadius'] . ' ' . $css['formBorderRadius'] . ' ' . $css['formBorderRadius'] . ';' . "\n";
        $style.= '-webkit-border-radius: ' . $css['formBorderRadius'] . ' ' . $css['formBorderRadius'] . ' ' . $css['formBorderRadius'] . ' ' . $css['formBorderRadius'] . ';' . "\n";
        }
        $style.= '}' . "\n";
        
        $style.= '#doifdForm' . $id . ' .' . $css[ 'forms' ] . $id . ' ul, li {' . "\n";
        $style.= 'list-style: none;' . "\n";
        $style.= 'padding-top: 10px;' . "\n";
        $style.= 'margin: 0 auto;' . "\n";
        $style.= '}' . "\n";
        
        $style.= '#doifdForm' . $id . ' .' . $css[ 'forms' ] . $id . ' input, label {' . "\n";
        $style.= 'margin: 5px;' . "\n";
        $style.= '}' . "\n";
        
        $style.= '#doifdForm' . $id . ' .' . $css[ 'forms' ] . $id . ' input[type=text]{' . "\n";
        if(!empty($css[ 'formTxtInputWidth' ])) {
        $style.= 'width: ' . $css[ 'formTxtInputWidth' ] . ';' . "\n";
        }
        if(!empty($css[ 'formTxtInputBkgdClr' ])) {
        $style.= 'background: ' . $css[ 'formTxtInputBkgdClr' ] . ';' . "\n";
        }
        $style.= '}' . "\n";
        $style.= '#doifdForm' . $id . ' .doifdTitle' . $id . ' {' . "\n";
        if(!empty($css[ 'formHeaderTxtClr' ])) {
        $style.= 'color: ' . $css[ 'formHeaderTxtClr' ] . ';' . "\n";
        }
        if(!empty($css[ 'formHeaderfont' ])) {
        $style.= 'font-family: ' . $css[ 'formHeaderfont' ] . ';' . "\n";
        }
        if(!empty($css[ 'formHeaderFntSze' ])) {
        $style.= 'font-size: ' . $css[ 'formHeaderFntSze' ] . ';' . "\n";
        }
        $style.= 'text-align: center;' . "\n";
        $style.= 'margin: 0px 0px 15px 0px;' . "\n";
        $style.= '}' . "\n";
        $style.= '#doifdForm' . $id . ' .doifdDesc' . $id . ' {' . "\n";
        if(!empty($css[ 'formDescTxtClr' ])) {
        $style.= 'color: ' . $css[ 'formDescTxtClr' ] . ';' . "\n";
        }
        if(!empty($css[ 'formDescfont' ])) {
        $style.= 'font-family: ' . $css[ 'formDescfont' ] . ';' . "\n";
        }
        if(!empty($css[ 'formDescFntSze' ])) {
        $style.= 'font-size: ' . $css[ 'formDescFntSze' ] . ';' . "\n";
        }
        $style.= 'text-align: center;' . "\n";
        $style.= 'margin: 15px 0px;' . "\n";
        $style.= 'line-height: 1.5em;' . "\n";
        $style.= '}' . "\n";

        $style.= '#doifdForm' . $id . ' .' . $css[ 'forms' ] . $id . ' input[type=text] {' . "\n";
        if(!empty($css[ 'formTxtInputWidth' ])) {
        $style.= 'width: ' . $css[ 'formTxtInputWidth' ] . ';' . "\n";
        }
        if(!empty($css[ 'formTxtInputBkgdClr' ])) {
        $style.= 'background: ' . $css[ 'formTxtInputBkgdClr' ] . ';' . "\n";
        }
        if( $css[ 'forms' ] == 'doifdDefault') {
        $style.= 'margin-bottom: 20px;' . "\n";
        }
        $style.= '}' . "\n";
        $style.= '#doifdForm' . $id . ' .' . $css[ 'forms' ] . $id . ' input[type=submit] {' . "\n"; 
        if( $css[ 'forms' ] == 'doifdDefault') {
        $style.= 'width: 50%;' . "\n";
        }
        $style.= 'color: '  . $css[ 'formButtonTxtClr' ] . ';' . "\n";
        $style.= 'background: '  . $css[ 'formButtonBkgdClr' ] . ';' . "\n";
        $style.= '}' . "\n";
        $style.= '#doifdForm' . $id . ' .doifdDefaultButtonHolder {' . "\n";
        $style.= 'text-align: center;' . "\n";
        $style.= '}' . "\n";
        
        }
        
        fwrite($file, $style); /* write to the file */
        fclose($file); /* close the file */
        
        }
    }
}
new DOIFDCustomCSS();
