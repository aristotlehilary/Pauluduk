<?php

class DOIFDLandingPage extends DOIFD {

    protected $errorMessages = array( );
    protected $validVer = true;
    protected $verification = '';
    protected $data = array( );
    protected $attr;
    protected $content;
    protected $buttonText = NULL;
    protected $fileExists = true;

    public function __construct( $attr = array( ), $content = array( ) ) {
        parent::__construct();

        
        $this->verification = $this->getVerification();
        $this->data = $this->getUserData();
        $this->fileExists = $this->file_exists();
        $this->attr = $attr;
        $this->content = $content;
        $this->buttonText = $this->getButtonText();
        
    }

    public function getVerification() {
        $this->verification = sanitize_key( $_GET[ 'ver' ] );
        return $this->verification;
    }

    public function getAttr() {
        if( isset( $attr ) ) {
            $this->attr = $attr;
        } else {
            $this->attr = '';
        }
        return $this->attr;
    }

    public function getContent() {
        if( isset( $content ) ) {
            $this->content = $content;
        } else {
            $this->content = '';
        }
        return $this->content;
    }

    public function getValidVer() {
        return $this->validVer;
    }

    public function getErrors() {
        return '<div class="exceeded"><img src="' . DOIFD_URL . 'public/assets/img/warning.png" alt="Warning" title="Warning" /><br />' . $this->errorMessages . '</div>';
    }

    public function getButtonText() {

        if( !empty( $this->attr[ 'button_text' ] ) ) {
            $this->buttonText = $this->attr[ 'button_text' ];
        } else {
            $this->buttonText = __( 'Click Here For Your Free Download', $this->plugin_slug );
        }
        return $this->buttonText;
    }

    public function getUserData() {

        global $wpdb;

        $sql =  $wpdb->prepare( "SELECT * 
                FROM {$wpdb->prefix}doifd_lab_subscribers
                INNER JOIN {$wpdb->prefix}doifd_lab_downloads
                ON {$wpdb->prefix}doifd_lab_downloads.doifd_download_id = {$wpdb->prefix}doifd_lab_subscribers.doifd_download_id
                WHERE doifd_verification_number = %s", $this->verification );

        $this->data = $wpdb->get_row( $sql, ARRAY_A );

        return $this->data;
    }

    public function renderButton() {
        
        if( $this->data[ 'doifd_download_type' ] == '1' ) {
            
            $this->button = '<h3>Thank you for confirming your email address</h3>';
            
        } else {
            
        $this->button = '<div class="thankyou">
                        <br /><form method="get" action="" enctype="multipart/form-data">
                        <input type="hidden" name="download_id" value="' . $this->data[ 'doifd_download_id' ] . '">
                        <input type="hidden" name="ver" value="' . $this->verification . '">
                        <input name="doifd_get_download" type="submit" value="' . $this->buttonText . '">
                        </form>
                        </div>';
        }
        return $this->button;
    }

    public function file_exists() {

        $upload_dir = wp_upload_dir();
        $file = $upload_dir[ 'basedir' ] . '/doifd_downloads/' . $this->data[ 'doifd_download_file_name' ];

        if( ( $this->data[ 'doifd_download_type' ] == '0' ) && !file_exists( $file ) ) {
            $this->fileExists = false;
        } else {
            $this->fileExists = true;
        }
        return $this->fileExists;
    }

    public function update_user() {

        global $wpdb;

        $wpdb->update(
                $wpdb->prefix . 'doifd_lab_subscribers', array(
            'doifd_email_verified' => '1',
                ), array( 'doifd_subscriber_id' => $this->data[ 'doifd_subscriber_id' ] ), array(
            '%d'
                ), array( '%d' )
        );
    }

    public function notify_admin() {

        if( $this->doifd_options[ 'notification_email' ] == '1'  &&  $this->data[ 'doifd_email_verified' ] == '0' ) {

              $notifyValues =  array(
                        "Name" => $this->data[ 'doifd_name' ],
                        "Product" => $this->data[ 'doifd_download_name' ],
                        "Email" => $this->data[ 'doifd_email' ],
                        );
                        
                $notify_admin = new DoifdEmail();
                $notify_admin->admin_notification( $notifyValues );
            }
    }

    public function verify_email() {

        global $wpdb;

        /* Check for the verification number */
        if( empty( $this->verification ) ) {
            $this->errorMessages = __( 'Not a valid verification number.', $this->plugin_slug );
        }

        /* See if the verification number is valid */
        if( empty( $this->data ) ) {

            $this->errorMessages = __( 'Not a valid verification number.', $this->plugin_slug );
        }

        /* See if the file really exists on the server */
        if( $this->fileExists == false ) {

            $this->errorMessages = __( 'The download does not exist', $this->plugin_slug );
        }

        /* See if the user has exceeded the download limit */
        if( ( $this->data[ 'doifd_email_verified' ] == '1' ) && ( $this->data[ 'doifd_downloads_allowed' ] >= $this->doifd_options[ 'downloads_allowed' ] ) ) {

            $this->errorMessages = __( 'You have exceeded the maximum number of', $this->plugin_slug ) . '<br />' . __( 'downloads for this item.', $this->plugin_slug );
        }

        /* Set validVer to false if any errors were generated */
        if( !empty( $this->errorMessages ) ) {
            $this->validVer = false;
        }
    }
    
        public function add_wp_users_db() {

            global $wpdb;

            $duplicate_email = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}doifd_lab_subscribers WHERE doifd_email = %s AND doifd_download_id = %d", $this->data[ 'doifd_email' ], $this->data[ 'doifd_subscriber_id' ] ), ARRAY_A );
            /* If yes, lets add the user if not, we will just go on our merry way. */

            if( ( $this->doifd_options[ 'add_to_wpusers' ] == '1' ) && ($duplicate_email == NULL ) && !email_exists( $this->data[ 'doifd_email' ] ) ) {

                /* Generate a random password for the new user */

                $random_password = wp_generate_password( $length = 12, $include_standard_special_chars = false );

                /* Insert into wp user table and get user id for meta information */

                $user_id = wp_create_user( $this->data[ 'doifd_email' ], $random_password, $this->data[ 'doifd_email' ] );

                /* Just for fun lets explode the subscriber name. in case they entered their first and last name */

                $name = explode( ' ', $this->data[ 'doifd_name' ] );

                /* Add first name to user meta table */

                update_user_meta( $user_id, 'first_name', $name[ 0 ] );

                /* If subcriber entered 2 names lets add the second as the last name */

                if( !empty( $name[ 1 ] ) ) {

                    update_user_meta( $user_id, 'last_name', $name[ 1 ] );
                }
                
                if ($this->doifd_options[ 'sendUserEmail' ] == '1') {
                
                wp_new_user_notification( $user_id, $deprecated = null, $notify = 'both' );
                
                } 

            }
        }

}