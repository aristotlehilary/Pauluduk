<?php

class DOIFDAdminUploadFormFields extends DOIFDAdmin {
    
    public $downloadid = '';
    public $data = array();
    
    public function __construct() {
        parent::__construct();
        
        $this->downloadid = $this->getDownloadID();
        $this->data = $this->getdownloadData();
    }

    public function getDownloadID() {
        if(isset($_GET[ 'doifdID' ])) {
            $id = $_GET[ 'doifdID' ];
        } else {
            $id = '';
        }
        return $id;
    }
    
    public function getdownloadData() {
        if(!empty($this->downloadid)){
        $formInfo = new DOIFDAdminManageForms();
        $data = $formInfo->getDownloadData( $this->downloadid );
        } else {
            $data = '';
        }
        return $data;
    }
    
    public function hiddenFields() {
        ?>

            <input type="hidden" name="doifd_download_id" id="doifd_download_id" value="<?php if( isset( $this->data[ 'doifd_download_id' ] ) ) echo $this->data[ 'doifd_download_id' ]; ?>" />
            <input type="hidden" name="doifd_form_id" id="doifd_form_id" value="<?php if( isset( $this->data[ 'doifd_download_form' ] ) ) echo $this->data[ 'doifd_download_form' ]; ?>" />
            <input type="hidden" name="doifd_download_name" id="doifd_download_name" value="<?php if( isset( $this->data[ 'doifd_download_name' ] ) ) echo $this->data[ 'doifd_download_name' ]; ?>" />
            <input type="hidden" name="doifd_download_file_name" id="doifd_download_file_name" value="<?php if( isset( $this->data[ 'doifd_download_file_name' ] ) ) echo $this->data[ 'doifd_download_file_name' ]; ?>" />
            <input type="hidden" name="max_upload_size" id="max_upload_size" value="<?php $max_size = wp_convert_hr_to_bytes( ini_get( 'upload_max_filesize' ) ); echo $max_size; ?>" />
            <input type="hidden" name="_wpnonce" id="_wpnonce" value="<?php $doifd_lab_nonce = wp_create_nonce( $_GET[ 'nonce' ] ); echo $doifd_lab_nonce; ?>"/>
            <input type="hidden" name="type" id="type" value="<?php if($_GET['type'] == 'List') { echo '1'; } else { echo '0'; } ?>" >
            <?php
            
    }
    
    public function downloadName() {
    
    ?>

     <fieldset id="doifdFieldset"><!-- Begin Name Your Download Fieldset-->
        <legend><?php _e( 'Name Your Download', $this->plugin_slug ); ?></legend>
            <div class="holder">
                <label for="download_name"><?php _e( 'Download Name', $this->plugin_slug ); ?></label>
                    <input type="text" name="download_name" id="download_name" size="30" value="<?php if( isset( $this->data[ 'doifd_download_name' ] ) ) echo $this->data[ 'doifd_download_name' ]; ?>"/>
                    <img class="ttdnh qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>">
            </div>
    </fieldset><!-- END Name Your Download Fieldset-->
            
    <?php     
    }
    
    public function mailListName() {
    
    ?>

     <fieldset id="doifdFieldset"><!-- Begin Name Your Download Fieldset-->
        <legend><?php _e( 'Name Your List', $this->plugin_slug ); ?></legend>
            <div class="holder">
                <label for="list_name"><?php _e( 'Mail List Name', $this->plugin_slug ); ?></label>
                    <input type="text" name="download_name" id="download_name" size="30" value="<?php if( isset( $this->data[ 'doifd_download_name' ] ) ) echo $this->data[ 'doifd_download_name' ]; ?>"/>
                    <img class="ttdnh qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>">
            </div>
    </fieldset><!-- END Name Your Download Fieldset-->
            
    <?php     
    }
    
