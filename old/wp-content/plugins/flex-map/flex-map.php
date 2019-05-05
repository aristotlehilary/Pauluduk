<?php
/**
 * Plugin Name: FLEX MAP
 * Plugin URI: http://demo.zotheme.com/extensions/flexmap/
 * Description: Provide a powerful map solution for your Wordpress website.
 * Version: 1.0.1
 * Author: Jax Porter & Fox
 * Author URI: https://twitter.com/jax_porter_139
 * License: GPLv2 or later
 * Text Domain: flex-map
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

if( !class_exists( 'myMaps' ) )
{
    final class myMaps
    {

        /**
         * Action argument used by the nonce validating the AJAX request.
         *
         * @var string
         */
        const NONCE = 'flx-mp-ajax';

        public $map_id;
        /**
         * Main Instance
         *
         * Insures that only one instance of myMaps exists in memory at any one
         * time. Also prevents needing to define globals all over the place.
         *
         * @since 1.0.0
         * @staticvar object $instance
         * @uses myMaps::setup_globals() Setup the globals needed
         * @uses myMaps::includes() Include the required files
         * @uses myMaps::setup_actions() Setup the hooks and actions
         * @return The one true myMaps
         */
        public static function instance()
        {
            /*Store the instance locally to avoid private static replication*/
            static $instance = null;

            /* Only run these methods if they haven't been ran previously*/
            if (null === $instance)
            {
                $instance = new myMaps();
                $instance->setup_globals();
                $instance->setup_actions();
            }
            /*Always return the instance*/
            return $instance;
        }


        /**
         * Set some smart defaults to class variables.
         * Allow some of them to be
         * filtered to allow for early overriding.
         *
         * @since 1.0.0
         * @access private
         * @uses plugin_dir_path() To generate plugin path
         * @uses plugin_dir_url() To generate plugin url
         * @uses apply_filters() Calls various filters
         */
        private function setup_globals()
        {
            $this -> file = __FILE__;
            $this -> basename   = apply_filters('mm_basename', plugin_basename( $this->file) );
            $this -> plugin_dir = apply_filters('mm_dir_path', plugin_dir_path( $this->file) );
            $this -> plugin_url = apply_filters('mm_dir_url', plugin_dir_url( $this->file) );
            $this -> assets     = apply_filters('mm_js_url', trailingslashit( $this -> plugin_url . 'assets') );
            /* plugin data */
            if( function_exists('get_plugin_data') ) {
                $this -> pl_data = get_plugin_data($this -> file);
                $this -> pl_name = $this -> pl_data['Name'];
            } else {
                $this -> pl_name = 'Flex Map';
            }
            /* short code name */
            $this -> shortcode   = 'flexmap';
        }

        /**
         * Setup the default hooks and actions
         *
         * @since 1.0.0
         * @access private
         * @uses add_action() To add various actions
         */
        private function setup_actions()
        {
            $handler = new self();

            /*  hook to link only on the front-end */
            add_action( 'wp_enqueue_scripts', array($this, 'mymaps_add_scripts_method' ) );

            /* Hook to embed admin script function */
            add_action('admin_enqueue_scripts', array($this, 'mymaps_add_admin_scripts'));

            /* hook to creating a multi-level administration menus */
            add_action( 'admin_menu', array($this, 'mymaps_admin_menu' ) );

            /* Mymaps add options */
            register_activation_hook($this->file, array($this, 'mymaps_add_options'));

            /* Hook to admin_init for handles ajax */
            add_action( 'admin_init', array($handler, 'mymaps_ajax') );

            /* Add shortcode */
            add_shortcode( $this -> shortcode, array($this, 'mymaps_shortcode_func' ) );

            add_action( 'admin_enqueue_scripts', array($this, 'prfx_image_enqueue' ) );

            /* Add VC shortcode */

            add_action( 'vc_before_init', array($this, 'flexmap_shortcode_VC') );

            add_action( 'widgets_init', array($this, 'flexmap_widgets_widgets' ) );
        }
        /* VC add shortcode */
        function flexmap_shortcode_VC() {
            $options = get_option('mymaps_options');
            $options  = $options['_map_posts_'];
            $arr_post = array();
            if( is_array($options) && count($options) > 0 ) {
                foreach( $options as $key => $value ) {
                    $general = json_decode($value['general']);
                    $arr_post[$general -> name . ' - ' . '[flexmap id="' . $key . '"]'] = $key;
                }
            }
            vc_map( array(
                "name" => __( "Flex Map", "flex-map" ),
                "base" => "flexmap",
                "icon" => $this -> plugin_url . '/img/icon-sm.png',
                "params" => array(
                    array(
                        'type' => 'dropdown',
                        'heading' => __( 'Map Post', 'flex-map' ),
                        'param_name' => 'id',
                        'value' => $arr_post
                    ),
                ),
            ) );
        }
        /**
         * Loads the image management javascript
         */
        function prfx_image_enqueue() {
            $screen = get_current_screen();
            $this -> slug_name = strtolower( $this -> pl_name );
            $this -> slug_name = explode( ' ', $this -> slug_name );
            $this -> slug_name = implode( '-', $this -> slug_name );
            /* map post */
            if (isset($screen->id) && $screen->id == $this -> slug_name . '_page_map-post')
            {
                if( function_exists('wp_enqueue_media') ) {
                    wp_enqueue_media();
                    // Registers and enqueues the required javascript.
                    wp_register_script('meta-box-image', $this -> assets . 'js/meta-box-image.js', array('jquery'));
                    wp_localize_script('meta-box-image', 'meta_image',
                        array(
                            'title' => __('Choose or Upload an Image', 'flex-map'),
                            'button' => __('Use this image', 'flex-map'),
                        )
                    );
                    wp_enqueue_script('meta-box-image');
                }
            }
        }

        /**
         * Provide an implement for mymaps to render front end of 'mymaps' shortcode
         *
         * @param  array $atts : contain attributes of shortcode
         * @return map_frame : html code of shortcode
         * @since 1.0.0
         */
        function mymaps_shortcode_func( $atts ) {
            global $map_id;
            if(!isset($atts['id'])) exit();
            $map_id[] = (int) $atts['id'];
            $map_data_arr = array();
            $map_data = array();

            $atts = shortcode_atts( array(
                'id' => false,
            ), $atts, $this -> shortcode );
            if( $options = get_option('mymaps_options') )
            {
                $map_post = $options['_map_posts_'];
                foreach( $map_id as $id ) {
                    if( isset($map_post[$id]) && $map_post[$id] != '' ) {
                        $map_data_arr[$id] = $map_post[$id];
                    }
                }

                if( !empty($map_data_arr) ) {
                    $map_data = $map_data_arr;
                    myMaps::shortcode_enqueue_script( $map_data, $this -> assets );
                    require_once $this -> plugin_dir .'template/shortcode.php';
                    return map_frame( $atts['id'], $map_data);
                } else {
                    return 'map array null';
                }
            } else {
                return 'cannot show';
            }
        }
        /**
         * Get the AJAX data that WordPress needs to output.
         *
         * @return array
         */
        private function get_ajax_data()
        {
            return wp_create_nonce(myMaps::NONCE);
        }

        /**
         * For add ajax handler
         *
         * since 1.0.0
         **/
        function mymaps_ajax()
        {
            /* Load admin ajax url.*/
            add_action('admin_header', array($this, 'mymaps_ajaxurl'));
            /* AJAX for load my styles */
            add_action('wp_ajax_flx_load_my_styles', array($this, 'flx_load_my_styles_callback') );
            add_action('wp_ajax_nopriv_flx_load_my_styles', array($this, 'flx_load_my_styles_callback'));

            /* AJAX for save 2 mystyles */
            add_action('wp_ajax_flx_save2_mystyles', array($this, 'flx_save2_mystyles_callback'));
            add_action('wp_ajax_nopriv_flx_save2_mystyles', array($this, 'flx_save2_mystyles_callback'));

            /* AJAX for delete mystyle */
            add_action('wp_ajax_flx_delete_mystyle', array($this, 'flx_delete_mystyle_callback'));
            add_action('wp_ajax_nopriv_flx_delete_mystyle', array($this, 'flx_delete_mystyle_callback'));

            /* AJAX for save map post */
            add_action('wp_ajax_flx_save_map', array($this, 'flx_save_map_callback'));
            add_action('wp_ajax_nopriv_flx_save_map', array($this, 'flx_save_map_callback'));

            /* AJAX for delete map post */
            add_action('wp_ajax_flx_delete_map', array($this, 'flx_delete_map_callback'));
            add_action('wp_ajax_nopriv_flx_delete_map', array($this, 'flx_delete_map_callback'));

            /* AJAX for upload marker icons  */
            add_action('wp_ajax_flx_upload_marker_icon', array($this, 'flx_upload_marker_icon_callback'));
            add_action('wp_ajax_nopriv_flx_upload_marker_icon', array($this, 'flx_upload_marker_icon_callback'));

            /* AJAX for delete marker icons */
            add_action('wp_ajax_flx_delete_marker_icon', array($this, 'flx_delete_marker_icon_callback'));
            add_action('wp_ajax_nopriv_flx_delete_marker_icon', array($this, 'flx_delete_marker_icon_callback'));

            /* AJAX for delete marker icons */
            add_action('wp_ajax_flx_import_map', array($this, 'flx_import_map_callback'));
            add_action('wp_ajax_nopriv_flx_import_map', array($this, 'flx_import_map_callback'));

            /* AJAX for delete marker icons */
            add_action('wp_ajax_mymaps_load_styles_libs', array($this, 'mymaps_load_styles_libs_callback'));
            add_action('wp_ajax_nopriv_mymaps_load_styles_libs', array($this, 'mymaps_load_styles_libs_callback'));
        }
        function flx_load_styles_libs_callback() {
            if ( ! is_admin() ) exit();
            // Make sure we are getting a valid AJAX request
            check_ajax_referer(self::NONCE);
            exit();
        }
        /**
         * Register our sidebars and widgetized areas.
         *
         */
        function flexmap_widgets_widgets() {
            register_widget('flexmap_widgets');
        }

        /**
         * provide an implementation for wp_ajax_flx_import_map, wp_ajax_nopriv_flx_import_map

         */
        function flx_import_map_callback() {
            $fl_obj = declare_mymaps();
            require_once $fl_obj -> plugin_dir . 'template/params/import.php';
            import_map_ajax();
            exit();
        }

        /**
         * Load admin ajax url.
         *
         * @since 1.0.0
         */
        function mymaps_ajaxurl()
        {
        ?>
            <script type="text/javascript">var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';</script>
        <?php
        }

        /**
         * Handle ajax request for DELETE marker icons
         *
         * since 1.0.0
         */
        function flx_delete_marker_icon_callback() {
            $fl_obj = declare_mymaps();
            // Make sure we are getting a valid AJAX request
            check_ajax_referer(self::NONCE);
            require_once $fl_obj -> plugin_dir .'template/params/mkPanel.php';
            ajax_delete_marker_icon();
            exit();
        }

        /**
         * Handle ajax request for save to my styles
         *
         * since 1.0.0
         */
        function flx_save2_mystyles_callback()
        {
            $fl_obj = declare_mymaps();
            // Make sure we are getting a valid AJAX request
            check_ajax_referer(self::NONCE);
            require_once $fl_obj -> plugin_dir .'template/params/stPanel.php';
            ajax_save2_mystyles();
            exit();
        }

        /**
         * Handle ajax request to load my styles panel
         *
         * @since 1.0.0
         */
        function flx_load_my_styles_callback()
        {
            $fl_obj = declare_mymaps();
            // Make sure we are getting a valid AJAX request
            check_ajax_referer(self::NONCE);
            require_once $fl_obj -> plugin_dir .'template/params/stPanel.php';
            ajax_load_mystyles();
            exit();
        }

        /**
         * Handle ajax request to delete my style
         */
        function flx_delete_mystyle_callback()
        {
            $fl_obj = declare_mymaps();
            // Make sure we are getting a valid AJAX request
            check_ajax_referer(self::NONCE);
            require_once $fl_obj -> plugin_dir .'template/params/stPanel.php';
            ajax_delete_mystyles();
            exit();
        }

        /**
         * Handle ajax request to save map post
         */
        function flx_save_map_callback()
        {
            $fl_obj = declare_mymaps();
            // Make sure we are getting a valid AJAX request
            check_ajax_referer(self::NONCE);
            require_once $fl_obj -> plugin_dir .'template/params/gnPanel.php';
            ajax_save_map_posts();
            exit();
        }

        /*
         * Handle ajax request to delete map post
        */
        function flx_delete_map_callback()
        {
            $fl_obj = declare_mymaps();
            // Make sure we are getting a valid AJAX request
            check_ajax_referer(self::NONCE);
            require_once $fl_obj -> plugin_dir .'template/listmap.php';
            ajax_delete_map_posts();
            exit();
        }

        /*
         * Handle ajax request to upload marker image
         */
        function flx_upload_marker_icon_callback()
        {
            $fl_obj = declare_mymaps();
            // Make sure we are getting a valid AJAX request
            check_ajax_referer(self::NONCE);
            require_once $fl_obj -> plugin_dir .'template/params/mkPanel.php';
            ajax_upload_marker_icon();
            exit();
        }

        /**
         * Provide an implementation for the mymap_admin_menu from admin_menu hook
         * to creating a multi-level administration menus
         *
         * since 1.0.0
         */
        function mymaps_admin_menu()
        {
            $this -> slug_name          = strtolower( $this -> pl_name );
            $this -> slug_name          = explode( ' ', $this -> slug_name );
            $this -> slug_name          = implode( '-', $this -> slug_name );
            // Create top-level menus item
            add_menu_page(
                'My Maps Configuration Page',
                __( $this -> pl_name , 'flex-map'),
                'manage_options',
                $this -> slug_name . '-main-menus',
                array($this, 'maps_main_page'),
                $this -> plugin_url . '/img/icon-sm.png'
            );
            // Create a sub-menus under the top-level menus
            add_submenu_page(
                $this -> slug_name . '-main-menus',
                __('All Maps', 'flex-map'),
                __('All Maps', 'flex-map'),
                'manage_options',
                $this -> slug_name . '-main-menus',
                array($this, 'maps_main_page')
            );
            /* map post */
            add_submenu_page(
                $this -> slug_name . '-main-menus',
                'Map Post',
                __('Map Post', 'flex-map'),
                'manage_options',
                 'map-post',
                array($this, 'map_post_page')
            );
            /* backup page */
            add_submenu_page(
                $this -> slug_name . '-main-menus',
                __('Import / Export', 'flex-map'),
                __('Import / Export', 'flex-map'),
                'manage_options',
                'import-export',
                array($this, 'import_export_page')
            );
        }
        /*
         * Render the Import Export page
         *
         * since 1.0.0
         */
        function import_export_page() {
            require_once $this -> plugin_dir .'template/imexpage.php';
            import_export_page();
        }
        /*
         * Render the Main Page
         *
         * since 1.0.0
         */
        function maps_main_page()
        {
            require_once $this -> plugin_dir .'template/listmap.php';
            list_map();
        }

        /**
         * Add 'Add Maps' submenu page
         *
         * since 1.0.0
         */
        function map_post_page()
        {
            $map_data = array();
            if(isset($_GET['edit_map']) && is_numeric($_GET['edit_map']))
            {
                if( $options = get_option('mymaps_options') )
                {
                    $map_data                 = $options['_map_posts_'];
                    $map_data                 = $map_data[$_GET['edit_map']];
                    $map_data['_post_id_']    = $_GET['edit_map'];
                    $map_data['_shortcode_']  = $this -> shortcode;
                }
            }
            $map_data['_nonce_'] = self::get_ajax_data();
            wp_enqueue_script('admin.init', $this -> assets . 'js/init.admin.js', null, '1.0.145', TRUE);
            wp_localize_script('admin.init', 'mapData', $map_data);
            wp_enqueue_script('admin.init');
            require_once $this -> plugin_dir .'template/addmaps.php';
        }

        function shortcode_enqueue_script( $map_data, $assets ) {
            /* Find to embed carousel */
            $carousel_embed = 0;
            foreach( $map_data as $options ) {
                if( isset($options['general']) ) {
                    $general = json_decode($options['general']);
                    if( isset($general -> map_legend) && $general -> map_legend === true )
                        $carousel_embed = 1;break;
                }
            }
            /* jquery embed */
            wp_enqueue_script("jquery");

            wp_enqueue_script( 'googlemap-script', 'https://maps.googleapis.com/maps/api/js?v=3.21&libraries=weather,places', null, '1.0.0', TRUE);
            wp_enqueue_script( 'mm.front', $assets . 'js/front.js', null, '1.0.21', TRUE );
            wp_localize_script( 'mm.front', 'map_data', $map_data );
            wp_enqueue_script( 'mm.front');

            if( $carousel_embed == 1 ) {
                /* Owl carousel assets */
                wp_enqueue_style( 'mm-carousel', $assets . 'elements/owl-carousel/owl.carousel.css' );
                wp_enqueue_style( 'mm-theme', $assets . 'elements/owl-carousel/owl.theme.css' );
                wp_enqueue_style( 'mm-trans', $assets . 'elements/owl-carousel/owl.transitions.css' );
                wp_enqueue_script( 'mm-carousel-js', $assets . 'elements/owl-carousel/owl.carousel.min.js', null, '1.0.0', TRUE );

            }

            wp_enqueue_style( 'mm-shortcode', $assets . 'css/shortcode.css');
            /* snow */
            wp_enqueue_script( 'mm-fallingsnow-js', $assets . 'elements/bg/fallingsnow_v6.js', null, '1.0.0', TRUE );
        }
        /**
         * add back-end script.
         *
         * @since 1.0.0
         *
         * @uses wp_enqueue_style() load styles.
         * @uses wp_enqueue_script() load scripts.
         */
        function mymaps_add_admin_scripts()
        {
            $screen = get_current_screen();

            $this -> slug_name = strtolower( $this -> pl_name );
            $this -> slug_name = explode( ' ', $this -> slug_name );
            $this -> slug_name = implode( '-', $this -> slug_name );
            /* map post */
            if (isset($screen->id) && $screen->id == $this -> slug_name . '_page_map-post')
            {
                wp_enqueue_script("jquery");
                wp_enqueue_style('admin.css',  $this -> assets . 'css/admin.css');
                wp_enqueue_script('googlemap-script', 'https://maps.googleapis.com/maps/api/js?v=3.21&sensor=false&libraries=weather,places', null, '1.0.0', TRUE);
                /* Style panel script */

                wp_enqueue_script('admin.st.script', $this -> assets . 'js/st.admin.js', null, '1.0.2', TRUE);
                wp_localize_script('admin.st.script', 'ajax_data', $this -> get_ajax_data());
                wp_enqueue_script('admin.st.script');
                wp_enqueue_script('admin.mk.script', $this -> assets . 'js/mk.admin.js', null, '1.0.0', TRUE);
                wp_localize_script('admin.mk.script', 'ajax_data', $this -> get_ajax_data());
                wp_enqueue_script('admin.mk.script');

                wp_enqueue_script('admin.dr.script', $this -> assets . 'js/dr.admin.js', null, '1.0.0', TRUE);
                wp_enqueue_script('gnr.admin.script',$this -> assets . 'js/gnr.admin.js', null, '1.0.0', TRUE);

                wp_enqueue_style('font-awesome', $this -> assets . 'css/font-awesome.min.css');
                wp_enqueue_style('elm-accordion', $this -> assets . 'elements/accordion/css/style.css');
                wp_enqueue_script('elm-accordion-scr', $this -> assets . 'elements/accordion/js/modernizr.custom.29473.js', null, '1.0.0', TRUE);
                /* Minicolors */
                wp_enqueue_script('elm-tinycolor', $this -> assets . 'elements/colorpicker/tinycolor.js', null, '1.0.0', TRUE);
                wp_enqueue_style('elm-colorpicker', $this -> assets . 'elements/colorpicker/jquery.colorpickersliders.css');
                wp_enqueue_script('elm-colorpicker-scr', $this -> assets . 'elements/colorpicker/jquery.colorpickersliders.js', null, '1.0.0', TRUE);
                /* flip panel*/
                wp_enqueue_style('elm-flpanel', $this -> assets . 'elements/panel/flpanel.css');
                /* draw panel */
                wp_enqueue_style('elm-slider', $this -> assets . 'elements/slider/jquery.mobile-1.4.5.min.css');
                wp_enqueue_script('elm-slider-script', $this -> assets . 'elements/slider/jquery.mobile-1.4.5.min.js', null, '1.0.0', TRUE);
                /* notification*/
                wp_enqueue_style('elm-notifi', $this -> assets . 'elements/notification/jquery.growl.css');
                wp_enqueue_script('elm-notifi-script', $this -> assets . 'elements/notification/jquery.growl.js', null, '1.0.0', TRUE);
                /* helper */
                wp_enqueue_script('elm-helper', $this -> assets . 'js/helper.js', null, '1.0.0', TRUE);
            }
            /* map list */
            if (isset($screen->id) && $screen->id == 'toplevel_page_' . $this -> slug_name . '-main-menus')
            {
                wp_enqueue_script("jquery");
                wp_enqueue_style('font-awesome', $this -> assets . 'css/font-awesome.min.css');
                wp_enqueue_style('common', $this -> assets . 'css/common.css');
                wp_enqueue_style('map-list', $this -> assets . 'css/list.css');

                wp_enqueue_script('list.admin.script', $this -> assets . 'js/list.admin.js', null, '1.0.0', TRUE);
                wp_localize_script('list.admin.script', 'ajax_data', $this -> get_ajax_data());
                wp_enqueue_script('list.admin.script');

                /* notification*/
                wp_enqueue_style('elm-notifi', $this -> assets . 'elements/notification/jquery.growl.css');
                wp_enqueue_script('elm-notifi-script', $this -> assets . 'elements/notification/jquery.growl.js', null, '1.0.0', TRUE);

                /* helper */
                wp_enqueue_script('elm-helper', $this -> assets . 'js/helper.js', null, '1.0.0', TRUE);
            }
            /* Backup page */
            if (isset($screen->id) && $screen->id == $this -> slug_name . '_page_import-export')
            {
                /* get map data */
                $options = get_option('mymaps_options');

                if( function_exists('content_url') ) {
                    $options['_host_'] = content_url();
                } else {
                    $options['_host_'] =  plugins_url('../../',__FILE__);
                }
                $options['_nonce_'] = $this -> get_ajax_data();
                wp_enqueue_script("jquery");
                wp_enqueue_script('ex-im.admin', $this -> assets . 'js/ex-im.admin.js', null, '1.0.0', TRUE);
                wp_localize_script('ex-im.admin', 'mapData', $options);
                wp_enqueue_script('ex-im.admin');
                wp_enqueue_style('admin.css',  $this -> assets . 'css/admin.css');

                /* flip panel*/
                wp_enqueue_style('font-awesome', $this -> assets . 'css/font-awesome.min.css');
                wp_enqueue_style('common', $this -> assets . 'css/common.css');
                wp_enqueue_style('map-list', $this -> assets . 'css/list.css');

                /* notification*/
                wp_enqueue_style('elm-notifi', $this -> assets . 'elements/notification/jquery.growl.css', null, '1.0.0');
                wp_enqueue_script('elm-notifi-script', $this -> assets . 'elements/notification/jquery.growl.js', null, '1.0.0', TRUE);

                /* Jquery upload */
                wp_enqueue_style('elm-bootstrap', $this -> assets . 'elements/upload/bootstrap.min.css', null, '1.0.0');
                wp_enqueue_style('elm-fileupload', $this -> assets . 'elements/upload/jquery.fileupload.css', null, '1.0.0');
                wp_enqueue_script('elm-ui-widget', $this -> assets . 'elements/upload/jquery.ui.widget.js', null, '1.0.0', TRUE );
                wp_enqueue_script('elm-iframe-transport', $this -> assets . 'elements/upload/jquery.iframe-transport.js', null, '1.0.0', TRUE );
                wp_enqueue_script('elm-fileupload-script', $this -> assets . 'elements/upload/jquery.fileupload.js', null, '1.0.0', TRUE );

                /* helper */
                wp_enqueue_script('elm-helper', $this -> assets . 'js/helper.js', null, '1.0.0', TRUE);
            }
        }
        /**
         * add front-end script.
         *
         * @since 1.0.0
         *
         * @uses wp_enqueue_style() load styles.
         * @uses wp_enqueue_script() load scripts.
         */
        function mymaps_add_scripts_method()
        {
        }
        /*
         * Add custom options
         *
         * @since 1.0.0
         */
        function mymaps_add_options()
        {
            if( !get_option('mymaps_options') )
            {
                $new_options['_mystyles_'] = '';
                $new_options['_map_posts_'] = '';
                $new_options['_icons_'] = '';
                add_option('mymaps_options', $new_options);
            }
        }
    }

    /**
     * The main function responsible for returning the one true rlProducts Instance
     * to functions everywhere.
     *
     * Use this function like you would a global variable, except without needing
     * to declare the global.
     *
     *
     * @return The one true rlProducts Instance
     */

    if (! function_exists('declare_mymaps') )
    {
        function declare_mymaps()
        {
            return myMaps::instance();
        }
    }

    /**
     * Hook declare_mymaps early onto the 'plugins_loaded' action.
     *
     * This gives all other plugins the chance to load before myMaps, to get their
     * actions, filters, and overrides setup without tabCarousel being in the way.
     */
    if (defined('MYMAPS_LATE_LOAD'))
    {
        add_action('plugins_loaded', 'declare_mymaps', (int) MYMAPS_LATE_LOAD);
    } else {
        declare_mymaps();
    }
    if( class_exists('WPBakeryShortCode') ) {
        class WPBakeryShortCode_Bartag extends WPBakeryShortCode {
        }
    }
    if( class_exists('WP_Widget') ) {
        class Flexmap_Widgets extends WP_Widget {
            function __construct () {
                parent::__construct(
                    'flexmap_widgets',
                    'Flex Map',
                    array( 'description' =>
                        'Displays flex map post' )
                );
            }
            function form( $instance ) {
            // Retrieve previous values from instance
            //    // or set default values if not present
            $render_widget = ( !empty( $instance['render_widget'] ) ?
                $instance['render_widget'] : 'true' );

                $options = get_option('mymaps_options');
                $options  = $options['_map_posts_'];

                ?>
                <!-- Display fields to specify title and item count -->
                <p>
                    <label for="<?php echo $this->get_field_id( 'render_widget' ); ?>">
                        <?php echo 'Maps'; ?>
                        <select id="<?php echo $this->get_field_id( 'render_widget' ); ?>"
                                name="<?php echo $this->get_field_name( 'render_widget' );?>">
                            <?php
                            if( is_array($options) && count($options) > 0 ) :
                                foreach( $options as $key => $value ) :
                                    $general = json_decode($value['general']);
                                ?>
                                <option value="<?php echo $key; ?>"
                                    <?php selected( $render_widget, $key ); ?>>
                                    <?php echo $general -> name . ' - ' . '[flexmap id="' . $key . '"]' ?></option>
                            <?php
                                endforeach;
                              endif;
                            ?>
                        </select>
                    </label>
                </p>

            <?php }
            function widget( $args, $instance ) {
                if ( $instance['render_widget'] != '' ) {
                    $map_id = (int) $instance['render_widget'];
                    $map_id = "[flexmap id='" . $map_id . "']";
                    echo do_shortcode($map_id);
                }
            }
        }
    }

}
