<?php

/*
  Plugin Name: Elegant Subscription Popup
  Plugin URI: http://techsini.com
  Description: Elegant subscription popup plugin shows an animated feedburner form when site gets loaded. It doesn't annoy the visitor to subscribe repeatedly instead it shows the feedburner subscription form with the interval of days set by admin.
  Version: 1.7.3
  Author: Shrinivas Naik
  Author URI: http://techsini.com
  License: GPL V3
 */


/*
Copyright (C) 2016 Shrinivas Naik

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see http://www.gnu.org/licenses/.

*/


if(!class_exists('elegant_subscription_form') && !class_exists('elegant_subscription_form_settings')){

    class elegant_subscription_form{

        private $options;

        public function __construct(){

            //Activate the plugin for first time
            register_activation_hook(__FILE__, array($this, "activate"));

            //Initialize settings page
            require_once(plugin_dir_path(__file__) . "settings.php");
            $elegant_subscription_form_settings = new elegant_subscription_form_settings();

            //Load scipts and styles
            add_action('wp_enqueue_scripts', array($this, 'register_scripts'));
		    add_action('wp_enqueue_scripts', array($this, 'register_styles'));

            //Run the plugin in footer
            add_action('wp_footer', array($this, 'run_plugin'));

            //Store options in a variable
            $this->options = get_option( 'elegant_subscription_form_settings' );

            //Set elegant subscription popup cookie as required
            add_action( 'init', array($this,'set_elegant_popup_cookie'));

            //plugin action links
            add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array($this, 'my_plugin_action_links'));

            //Show activation notice
            add_action('admin_notices', array($this, 'esp_activation_notice'));
        }


        public function activate(){

            //Set default options for the plugin
            $initial_settings = array(
                'feedBurner_id' => '' ,
                'popup_title'   => 'Subscribe For Latest Updates',
                'popup_description' => 'Signup for our newsletter and get notified when we publish new articles for free!',
                'daysinterval'  => '2',
                'credittoauthor'=> '0'
                );
            add_option("elegant_subscription_form_settings", $initial_settings);

            /* Create transient data */
            set_transient('esp-admin-notice', true, 10);

        }

        public function deactivate(){

        }

        public function register_scripts(){
            wp_enqueue_script('jquery');
            wp_enqueue_script('espjs', plugins_url( 'js/esp.js' , __FILE__ ),array( 'jquery' ));
        }

        public function register_styles(){
            wp_enqueue_style( 'ElegantSubscriptionFormStyle', plugins_url('css/style.css', __FILE__) );
            wp_enqueue_style( 'AnimateCSS', plugins_url('css/animate.css', __FILE__) );
        }

        public function run_plugin() {

            $feedburnerid = $this->options['feedBurner_id'];
            $credit = $this->options['credittoauthor'];
            @$popup_title = $this->options['popup_title'];
            @$popup_description = $this->options['popup_description'];
            @$popup_logo = $this->options['popup_logo'];

            if($this->can_show_popup() == TRUE && !empty($feedburnerid)) {

            ?>
                <style>
                    .mb_elegantModalclose {
                        background-image:url(<?php echo plugins_url('images/close.png', __FILE__ )?>);
                    }
                </style>

                <div id="openModal" class="mb_elegantModal">
	               <div class="animated">
                        <a title="Close" class="mb_elegantModalclose"></a>

                        <?php
                        if(!empty($popup_logo)){
                            ?>
                                <div class="esp-logo">
                                <img src="<?php echo $popup_logo; ?>" alt="" />
                                </div>
                            <?php
                        }
                        ?>
                        <h2><?php echo $popup_title; ?></h2>
                        <p><?php echo $popup_description; ?></p>
                        <br><br>
                        <form target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $feedburnerid ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true" method="post" action="http://feedburner.google.com/fb/a/mailverify">
                            <input type="hidden" value="<?php echo $feedburnerid?>" name="uri">
                            <input type="hidden" value="en_US" name="loc">
                            <input id="esp_email" type="email" name="email" value="" required/>
                        <br>
                        <button class="mb_elegantpopupbutton">SUBSCRIBE NOW</button>
                        </form>
                        <?php
                            if($credit == "1"){

                                //Backlink has been removed (commented out) in the version 1.7.3
                                //as it may create unnatural backlinks to our website

                                //echo "<br><a href='http://techsini.com' target='_blank'>By TECHSINI</a>";
                            }
                        ?>
	               </div>
                </div>

                <script>
                    jQuery(document).ready(function() {

                        jQuery(".mb_elegantModal").delay(5000).fadeIn("slow", function() {
                            jQuery("div", this).fadeIn("slow");
                            jQuery("div", this).addClass("swing");

                            var txt = "Enter Your Email ID Here..";
                            var timeOut;
                            var txtLen = txt.length;
                            var char = 0;
                            jQuery("[name='email']").attr('placeholder', '|');
                            setTimeout(function() {

                            (function typeIt() {
                                var humanize = Math.round(Math.random() * (200 - 30)) + 30;
                                timeOut = setTimeout(function() {
                                  char++;
                                  var type = txt.substring(0, char);
                                  jQuery("[name='email']").attr('placeholder', type + '|');
                                  typeIt();

                                  if (char == txtLen) {
                                    jQuery("[name='email']").attr('placeholder', jQuery("[name='email']").attr('placeholder').slice(0, -1)) // remove the '|'
                                    clearTimeout(timeOut);
                                  }
                                }, humanize);
                            }());

                          },1200);

                        });

                    });
                </script>
            <?php
            }
	    }

        public function can_show_popup(){

            $siteurl = htmlspecialchars($this->url_to_domain(get_bloginfo('url')));
            if (strpos($siteurl, '.') !== FALSE){
                $arr = explode(".", $siteurl, 2);
                $sitename = $arr[0];
            } else {
                $sitename = $siteurl;
            }
            $cookiename = 'elegant_subscription_form_cookie_'.$sitename;
            if(!isset($_COOKIE[$cookiename])){
                //Show the popup
                return true;
            } else {
                //Do not show the popup
                return false;
            }
        }

        public function set_elegant_popup_cookie(){

            //$feedburnerid = $this->options['feedBurner_id'];
            $siteurl = htmlspecialchars($this->url_to_domain(get_bloginfo('url')));
            if (strpos($siteurl, '.') !== FALSE){
                $arr = explode(".", $siteurl, 2);
                $sitename = $arr[0];
            } else {
                $sitename = $siteurl;
            }
            $cookiename = 'elegant_subscription_form_cookie_'.$sitename;
            if(!isset($_COOKIE[$cookiename]) && ! is_admin()){
                $daysinterval = $this->options['daysinterval'];
                setcookie($cookiename, "shown", time()+ (86400 * $daysinterval) , COOKIEPATH, COOKIE_DOMAIN, false);
            }
        }

		function url_to_domain($url)
        {
            $host = @parse_url($url, PHP_URL_HOST);
            // If the URL can't be parsed, use the original URL
            // Change to "return false" if you don't want that
            if (!$host)
                $host = $url;
            // The "www." prefix isn't really needed if you're just using
            // this to display the domain to the user
            if (substr($host, 0, 4) == "www.")
                $host = substr($host, 4);
            // You might also want to limit the length if screen space is limited
            if (strlen($host) > 50)
                $host = substr($host, 0, 47) . '...';
            return $host;
        }

        function my_plugin_action_links( $links ) {
           $links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=elegant-subscription-form-settings') ) .'">Settings</a>';
           $links[] = '<br><b><a class="more-plugins" href="http://techsini.com" target="_blank">Check Out More Plugins >></a></b>';
           return $links;
        }

        public function esp_activation_notice(){
        /* Check transient, if available display notice */
        if( get_transient( 'esp-admin-notice' ) ){

            $plugin_data = get_plugin_data( __FILE__ );
            $plugin_name = $plugin_data['Name'];
            ?>
                <div class="notice notice-success is-dismissible">
                    <p>Thank you for installing <?php echo $plugin_name; ?> Lite Plugin! <strong>Upgrade to <?php echo $plugin_name; ?> PRO version and get the following features</strong></p>
                        <ul>
                            <li>* Add other newsletter subscription instead of Feedburner such as MailPoet using shortcode</li>
                            <li>* WYSIWYG editor to enter your message in the backend with media upload Button</li>
                            <li>* Delayed popup option</li>
                            <li>* Change popup content and heading font size</li>
                            <li>* Change popup background color</li>
                            <li>* Change popup text color</li>
                            <li>* Change popup width</li>
                            <li>* Optimized for MailPoet newsletter</li>
                        </ul>
                        <p>
                        <a href="http://techsini.com/our-wordpress-plugins/elegant-subscription-popup" target="_blank"><input class="button-primary" type="button" value="Get the PRO Version Now!"></a>
                        </p>
                </div>
                <?php
                /* Delete transient, only display this notice once. */
                delete_transient( 'esp-admin-notice' );
            }
        }

    } //class

}//if

$elegant_subscription_form = new elegant_subscription_form();

?>
