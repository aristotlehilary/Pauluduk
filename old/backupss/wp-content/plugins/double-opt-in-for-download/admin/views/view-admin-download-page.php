 <?php
        if( class_exists( 'DOIFDAWeberDownloadTable' ) ) {
            $dfdDownloadTable = new DOIFDAWeberDownloadTable();
            $dfdListTable = new DOIFDAWeberListTable();
        } elseif( (class_exists( 'DOIFDMailChimpSettings' )) && (class_exists( 'DOIFDConstantContactSettings' )) ) {
            $dfdDownloadTable = new DOIFDPremiumAdminDownloadTable();
            $dfdListTable = new DOIFDPremiumAdminListTable();  
        } elseif( (class_exists( 'DOIFDMailChimpSettings' )) && (!class_exists( 'DOIFDConstantContactSettings' )) ) {
            $dfdDownloadTable = new DOIFDMailchimpAdminDownloadTable();
            $dfdListTable = new DOIFDMailchimpAdminListTable();
        } elseif( (class_exists( 'DOIFDMailPoetDownloadTable' )) ) {
            $dfdDownloadTable = new DOIFDMailPoetDownloadTable();
            $dfdListTable = new DOIFDMailPoetListTable();
        } elseif( (class_exists( 'DOIFDMadMimiDownloadTable' )) ) {
            $dfdDownloadTable = new DOIFDMadMimiDownloadTable();
            $dfdListTable = new DOIFDMadMimiListTable();
        } else {
            $dfdDownloadTable = new DOIFDAdminDownloadTable();
            $dfdListTable = new DOIFDAdminListTable();
        }
?>

<div class="wrap">

    <?php if(isset($_GET['msg'])) { echo '<div id="message" class="updated"><p><strong>' . $_GET['msg'] . '</p></strong></div>' ;} ?>
    <h2 style="margin-bottom: 25px;">Downloads / Mailing Lists Page</h2>
    <div id="tabs">
        <ul>
            <li><h3><a href="#tabs-1"><?php echo apply_filters( 'doifd_download_table_title', __( 'Downloads', 'double-opt-in-for-download' ) ); ?></a></h3></li>
            <li><h3><a href="#tabs-2"><?php echo apply_filters( 'doifd_download_table_title', __( 'Mailing Lists', 'double-opt-in-for-download' ) ); ?></a></h3></li>
        </ul>
        <div id="tabs-1">
        <a href="admin.php?page=doifd-admin-menu_manage_download&task=Create Download&type=Download&buttoncmd=upload&nonce=doifd-add-download-nonce&formID=doifd_admin_download_form&buttonTxt=Create Download&formButtonCmd=Create Form"  class='button-primary' >Add Download File</a>

        <hr />

        <?php $dfdDownloadTable->prepare_items();

            echo '<form method="get" >';

            echo '<input type="hidden" name="page" value="' . $_REQUEST[ 'page' ] . '" />';

            $dfdDownloadTable->display();

            echo '</form>';

?>
        </div>
        <div id="tabs-2">
        <a href="admin.php?page=doifd-admin-menu_manage_download&task=Create Mailing List&type=List&buttoncmd=upload&nonce=doifd-add-download-nonce&formID=doifd_admin_download_form&buttonTxt=Create Mailing List&formButtonCmd=Create Form" class='button-primary' >Add Mailing List</a>

        <hr />

        <?php 
        
        $dfdListTable->prepare_items();
        $dfdListTable->display();
        
        ?>

        </div>
    </div> 
</div>