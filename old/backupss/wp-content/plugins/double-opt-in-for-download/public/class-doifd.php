<?php

require_once( DOIFD_DIR . 'public/includes/class-doifd-custom-css.php' );
require_once( DOIFD_DIR . 'public/includes/class-doifd-download.php' );
require_once( DOIFD_DIR . 'public/includes/class-doifd-shortcodes.php' );
require_once( DOIFD_DIR . 'public/includes/class-doifd-registration-form.php' );
require_once( DOIFD_DIR . 'public/includes/class-doifd-widget-registration-form.php' );
require_once( DOIFD_DIR . 'public/includes/class-doifd-registration.php' );
require_once( DOIFD_DIR . 'public/includes/class-doifd-landing-page.php' );
require_once( DOIFD_DIR . 'public/includes/class-doifd-widget.php' );
require_once( DOIFD_DIR . 'public/includes/class-doifd-validation.php' );
require_once( DOIFD_DIR . 'emails/class-doifd-email.php' );

class DOIFD {

    const VERSION = DOIFD_VERSION;

    public $plugin_slug = 'double-opt-in-for-download';
    protected static $instance = null;
    public $doifd_options;

    public function __construct() {

        $this->doifd_options = $this->get_options();


        add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
        add_action( 'admin_init', array( $this, 'doifd_upgradecheck' ) );
        add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueueFormStyles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueueWidgetFormStyles' ) );
        add_action( 'activated_plugin', array( $this, 'save_error' ) );
        add_action( 'widgets_init', array( $this, 'doifd_lab_widget' ) );
        add_action( 'wp_ajax_doifd_GFD', array( $this, 'getFormStyleData' ) );
        add_action( 'wp_ajax_doifd_GSI', array( $this, 'getSubscriberInfo' ) );
    }

