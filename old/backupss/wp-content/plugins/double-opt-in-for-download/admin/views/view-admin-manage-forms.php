<div class = "wrap">
    <h2><?php echo $_GET[ 'task' ]; ?></h2>

    <div id="doifdAdminDownloadForm">
        <form id="doifdManageForms" name="doifdManageForms" method="post" action="" enctype="multipart/form-data" >
            <input type="hidden" name="_wpnonce" id="_wpnonce" value="<?php
            $doifd_lab_nonce = wp_create_nonce( $_GET[ 'nonce' ] );
            echo $doifd_lab_nonce; ?>"/>
            <input type="hidden" name="formID" id="formID" value="<?php if (isset($_GET[ 'formID' ])) { echo $_GET[ 'formID' ]; } ?>"
            

         <div id="formCreation"><!-- Beginning of Form Creation Section-->
             
            <div id="doifdDownloadFormTabs"><!-- Beginning of Tabs Section-->
                
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
                <div style="text-align: center; clear: both;">
                <input class='button-primary doifd_button' name="<?php echo $_GET[ 'buttoncmd' ]; ?>" id="<?php echo $_GET[ 'buttoncmd' ]; ?>" type="submit" value="<?php echo $_GET[ 'buttonTxt' ]; ?>">
            </div>
            </div><!-- END div for form creation section-->
            
            
        </form>

        <?php include_once( DOIFD_DIR . 'admin/includes/upload-form-fields/class-doifd-admin-tool-tips.php'); ?>
    
</div>
            
 