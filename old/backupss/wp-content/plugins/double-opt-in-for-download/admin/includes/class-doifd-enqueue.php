<?php

class DOIFDEnqueue extends DOIFDAdmin {
    
    public function __construct() {
//        parent::__construct();
        
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
        add_action ( 'admin_init', array( $this, 'doifd_admin_resend_verification_email' ) );
    }
    
    public function enqueue_admin_styles() {
        
        global $doifdPages;
       
        if( !isset( $doifdPages ) ) {
            return;
        }

        $screen = get_current_screen();
        
        if (in_array($screen->id, $doifdPages ))  {          
            wp_enqueue_style( $this->plugin_slug . '-admin-styles', DOIFD_URL . 'admin/assets/css/admin.css', array( ), DOIFD::VERSION );
            wp_enqueue_style( $this->plugin_slug . '-admin-jbox-styles', DOIFD_URL . 'admin/assets/css/jBox.css', array( ), DOIFD::VERSION );
            wp_enqueue_style( $this->plugin_slug . '-admin-jbox-tooltip-style', DOIFD_URL . 'admin/assets/css/TooltipBorder.css', array( ), DOIFD::VERSION );
            wp_enqueue_style( $this->plugin_slug . '-admin-js-ui-styles', DOIFD_URL . 'admin/assets/css/doifd-jquery-ui-min.css', array( ), DOIFD::VERSION );
            wp_enqueue_style( 'thickbox' );
            wp_enqueue_style( 'dashicons' );
            wp_enqueue_style( 'wp-color-picker' );
        }
    }

    public function enqueue_admin_scripts() {
        
        global $doifdPages;
    
        if( !isset( $doifdPages ) ) {
            return;
        }

        $screen = get_current_screen();
        
        if (in_array($screen->id, $doifdPages )) {
            wp_enqueue_script( $this->plugin_slug . '-admin-script', DOIFD_URL . 'admin/assets/js/admin.js', array( 'jquery' ), DOIFD::VERSION );
            wp_enqueue_script( $this->plugin_slug . '-admin-jbox-script', DOIFD_URL . 'admin/assets/js/jBox.min.js', array( 'jquery' ), DOIFD::VERSION );
            wp_enqueue_script( $this->plugin_slug . '-admin-validate-script', DOIFD_URL . 'admin/assets/js/jquery.validate.min.js', array( 'jquery' ), DOIFD::VERSION );
            wp_enqueue_script( $this->plugin_slug . '-admin-color-picker-script', DOIFD_URL . 'my-script.js',  array( 'wp-color-picker' ), false, true );
            wp_enqueue_script( 'jquery-ui-dialog' );
            wp_enqueue_script( 'jquery-ui-tabs' );
            wp_enqueue_script( 'jquery-ui-accordion' );        
            wp_enqueue_media();

            /* TODO This needs to be reviewed for deprecation */
            wp_localize_script( $this->plugin_slug . '-admin-script', 'ajaxupload', array(
                'uploadFormURL' => 'TB_inline?width=600&height=550&inlineId=doifd-upload-form',
                'mailchimp' => DOIFD_URL . 'admin/mailchimp-options.php',
                'uploadNonce' => wp_create_nonce( 'doifd-upload-nonce' ),
                'filetoolarge' => __( 'Your selected file exceeds your servers PHP file upload size limit. To learn how to get around your PHP file upload size limit, ', $this->plugin_slug ) . '<a href="http://www.doubleoptinfordownload.com/forums/topic/large-file-how-to-get-around-phps-file-upload-size-limit/" target="new" />' . __( ' Click Here', $this->plugin_slug ) . '</a>',
                'editdownloadform' => DOIFD_URL . 'premium/views/view-admin-edit-download.php',
                'adminImage' => DOIFD_ADMIN_IMG_URL
                    )
            );
        }

    }
    
    public function doifd_admin_resend_verification_email() {
        
            /* Check if it's coming from the resend verification email button and the user has privileges */
        
            $email = new DOIFDEmail;

            if ( isset ( $_REQUEST[ 'name' ] ) && ( $_REQUEST[ 'name' ] == 'doifd_lab_resend_verification_email' ) && ( current_user_can ( 'manage_options' ) ) ) {

                /* sanitize variables from form and assign to variables */

                $a = sanitize_text_field ( $_REQUEST[ 'user_name' ] );

                $b = sanitize_email ( $_REQUEST[ 'user_email' ] );

                $c = preg_replace ( '/[^ \w]+/', '', $_REQUEST[ 'user_ver' ] );

                $d = preg_replace ( "/[^0-9]/", "", $_REQUEST[ 'download_id' ] );

                /* Package clean variable into an array and send them to the send email function */

                if ( has_filter ( 'doifd_alt_verification_email' ) ) {

                    $send = apply_filters ( 'doifd_alt_verification_email', $value = array(
                        "user_name" => $a,
                        "user_email" => $b,
                        "user_ver" => $c,
                        "download_id" => $d ) );
                } else {

                    $send = $email->send_verification_email( $value = array(
                                "user_name" => $a,
                                "user_email" => $b,
                                "user_ver" => $c,
                                "download_id" => $d ) );
        }
        
                if ( $send === TRUE ) {
        
                    echo '<div class="updated"><p><strong>' . __ ( 'Email Sent', $this->plugin_slug ) . '</strong></p></div>';
                } else {

                    echo '<div class="error"><p><strong>' . __ ( 'The Email was NOT Sent', $this->plugin_slug ) . '</a></strong></p></div>';
                }
                
            }
            
        }

}
new DOIFDEnqueue();