    public static function get_instance() {

        if( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function get_plugin_slug() {
        return $this->plugin_slug;
    }

    public function getCustomCSS() {
        $getCSS = new DOIFDCustomCSS();
        $getCSS->add_css_to_head();
        return $getCSS;
    }

    public function get_options() {

        $this->doifd_options = get_option( 'doifd_lab_options' );
        return $this->doifd_options;
    }

    public static function activate( $network_wide ) {

        if( function_exists( 'is_multisite' ) && is_multisite() ) {

            if( $network_wide ) {

                // Get all blog ids
                $blog_ids = self::get_blog_ids();

                foreach ( $blog_ids as $blog_id ) {

                    switch_to_blog( $blog_id );
                    self::single_activate();

                    restore_current_blog();
                }
            } else {
                self::single_activate();
            }
        } else {
            self::single_activate();
        }
    }

    public static function deactivate( $network_wide ) {

        if( function_exists( 'is_multisite' ) && is_multisite() ) {

            if( $network_wide ) {

                // Get all blog ids
                $blog_ids = self::get_blog_ids();

                foreach ( $blog_ids as $blog_id ) {

                    switch_to_blog( $blog_id );
                    self::single_deactivate();

                    restore_current_blog();
                }
            } else {
                self::single_deactivate();
            }
        } else {
            self::single_deactivate();
        }
    }

    public function activate_new_site( $blog_id ) {

        if( 1 !== did_action( 'wpmu_new_blog' ) ) {
            return;
        }

        switch_to_blog( $blog_id );
        self::single_activate();
        restore_current_blog();
    }

    private static function get_blog_ids() {

        global $wpdb;

        // get an array of blog ids
        $sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

        return $wpdb->get_col( $sql );
    }

    private static function single_activate() {

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        global $wpdb;

        if( version_compare( get_bloginfo( 'version' ), '3.0', '<' ) ) {
            deactivate_plugins( basename( __FILE__ ) );
        }

        $old_version = get_option( 'doifd_lab_version' );
        $current_version = DOIFD::VERSION;

        if( $current_version != $old_version ) {

            update_option( 'doifd_lab_version', $current_version );

            self::installRoutine();
        }

        /* Create download directory if it does not exist */

        if( !is_dir( DOIFD_DOWNLOAD_DIR ) ) {
            mkdir( DOIFD_DOWNLOAD_DIR );
        }

        /* Create .htacess file to block access to download folders if it does not exist 
         * is there already an .htaccess file in the download directory?
         */

        if( !is_file( DOIFD_DOWNLOAD_DIR . '.htaccess' ) ) {

            /* Create the .htaccess file in the download directory. */

            $create_name = DOIFD_DOWNLOAD_DIR . '.htaccess';

            /* Open the .htaccess file for editing */

            $file_handle = fopen( $create_name, 'w' ) or die( "Error: Can't open file" );

            /* Add the contents of the .htaccess file */

            $content_string = "deny from all";

            /* Write the file to disk */

            fwrite( $file_handle, $content_string );

            /* Close the file */

            fclose( $file_handle );
        }
    }

    private static function single_deactivate() {
        // @TODO: Define deactivation functionality here
    }

    public function load_plugin_textdomain() {

        $domain = $this->plugin_slug;
        $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

        load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
        load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );
    }

    public function register_form_stylesheets() {
        wp_register_style( $this->plugin_slug . '-widget-style', plugins_url( 'assets/css/widget-style.php', __FILE__ ), array(), self::VERSION );
        wp_register_style( $this->plugin_slug . '-form-style', plugins_url( 'assets/css/form-style.php', __FILE__ ), array(), self::VERSION );
    }

    public function enqueue_styles() {
        global $post;

        wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/style.css', __FILE__ ), array(), self::VERSION );
        
    }

    public function enqueueFormStyles() {
        global $post;
        global $wpdb;

        if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'lab_subscriber_download_form' ) ) {
            preg_match_all( '/lab_subscriber_download_form download_id=([0-9]+) form_id=([0-9]+)/', $post->post_content, $matches );
            preg_match_all( '/lab_subscriber_download_form download_id=([0-9]+)/', $post->post_content, $matches2 );

            if( is_array( $matches ) ) {
                foreach ( $matches[ 2 ] as $match1 ) {
                    $formID1[] = $match1;
                }
            } else {
                $formID1 = array( $matches[ 2 ] );
            }

            if( is_array( $matches2 ) ) {
                foreach ( $matches2[ 1 ] as $match ) {

                    $sql1 = $wpdb->prepare( "SELECT
                        doifd_download_form
                        FROM
                        {$wpdb->prefix}doifd_lab_downloads WHERE doifd_download_id = %s", $match );
                    $formID2[] = $wpdb->get_var( $sql1 );
                }
            } else {

                $sql1 = $wpdb->prepare( "SELECT
                        doifd_download_form
                        FROM
                        {$wpdb->prefix}doifd_lab_downloads WHERE doifd_download_id = %s", $matches2[ 1 ] );
                $value = $wpdb->get_var( $sql1 );
                $formID2 = array( $value );
            }

            if( !empty( $formID1 ) && !empty( $formID2 ) ) {
                $formID = array_unique( array_merge( $formID1, $formID2 ) );
            } elseif( !empty( $formID1 ) && empty( $formID2 ) ) {
                $formID = $formID1;
            } elseif( empty( $formID1 ) && !empty( $formID2 ) ) {
                $formID = $formID2;
            } else {
                $formID = '';
            }


            if( !empty( $formID ) ) {

                foreach ( $formID as $match ) {

                    if( isset( $match ) && ($match != '0') ) {
                        wp_enqueue_style( $this->plugin_slug . '-form-style-' . $match, plugins_url( 'assets/css/form' . $match . '.css', __FILE__ ), array(), self::VERSION );
                    } else { 
                        wp_enqueue_style( $this->plugin_slug . '-form-style', plugins_url( 'assets/css/doifdLegacyForm.css', __FILE__ ), array(), self::VERSION );
                        
                    }
                }
            }
        }
    }
    /* This function retrieves the data to populate the admin edit forms */
    public function getFormStyleData() {
        
        global $wpdb;
        
        $formID = preg_replace ( '/[^0-9]/', '', $_POST[ 'formID' ] );
        
            /* Put this into a function???? Gets a listing of the forms for a dropdown menu */
            $sql2 = $wpdb->prepare( "SELECT
                doifd_download_form
                FROM
                {$wpdb->prefix}doifd_lab_forms WHERE doifd_form_id = %s", $formID );

            $formStyleData = $wpdb->get_row( $sql2, ARRAY_A );
            if( !empty( $formStyleData ) ) {
                $formStyles = unserialize(base64_decode($formStyleData['doifd_download_form'] ) );
                $formStyles = array_map('html_entity_decode', $formStyles);
            } else {
                $formStyles = '';
            }

        echo json_encode( $formStyles );
        wp_die();
    }
    
    /* This function gets the subscriber info */
    
    public function getSubscriberInfo() {
       
       global $wpdb;
        
       /* Get the subscribers information */
       
       $sql = $wpdb->prepare( "SELECT
                *
                FROM
                {$wpdb->prefix}doifd_lab_subscribers WHERE doifd_subscriber_id = %s", $_GET['subID'] );

       $subscriberData = $wpdb->get_row( $sql, ARRAY_A );
       
       /* Unserialize the misc fields to provide the data */
       $miscFields = unserialize($subscriberData['doifd_sub_data']);
       /* Filter out any empty array's, we just want to show actual values */
       $miscFields = (array_filter($miscFields));
       
       /* Get the name of the subscribers download */
       $sql1 = $wpdb->prepare( "SELECT
                doifd_download_name
                FROM
                {$wpdb->prefix}doifd_lab_downloads WHERE doifd_download_id = %s", $subscriberData['doifd_download_id'] );

       $downloadName = $wpdb->get_var( $sql1 );
       
       /* Make the date & time a little more readable */
       $time = strtotime($subscriberData['time']);
       $betterTime = date("m/d/y g:i A", $time);
        
       /* Generate the HTML for the popup */
       $html.= '<div style="width: 100%; padding: 25px; border: 8px solid #d3d3d3; font-size: 1.5em;">';
       $html.= '<span style="margin: 15px; display: block;">Name:  ' . $subscriberData['doifd_name'] . '</span>';
       $html.= '<span style="margin: 15px; display: block;">Email:  ' . $subscriberData['doifd_email'] . '</span>';
       $html.= '<span style="margin: 15px; display: block;">Download:  ' . $downloadName . '</span>';
       foreach ( $miscFields as $key => $value ) {
         $html.= '<span style="margin: 15px; display: block;">' . $key . ':  ' . $value . '</span>';
       }
       $html.= '<span style="margin: 15px; display: block;">IP Address:  ' . $subscriberData['doifd_subscriber_ip'] . '</span>';
       $html.= '<span style="margin: 15px; display: block;">Date:  ' . $betterTime . '</span>';
       $html.= '</div>';
       
       echo $html;
       wp_die();
    }

    public function enqueueWidgetFormStyles() {

        global $wpdb;

        if( is_active_widget( false, false, 'doifd_lab_widget_signup' ) ) {

            $widgetDownloadID = get_option( 'widget_doifd_lab_widget_signup' );

            $widgetFormID = array();

            /* Do a foreach statement with !empty to clean out empty array */
            foreach ( $widgetDownloadID as $val ) {
                
                     if( isset( $val[ 'doifd_form_id' ] ) && ( $val[ 'doifd_form_id' ] != '0') ) {
                        wp_enqueue_style( $this->plugin_slug . '-widget-form-style-'. $val[ "doifd_form_id" ], plugins_url( 'assets/css/form' . $val[ "doifd_form_id" ] . '.css', __FILE__ ), array(), self::VERSION );
                        wp_enqueue_style( $this->plugin_slug . '-default-form-style', plugins_url( 'assets/css/defaultFormStyles.css', __FILE__ ), array(), self::VERSION );
                    } else {
                        wp_enqueue_style( $this->plugin_slug . '-widget-form-style', plugins_url( 'assets/css/doifdLegacyWidgetForm.css', __FILE__ ), array(), self::VERSION );
                        
                    }
                
                }

        }
    }

    public function enqueue_scripts() {

        wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'assets/js/public.js', __FILE__ ), array( 'jquery' ), self::VERSION, true );
    }

    public function save_error() {

        file_put_contents( ABSPATH . 'wp-content/uploads/doifd_downloads/activation_error.txt', ob_get_contents() );
    }

    public function doifd_lab_widget() {
        register_widget( 'DOIFDFormWidget' );
    }

    public function doifd_upgradecheck() {

        $current_version = DOIFD::VERSION;

        $installed_version = get_option( 'doifd_lab_version' );

        if( !$installed_version ) {
            //No installed version - we'll assume its just been freshly installed
            add_option( 'doifd_lab_version', $current_version );
            
        } elseif( $installed_version != $current_version ) {

            self::installRoutine();

            //Database is now up to date: update installed version to latest version
            update_option( 'doifd_lab_version', $current_version );
        }
    }

    private static function installRoutine() {

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        global $wpdb;

        /* Create Download table */

        $download_table = $wpdb->prefix . 'doifd_lab_downloads';

        $download = "CREATE TABLE $download_table (
                        doifd_download_id INT(11) NOT NULL AUTO_INCREMENT ,
                        doifd_download_name VARCHAR(250) NOT NULL ,
                        doifd_download_file_name VARCHAR(250) NOT NULL ,
                        doifd_download_landing_page INT(20) NOT NULL ,
                        doifd_number_of_downloads INT(11) DEFAULT '0' NOT NULL ,
                        doifd_download_type TINYINT(1) DEFAULT '0' NOT NULL ,
                        doifd_download_form INT(11) DEFAULT '0' NOT NULL ,
                        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL ,
                        UNIQUE KEY id (doifd_download_id)
                        );";

        dbDelta( $download );

        /* Create Subscriber Table */

        $subscriber_table = $wpdb->prefix . 'doifd_lab_subscribers';

        $subscriber = "CREATE TABLE $subscriber_table (
                        doifd_subscriber_id INT(11) NOT NULL AUTO_INCREMENT,
                        doifd_name VARCHAR(250) NOT NULL ,
                        doifd_email VARCHAR(250) NOT NULL ,
                        doifd_email_verified TINYINT(1) DEFAULT '0' NOT NULL  ,
                        doifd_verification_number VARCHAR(75) NOT NULL ,
                        doifd_download_id VARCHAR(45) NOT NULL ,
                        doifd_subscriber_ip VARCHAR(20) NOT NULL ,
                        doifd_downloads_allowed TINYINT(1) DEFAULT '0' ,
                        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                        UNIQUE KEY id (doifd_subscriber_id)
                          );";

        dbDelta( $subscriber );

        /* Create table for Forms */

        $form_table = $wpdb->prefix . 'doifd_lab_forms';

        $forms = "CREATE TABLE $form_table (
                        doifd_form_id INT(11) NOT NULL AUTO_INCREMENT,
                        doifd_type VARCHAR(5) NOT NULL ,
                        doifd_name VARCHAR(250) NOT NULL ,
                        doifd_download_form TEXT NOT NULL ,
                        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                        UNIQUE KEY id (doifd_form_id)
                          );";

