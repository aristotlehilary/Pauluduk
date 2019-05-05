<div class="wrap">

    <h2 style="margin-bottom: 25px;">General Settings Page</h2>

    <form id="doifdOptionsForm" action="options.php" method="post">
        <div id="tabs">
            <ul>
                <?php
                $tabs = new DOIFDAdminGeneralOptionsFields();
                $tabs = $tabs->general_settings_tabs ();

                foreach ( $tabs as $href => $name ) {
                    echo '<li><h3><a href="#' . $href . '">' . $name . '</a></h3></li>';
                }

                ?>
            </ul>
            <?php
            $tabs_content = new DOIFDAdminGeneralOptionsFields();
            $tabs_content = $tabs_content->general_settings_content ();

            foreach ( $tabs_content as $tab_id => $content ) {

                echo '<div id="' . $tab_id . '">';

                if ( is_array ( $content ) ) {
                    
                    $array_key = current ( array_keys ( $content ) );

                    foreach ( $content as $key => $value ) {

                        if($value == 'doifd_lab_form_custom_css') {
                            echo '<div class="alert alert-block alert-error">';
                            echo '<p><strong>Warning!</strong> This Custom CSS Feature will be removed on January 1, 2017. Please migrate your Custom CSS to the new Forms section of the plugin, where you can create individual forms for each download.</p>';
                            echo '</div>';
                        }
                        
                        if($value == 'doifd_lab_form_style') {
                            echo '<div class="alert alert-block alert-error">';
                            echo '<p><strong>Warning!</strong> The Default Form Style Settings Feature will be removed on January 1, 2017. Please migrate your custom settings to the new Forms section of the plugin, where you can create individual forms for each download.</p>';
                            echo '</div>';
                        }
                        
                        if($value == 'doifd_lab_form_optional_fields') {
                            echo '<div class="alert alert-block alert-error">';
                            echo '<p><strong>Warning!</strong> The Default Forms Settings Section will be removed on January 1, 2017. Please migrate your Custom Form Settings to the new Forms section of the plugin, where you can create individual forms for each download.</p>';
                            echo '</div>';
                        }

                        if ( in_array ( "doifd_mailchimp", $content, true ) ) {

                            if ( class_exists ( 'DOIFDPremiumAdmin' ) ) {

                                echo '</form>';
                                echo '<form action="options.php" method="post">';
                                settings_fields ( $array_key );
                                do_settings_sections ( $value );
                                echo '<input class="button-primary" name="submit" type="submit" value="' . __ ( 'Save Changes', $this->plugin_slug ) . '">';
                            } else {

                                ?>
                                <div class="premium_promo">
                                    <p><?php _e ( 'The Mailchimp feature is only available<br>in the Premium Version', $this->plugin_slug ); ?></p>
                                    <a href="http://www.doubleoptinfordownload.com/premium-double-opt-in-for-download/" target="new" class="premium_promo_button" ><?php _e ( 'Click Here To Purchase Premium DOIFD', $this->plugin_slug ); ?></a></p>
                                </div>
                                <?php
                            }
                        } elseif ( in_array ( "doifd_constantcontact", $content, true ) ) {

                            if ( class_exists ( 'DOIFDPremiumAdmin' ) ) {

                                echo '</form>';
                                echo '<form action="options.php" method="post">';

                                settings_fields ( $array_key );
                                do_settings_sections ( $value );

                                echo '<input class="button-primary" name="submit" type="submit" value="' . __ ( 'Save Changes', $this->plugin_slug ) . '">';
                            } else {

                                ?>
                                <div class="premium_promo">
                                    <p><?php _e ( 'The Constant Contact feature is only available<br>in the Premium Version', $this->plugin_slug ); ?></p>
                                    <p><a href="http://www.doubleoptinfordownload.com/premium-double-opt-in-for-download/" target="new" class="premium_promo_button" ><?php _e ( 'Click Here To Purchase Premium DOIFD', $this->plugin_slug ); ?></a></p>
                                </div>
                    <?php
                }
            } else {

                if ( in_array ( "doifd_aweber", $content, true ) ) {

                    echo '</form>';
                    echo '<form action="options.php" method="post">';
                    settings_fields ( $array_key );
                    do_settings_sections ( $value );
                    
                                    
                } elseif ( in_array ( "doifd_madmimi", $content, true ) ) {
                        
                    echo '</form>';
                    echo '<form action="options.php" method="post">';
                    settings_fields ( $array_key );
                    do_settings_sections ( $value );
                    echo '<input class="button-primary" name="submit" type="submit" value="' . __ ( 'Save Changes', $this->plugin_slug ) . '">';
                    
                } else {

                    settings_fields ( $array_key );
                    do_settings_sections ( $value );
                    echo '<input class="button-primary" name="submit" type="submit" value="' . __ ( 'Save Changes', $this->plugin_slug ) . '">';
                }
                echo '<hr />';
            }
        }
    } else {

        if ( ! class_exists ( 'DOIFDPremiumAdmin' ) && ( $content == "doifd_lab_captcha" ) ) {

            ?>

                        <div class="premium_promo">
                            <p><?php _e ( 'The Captcha feature is only available<br>in the Premium Version', $this->plugin_slug ); ?></p>
                            <p><a href="http://www.doubleoptinfordownload.com/premium-double-opt-in-for-download/" target="new" class="premium_promo_button" ><?php _e ( 'Click Here To Purchase Premium DOIFD', $this->plugin_slug ); ?></a></p>
                        </div>

            <?php
        } else {
            if( $content == 'doifd_lab_widget_style' ) {
            echo '<div class="alert alert-block alert-error">';
            echo '<p><strong>Warning!</strong> The Default Widget Settings Section will be removed on January 1, 2017. Please migrate your Custom Form Settings to the new Forms section of the plugin, where you can create individual forms for each download.</p>';
            echo '</div>';
            }
            
            settings_fields ( 'doifd_lab_options' );
            do_settings_sections ( $content );
            echo '<input class="button-primary" name="submit" type="submit" value="' . __ ( 'Save Changes', $this->plugin_slug ) . '">';
        }
    }


    echo '</div>';
}

?>

        </div>
    </form>
</div> <!--Wrap End--> 