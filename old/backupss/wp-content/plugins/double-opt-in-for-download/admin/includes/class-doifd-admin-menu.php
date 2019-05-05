<?php

class DOIFDAdminMenu extends DOIFDAdmin {
    
    public function __construct() {
        parent::__construct();

        // Adds the plugin menu
        add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

        // Removes the DOIFD from the sub menu
        add_action( 'admin_menu', array( $this, 'adjust_the_doifd_menu' ), 999 );

        add_action( 'admin_menu', array( $this, 'doifd_support_sub_menu' ) );
        add_action( 'admin_menu', array( $this, 'doifd_get_premium_sub_menu' ) );
    }

    public function add_plugin_admin_menu() {

        if( !is_admin() ) {
            return null;
        }

            $loadmenu = new DOIFDAdminMenuWorker();
            $loadmenu->pluginAdminMenu();
    
    }

    public function adjust_the_doifd_menu() {

        $page = remove_submenu_page( 'doifd-admin-menu', 'doifd-admin-menu' );
    }

    function doifd_support_sub_menu() {

        if( !current_user_can( 'install_plugins' ) ) {
            return null;
        }

        global $submenu;

        $url = 'http://www.doubleoptinfordownload.com/';

        $submenu[ 'doifd-admin-menu' ][ ] = array( '<div id="doifd-support">' . __( 'Support', 'double-opt-in-for-download' ) . '</div>', 'install_plugins', $url );
    }

    /* Adds Support to DOIFD sub menu with link that goes to DOIFD Website */

    function doifd_get_premium_sub_menu() {

        if( !current_user_can( 'install_plugins' ) ) {
            return null;
        }

        global $submenu;

        $url = 'http://www.doubleoptinfordownload.com/premium-double-opt-in-for-download/';

        $submenu[ 'doifd-admin-menu' ][ ] = array( '<div id="doifd-premium">' . __( 'Get Premium Version', 'double-opt-in-for-download' ) . '</div>', 'install_plugins', $url );
    }

}

new DOIFDAdminMenu();

class DOIFDAdminMenuWorker extends DOIFDAdmin {
    
    public function __construct() {
        parent::__construct();
    }

    public function pluginAdminMenu() {
        
        global $doifdPages;

        $doifdPages[] = add_menu_page(
                'doifd-admin-menu', __( 'DOIFD', $this->plugin_slug ), 'install_plugins', 'doifd-admin-menu', array( $this, 'doifd_settings_page' ) );

        //create sub menu page for downloads
        $doifdPages[] = add_submenu_page(
                'doifd-admin-menu', 'doifd downloads', apply_filters( 'doifd_download_menu_title', __( 'Downloads', $this->plugin_slug ) ), 'install_plugins', 'doifd-admin-menu_downloads', array( $this, 'doifd_download_page' ) );
        
         //create sub menu page for expansion plugins
        $doifdPages[] = add_submenu_page(
                'doifd-admin-menu', 'Expansions', __( 'Expansion Plugins', $this->plugin_slug ), 'install_plugins', 'doifd-admin-menu_expansions', array( $this, 'doifd_expansions_page' ) );
        
        //create sub menu page for forms
        $doifdPages[] = add_submenu_page(
                'doifd-admin-menu', 'Forms', __( 'Forms', $this->plugin_slug ), 'install_plugins', 'doifd-admin-menu_forms', array( $this, 'doifd_forms_page' ) );

        //create sub menu page for settings page
        $doifdPages[] = add_submenu_page(
                'doifd-admin-menu', 'Settings', apply_filters( 'doifd_download_settings_title', __( 'Settings', $this->plugin_slug ) ), 'install_plugins', 'doifd-admin-menu_settings', array( $this, 'doifd_settings_page' ) );

        //create sub menu page for subscribers
        $doifdPages[] = add_submenu_page(
                'doifd-admin-menu', 'doifd subscribers', __( 'Subscribers', $this->plugin_slug ), 'install_plugins', 'doifd-admin-menu_subscribers', array( $this, 'doifd_subscribers_page' ) );
        
        if(has_filter('doifd_license_keys')) {
        $doifdPages[] = add_submenu_page (
                'doifd-admin-menu', 'Licenses', __ ( 'Licenses', $this->plugin_slug ), 'install_plugins', 'doifd-admin-menu_licnese', array( $this, 'doifd_license_page' ) );
        }
        
        //create sub menu page to edit downloads
        $doifdPages[] = add_submenu_page(
                '', 'manage download', '', 'install_plugins', 'doifd-admin-menu_manage_download', array( $this, 'doifd_manage_download_page' ) );
        
        //create sub menu page to edit downloads
        $doifdPages[] = add_submenu_page(
                '', 'manage forms', '', 'install_plugins', 'doifd-admin-menu_manage_forms', array( $this, 'doifd_manage_forms_page' ) );
        
    }
    
    public function doifd_license_page() {
        include_once( DOIFD_DIR . 'admin/views/view-admin-license-page.php' );
    }
    
     public function doifd_download_page() {
        include_once( DOIFD_DIR . 'admin/views/view-admin-download-page.php' );
    }

    public function doifd_subscribers_page() {
        include_once( DOIFD_DIR . 'admin/views/view-admin-subscribers-page.php' );
    }
    
    function doifd_forms_page() {
        include_once ( DOIFD_DIR . '/admin/views/view-admin-forms-page.php' );
    }

    public function doifd_settings_page() {

        include_once ( DOIFD_DIR . '/admin/views/view-admin-settings.php' );
               
       if(isset($_GET['settings-updated']) && $_GET['settings-updated']== 'true') {
       $createCSS = new DOIFDCustomCSS;
       $createCSS->createLegacyFormCSS();
       $createCSS->createLegacyWidgetFormCSS();
       
       }
    }
    
    public function doifd_manage_download_page() {

        include_once ( DOIFD_DIR . '/admin/views/view-admin-manage-download.php' );
    }
    
    public function doifd_manage_forms_page() {

        include_once ( DOIFD_DIR . '/admin/views/view-admin-manage-forms.php' );
    }
    
    public function display_plugin_admin_page() {
        include_once( 'views/admin.php' );
    }
    
    function doifd_expansions_page() {
        include_once ( DOIFD_DIR . '/admin/views/view-admin-expansion-page.php' );
    }

}
new DOIFDAdminMenuWorker();
