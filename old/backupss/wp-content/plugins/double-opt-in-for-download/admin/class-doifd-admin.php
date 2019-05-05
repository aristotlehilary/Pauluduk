<?php

        require_once( DOIFD_DIR . 'admin/includes/class-doifd-list-table.php' );
        require_once( DOIFD_DIR . 'admin/includes/class-doifd-enqueue.php' );
        require_once( DOIFD_DIR . 'emails/class-doifd-email.php' );
        require_once( DOIFD_DIR . 'admin/includes/class-doifd-admin-menu.php' );
        require_once( DOIFD_DIR . 'admin/includes/class-doifd-admin-manage-downloads.php');
        require_once( DOIFD_DIR . 'admin/includes/class-doifd-admin-manage-subscribers.php');
        require_once( DOIFD_DIR . 'admin/includes/class-doifd-admin-manage-forms.php');
        require_once( DOIFD_DIR . 'admin/includes/class-doifd-admin-general-settings.php' );
        require_once( DOIFD_DIR . 'admin/includes/class-doifd-admin-validation.php' );
        require_once( DOIFD_DIR . 'admin/includes/class-doifd-admin-email-settings.php' );
        require_once( DOIFD_DIR . 'admin/includes/class-doifd-admin-legacy-form-settings.php' );
        require_once( DOIFD_DIR . 'admin/includes/class-doifd-admin-widget-settings.php' );
        require_once( DOIFD_DIR . 'admin/includes/class-doifd-admin-custom-css-settings.php' );
        require_once( DOIFD_DIR . 'admin/includes/class-admin-csv.php');
        require_once( DOIFD_DIR . 'admin/includes/class-doifd-admin-messages.php');
        require_once( DOIFD_DIR . 'admin/includes/class-doifd-admin-download-table.php');
        require_once( DOIFD_DIR . 'admin/includes/class-doifd-admin-form-table.php');
        require_once( DOIFD_DIR . 'admin/includes/class-doifd-admin-list-table.php');
        require_once( DOIFD_DIR . 'admin/includes/class-doifd-admin-subscriber-table.php');
        require_once( DOIFD_DIR . 'admin/includes/upload-form-fields/class-doifd-admin-upload-form-fields.php');
        require_once( DOIFD_DIR . 'admin/includes/upload-form-fields/class-doifd-admin-create-form-fields.php');
        

class DOIFDAdmin extends DOIFD {

    protected static $instance = null;

    public function __construct() {
        parent::__construct();
        
        
    }
    
    public static function get_instance() {

        if( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }
    
    public function get_options() {

        $this->doifd_options = get_option( 'doifd_lab_options' );

        return $this->doifd_options;
    }

}
new DOIFDAdmin();