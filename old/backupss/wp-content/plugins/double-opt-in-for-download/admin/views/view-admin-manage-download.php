<div class = "wrap">
    <?php
    if( isset( $_GET[ 'msg' ] ) ) {
        echo $_GET[ 'msg' ];
    }

    ?>

    <h2><?php echo $_GET[ 'task' ]; ?></h2>

    <div id="doifdAdminDownloadForm"> <!--div for entire form-->
        
        <!-- Begin Form-->
        
        <form id="doifdManageForms" name="doifdManageForms" method="post" action="" enctype="multipart/form-data" >
        
        <div id="downloadFields" > <!--div for download fields to show/hide-->
            
            <!-- Begin Hidden Input Fields-->
            
             <?php 
                    if(  class_exists( 'DOIFDPremiumAdminUploadFormFields' )) {
                         $formFields = new DOIFDPremiumAdminUploadFormFields;
                         $formFields->hiddenFields();
                    } else {
                        $formFields = new DOIFDAdminUploadFormFields;
                        $formFields->hiddenFields();
                    }
                  ?>
            
            <!-- END Hidden Input Fields-->
            
            <?php $formFields->generateUploadFields(); ?>
            
        </div><!--END div for download fields to show/hide-->
            
         <div id="formCreation"><!-- Beginning of Form Creation Section-->
             
            <div id="doifdDownloadFormTabs"><!-- Beginning of Tabs Section-->
                
                <h1><?php _e( 'Create Form', $this->plugin_slug ); ?></h1>

                <?php 
                    if(  class_exists( 'DOIFDPremiumAdminCreateFormFields' )) {
                         $formFields = new DOIFDPremiumAdminCreateFormFields;
                         $formFields->generateFormFields();
                    } else {
                        $formFields = new DOIFDAdminCreateFormFields;
                        $formFields->generateFormFields();
                    }
                  ?>
                
                    <!--Beginning of tabs header-->

                    <ul>
                        <li><h3><a href="#tabs-1"><?php echo apply_filters( 'doifd_download_table_title', __( 'Form Options', 'double-opt-in-for-download' ) ); ?></a></h3></li>
                        <li><h3><a href="#tabs-2"><?php echo apply_filters( 'doifd_download_table_title', __( 'Advanced Styling', 'double-opt-in-for-download' ) ); ?></a></h3></li>
                    </ul>
                    
                    <!--END of tabs header-->

                    <div id="tabs-1"><!-- Beginning of Tabs 1 section-->
                        
                        <?php 
                        
                        $formFields->generateFormOptions();

                        ?>
                    
                    </div><!-- END of Tabs 1 section-->
                    
                    <div id="tabs-2"><!-- Beginning of Tabs 2 section-->
                        
                        <?php 
                        
                        $formFields->generateFormAdvancedOptions();
                        
                        ?>
                    </div> <!-- END div for tabs 2 section-->
                </div><!-- END div for tabs section-->
            </div><!-- END div for form creation section-->
            <div style="text-align: center; clear: both;">
                <input class='button-primary' name="<?php echo $_GET[ 'buttoncmd' ]; ?>" id="<?php echo $_GET[ 'buttoncmd' ]; ?>" type="submit" value="<?php echo $_GET[ 'buttonTxt' ]; ?>">
            </div>

        </form>

    </div><!-- End doifddownloadform div-->
    
    <?php include_once( DOIFD_DIR . 'admin/includes/upload-form-fields/class-doifd-admin-tool-tips.php'); ?>

</div> <!-- END div for entire form-->