<?php
    
    class DOIFDEmail extends DOIFD {

        public $doifd_options;

        public function __construct() {
            parent::__construct();
    
            $this->doifd_options = $this->get_options();            
               
        }
            
        public function send_verification_email( $value ) {

            global $wpdb;

            $wpdb->doifd_subscribers = $wpdb->prefix . 'doifd_lab_subscribers';
            $wpdb->doifd_downloads = $wpdb->prefix . 'doifd_lab_downloads';

            /* If $value is not empty proceed, other wise, let die */

            if ( ! empty ( $value ) ) {


                /* If the admin set a different "from email" use that otherwise use the default admin email address. */

                if ( ! empty ( $this->doifd_options[ 'from_email' ] ) ) {

                    $msg_from_email = $this->doifd_options[ 'from_email' ];
                } else {

                    $msg_from_email = get_bloginfo ( 'admin_email' );
                }

                /* If the admin set a different "Website Name" use that, otherwise use the default admin blog name. */

                if ( ! empty ( $this->doifd_options[ 'email_name' ] ) ) {

                    $msg_from_name = $this->doifd_options[ 'email_name' ];
                } else {

                    $msg_from_name = get_bloginfo ( 'name' );
                }

                /* Send HTML Email */

                if ( isset ( $this->doifd_options[ 'send_html' ] ) ) {

                    $html = $this->doifd_options[ 'send_html' ];
                } else {

                    $html = FALSE;
                }
                
                if ( isset ( $this->doifd_options[ 'send_html' ] ) && ( $this->doifd_options[ 'send_html' ] == '1' ) ) {

                    $type = 'text/html';
                } else {

                    $type = 'text/plain';
                }

                /* Get the email address of subscriber and assign to variable */

                $doifd_lab_to = $value[ 'user_name' ] . ' <' . $value[ 'user_email' ] . '>';

                /* Get the user name of subscriber and assign to variable */

                $doifd_user_name = $value[ 'user_name' ];

                /* Get the download_id and assign to variable */
                
                $doifd_download_id = $value[ 'download_id' ];

                /* Query the database to get the name of download and the landing page and assign to a variables. */

                $sql = $wpdb->get_row ( $wpdb->prepare ( "SELECT doifd_download_name, doifd_download_landing_page FROM $wpdb->doifd_downloads WHERE doifd_download_id = %s", $doifd_download_id ), ARRAY_A );

                /* This is for the conversion from moving the landing page from general options to each individual upload. Can remove/simplify on 01/2015 */

                if ( $sql[ 'doifd_download_landing_page' ] != '0' ) {

                    $landing_page = $sql[ 'doifd_download_landing_page' ];
                } else {

                    $landing_page = $this->doifd_options[ 'landing_page' ];
                }

                $download_name = $sql[ 'doifd_download_name' ];

                /* The $URL provides the link with the verification number attached to the the url for verification */

                $url = add_query_arg ( 'ver', $value[ 'user_ver' ], get_permalink ( $landing_page ) );

                /* The subject line of the email */

                if ( isset ( $this->doifd_options[ 'email_subject' ] ) ) {

                    $subject = $this->doifd_options[ 'email_subject' ];
                } else {

                    $subject = '';
                }

                if ( ! empty ( $subject ) ) {

                    $updated_subject = str_ireplace ( array( '{download}', '{site_name}' ), array( $download_name, get_bloginfo ( 'name' ) ), $subject );

                    $doifd_lab_subject = $updated_subject;
                } else {

                    $doifd_lab_subject = sprintf ( __ ( 'Your Free Download from %s', $this->plugin_slug ), get_bloginfo ( 'name' ) );
                }

                /* Get the email message from the options table */

                $doifd_lab_message_template = $this->doifd_options[ 'email_message' ];

                /* Replace the {user_name}, {download} and {url} in the email message body with the actual name and URL. */

                $doifd_lab_message = str_ireplace ( array( '{subscriber}', '{url}', '{download}' ), array( $doifd_user_name, $url, $download_name ), $doifd_lab_message_template );

                /* Assign value to email header(s) */

                $wp_doifd_lab_from[ ] = 'From:' . $msg_from_name . '   <' . $msg_from_email . '>';

                /******************************************************
                 * Optional cc headers if you need to use them.
                 * $doifd_lab_headers[] = 'Cc: John Q Codex <jqc@wordpress.org>'; 
                 * $doifd_lab_headers[] = 'Cc: iluvwp@wordpress.org'; // note you can just use a simple email address 
                 * **************************************************************
                 */
                if ( $html == TRUE ) {
                    add_filter ( 'wp_mail_content_type', array( $this, 'set_html_content_type' ) );
                }
                /* Send the email using wp_mail */
                
                $this->sendEmailFunction( $doifd_lab_to, $doifd_lab_subject, $doifd_lab_message, $wp_doifd_lab_from, get_bloginfo ( 'name' ), get_bloginfo ( 'admin_email' ), $type );

                if ( $html == TRUE ) {
                    remove_filter ( 'wp_mail_content_type', array( $this, 'set_html_content_type' ) );
                }

                return TRUE;
            } else {

                return FALSE;
            }
        }

        public function admin_notification( $value ) {
            
            require_once( DOIFD_DIR . '/emails/templates/admin-notification-email.php' );

            global $wpdb;
            
            add_filter ( 'wp_mail_content_type', array( $this, 'set_html_content_type' ) );

            if ( function_exists ( 'is_multisite' ) && is_multisite () ) {
            //checks if it's a multisite
                $doifd_lab_to = get_blog_option ( $current_blog->blog_id, 'admin_email' );

                //in multisite, it returns the network-wide site E-mail
            } else {

                $doifd_lab_to = 'Admin <' . get_bloginfo ( 'admin_email' ) . '>';
            }

            $html = '';
            foreach($value as $key => $item){
                $html.= $key .': ' . $item . '<br />';
            }

            $doifd_lab_admin_subject = apply_filters ( 'doifd_admin_email_subject', '[New Download] @ ' . get_bloginfo ( 'name' ));

            $wp_doifd_lab_from[ ] = 'From:' . get_bloginfo ( 'name' ) . '   <' . get_bloginfo ( 'admin_email' ) . '>';

            $adminEmail = new doifdEmails();
            
            ob_start();
            $doifd_message = $adminEmail->adminEmail($value);
            $doifd_lab_message = ob_get_contents();
            ob_end_clean();

            $this->sendEmailFunction( $doifd_lab_to, $doifd_lab_admin_subject, $doifd_lab_message, $wp_doifd_lab_from, get_bloginfo ( 'name' ), get_bloginfo ( 'admin_email' ), $type="text/html" );
            
            remove_filter ( 'wp_mail_content_type', array( $this, 'set_html_content_type' ) );
        }
        
        public function sendEmailFunction( $doifd_lab_to, $doifd_lab_subject, $doifd_lab_message, $wp_doifd_lab_from, $msg_from_name, $msg_from_email, $type ) {
           
           if( class_exists( 'DOIFD_SendGrid_SendEmail' )) {
               $sg = new DOIFD_SendGrid_SendEmail;
               $sg->sendEmailFunction( $doifd_lab_to, $doifd_lab_subject, $doifd_lab_message, $wp_doifd_lab_from, $msg_from_name, $msg_from_email, $type );
           } else {
            
           wp_mail ( $doifd_lab_to, $doifd_lab_subject, $doifd_lab_message, $wp_doifd_lab_from, $msg_from_name, $msg_from_email );
           
           }
        }

        public function set_html_content_type() {

            $html = "text/html";
            return $html;
        }

    }
new DOIFDEmail();