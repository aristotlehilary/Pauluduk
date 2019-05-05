<?php

    class DOIFDFormWidget extends WP_Widget {
        
        
        function DOIFDFormWidget() {

            $description = __( 'Display DOIFD Signup Form', 'double-opt-in-for-download' );
            $widget_title = __( 'DOIFD Form', 'double-opt-in-for-download' );

            $widget_ops = array (
                'classname' => 'doifd_lab_widget_signup_class',
                'description' => $description
            );
            parent::__construct( 'doifd_lab_widget_signup', $widget_title, $widget_ops );            
        }


        function widget( $args, $instance ) {

            global $wpdb;
            global $widget_download_id;

            // extract widget arguments.
            extract( $args );
            
            // get $instance variables and assign to variables
            $title = apply_filters( 'widget_title', $instance[ 'title' ] );
            $widget_download_id = apply_filters( 'widget_doifd_download_name', $instance[ 'doifd_download_name' ] );
            $header_text = apply_filters( 'widget_doifd_form_text', $instance[ 'doifd_form_text' ] );
            $lab_widget_form_button_text = apply_filters( 'widget_doifd_form_button_text', $instance[ 'doifd_form_button_text' ] );

            if ( empty( $header_text ) || (!isset( $header_text )) ) {
                // header text for widget form show to subscribers if not set by admin
                $header_text = __( 'Please provide your name and email address for your free download.', 'double-opt-in-for-download' );
            }

            // text shown on submit button in the form
            if ( empty( $lab_widget_form_button_text ) || (!isset( $lab_widget_form_button_text )) ) {
                $lab_widget_form_button_text = __( 'Submit', 'double-opt-in-for-download' );
            }

            /*  See if the Admin wants Captcha On or Off for the widget */

            $options = get_option( 'doifd_lab_options' );

            if ( ( class_exists( 'DOIFDPremium') && $options[ 'recaptcha_enable_widget' ] ) == 1 ) {

                $doifd_widget_captcha = TRUE;
            } else {

                $doifd_widget_captcaha = FALSE;
            }

            // label for name text input box
            $subscriber_name = __( 'Name', 'double-opt-in-for-download' );

            // label for email text input box
            $subscriber_email = __( 'Email Address', 'double-opt-in-for-download' );

            //Set promotional link if option is on
            // get options from options table and assign to variable
//            $options = get_option ( 'doifd_lab_options' );
            // see if the admin wants to add the subscriber to the wp user table
            $widget_nonce = wp_create_nonce( 'doifd-subscriber-registration-nonce' );
            
            if ( isset( $options[ 'promo_link' ] ) ) {
                $option = $options[ 'promo_link' ];
            }

            if ( ( isset( $option ) ) && ($option == '1') ) {
                $doifd_promo_link = '<p class="doifd_widget_promo_link"><a href="http://www.doubleoptinfordownload.com" target="new">' . __( 'Powered by', 'double-opt-in-for-download' ) . '<br />' . __( 'DOIFD', 'double-opt-in-for-download' ) . '</a></p>';
            } else {
                $doifd_promo_link = '';
            }
            
            /* See If Privacy Policy is Set */

            if (isset($options['use_privacy_policy'])) {

                $option = $options['use_privacy_policy'];
                $text = $options['privacy_link_text'];
                $link = $options['privacy_page'];
                
            }

            if (( isset($option) ) && ($option == '1')) {

                $doifd_privacy_policy = '<div class="doifd_privacy_link"><a href="'. get_page_link($link). '" target="new" >' . $text . '</a></div>';
            } else {

                $doifd_privacy_policy = '';
            }

            echo $before_widget;

            // get widget title
            if ( !empty( $title ) ) {
                echo $before_title . $title . $after_title;
            }

            // get verification number if it's set
            if ( isset( $_GET[ 'ver' ] ) ) {
                $ver = $_GET[ 'ver' ];
            } else {
                $ver = '';
            }
            
             if ( isset( $_POST[ 'doifd_widget_download_form' ] ) && $_POST['form_source'] == 'widget' ) {
                 
                 if (  class_exists( 'DOIFDPremiumRegistrationProcess' ) ) {
                     
                 $process = new DOIFDPremiumRegistrationProcess( $_POST );
                 $msg = $process->premium_widget_registration_process();
                     
                 } else {
                 
                 $process = new DOIFDRegistrationProcess( $_POST );
                 $msg = $process->widget_registration_process();
                 
                 }
                 
                 } else {
                     
                     $msg = '';
             }
            
            $label = ( (isset( $options['use_widget_form_labels'] )? $options['use_widget_form_labels'] : '') );
            
            $widget_values = apply_filters( 'doifd_widget_setup_values', array (
                    "widget_form_text" => $header_text,
                    "widget_id" => $widget_download_id,
                    "widget_form_id" => $instance[ 'doifd_form_id' ],
                    "widget_nonce" => $widget_nonce,
                    "widget_name" => $subscriber_name,
                    "widget_email" => $subscriber_email,
                    "widget_button_text" => $lab_widget_form_button_text,
                    "widget_privacy" => $doifd_privacy_policy,
                    "widget_promo" => $doifd_promo_link,
                    "widget_className" => ( (isset($options[ 'widget_class' ])? $options[ 'widget_class' ] : '') ),
                    "widget_error" => $msg
                ) );
            
            if ($this->getDownloadInfo( $widget_download_id )) {
                
                if ( class_exists('DOIFDPremiumWidgetRegistrationForm') ) {
                    
                    $form = new DOIFDPremiumWidgetRegistrationForm( $widget_download_id, $widget_values );
                    if (strpos($msg, 'doifd_success_msg') !== false) {
                        echo $msg;
                    } else {
                        $form->render_form();
                    }
                    
                } else {
                
                $form = new DOIFDWidgetRegistrationForm( $widget_download_id, $widget_values );
                    /* if the return message from the registration is a success message, just
                     * show that, other wise show the form.
                     */
                    if (strpos($msg, 'doifd_success_msg') !== false) {
                        echo $msg;
                    } else {
                        $form->render_form();
                    }
                  
                }
            
             } else {
                
                echo '<div class="exceeded"><img src="' . DOIFD_URL . 'public/assets/img/warning.png" alt="Warning" title="Warning" /><br/>The download ID does not exist. <br/><br/>Reselect the download in the admin widget area and save again.</div>';
            }

            echo $after_widget;
            
           
        }

        function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = $new_instance['title'];
            $instance['doifd_form_text'] = $new_instance['doifd_form_text'];
            $instance['doifd_form_button_text'] = $new_instance['doifd_form_button_text'];
            $instance['doifd_download_name'] = $new_instance['doifd_download_name'];
            $instance['doifd_form_id'] = ( ( ! empty( $new_instance['doifd_form_id'] ) ) ? $new_instance['doifd_form_id'] : '0' );

            return $instance;
        }

        function form( $instance ) {

// this function creates the widget form in the admin area

            global $wpdb;

            // get the $instances and assign them to variables.
            if ( isset( $instance[ 'title' ] ) && $instance[ 'doifd_download_name' ] ) {
                $title = esc_attr( $instance[ 'title' ] );
                $dlid = esc_attr( $instance[ 'doifd_download_name' ] );
                $formID = esc_attr( $instance[ 'doifd_form_id' ] );
                $widget_form_text = esc_attr( $instance[ 'doifd_form_text' ] );
                $widget_form_button_text = esc_attr( $instance[ 'doifd_form_button_text' ] );
            } else {
                $title = '';
                $dlid = '';
                $formID = '';
                $widget_form_text = '';
                $widget_form_button_text = '';
            }
            ?>
            <!--Show the Form-->
            <p>
                
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
                </label>
                <label for="<?php echo $this->get_field_id( 'doifd_form_text' ); ?>"><?php _e( 'Form Text:', 'double-opt-in-for-download' ); ?>
                    <textarea class="widefat" rows="3" id="<?php echo $this->get_field_id( 'doifd_form_text' ); ?>" name="<?php echo $this->get_field_name( 'doifd_form_text' ); ?>" type="text"><?php echo $widget_form_text; ?></textarea>
                </label>
                <label for="<?php echo $this->get_field_id( 'doifd_form_button_text' ); ?>"><?php _e( 'Button Text:', 'double-opt-in-for-download' ); ?>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'doifd_form_button_text' ); ?>" name="<?php echo $this->get_field_name( 'doifd_form_button_text' ); ?>" type="text" value="<?php echo $widget_form_button_text; ?>" />
                </label>
                <label for="<?php echo $this->get_field_id( 'Download' ); ?>"><?php _e( 'Select Download:', 'double-opt-in-for-download' ); ?>
                    <select name="<?php echo $this->get_field_name( 'doifd_download_name' ); ?>" id="<?php echo $this->get_field_id( 'doifd_download_id' ); ?>" class="widefat">
                        <!--Get list of Downloads and populate drop down select in form-->
                        <?php
                        $sql = "SELECT * FROM " . $wpdb->prefix . "doifd_lab_downloads ";
                        $downloads = $wpdb->get_results( $sql );
                        foreach ( $downloads as $download ) {
                            echo '<option value="' . $download->doifd_download_id . '"' . ( ( $dlid == $download->doifd_download_id ) ? 'selected="selected"' : "" ) . '">' . $download->doifd_download_name . '</option>';
                        }
                        ?> 
                    </select>
                </label>
                <label for="<?php echo $this->get_field_id( 'doifd_download_form' ); ?>"><?php _e( 'Select Form:', 'double-opt-in-for-download' ); ?>
                    <select name="<?php echo $this->get_field_name( 'doifd_form_id' ); ?>" id="<?php echo $this->get_field_id( 'doifd_form_id' ); ?>" class="widefat">
                        <!--Get list of Downloads and populate drop down select in form-->
                        <?php
                        $sql2 = "SELECT * FROM " . $wpdb->prefix . "doifd_lab_forms";
                        $forms = $wpdb->get_results( $sql2 );
                            echo '<option value="0"' . ( ( $formID == $form->doifd_form_id ) ? 'selected="selected"' : "" ) . '">Use Legacy Form</option>';
                        foreach ( $forms as $form ) {
                            echo '<option value="' . $form->doifd_form_id . '"' . ( ( $formID == $form->doifd_form_id ) ? 'selected="selected"' : "" ) . '">' . $form->doifd_name . '</option>';
                        }
                        ?> 
                    </select>
            </p>
            <?php
        }
        
        public function getDownloadInfo( $dfdValue ) {
            global $wpdb;

            $sql = $wpdb->prepare( "SELECT
                doifd_download_name,
                doifd_download_file_name,
                doifd_download_form
                FROM
                {$wpdb->prefix}doifd_lab_downloads WHERE doifd_download_id = %s", $dfdValue );

            $this->data = $wpdb->get_row( $sql, ARRAY_A );
            
            return $this->data;
        }
        
        public function getDownloadFormInfo($id) {
            global $wpdb;
            
            $sql = $wpdb->prepare( "SELECT
                doifd_download_form
                FROM
                {$wpdb->prefix}doifd_lab_forms WHERE doifd_form_id = %s", $id );
 
            /* WFI = Widget Form Info */
            $this->WFD = unserialize(base64_decode($wpdb->get_var( $sql )));
            
            return $this->WFD;
        }

    }
new DOIFDFormWidget();