    public function landingPage() {
        ?>
        <fieldset id="doifdFieldset"><!-- Begin Choose Your Landing Page Fieldset-->
                <legend><?php _e( 'Choose Your Landing Page', $this->plugin_slug ); ?></legend>
                <div class="holder">
                    <label for="doifd_download_landing_page"><?php _e( 'Select a Landing Page', $this->plugin_slug ); ?></label>

                    <?php
                    echo '<select name="doifd_download_landing_page" id="doifd_download_landing_page">';
                    echo "<option value=''>";
                    echo esc_attr( __( 'Select Landing Page', $this->plugin_slug ) );
                    echo '</option>';
                    $pages = get_pages();
                    foreach ( $pages as $page ) {
                        $option = '<option value="' . $page->ID . '" ' . (isset($this->data[ 'doifd_download_form' ]) && ($this->data[ 'doifd_download_landing_page' ] == $page->ID ) ? 'selected="selected"' : "") . '>';
                        $option .= $page->post_title;
                        $option .= '</option>';
                        echo $option;
                    }
                    echo '</select>';
                    echo '<img class="ttslph qmimg" src="' . DOIFD_URL . 'admin/assets/img/qm.png">';
//                echo '<p class="expl"><a href="http://www.doubleoptinfordownload.com/what-is-a-landing-page/" target="_blank" />' . __( 'What is a Landing Page?', $this->plugin_slug ) . '</a></p>';

                    ?>
                </div>
            </fieldset><!-- END Choose Your Landing Page Fieldset-->
            <?php
    }
    
    public function downloadFile() {
        ?>
            <fieldset id="doifdFieldset"><!-- Begin Attach Your Download Fieldset-->
                <legend><?php _e('Attach Your Download File', $this->plugin_slug ) ?></legend>
                <div class="holder">
                    <table>    
                        <tr>
                            <td><label for="userfile" ><?php _e( 'Select your download file', $this->plugin_slug ); ?></label></td>
                            <td><input type="file" name="userfile" id="userfile" size="50" value=""></td>
                            <td><img class="ttsdfh qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>"></td>
                        </tr>
                    </table>
                </div>
                <p style="text-align: center;">( Your PHP File Size Limit is: <?php echo ini_get('upload_max_filesize'); ?> | <a href="http://support.doubleoptinfordownload.com/support/solutions/articles/5000526383-my-download-is-larger-than-my-php-file-size-limit" target="new" >How can I get around my PHP File Size Limit?</a> )</p>
            </fieldset><!-- END Attach Your Download Fieldset-->      
        <?php
    }
    
    public function downloadForm() {
        
        $formInfo = new DOIFDAdminManageForms();
        $formResults = $formInfo->areThereForms();
        ?>
         <fieldset><!-- Begin Select a form Fieldset-->
                <legend><?php _e( 'Select a Form For this Download', $this->plugin_slug ); ?></legend>
                <input style="float: right;" class='button-primary' name="doifdCreateForm" id="doifdCreateForm" type="button" value="<?php echo $_GET[ 'formButtonCmd' ]; ?>">
                <div class="holder">
                    <label for="doifd_selected_form"><?php _e( 'Select A Form', $this->plugin_slug ); ?></label>
                    <?php
                    if( !empty( $formResults ) ) {
                        echo '<select name="doifd_selected_form" id="doifd_selected_form">';
                        echo "<option value=''>";
                        echo esc_attr( __( 'Select Form', $this->plugin_slug ) );
                        echo '</option>';
                        echo '<option value="0"' . (isset($this->data[ 'doifd_download_form' ]) && ($this->data[ 'doifd_download_form' ] == "0" ) ? 'selected="selected"' : "") . '>';
                        echo esc_attr( __( 'Use Legacy Form', $this->plugin_slug ) );
                        echo '</option>';
                        foreach ( $formResults as $form ) {
                            $option = '<option value="' . $form->doifd_form_id . '" ' . (isset($this->data[ 'doifd_download_form' ]) && ($this->data[ 'doifd_download_form' ] == $form->doifd_form_id ) ? 'selected="selected"' : "") . '>';
                            $option .= $form->doifd_name;
                            $option .= '</option>';
                            echo $option;
                        }
                        echo '</select>';
                        echo '<img class="ttsdfmh qmimg" src="' . DOIFD_URL . 'admin/assets/img/qm.png"><br />';
                        echo '<div id="fsha">';
                    } else {
                        echo _e("You have not created a form yet. Click the Create Form button to create your first form.", $this->plugin_slug );
                    }
                        

                    ?>
                    
                </div>
                </div>
            </fieldset><!-- End Select a form Fieldset-->   
        <?php
    }
    

    public function generateUploadFields() {
        
        if(isset($_GET['type']) && ($_GET['type'] == 'Download')) {
        $this->downloadName();
        } else {
            $this->mailListName();
        }
        $this->landingPage();
        if(isset($_GET['type']) && ($_GET['type'] == 'Download')) {
        $this->downloadFile();
        }
        $this->downloadForm();
        
    }
    
}