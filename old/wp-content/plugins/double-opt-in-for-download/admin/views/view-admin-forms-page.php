<div class = "wrap">

    <h2 style="margin-bottom: 25px;">Forms Page</h2>
   
     <div id="tabs">
        
        <ul>
            <li><h3><a href="#tabs-1"><?php echo __( 'Forms', $this->plugin_slug ) ; ?></a></h3></li>
        </ul>
        
        <div id="tabs-1">
        <a href='admin.php?page=doifd-admin-menu_manage_forms&task=Create Form&type=Form&buttoncmd=createForm&nonce=doifd-add-form-nonce&buttonTxt=Create Form'  class='button-primary' >Add Form</a>
    <?php
        
    if( class_exists( 'DOIFDPremiumFormTable' ) ) {
        
        $dfdFormTable = new DOIFDPremiumFormTable();
        
    } else {
        
        $dfdFormTable = new DOIFDAdminFormTable();
    }

    $dfdFormTable->prepare_items();
    echo '<form method="get" >';
    echo '<input type="hidden" name="page" value="' . $_REQUEST[ 'page' ] . '" />';
    if( class_exists( 'DOIFDPremiumSubscriberTable' ) ) {
    $dfdFormTable->search_box('search', 'search_id');
    }
    $dfdFormTable->display(); 

    ?>
        </form>
        </div>
     </div>

</div>

