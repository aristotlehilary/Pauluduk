<?php

    class DOIFDAdminCSV extends DOIFD {

        public function __construct() {
   

            add_action ( 'admin_init', array( $this, 'csv_download' ) );
        }

        public function csv_download() {

            global $wpdb;

            /* Check if it's coming from the download subsribers button and the user has privileges */

            if ( isset ( $_POST[ 'doifd_lab_export_csv' ] ) && ( current_user_can ( 'manage_options' ) ) ) {

                /* See if admin wants all emails or just verified, and sanitize it. */

                $value = preg_replace ( '/[^0-9]/', '', $_POST[ 'csv_option' ] );
                
                if (isset($_POST['download'])) {
                    $download = preg_replace ( '/[^0-9]/', '', $_POST[ 'download' ] );
                } else {
                    $download = '';
                }

                /* Check the value and make it MYSQL friendly. Send Error Message if there is no value. */

                if ( $value == '0' ) {

                    $value = '0 or 1';
                    
                } elseif ( $value == '1' ) {

                    $value = '(1)';
                    
                } else {

                    $text = __ ( 'Nothing was selected.', 'double-opt-in-for-download' );

                    return '<div id="message" class="error"><p><strong>' . $text . '</p></strong></div>';
                }

                if ( isset ( $_POST[ 'dupe' ] ) && $_POST[ 'dupe' ] == '1' ) {

                    $dupe = 'GROUP BY doifd_email';
                } else {

                    $dupe = '';
                }

                /* Create name for file "Website Name-Subscribers-Date" */

                $fileName = '"' . get_bloginfo ( 'name' ) . '-Subscribers-' . date ( 'Y-m-d' ) . '.csv"';

                /* Header for download */

                header ( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
                header ( 'Content-Description: File Transfer' );
                header ( "Content-type: text/csv" );
                header ( "Content-Disposition: attachment; filename=" . $fileName . "" );
                header ( "Expires: 0" );
                header ( "Pragma: public" );

                /* Create file */

                $fh = @fopen ( 'php://output', 'w' );

                /* Query database for list of subscribers. Only pull verified email addresses
                 * and don't include duplicates.
                 */

                $sql = "SELECT {$wpdb->prefix}doifd_lab_subscribers.doifd_name AS Name,
                    {$wpdb->prefix}doifd_lab_subscribers.doifd_email AS Email,
                    {$wpdb->prefix}doifd_lab_downloads.doifd_download_name AS Download_Name,
                    {$wpdb->prefix}doifd_lab_subscribers.doifd_subscriber_ip AS IP_Address,
                    {$wpdb->prefix}doifd_lab_subscribers.time AS Date                 
                FROM {$wpdb->prefix}doifd_lab_subscribers
                LEFT JOIN {$wpdb->prefix}doifd_lab_downloads
                ON {$wpdb->prefix}doifd_lab_downloads.doifd_download_id = {$wpdb->prefix}doifd_lab_subscribers.doifd_download_id
                WHERE doifd_email_verified = $value
                $dupe";

                $results = $wpdb->get_results( $sql, ARRAY_A );

                $headerDisplayed = false;

                foreach ( apply_filters('doifd_pre_csv_data', $results, $value, $dupe, $download) as $data ) {

                    /* Add header rows if not already displayed */

                    if ( ! $headerDisplayed ) {

                        /* Use the keys from $data as the titles */

                        fputcsv ( $fh, array_keys ( $data ) );

                        $headerDisplayed = true;
                    }

                    /* Put the data into the file */

                    fputcsv ( $fh, $data );
                }

                /* Close the file */

                fclose ( $fh );

                /* Make sure nothing else is sent, our file is done */

                exit;
            }
        }
        
    public function csvSelectForm() {
    
    $html = '';
    $html .= '<p>' . __( "Download all emails or just verfied emails.", $this->plugin_slug ) . '</p>';
    $html .= '<form method="post" action="" enctype="multipart/form-data">';
    $html .= '<select name="csv_option">';
    $html .= '<option value="0">' . __( "All Emails", $this->plugin_slug ) . '</option>';
    $html .= '<option value="1">' . __( "Only Verified Emails", $this->plugin_slug ) . '</option>';
    $html .= '</select><br />';
    $html .= '<br />';
    $html .= '<input type="checkbox" name="dupe" value="1">' . __( "Remove duplicate emails.", $this->plugin_slug );
    $html .= '<br />';
    $html .= '<br />';
    $html .= '<input class="button-primary" name="doifd_lab_export_csv" id="doifd_lab_export_csv" type="submit" value="' . __( "Download Subscribers (csv)", $this->plugin_slug ) . '">';
    $html .= '</form>';

    echo apply_filters( 'doifd_csv_form', $html );
    
    }

}
new DOIFDAdminCSV();