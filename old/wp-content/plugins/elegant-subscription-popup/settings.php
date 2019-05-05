<?php

class elegant_subscription_form_settings {

    //Holds the values to be used in the fields callbacks
    private $options;

    public function __construct(){

        add_action("admin_menu", array($this,"add_plugin_menu"));
        add_action("admin_init", array($this,"page_init"));

        add_action('admin_enqueue_scripts', array($this, 'register_admin_scripts'));

    }

    public function add_plugin_menu(){

        add_options_page( "Elegant Subscription Popup", //page_title
        "Elegant Subscription Popup", //menu_title
        "administrator", //capability
        "elegant-subscription-form-settings", //menu_slug
        array($this, "create_admin_page")); //callback function

    }

    public function register_admin_scripts(){
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'esp_admin', plugins_url('js/esp_admin.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
        wp_enqueue_style( 'custom-admin-style', plugins_url('css/admin-css.css', __FILE__));

        wp_enqueue_style( 'thickbox' );
        wp_enqueue_script( 'thickbox' );
        wp_enqueue_script( 'media-upload' );
    }

    public function create_admin_page(){

        $this->options = get_option( 'elegant_subscription_form_settings' );

        ?>
        <div class="wrap">

            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">


                    <div id="post-body-content">
                        <div class="meta-box-sortables ui-sortable">
                            <div class="postbox">
                                <h3><span class="dashicons dashicons-admin-generic"></span>Elegant Subscription Popup Settings</h3>
                                <div class="inside">
                                    <form method="post" action="options.php">
                                        <?php
                                        // This prints out all hidden setting fields
                                        settings_fields( 'elegant_subscription_form_settings_group' ); //option group
                                        do_settings_sections( 'elegant-subscription-form-settings' ); //settings page slug
                                        submit_button(); ?>

										<div class="postbox" id="upgradetopro">
                                            <h3><span>Upgrade to Pro</span></h3>
                                            <div class="inside">
                                                <strong>Upgrade to Pro and get the following features</strong>
                                                <ul class="upgrade-to-pro">
													<li> Add other newsletter subscription instead of Feedburner such as <span style="color:blue">MailPoet</span> using shortcode</li>
                                                    <li> WYSIWYG editor to enter your message in the backend with media upload Button</li>
													<li> Optimized for MailPoet newsletter</li>
                                                    <li> Set delay time for the popup</li>
                                                    <li> Change popup content font size and heading font size </li>
													<li> Change popup background color</li>
													<li> Change popup text color</li>
												</ul>
                                                <a href="http://techsini.com/our-wordpress-plugins/elegant-subscription-popup/" target="_blank"><button type="button" class="button button-primary" name="getpro">Get Pro Version Now!</button></a><br>
                                            </div>
                                        </div>


                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> <!--post-body-content-->


                    <!-- sidebar -->
                    <div id="postbox-container-1" class="postbox-container">
                        <div class="meta-box-sortables">

                            <div class="postbox">
                                <h3><span>About</span></h3>
                                <div class="inside">
									<strong>Elegant Subscription Popup (Lite)</strong> <br>
                                    Website: <a href="http://techsini.com" target="_blank">TechSini.com</a> <br>
                                    Thank you for installing this plugin.
                                </div> <!-- .inside -->
                            </div> <!-- .postbox -->

							<div class="postbox">
                                <h3><span>Upgrade to Pro</span></h3>
                                <div class="inside">
                                    <strong>Upgrade to Pro and get the more features just for <span style="font-size:16px">$5</strong></span> <br><br>
                                    <a href="#upgradetopro" class="smoothscroll"><button type="button" class="button button-primary" name="getpro">Why Upgrade to Pro?</button></a><br>
                                </div>
                            </div>

                            <div class="postbox">
                                <h3><span>Losing your Adsense Revenue?</span></h3>
                                <div class="inside">
                                    <p>
                                        Are you losing your AdSense revenue with Ad-blocker browser plugin? Try our all new Simple Adblock Notice PRO wordpress plugin to tackle the Ad-blocker.
                                    </p>
                                    <a href="http://techsini.com/our-wordpress-plugins/simple-adblock-notice/" target="_blank"><button type="button" class="button button-primary">Get Simple Adblock Notice PRO Now</button></a><br>
                                </div>
                            </div>

                            <div class="postbox">
                                   <h3><span>Rate This Plugin!</span></h3>
                                   <div class="inside">
                                     <p>Please <a href="https://wordpress.org/plugins/elegant-subscription-popup/" target="_blank">rate this plugin</a> and share it to help the development.</p>

                                     <ul class="soc">
                                       <li><a class="soc-facebook" href="https://www.facebook.com/techsini" target="_blank"></a></li>
                                       <li><a class="soc-twitter" href="https://twitter.com/techsini" target="_blank"></a></li>
                                       <li><a class="soc-google soc-icon-last" href="https://plus.google.com/+Techsini" target="_blank"></a></li>
                                     </ul>

                                   </div> <!-- .inside -->
                             </div> <!-- .postbox -->

                             <div class="postbox">
                                <h3><span>Follow Us to Get Latest Updates</span></h3>
                                <div class="inside">
                                    <br>
                                    <!-- Facebook like start -->
                                    <div id="fb-root"></div>
                                    <script>(function(d, s, id) {
                                      var js, fjs = d.getElementsByTagName(s)[0];
                                      if (d.getElementById(id)) return;
                                      js = d.createElement(s); js.id = id;
                                      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7&appId=876096245785368";
                                      fjs.parentNode.insertBefore(js, fjs);
                                    }(document, 'script', 'facebook-jssdk'));</script>

                                    <div class="fb-like" data-href="https://www.facebook.com/techsini/" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
                                    <!-- Facebook like end -->

                                    <br><br>

                                    <!-- Twitter follow start -->
                                    <script>window.twttr = (function(d, s, id) {
                                      var js, fjs = d.getElementsByTagName(s)[0],
                                        t = window.twttr || {};
                                      if (d.getElementById(id)) return t;
                                      js = d.createElement(s);
                                      js.id = id;
                                      js.src = "https://platform.twitter.com/widgets.js";
                                      fjs.parentNode.insertBefore(js, fjs);

                                      t._e = [];
                                      t.ready = function(f) {
                                        t._e.push(f);
                                      };

                                      return t;
                                    }(document, "script", "twitter-wjs"));</script>

                                    <a class="twitter-follow-button"
                                      href="https://twitter.com/techsini">
                                    Follow @TechSini</a>
                                    <!-- Twitter follow end -->


                                </div> <!-- .inside -->
                            </div> <!-- .postbox -->

                             <div class="postbox">
                                    <h3><span>Our other WordPress Plugins</span></h3>
                                    <div class="inside">
                                      <ul>
                                         <li><a href="http://techsini.com/our-wordpress-plugins/disable-right-click/">Prevent Content Theft</a></li>
                                         <li><a href="http://techsini.com/our-wordpress-plugins/stylish-notification-popup/">Stylish Notification Popup</a></li>
										 <li><a href="http://techsini.com/our-wordpress-plugins/simple-adblock-notice/">Simple Adblock Notice</a></li>
                                      </ul>
                                    </div> <!-- .inside -->
                                </div> <!-- .postbox -->

                        </div> <!-- .meta-box-sortables -->
                    </div> <!-- #postbox-container-1 .postbox-container -->


                </div>
            </div>
        </div>
        <?php
    }

    public function page_init(){

        register_setting(
        'elegant_subscription_form_settings_group', // Option group
        'elegant_subscription_form_settings' // Option name
    );

    add_settings_section(
    'section_1', // ID
    '', // Title
    array( $this, 'section_1_callback' ), // Callback
    'elegant-subscription-form-settings' // Page
);

add_settings_field(
'feedBurner_id', // ID
'FeedBurner ID', // Title
array( $this, 'feedBurner_id_callback' ), // Callback
'elegant-subscription-form-settings', // Page
'section_1' // Section
);

add_settings_field(
'popup_title', // ID
'Popup Title', // Title
array( $this, 'popup_title_callback' ), // Callback
'elegant-subscription-form-settings', // Page
'section_1' // Section
);

add_settings_field(
'popup_description', // ID
'Popup Description', // Title
array( $this, 'popup_description_callback' ), // Callback
'elegant-subscription-form-settings', // Page
'section_1' // Section
);

add_settings_field(
'popup_logo', // ID
'Popup Logo', // Title
array( $this, 'popup_logo_callback' ), // Callback
'elegant-subscription-form-settings', // Page
'section_1' // Section
);

add_settings_field(
'daysinterval', // ID
'Show Every X Day(s)', // Title
array( $this, 'daysinterval_callback' ), // Callback
'elegant-subscription-form-settings', // Page
'section_1' // Section
);

add_settings_field(
'credittoauthor', // ID
'Wanna Give Credit to Author with a backlink?', // Title
array( $this, 'credittoauthor_callback' ), // Callback
'elegant-subscription-form-settings', // Page
'section_1' // Section
);

}
public function section_1_callback(){

}

public function feedBurner_id_callback(){
    printf('<input type="text" id="feedBurner_id" name="elegant_subscription_form_settings[feedBurner_id]" value="%s" /> (<a href="https://www.youtube.com/watch?v=OttpVCKIBT0" target="_blank">Where is my Feedburner ID?</a>)',  isset( $this->options['feedBurner_id'] ) ? esc_attr( $this->options['feedBurner_id']) : '');
}

public function popup_title_callback(){
    printf('<input type="text" id="popup_title" name="elegant_subscription_form_settings[popup_title]" value="%s" />',  isset( $this->options['popup_title'] ) ? esc_attr( $this->options['popup_title']) : '');
}

public function popup_description_callback(){
    printf('<textarea id="popup_description" rows="4" class="large-text" name="elegant_subscription_form_settings[popup_description]">%s</textarea>',  isset( $this->options['popup_description'] ) ? esc_attr( $this->options['popup_description']) : '');
}

public function popup_logo_callback(){

    if(isset($this->options['popup_logo'])){
        $popuplogo = $this->options['popup_logo'];
    }
    printf('<div id="popuplogo_thumb">');
    if(isset($popuplogo)) { ?>
        <img src="<?php echo $popuplogo?>"  width="65"/>
        <?php
    }

    printf('</div>');
    printf('<input id="popup_logo" type="text" name="elegant_subscription_form_settings[popup_logo]" value="%s" class="wpss_text wpss-file" />',  isset( $this->options['popup_logo'] ) ? esc_attr( $this->options['popup_logo']) : '');
    printf('<input id="popup_logo_submit" type="button" value="Upload Image" class="wpss-filebtn" />');
}

public function daysinterval_callback(){

    $daysinterval = isset( $this->options['daysinterval'] ) ? esc_attr( $this->options['daysinterval']) : '2';

    echo ('<select id="daysinterval" name="elegant_subscription_form_settings[daysinterval]">' .
    '<option value="1" ' . selected($daysinterval, "1", false) . '>1</option>' .
    '<option value="2" ' . selected($daysinterval, "2", false) . '>2</option>' .
    '<option value="5" ' . selected($daysinterval, "5", false) . '>5</option>' .
    '<option value="10" ' . selected($daysinterval, "10", false) . '>10</option>' .
    '</select>'
);
}

public function credittoauthor_callback(){

    if (!isset($this->options['credittoauthor']))
    {
        $this->options['credittoauthor'] = 0;
    }

    echo ('<input type = "checkbox"
    id = "credittoauthor"
    name= "elegant_subscription_form_settings[credittoauthor]"
    value = "1"' . checked(1, $this->options['credittoauthor'], false) . '/>' );
}

}


?>
