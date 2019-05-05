<?php

class DOIFDAdminManageForms extends DOIFDAdmin {

    public function __construct() {
        parent::__construct();

        add_action( 'admin_init', array( $this, 'addForm' ) );
        add_action( 'admin_init', array( $this, 'editForm' ) );
    }

    public function editForm() {

        global $wpdb;

        if( isset( $_POST[ 'update_form' ] ) ) {

            /* Clean the values */
            $clean = new DOIFDAdminValidation;
            $valid = $clean->cleanFormAddEditFields( $_POST );

            $updateFormValues = array(
                'doifd_name' => $valid[ 'formName' ],
                'doifd_download_form' => base64_encode(serialize( $valid ))
            );

            $updateFormFormats = array(
                '%s', // value1
                '%s' // value2
            );

            $wpdb->update( $wpdb->prefix . 'doifd_lab_forms', $updateFormValues, array( 'doifd_form_id' => $valid[ 'formID' ] ), $updateFormFormats, array(
                '%d' )
            );

            /* Update the CSS file for this form */
            $createCSS = new DOIFDCustomCSS;
            $createCSS->createCustomCSSFile( $valid, $valid[ 'formID' ] );
        }
    }
    
    public function getDownloadData($value) {
        global $wpdb;
        $sql1 = "SELECT * FROM " . $wpdb->prefix . "doifd_lab_downloads WHERE doifd_download_id=" . $value . "";
        $data = $wpdb->get_row( $sql1, ARRAY_A );
        return $data;
        
    }
    
    public function areThereForms() {
        global $wpdb;
        $formResults = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}doifd_lab_forms", OBJECT );
        return $formResults;
    }
    
    public function getDownloadIDFormValues($value) {
        global $wpdb;
        
        $sql1 = "SELECT * FROM " . $wpdb->prefix . "doifd_lab_downloads WHERE doifd_download_id=" . $value . "";
        $data = $wpdb->get_row( $sql1, ARRAY_A );
        
            /* Put this into a function???? Gets a listing of the forms for a dropdown menu */
            $sql2 = $wpdb->prepare( "SELECT
                doifd_download_form
                FROM
                {$wpdb->prefix}doifd_lab_forms WHERE doifd_form_id = %s", $data[ 'doifd_download_form' ] );

            $formStyleData = $wpdb->get_row( $sql2, ARRAY_A );
            if( !empty( $formStyleData ) ) {
                $formStyles = unserialize(base64_decode( $formStyleData['doifd_download_form'] ));
            } else {
                $formStyles = '';
            }
        
        return $formStyles;
    }
    
    public function getFormIDValues($value) {
            global $wpdb;
            /* Put this into a function???? Gets a listing of the forms for a dropdown menu */
            $sql2 = $wpdb->prepare( "SELECT
                doifd_download_form
                FROM
                {$wpdb->prefix}doifd_lab_forms WHERE doifd_form_id = %s", $value );

            $formStyleData = $wpdb->get_row( $sql2, ARRAY_A );
            if( !empty( $formStyleData ) ) {
                $formStyles = unserialize(base64_decode( $formStyleData['doifd_download_form'] ) );
            } else {
                $formStyles = '';
            }
            
            return $formStyles;
    }

    public function addForm() {

        global $wpdb;

        if( isset( $_POST[ 'createForm' ] ) ) {

            /* Clean the values */
            $clean = new DOIFDAdminValidation;
            $valid = $clean->cleanFormAddEditFields( $_POST );

            $formValues = array(
                'doifd_name' => $valid[ 'formName' ],
                'doifd_download_form' => base64_encode(serialize( $valid )),
                'time' => current_time( 'mysql', 0 )
            );

            $formValues_formats = array(
                '%s'
            );

            $wpdb->insert( $wpdb->prefix . 'doifd_lab_forms', $formValues, $formValues_formats );



            $newFormID = $wpdb->insert_id;

            /* Create a css file for this form */
            $createCSS = new DOIFDCustomCSS;
            $createCSS->createCustomCSSFile( $valid, $newFormID );

            $editForm = urlencode( 'Edit Form' );

            wp_redirect( admin_url( sprintf( '/admin.php?page=doifd-admin-menu_manage_forms&formID="%s"&task="%s"&buttoncmd="%s"&nonce="%s"&buttonTxt="%s"', $newFormID, $editForm, "update_form", "doifd-edit-form-nonce", $editForm ), 'http' ), 301 );
        }
    }
    
    public function getFonts() {
        
        $fontFamilyArray = array(
            '' => 'Select Font',
            'georgia' => 'Georgia, serif',
            'Palatino' => 'Palatino Linotype, Book Antiqua, Palatino, serif',
            'Times' => 'Times New Roman, Times, serif',
            'ArialHelvetica' => 'Arial, Helvetica, sans-serif',
            'ArialBlack' => 'Arial Black, Gadget, sans-serif',
            'Comic' => 'Comic Sans MS, cursive, sans-serif',
            'Impact' => 'Impact, Charcoal, sans-serif',
            'Lucida' => 'Lucida Sans Unicode, Lucida Grande, sans-serif',
            'Tahoma' => 'Tahoma, Geneva, sans-serif',
            'Trebuchet' => 'Trebuchet MS, Helvetica, sans-serif;',
            'Verdana' => 'Verdana, Geneva, sans-serif',
            'Courier' => 'Courier New, Courier, monospace',
            'Lucida' => 'Lucida Console, Monaco, monospace'
            );
    
        return $fontFamilyArray;
    }

}

new DOIFDAdminManageForms;

