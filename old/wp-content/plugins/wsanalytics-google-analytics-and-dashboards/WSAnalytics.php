<?php
/*
* Plugin Name: WSAnalytics - Google Analytics And Dashboards
* Plugin URI: http://wsofi.com/
* Description: Google API Based plugin for Google Analytics implementation, Creates Dashboards inside admin area, Does Installation of Google Analytics and more. You can share with your team, authors, and with your sales team with all or limited control.
* Version: 1.1.2
* Author: WSofi
* Author URI: http://wsofi.com/
* License: GPLv2+
* Text Domain: WSAnalytics
* Min WP Version: 3.0.1
* Max WP Version: 4.1
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

ini_set( 'include_path', dirname(__FILE__) . '/lib/' );

if ( !class_exists( 'WS_Analytics' ) ) {

    if ( !class_exists( 'Analytics_normal' ) ){
            
        require_once WP_PLUGIN_DIR .'/wsanalytics-google-analytics-and-dashboards/WSAnalytics-general.php';
    }

class WS_Analytics extends Analytics_normal{

    public $token  = false;
    public $client = null;

    // Constructor
    function __construct() {
        
        parent::__construct();
        
        if ( !class_exists( 'WSAnalytics_Google_Client' ) ) {

            require_once WSAnalytics_LIB_PATH . 'Google/Client.php';
            require_once WSAnalytics_LIB_PATH . 'Google/Service/Analytics.php';
        }

        add_action( 'plugin_action_links', array( 
                    $this,
                    'ws_plugin_links'
                ),10,2);

        add_action( 'plugin_row_meta', array( 
                    $this,
                    'wsanalytics_plugin_row_meta'
                ),10,2);

        add_action( 'admin_enqueue_scripts', array( 
                    $this,
                    'ws_scripts'
                ));
        add_action( 'admin_enqueue_scripts', array( 
                    $this,
                    'ws_styles'
                ));
    
        
        add_action( 'wp_enqueue_scripts', array( 
                    $this,
                    'ws_front_scripts'
                ));
        add_action( 'wp_enqueue_scripts', array( 
                    $this,
                    'ws_front_styles'
                ));
    
        add_action( 'admin_menu', array(
                    $this,
                    'wpws_add_menu'
                ));

        // Insert Google Analytics Code
        if( get_option( 'wsanalytics_code') == 1  ) {

            add_action( 'wp_head', array(
                    $this,
                    'wsanalytics_add_analytics_code'
                ));
        }

        add_action( 'wp_ajax_nopriv_get_ajax_single_admin_analytics', array(
                    $this,
                    'get_ajax_single_admin_analytics'
                ));

        add_action( 'wp_ajax_get_ajax_single_admin_analytics', array(
                    $this,
                    'get_ajax_single_admin_analytics'
                ));
				
				
		 add_action ( 'wp_ajax_ws_get_online_data', array (
                    $this,
                    'ws_realtime_data_get'
                ));

        add_action( 'wp_ajax_get_ajax_secret_keys', array(
                    $this,
                    'get_ajax_secret_keys'
                ));

        if( get_option( 'WSAnalytics_disable_front') == 0 ) {

            add_filter( 'the_content', array(
                        $this,
                        'get_single_front_analytics'
            ));        
        }

        /* 
         * load Analytics under the EDIT POST Screen
         * add action runs only for admin section and load metabox.
        */

        if ( is_admin() ) {
            add_action( 'load-post.php', array(
                        $this,
                        'load_metaboxes'
                    ));
        }

        // Show welcome message when user activate plugin.
        if ( get_option( 'ws_welcome_message' ) == 0 ) {
                
            add_action( 'admin_print_footer_scripts', array( 
                        $this, 
                        'ws_welcome_message' 
                       ) );
        }    

        
        register_activation_hook( __FILE__,   array( $this, 'install' ) );
        register_deactivation_hook( __FILE__, array( $this, 'uninstall' ) );
    }


    /*
     * Show analytics sections under the posts/pages in the metabox.
     */

    function load_metaboxes() {

        add_action( 'add_meta_boxes', array(
                    $this,
                    'show_admin_single_analytics_add_metabox'
        ));
    }

    /* 
     * Show metabox under each Post type to display Analytics of single post/page in wp-admin
     */
    public function show_admin_single_analytics_add_metabox() {

        $post_types = get_option( 'WSAnalytics_posts_stats' );

        foreach ( $post_types as $post_type ) {
                
            add_meta_box('pa-single-admin-analytics', // $id
                    'WSAnalytics: Google Analytics of this page.', // $title
                    array(
                        'WS_Analytics',
                        'show_admin_single_analytics'
                    ), // $callback
                    
                    $post_type, // $posts
                    'normal',   // $context
                    'high'      // $priority
                ); 
        } //$post_types as $post_type
    }


    public static function get_ajax_secret_keys(){

        $response = wp_remote_get( "http://www.wsofi.com/creds/creds.json" );
        if( is_wp_error( $response ) ) {
           $error_message = $response->get_error_message();
           echo "Something went wrong: $error_message";
        } else {
           print_r($response['body']);
        }
        die();
    }

    /* 
     * Show Analytics of single post/page in wp-admin under EDIT screen.
     */
    public static function show_admin_single_analytics() {

        global $post;

        $back_exclude_posts = explode( ',', get_option( 'post_analytics_exclude_posts_back' ));

        if ( is_array( $back_exclude_posts ) ) {
                        
            if ( in_array( $post->ID, $back_exclude_posts ) ) {
                            
                _e('This post is excluded and will not show Analytics.');
                            
                return;
            }
        }
            
        $urlPost = '';
        $wp_WSAnalytics  = new WS_Analytics();
        $urlPost = parse_url( get_permalink( $post->ID ) );
        $start_date = ''; $end_date = ''; $urlpost = '' ;
        $is_access_level = get_option( 'post_analytics_access_back' );
            
        if( $wp_WSAnalytics->ws_check_roles( $is_access_level ) ){ ?>

            <div class="pa-filter">
                <table cellspacing="0" cellpadding="0" width="400">
                    <tbody>
                        <tr>
                            <td width="0">
                                <input type="text" id="start_date" name="start_date">
                            </td>
                            <td width="0">
                                <input type="text" id="end_date" name="end_date">
                            </td>
                                <input type="hidden" name="urlpost" id="urlpost" value="<?php echo $urlPost['path']; ?>">
                            <td width="0">
                                <input type="button" id="view_analytics" name="view_analytics" value="View Analytics" class="button-primary btn-green">
                            </td>
                       </tr>
                    </tbody>
                </table>
            </div>
            <div class="loading" style="display:none">
                <img src="<?php echo plugins_url('images/loading.gif', __FILE__);?>">
            </div>
            <div class="show-hide">
                    <?php $wp_WSAnalytics->get_single_admin_analytics( $start_date, $end_date, $post->ID, 0 ); ?>
            </div>
            <?php
        }
        else{
            echo _e( 'You are not allowed to see stats', 'wp-WSAnalytics' );
        }
    }

    // Add Google Analytics JS code
    public function wsanalytics_add_analytics_code() {
   
        global $current_user;

        $roles = $current_user->roles;

        if ( isset( $roles[0] ) and in_array( $roles[0], get_option( 'display_tracking_code' ) )) {

        }
        else{

             echo '<!-- This site uses the Google Analytics by WSAnalytics  v - ' . WSAnalytics_VERSION . '  http://WSofi.com !-->';

            if ( get_option( 'WSAnalytics_tracking_code' ) == 'universal' ) { ?>

                <script>
                      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
                      ga('create', '<?php echo get_option( "webPropertyId" );?>', 'auto');
					  <?php if ( get_option( 'display_demographic_code' ) == 1  ) {
					$str =<<<HereDOC
					ga('require', 'displayfeatures');
HereDOC;
echo $str;
					} ?>
					ga('send', 'pageview');	
					  </script>

            <?php 
            }

            if ( get_option( 'WSAnalytics_tracking_code' ) == 'ga' ) { ?>
                
                <script type="text/javascript">//<![CDATA[
                    var _gaq = _gaq || [];
                    _gaq.push(['_setAccount', '<?php echo get_option( "webPropertyId" );?>']);
					
                    _gaq.push(['_trackPageview']);
                    (function () {
                        var ga = document.createElement('script');
                        ga.type = 'text/javascript';
                        ga.async = true;
						<?php if ( get_option( 'display_demographic_code' ) == 1  ) {
					$str =<<<HereDOC
					ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
HereDOC;
echo $str;
					} else{
					$str =<<<HereDOC
					
					ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
HereDOC;
echo $str;
					}
					?>
                        				
                        var s = document.getElementsByTagName('script')[0];
                        s.parentNode.insertBefore(ga, s);
					
                    })();
                    //]]>
                </script>

            <?php
            }

            echo '<!-- This site uses the Google Analytics by WSAnalytics  v - ' . WSAnalytics_VERSION . '  http://WSofi.com !-->';
			
        }
    }

    /**
    * Add a link to the settings page to the plugins list
    */
    public function ws_plugin_links( $links, $file ) {

            static $this_plugin;
            
            if ( empty( $this_plugin ) ){ 
                
                $this_plugin = 'wp-WSAnalytics/wp-WSAnalytics.php';
            }

            if ( $file == $this_plugin ) {
                
                $settings_link = '<a href="' . admin_url("admin.php?page=WSAnalytics-settings") . '">' . __( 'Settings', 'wp-WSAnalytics' ) . '</a> | <a href="' . admin_url("admin.php?page=WSAnalytics-dashboard") . '">' . __( 'Dashboard', 'wp-WSAnalytics' ) . '</a>';
                array_unshift( $links, $settings_link );
            }
            
            return $links;
    }

    /**
     * Plugin row meta links
     *
     * @since 0.1
     * @param array $input already defined meta links
     * @param string $file plugin file path and name being processed
     * @return array $input
     */
    function wsanalytics_plugin_row_meta( $input, $file ) {
        if ( $file != 'wp-WSAnalytics/wp-WSAnalytics.php' )
            return $input;

        $links = array(
            '<a href="http://WSofi.com/">' . esc_html__( 'Does nothing ', 'edd' ) . '</a>',
            '<a href="http://WSofi.com/">' . esc_html__( 'Does nothing', 'edd' ) . '</a>',
        );

        $input = array_merge( $input, $links );

        return $input;
    }


    /**
     * Warning Display if profiles are not selected.
     */
    public function ws_check_warnings(){
            
        add_action( 'admin_footer', array( 
                    &$this, 
                    'profile_warning' 
                ));
    }

    /**
     * Getting current screen details
     */
    public static function ws_page_file_path() {
    
        $screen = get_current_screen();

        if ( strpos( $screen->base, 'WSAnalytics-settings' ) !== false ) {
            include( WSAnalytics_ROOT_PATH . '/inc/WSAnalytics-settings.php' );
        } 
        else {
            include( WSAnalytics_ROOT_PATH . '/inc/WSAnalytics-dashboard.php' );
        }
    }

    /**
     * Loading style sheets for the plugin + Welcome pointer
     */
    public function ws_styles( $page ) {
            
            wp_enqueue_style( 'wp-WSAnalytics-style', plugins_url('css/wp-WSAnalytics-style.css', __FILE__));
            wp_enqueue_style( 'chosen', plugins_url('css/chosen.css', __FILE__));

            if ( get_option( 'ws_welcome_message' ) == '0' ) {
                
                wp_enqueue_style( 'wp-pointer' );
            
            }
    }

    public function ws_front_styles( $page ) {
        
        if( get_option( 'WSAnalytics_disable_front') == 0 ) {

            wp_enqueue_style( 'front-end-style', plugins_url('css/frontend_styles.css', __FILE__),false,WSAnalytics_VERSION);            
        }
    }

    /**
     * Loading scripts js for the plugin.
     */
    public function ws_scripts( $page ) {

        wp_enqueue_script ( 'jquery' );
        wp_enqueue_script ( 'charts_api_js', 'https://www.google.com/jsapi', false, WSAnalytics_VERSION );
        wp_enqueue_script ( 'chosen-js', plugins_url('js/chosen.jquery.js', __FILE__), false, WSAnalytics_VERSION );
        wp_enqueue_script ( 'script-js', plugins_url('js/wp-WSAnalytics.js', __FILE__), false, WSAnalytics_VERSION );
        wp_enqueue_script ( 'jquery-ui-tooltip' );
        wp_enqueue_script ( 'jquery-ui-datepicker');
            
        if ( get_option( 'ws_welcome_message' ) == '0' ) {
             
            wp_enqueue_script( 'wp-pointer' );
        }   
    }

    /**
     * Loading scripts js for the plugin.
     */
    public function ws_front_scripts( $page ) {
        
        if( get_option( 'WSAnalytics_disable_front') == 0 ){

            wp_enqueue_script ('jquery');
            wp_enqueue_script ('WSAnalytics-classie', plugins_url('js/classie.js', __FILE__), false, WSAnalytics_VERSION);
            wp_enqueue_script ('WSAnalytics-selectfx', plugins_url('js/selectFx.js', __FILE__), false, WSAnalytics_VERSION);
            wp_enqueue_script ('WSAnalytics-script', plugins_url('js/script.js', __FILE__), false, WSAnalytics_VERSION);

        }
    }

    /** 
     * Create Analytics menu at the left side of dashboard
     */
    public static function wpws_add_menu() {

        add_menu_page( WSAnalytics_NICK, 'WSAnalytics', 'manage_options', 'WSAnalytics-dashboard', array(
                          __CLASS__,
                         'ws_page_file_path'
                        ), plugins_url('images/wp-analytics-logo.png', __FILE__),'2.1.9');

            add_submenu_page( 'WSAnalytics-dashboard', WSAnalytics_NICK . ' Dashboard', ' Dashboard', 'manage_options', 'WSAnalytics-dashboard', array(
                              __CLASS__,
                             'ws_page_file_path'
                            ));
            
            add_submenu_page( 'WSAnalytics-dashboard', WSAnalytics_NICK . ' Settings', '<b style="color:#f9845b">Settings</b>', 'manage_options', 'WSAnalytics-settings', array(
                              __CLASS__,
                             'ws_page_file_path'
                            ));
    }

    /** 
     * Creating tabs for settings
     * @since 0.0.1
     */

    public function ws_settings_tabs( $current = 'authentication' ) {
            
            $tabs = array( 'authentication' 		=>  'Authentication', 
                            'profile'       		=>  'Profile',
                            'general_tracking'		=>	'General Tracking',
							'admin'         		=>  'Admin'
							
                    );

            echo '<div class="left-area">';

            echo '<div id="icon-themes" class="icon32"><br></div>';
            echo '<h2 class="nav-tab-wrapper">';

            foreach( $tabs as $tab => $name ) {

                $class = ( $tab == $current ) ? ' nav-tab-active' : '';
                echo "<a class='nav-tab$class' href='?page=WSAnalytics-settings&tab=$tab'>$name</a>";
            }

            echo '</h2>';
    }

    /**
     * Get profiles from user Google Analytics account profiles.
     */
    public function pt_get_analytics_accounts() {

            try {

                if( get_option( 'ws_google_token' ) !='' ) {
                    $profiles = $this->service->management_profiles->listManagementProfiles( "~all", "~all" );
                    return $profiles;
                }
                
                else{
                    echo '<br /><p class="description">' . __( 'You must authenticate to access your web profiles.', 'wp-WSAnalytics' ) . '</p>';
                }

            }
            
            catch (Exception $e) {
                die('An error occured: ' . $e->getMessage() . '\n');
            }
    }

    public function ws_setting_url() {
        
        return admin_url('admin.php?page=WSAnalytics-settings');
    
    }


    public function pt_save_data( $key_google_token ) {

        update_option( 'post_analytics_token', $key_google_token );
        $this->ws_connect();

        return true;
    }

    /**
     * Warning messages.
     */
    public function profile_warning() {

            $profile_id     =   get_option( "pt_webprofile" );
            $acces_token    =   get_option( "post_analytics_token" );

            if (! isset( $acces_token ) || empty( $acces_token )) {
               
               echo "<div id='message' class='error'><p><strong>" . __( "WSAnalytics is not active. Please <a href='" . menu_page_url ( 'WSAnalytics-settings', false ) ."'>Authenticate</a> in order to get started using this plugin.", 'wp-WSAnalytics' )."</p></div>"; 
            }
            else{
                
                if (! isset( $profile_id ) || empty( $profile_id )){
                    echo '<div class="error"><p><strong>' . __( 'Google Analytics Profile is not set. Set the <a href="' . menu_page_url ( 'WSAnalytics-settings', false ) . '&tab=profile">Profile</a> ', 'wp-WSAnalytics' ) . '</p></div>';
                }
            }
    }


    public function get_single_front_analytics( $content ) {
        
        global $post, $wp_WSAnalytics;

        $front_access = get_option( 'post_analytics_access' );

        if ( is_single() || is_page() ) {
            
            $post_type = get_post_type( $post->ID );
            
            if( strlen( get_option( 'WSAnalytics_posts_stats_front' ) < 3) ) {
                return $content;
            }

            if( is_array( get_option( 'WSAnalytics_posts_stats_front' )) and !in_array( $post_type, get_option( 'WSAnalytics_posts_stats_front' ) ) ) {

                return $content;
            }

            if ( is_array( get_option( 'post_analytics_exclude_posts_front' ) ) ) {
                    
                if ( in_array( get_the_ID(), get_option( 'post_analytics_exclude_posts_front' ) ) ) {
                            
                    return $content;
                }
            }

            // Showing stats to guests
            if ( $front_access[0] == 'every-one' || $this->ws_check_roles( $front_access )) {
                
                $post_analytics_settings_front = array();
                $post_analytics_settings_front = get_option( 'post_analytics_settings_front' );
              
                $urlPost =  parse_url( get_permalink( $post->ID ) );
            
                if ( $urlPost['host'] == 'localhost' ) 
                    $filter = 'ga:pagePath==/'; 
                else 
                    $filter = 'ga:pagePath==' .$urlPost['path']. '';  

                if( get_the_time('Y', $post->ID) < 2005 ) {

                    $start_date = '2005-01-01';
                }
                else {

                     $start_date = get_the_time('Y-m-d', $post->ID);   
                }

                $end_date = date('Y-m-d');
                
                ob_start();

                include WSAnalytics_ROOT_PATH . '/inc/front-menus.php';

                if(! empty( $post_analytics_settings_front )){

                        if (is_array( $post_analytics_settings_front )){

                            $stats = $this->ws_get_analytics( 'ga:sessions,ga:bounces,ga:newUsers,ga:entrances,ga:pageviews,ga:sessionDuration,ga:avgSessionDuration,ga:users',$start_date, $end_date, false, false, $filter);

                            if ( isset( $stats->totalsForAllResults ) ) {

                                include WSAnalytics_ROOT_PATH . '/views/front/general-stats.php'; 
                                ws_include_general( $this, $stats);
                            }
                        }
                }
                      
                $content .= ob_get_contents();
                ob_get_clean();
            }

        }
        
        return $content;

    }

    /*
     * get the Analytics data from ajax() call
     * 
     */

    public function get_ajax_single_admin_analytics() {

        $startDate = '';
        $endDate   = '';
        $postID    = 0 ;
        $startDate = $_POST['start_date'];
        $endDate   = $_POST['end_date'];
        $postID    = $_POST['post_id'];
        $this->get_single_admin_analytics( $startDate, $endDate, $postID, 1 );

        die();
    }
	
	

    /*
     * get the Analytics data for wp-admin posts/pages.
     * 
     */
    public function get_single_admin_analytics( $start_date = '', $end_date = '', $postID = 0, $ajax = 0 ) {

        global $post;
            
                      
        if ( $postID == 0 ) {
            $u_post = '/'; 
        }
        else{
            $u_post = parse_url( get_permalink( $postID ) );
        }

        if ( $u_post['host'] == 'localhost' ) 
            $filter = false;
        else
           $filter = 'ga:pagePath==' .$u_post['path']. '';


        if ( $start_date == '' ) {
            
            $s_date = get_the_time('Y-m-d', $post->ID);
            if(get_the_time('Y', $post->ID) < 2005){
                $s_date = '2005-01-01';
            }
        }
        else{
            $s_date = $start_date;
        }

        if ( $end_date == '' ) {
            $e_date = date('Y-m-d');
        }   
        else{
                $e_date = $end_date;
        }

        $show_settings = array();
        $show_settings = get_option('post_analytics_settings_back');
            
        // Stop here, if user has disable backend analytics i.e OFF
        if ( get_option( 'post_analytics_disable_back' ) == 1 and $ajax == 0) {
            return;
        }

        echo '<p> Displaying Analytics of this page from ' . date("jS F, Y", strtotime($s_date)) . ' to '. date("jS F, Y", strtotime($e_date)) . '</p>';

        if( !empty( $show_settings )){

            if (is_array( $show_settings )){
                    
                if (in_array( 'show-overall-back', $show_settings )) { 
                       
                    $stats = $this->ws_get_analytics( 'ga:sessions,ga:bounces,ga:newUsers,ga:entrances,ga:pageviews,ga:sessionDuration,ga:avgSessionDuration,ga:users',$s_date, $e_date, false, false, $filter);
                        
                    if ( isset( $stats->totalsForAllResults ) ) {

                        include WSAnalytics_ROOT_PATH . '/views/admin/single-general-stats.php'; 
                        wws_single_include_general( $this, $stats);                      
                    }
                }
            }
        }
    }

	// Get RealTime statistics.
    function ws_realtime_data_get() { 
            
        if (! isset( $_REQUEST['ws_security'] ) OR ! wp_verify_nonce( $_REQUEST['ws_security'] , 'ws_get_online_data' ) ) {
            return;
        }
            
        if (! function_exists( 'curl_version' ) ) {
            die();
        }

        print_r( stripslashes( json_encode( $this->ws_realtime_data( get_option( "pt_webprofile_dashboard" ) ) ) ) ); 

        die();
    }
	
	
	/*
	 * Real Time Function for jQuery Calc for categorising Data 
	 */
	  public function ws_realtime() {
            $code = '
                <script type="text/javascript">
                function onlyUniqueValues(value, index, self) {
                    return self.indexOf(value) === index;
                 }
        
                function countvisits(data, searchvalue) {
                    var count = 0;
                    if(data["rows"]){
                    for ( var i = 0; i < data["rows"].length; i = i + 1 ) {
                        if (jQuery.inArray(searchvalue, data["rows"][ i ])>-1){
                            count += parseInt(data["rows"][ i ][6]);
                        }
                    }
                }
                    return count;
                 }
        
                function ws_generatetooltip(data) {
                    var count = 0;
                    var table = "";
                    for ( var i = 0; i < data.length; i = i + 1 ) {
                            count += parseInt(data[ i ].count);
                            table += "<td>"+data[i].value+"</td><td class=\'ws-pgdetailsr\'>"+data[ i ].count+"</td></tr>";
                    };
                    if (count){
                        return("<table>"+table+"</table>");
                    }else{
                        return("");
                    }
                }
        
                function ws_wsgedetails(data, searchvalue) {
                    var newdata = [];
                    for ( var i = 0; i < data["rows"].length; i = i + 1 ){
                        var sant=1;
                        for ( var j = 0; j < newdata.length; j = j + 1 ){
                            if (data["rows"][i][0]+data["rows"][i][1]+data["rows"][i][2]+data["rows"][i][3]==newdata[j][0]+newdata[j][1]+newdata[j][2]+newdata[j][3]){
                                newdata[j][6] = parseInt(newdata[j][6]) + parseInt(data["rows"][i][6]);
                                sant = 0;
                            }
                        }
                        if (sant){
                            newdata.push(data["rows"][i].slice());
                        }
                    }
        
                    var countrfr = 0;
                    var countkwd = 0;
                    var countdrt = 0;
                    var countscl = 0;
                    var tablerfr = "";
                    var tablekwd = "";
                    var tablescl = "";
                    var tabledrt = "";
                    for ( var i = 0; i < newdata.length; i = i + 1 ) {
                        if (newdata[i][0] == searchvalue){
                            var wsgetitle = newdata[i][5];
                            switch (newdata[i][3]){
                                case "REFERRAL":    countrfr += parseInt(newdata[ i ][6]);
                                                    tablerfr += "<tr><td class=\'ws-pgdetailsl\'>"+newdata[i][1]+"</td><td class=\'ws-pgdetailsr\'>"+newdata[ i ][6]+"</td></tr>";
                                                    break;
                                case "ORGANIC":     countkwd += parseInt(newdata[ i ][6]);
                                                    tablekwd += "<tr><td class=\'ws-pgdetailsl\'>"+newdata[i][2]+"</td><td class=\'ws-pgdetailsr\'>"+newdata[ i ][6]+"</td></tr>";
                                                    break;
                                case "SOCIAL":      countscl += parseInt(newdata[ i ][6]);
                                                    tablescl += "<tr><td class=\'ws-pgdetailsl\'>"+newdata[i][1]+"</td><td class=\'ws-pgdetailsr\'>"+newdata[ i ][6]+"</td></tr>";
                                                    break;
                                case "DIRECT":      countdrt += parseInt(newdata[ i ][6]);
                                                    break;
                            };
                        };
                    };
                    if (countrfr){
                        tablerfr = "' . __ ( "REFERRALS", 'wp-WSAnalytics' ) . ' ("+countrfr+")"+tablerfr+"";
                    }
                    if (countkwd){
                        tablekwd = "' . __ ( "KEYWORDS", 'wp-WSAnalytics' ) . ' ("+countkwd+")"+tablekwd+"";
                    }
                    if (countscl){
                        tablescl = "' . __ ( "SOCIAL", 'wp-WSAnalytics' ) . ' ("+countscl+")"+tablescl+"";
                    }
                    if (countdrt){
                        tabledrt = "' . __ ( "DIRECT", 'wp-WSAnalytics' ) . ' ("+countdrt+")";
                    }
                    return (wsgetitle);
                 }
            
                 function online_refresh(){
                    jQuery.post(ajaxurl, {action: "ws_get_online_data", ws_security: "'.wp_create_nonce('ws_get_online_data').'"}, function(response){
                        var data = jQuery.parseJSON(response);
                        if (data["totalsForAllResults"]["ga:activeVisitors"]!==document.getElementById("ws-online").innerHTML){
                            jQuery("#ws-online").fadeOut("slow");
                            jQuery("#ws-online").fadeOut(500);
							jQuery("#ws-online").fadeOut("slow", function() {
                                if ((parseInt(data["totalsForAllResults"]["ga:activeVisitors"]))<(parseInt(document.getElementById("ws-online").innerHTML))){
                                }else{
                                }
                                document.getElementById("ws-online").innerHTML = data["totalsForAllResults"]["ga:activeVisitors"];
                            });
                            jQuery("#ws-online").fadeIn("slow");
                            jQuery("#ws-online").fadeIn(500);
                            jQuery("#ws-online").fadeIn("slow", function() {
								});
						
                        };
        
                        var wsgewsth = [];
                        var referrals = [];
                        var keywords = [];
                        var social = [];
                        var visittype = [];
                        if(data["rows"]){
                        for ( var i = 0; i < data["rows"].length; i = i + 1 ) {
                            wsgewsth.push( data["rows"][ i ][0] );
                            if (data["rows"][i][3]=="REFERRAL"){
                                referrals.push( data["rows"][ i ][1] );
                            }
                            if (data["rows"][i][3]=="ORGANIC"){
                                keywords.push( data["rows"][ i ][2] );
                            }
                            if (data["rows"][i][3]=="SOCIAL"){
                                social.push( data["rows"][ i ][1] );
                            }
                            visittype.push( data["rows"][ i ][3] );
                        }
                    }
                        var uwsgewsth = wsgewsth.filter(onlyUniqueValues);
                        var uwsgewsthstats = [];
                        for ( var i = 0; i < uwsgewsth.length; i = i + 1 ) {
                            uwsgewsthstats[i]={"wsgewsth":uwsgewsth[i],"count":countvisits(data,uwsgewsth[i])};
                        }
                        uwsgewsthstats.sort( function(a,b){ return b.count - a.count } );
        
                        var pgstatstable = "";
                        for ( var i = 0; i < uwsgewsthstats.length; i = i + 1 ) {
                            if (i < 10 ){
                                pgstatstable += "<tr class=\"ws-pline\"><td class=\"ws-pright\">"+(i+1)+"</td><td class=\"ws-pleft\"><a href=\"'.get_option("pt_webprofile_url").'"+uwsgewsthstats[i].wsgewsth.substring(0,70)+"\" title=\""+ws_wsgedetails(data, uwsgewsthstats[i].wsgewsth)+"\" target=\"_blank\">"+ws_wsgedetails(data, uwsgewsthstats[i].wsgewsth)+"</a></td><td class=\"ws-pright\">"+uwsgewsthstats[i].count+"</td></tr>";
                            }
                        }
                        document.getElementById("ws-wsges").innerHTML="<br /><table class=\"ws-pg Real_Time_Statistics_table\"><tr><th class=\"wd_1\">#</th><th>Page Title</th><th class=\"wd_2\">Visitors</th></tr>"+pgstatstable+"</table>";
        
                        var ureferralsstats = [];
                        var ureferrals = referrals.filter(onlyUniqueValues);
                        for ( var i = 0; i < ureferrals.length; i = i + 1 ) {
                            ureferralsstats[i]={"value":ureferrals[i],"count":countvisits(data,ureferrals[i])};
                        }
                        ureferralsstats.sort( function(a,b){ return b.count - a.count } );
        
                        var ukeywordsstats = [];
                        var ukeywords = keywords.filter(onlyUniqueValues);
                        for ( var i = 0; i < ukeywords.length; i = i + 1 ) {
                            ukeywordsstats[i]={"value":ukeywords[i],"count":countvisits(data,ukeywords[i])};
                        }
                        ukeywordsstats.sort( function(a,b){ return b.count - a.count } );
        
                        var usocialstats = [];
                        var usocial = social.filter(onlyUniqueValues);
                        for ( var i = 0; i < usocial.length; i = i + 1 ) {
                            usocialstats[i]={"value":usocial[i],"count":countvisits(data,usocial[i])};
                        }
                        usocialstats.sort( function(a,b){ return b.count - a.count } );
        
                        var uvisittype = ["REFERRAL","ORGANIC","SOCIAL"];
                        document.getElementById("ws-tdo-right").innerHTML = "<div class=\"ws-bigtext\"><span class=\"count-visits\">" +countvisits(data,uvisittype[0])+ "</span><span class=\"source\"><a href=\"#\" title=\""+ws_generatetooltip(ureferralsstats)+"\">"+\'' . __ ( "REFERRAL", 'wp-WSAnalytics' ) . '\'+"</a></span></div>";
                        document.getElementById("ws-tdo-right").innerHTML += "<div class=\"ws-bigtext\"><span class=\"count-visits\">" +countvisits(data,uvisittype[1])+ "</span><span class=\"source\"><a href=\"#\" title=\""+ws_generatetooltip(ukeywordsstats)+"\">"+\'' . __ ( "ORGANIC", 'wp-WSAnalytics' ) . '\'+"</a></span></div>";
                        document.getElementById("ws-tdo-right").innerHTML += "<div class=\"ws-bigtext\"><span class=\"count-visits\">" +countvisits(data,uvisittype[2])+ "</span><span class=\"source\"><a href=\"#\" title=\""+ws_generatetooltip(usocialstats)+"\">"+\'' . __ ( "SOCIAL", 'wp-WSAnalytics' ) . '\'+"</a></span></div>";
        
                        var uvisitortype = ["DIRECT","NEW","RETURNING"];
                        document.getElementById("ws-tdo-rights").innerHTML = "<div class=\"ws-bigtext\"><span class=\"count-visits\">" +countvisits(data,uvisitortype[0])+ "</span><span class=\"source\"><a href=\"#\" title=\"DIRECT Visitors\">"+\'' . __ ( "DIRECT", 'wp-WSAnalytics' ) . '\'+"</a></span></div>";
                        document.getElementById("ws-tdo-rights").innerHTML += "<div class=\"ws-bigtext\"><span class=\"count-visits\">" +countvisits(data,uvisitortype[1])+ "</span><span class=\"source\"><a href=\"#\" title=\"NEW Visitors\">"+\'' . __ ( "NEW", 'wp-WSAnalytics' ) . '\'+"</a></span></div>";
                        document.getElementById("ws-tdo-rights").innerHTML += "<div class=\"ws-bigtext\"><span class=\"count-visits\">" +countvisits(data,uvisitortype[2])+ "</span><span class=\"source\"><a href=\"#\" title=\"RETURNING Visitors\">"+\'' . __ ( "RETURNING", 'wp-WSAnalytics' ) . '\'+"</a></span></div>";
        
                        if (!data["totalsForAllResults"]["ga:activeVisitors"]){
                            location.reload();
                        }
        
                    });
               };
               online_refresh();
               setInterval(online_refresh, 20000);
               </script>';
            return $code;
			
}

    public function ws_realtime_data() {
            $profile_id = get_option("pt_webprofile_dashboard");
            $metrics = 'ga:activeVisitors';
            $dimensions = 'ga:pagepath,ga:source,ga:keyword,ga:trafficType,ga:visitorType,ga:pageTitle';
            try {
               
                    $data = $this->service->data_realtime->get ( 'ga:' . $profile_id, $metrics, array (
                            'dimensions' => $dimensions
                    ) );
                }
             catch ( Exception $e ) {
                update_option ( 'ws_lasterror_occur', esc_html($e));
                return '';
            }
            return $data;           
    } 
	
	// End Real Time Function 
	
	
    
    /*
     * Pretty numbers
     */
    function wws_pretty_numbers( $num ) {

        return round(($num/1000),2).'k';
    }

    /*
     * format numbers
     */
    function wws_number_format( $num ) {

        return number_format($num);
    }

    /*
     * Pretty time to display
     */
    function ws_pretty_time( $time ) {

            // Check if numeric
            if ( is_numeric($time) ) {

                $value = array(
                    "years" => '00',
                    "days" => '00',
                    "hours" => '',
                    "minutes" => '',
                    "seconds" => ''
                );
                
                if ($time >= 31556926) {
                    $value["years"] = floor($time / 31556926);
                    $time           = ($time % 31556926);
                } //$time >= 31556926

                if ($time >= 86400)
                    {
                    $value["days"] = floor($time / 86400);
                    $time          = ($time % 86400);
                    } //$time >= 86400
                if ($time >= 3600)
                    {
                    $value["hours"] = str_pad(floor($time / 3600), 1, 0, STR_PAD_LEFT);
                    $time           = ($time % 3600);
                    } //$time >= 3600
                if ($time >= 60)
                    {
                    $value["minutes"] = str_pad(floor($time / 60), 1, 0, STR_PAD_LEFT);
                    $time             = ($time % 60);
                    } //$time >= 60
                    $value["seconds"] = str_pad(floor($time), 1, 0, STR_PAD_LEFT);
                # Get the hour:minute:second version
                if($value['hours']!=''){
                    $attach_hours='<sub>h</sub> ';
                }
                if($value['minutes']!=''){
                    $attach_min='<sub>min</sub> ';
                }
                if($value['seconds']!=''){
                    $attach_sec='<sub>sec</sub>';
                }
                return $value['hours'] .@$attach_hours. $value['minutes'] .@$attach_min. $value['seconds'].$attach_sec;
                
                } //is_numeric($time)
            else
                {
                return false;
                }
    }


    public function ws_check_roles( $access_level ) {
            
        if ( is_user_logged_in () && isset ( $access_level ) ) {
                
            global $current_user;
            $roles = $current_user->roles;

                if ( in_array ( $roles[0], $access_level ) ) {
                    
                return true;
            }
            else {
                    
                return false;
            }
        }
    }

    public function ws_welcome_message() {

        $pointer_content = '<h3>WSAnalytics - Google Analytics for WordPress.</h3>';
        $pointer_content .= '<p>Thank you for activating WSAnalytics Plugin. Enjoy Google Analytics for everything in WordPress.</p>';
        ?>

        <script type="text/javascript">
            //<![CDATA[
            jQuery(document).ready( function($) {

                $('#toplevel_page_pa-dashboard').pointer({
                        content: '<?php echo $pointer_content; ?>',
                        position: 'left',
                        close: function() {
                            <?php update_option("ws_welcome_message",1) ?>
                        }
                }).pointer('open');
            });
            //]]>
        </script>
        
        <?php
    }

    /*
     * Activate options by default on installing the plugin. 
     */
    static function install() {

        update_option( 'WSAnalytics_posts_stats', array( 'post','page' ));
        update_option( 'post_analytics_disable_back'  ,   1 );
        update_option( 'wsanalytics_code'  ,   1 );
        update_option( 'post_analytics_settings_back' , array( 'show-overall-back' ) );
        update_option( 'post_analytics_access_back'   , array( 'editor','administrator' ) );
        update_option( 'display_tracking_code'        , array( 'administrator' ) );
		update_option( 'display_demographic_code' ,   1 );
       

    }

    static function uninstall() {

        delete_option( 'WSAnalytics_posts_stats' );
        delete_option( 'ws_google_token' );
        delete_option( 'ws_welcome_message' );
        delete_option( 'post_analytics_token' );
            
     }

}

$wp_WSAnalytics =   new WS_Analytics();

$wp_WSAnalytics->ws_check_warnings();

} //end if
?>