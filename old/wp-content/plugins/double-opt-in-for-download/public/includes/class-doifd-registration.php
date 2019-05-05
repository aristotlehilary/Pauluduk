<?php

if( !class_exists( 'DOIFDRegistrationProcess' ) ) {

    class DOIFDRegistrationProcess extends DOIFD {

        protected $data = array();
        protected $ver;
        protected $download_id;

        public function __construct( $params ) {
            parent::__construct();

            if( empty( $params ) || !is_array( $params ) ) {
                throw new Exception( "Invalid data!" );
            }

            $this->data = $params;
            $this->ver = $this->ver();
            $this->download_id = $this->download_id();
        }

        public function ver() {

            $this->ver = sha1( time() );
            return $this->ver;
        }

        public function download_id() {
            if( isset( $this->data[ 'download_id' ] ) ) {
                $this->download_id = $this->data[ 'download_id' ];
            } elseif( isset( $this->data[ 'widget_download_id' ] ) ) {
                $this->download_id = $this->data[ 'widget_download_id' ];
            } else {
                $this->download_id = '';
            }
            return $this->download_id;
        }

        public function widget_registration_process() {

            if( isset( $_POST[ 'doifd_widget_download_form' ] ) ) {

                global $wpdb;

                if( $this->doifd_options[ 'form_security' ] == '0' ) {

                    if( !wp_verify_nonce( $_POST[ 'widget_wpnonce' ], 'doifd-subscriber-registration-nonce' ) ) wp_die( 'Security check' );
                }

                $html = '';
                $errors = array();
                $validatorObj = new DOIFDValidation( $_POST );
                $validatorObj->validate();

                if( $validatorObj->getIsValid() ) {
                    $value = $validatorObj->getCleanUploadData();
                    $this->add_to_db( $value );
                    $this->send_email( $value );
                    $html .= $this->doifd_form_success_msg();

                } else {

                    $errors = $validatorObj->getErrors();
                    foreach ( $errors as $value ) {
                        $html .= '<div class="doifd_error_msg">' . $value . '</div>';
                    }
                    
                }
                return $html;
            }
        }

        public function registration_process() {

            if( isset( $this->data[ 'doifd_download_form' ] ) ) {

                global $wpdb;

                if( isset( $this->doifd_options[ 'form_security' ] ) && $this->doifd_options[ 'form_security' ] == '0' ) {

                    if( !wp_verify_nonce( $_POST[ '_wpnonce' ], 'doifd-subscriber-registration-nonce' ) ) wp_die( 'Security check' );
                }

                $html = '';
                $errors = array();
                $validatorObj = new DOIFDValidation( $this->data );
                $validatorObj->validate();

                if( $validatorObj->getIsValid() ) {
                    $value = $validatorObj->getCleanUploadData();
                    $this->add_to_db( $value );
                    $this->send_email( $value );
                    $html .= $this->doifd_form_success_msg();
                        
                } else {

                    $errors = $validatorObj->getErrors();
                    foreach ( $errors as $value ) {
                        $html .= '<div class="doifd_error_msg">' . $value . '</div>';
                    }
                    
                }
                return $html;
            }
        }

        public function doifd_form_success_msg() {

            global $wpdb;

            $type = $wpdb->get_var( $wpdb->prepare( "SELECT doifd_download_type FROM {$wpdb->prefix}doifd_lab_downloads WHERE doifd_download_id = %d", $this->download_id ) );

            if( $type === '1' ) {

                $msg = '<div class="doifd_success_msg"><h4>' . __( 'Thank You for Registering!', $this->plugin_slug ) . '<br />' . __( 'Please check your email to confirm your subscription.', $this->plugin_slug ) . '</h4><br /><i>' . __( 'Don\'t forget to check your junk or spam folder.', $this->plugin_slug ) . '</i></div>';
            } else {

                $msg = '<div class="doifd_success_msg"><h4>' . __( 'Thank You for Registering!', $this->plugin_slug ) . '<br />' . __( 'Please check your email for your link to your Free download.', $this->plugin_slug ) . '</h4><br /><i>' . __( 'Don\'t forget to check your junk or spam folder.', $this->plugin_slug ) . '</i></div>';
            }

            return $msg;
        }

        public function add_to_db( $values ) {

            global $wpdb;

            /* Get user IP address */

             $ip = sanitize_text_field( $_SERVER['REMOTE_ADDR']);
             
            /* Insert subscriber into the database */

            $data = apply_filters( 'doifd_insert_subscriber_data', $data = array(
            'doifd_name' => $values[ 'user_name' ],
            'doifd_email' => $values[ 'user_email' ],
            'doifd_verification_number' => $this->ver,
            'doifd_download_id' => $values[ 'id' ],
            'doifd_subscriber_ip' => $ip,
            'time' => current_time( 'mysql', 0 )
            ), $values, $this->ver );
            $format = apply_filters( 'doifd_insert_subscriber_format', $format = array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
                    ) );

            $wpdb->insert( $wpdb->prefix . 'doifd_lab_subscribers', $data, $format );
        }

        public function send_email( $values ) {

            if( has_filter( 'doifd_alt_verification_email' ) ) {

                $send = apply_filters( 'doifd_alt_verification_email', $value = array(
                    "user_name" => $values[ 'user_name' ],
                    "user_email" => $values[ 'user_email' ],
                    "user_ver" => $this->ver,
                    "download_id" => $values[ 'id' ] ) );
            } else {

                $send_ver_email = new DOIFDEmail();
                $send_ver_email->send_verification_email( $value = array(
                    "user_name" => $values[ 'user_name' ],
                    "user_email" => $values[ 'user_email' ],
                    "user_ver" => $this->ver,
                    "download_id" => $values[ 'id' ] ) );
            }
        }

    }

}
//new DOIFDRegistrationProcess();