        dbDelta( $forms );

        /* Create the default form and add them to the form data base */

        $tableResults = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}doifd_lab_forms", OBJECT );

        if( empty( $tableResults ) ) {

            $oldValues = get_option( 'doifd_lab_options' );

            $defaultFormValues = array(
                
            'formName' => 'Doifd Default Form',
            'forms' => 'doifdDefault',
            'form_class_name' => '',
            'form_css' => '',
            'formHeaderTxt' => 'GET OUR FREE E-BOOK',
            'formHeaderTxtClr' => '#515151',
            'formHeaderfont' => 'Tahoma, Geneva, sans-serif',
            'formHeaderFntSze' => '1.2em',
            'formDescTxt' => 'Simply fill in the form below, verify your email address<br /> and you’ll be sent a link to download our free e-book.',
            'formDescTxtClr' => '#515151',
            'formDescfont' => 'Verdana, Geneva, sans-serif',
            'formDescFntSze' => '.9em',
            'formButtonTxt' => 'Submit!',
            'formButtonTxtClr' => '#ffffff',
            'formButtonBkgdClr' => '#DE1B1B',
            'useFormLabels' => '0',
            'useFormPlaceHolders' => '1',
            'formWidth' => '80%',
            'formInsidePadding' => '25px',
            'formBkgdClr' => '#F6F6F6',
            'formTxtClr' => '#515151',
            'formMarginRgt' => '',
            'formMarginLft' => '',
            'formMarginTop' => '',
            'formMarginBtm' => '',
            'formTxtInputBkgdClr' => '#ffffff',
            'formTxtInputWidth' => '85%',
            'formBorderWidth' => '8px',
            'formBorderClr' => '#2b2b2b',
            'formBorderStyle' => 'solid',
            'formBorderRadius' => ''
                
            );

//            $defaultWidgetFormValues = array(
//                
//            'formName' => 'Doifd Widget Default Form',
//            'forms' => 'doifdDefault',
//            'form_class_name' => '',
//            'form_css' => '',
//            'formHeaderTxt' => 'GET OUR FREE E-BOOK',
//            'formHeaderTxtClr' => '#515151',
//            'formHeaderfont' => 'Tahoma, Geneva, sans-serif',
//            'formHeaderFntSze' => '1.2em',
//            'formDescTxt' => 'Simply fill in the form below, verify your email address and you’ll be sent a link to download our free e-book.',
//            'formDescTxtClr' => '#515151',
//            'formDescfont' => 'Verdana, Geneva, sans-serif',
//            'formDescFntSze' => '.9em',
//            'formButtonTxt' => 'Submit!',
//            'formButtonTxtClr' => '#ffffff',
//            'formButtonBkgdClr' => '#00a010',
//            'useFormLabels' => '0',
//            'useFormPlaceHolders' => '1',
//            'formWidth' => '100%',
//            'formInsidePadding' => '25px',
//            'formBkgdClr' => '#000000',
//            'formTxtClr' => '#515151',
//            'formMarginRgt' => '',
//            'formMarginLft' => '',
//            'formMarginTop' => '',
//            'formMarginBtm' => '',
//            'formTxtInputBkgdClr' => '#ffffff',
//            'formTxtInputWidth' => '100%',
//            'formBorderWidth' => '',
//            'formBorderClr' => '',
//            'formBorderStyle' => '',
//            'formBorderRadius' => ''
//
//            );

            $updateFormValues = array(
                'doifd_name' => 'Doifd Default Form',
                'doifd_download_form' => base64_encode(serialize($defaultFormValues))
            );

            $updateFormFormats = array(
                '%s', // value1
                '%s' // value2
            );

            $wpdb->insert( $wpdb->prefix . 'doifd_lab_forms', $updateFormValues, $updateFormFormats );
            
            /* TODO: Is the Default Widget Form really needed?
             * This most likely will not be needed, but will leave the code here, just in case
             * 
            $updateWidgetValues = array(
                'doifd_name' => 'Doifd Widget Default Form',
                'doifd_download_form' => base64_encode(serialize($defaultWidgetFormValues))
            );

            $updateWidgetFormats = array(
                '%s', // value1
                '%s' // value2
            );

            $wpdb->insert( $wpdb->prefix . 'doifd_lab_forms', $updateWidgetValues, $updateWidgetFormats );
             * 
             * 
             */
            
            /* Create the Legacy Form(s) CSS files */
            $createCSS = new DOIFDCustomCSS;
            $createCSS->createLegacyFormCSS();
            $createCSS->createLegacyWidgetFormCSS();
            $createCSS->createCustomCSSFile($defaultFormValues, '1');
//            $createCSS->createCustomCSSFile($defaultWidgetFormValues, '2'); **I'm thinking this will really not be needed.
        }
        
                /* If there are already forms create in the table, we need to recreate the stylesheets */
        
        if( !empty( $tableResults ) ) {
            
             $sql1 = "SELECT * FROM " . $wpdb->prefix . "doifd_lab_forms";
             $formValue = $wpdb->get_results( $sql1, ARRAY_A );
             $createCSS = new DOIFDCustomCSS;

             foreach ($formValue as $forms) {
                             
             $value = unserialize(base64_decode($forms['doifd_download_form']));
                 
             $form = array(
                
            'formName' => $value['formName'],
            'forms' => $value['forms'],
            'form_class_name' => $value['form_class_name'],
            'form_css' => $value['form_css'],
            'formHeaderTxt' => $value['formHeaderTxt'],
            'formHeaderTxtClr' => $value['formHeaderTxtClr'],
            'formHeaderfont' => $value['formHeaderfont'],
            'formHeaderFntSze' => $value['formHeaderFntSze'],
            'formDescTxt' => $value['formDescTxt'],
            'formDescTxtClr' => $value['formDescTxtClr'],
            'formDescfont' => $value['formDescfont'],
            'formDescFntSze' => $value['formDescFntSze'],
            'formButtonTxt' => $value['formButtonTxt'],
            'formButtonTxtClr' => $value['formButtonTxtClr'],
            'formButtonBkgdClr' => $value['formButtonBkgdClr'],
            'useFormLabels' => $value['useFormLabels'],
            'useFormPlaceHolders' => $value['useFormPlaceHolders'],
            'formWidth' => $value['formWidth'],
            'formInsidePadding' => $value['formInsidePadding'],
            'formBkgdClr' => $value['formBkgdClr'],
            'formTxtClr' => $value['formTxtClr'],
            'formMarginRgt' => $value['formMarginRgt'],
            'formMarginLft' => $value['formMarginLft'],
            'formMarginTop' => $value['formMarginTop'],
            'formMarginBtm' => $value['formMarginBtm'],
            'formTxtInputBkgdClr' => $value['formTxtInputBkgdClr'],
            'formTxtInputWidth' => $value['formTxtInputWidth'],
            'formBorderWidth' => $value['formBorderWidth'],
            'formBorderClr' => $value['formBorderClr'],
            'formBorderStyle' => $value['formBorderStyle'],
            'formBorderRadius' => $value['formBorderRadius']
                
            );
             
             $createCSS->createCustomCSSFile($form, $forms['doifd_form_id']);
                 
             }
            
            $createCSS->createLegacyFormCSS();
            $createCSS->createLegacyWidgetFormCSS();
            
        }
        
        /* Setup DOIFD default options */

        /* If there are no options in the db, create the default options */
        if( !get_option( 'doifd_lab_options' ) ) {
            
            /* Setup the default options and put them in an array */
            $doifd_default_options = array(
                'downloads_allowed' => '1',
                'add_to_wpusers' => '0',
                'sendUserEmail' => '0',
                'removeDOIFDData' => '0',
                'form_security' => '0',
                'promo_link' => '0',
                'use_privacy_policy' => '0',
                'privacy_link_text' => '',
                'privacy_link_font_size' => '0.9em',
                'privacy_page' => '',
                'use_form_labels' => '1',
                'use_widget_form_labels' => '1',
                'notification_email' => '1',
                'from_email' => '',
                'email_name' => '',
                'email_message' => __( 'Dear {subscriber},

Thank you for your interest in our free download {download}.

Below you will find the link to your download file. We hope you will enjoy it.

{url}

Thank You', 'double-opt-in-for-download' ),
                'widget_class' => ''
            );
            
            /* Addd the doifd_lab_options */
            add_option( 'doifd_lab_options', $doifd_default_options );
        }
        
    }
    
    
}