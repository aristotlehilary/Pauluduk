<div class = "wrap">
    
    <h2 style="margin-bottom: 25px;">Subscribers Page</h2>

     <div id="tabs">
        <ul>
            <li><h3><a href="#tabs-1"><?php echo apply_filters( 'doifd_subscriber_table_title', __( 'Subscribers', $this->plugin_slug ) ); ?></a></h3></li>
        </ul>
        <div id="tabs-1">
    <?php
        
    if( class_exists( 'DOIFDPremiumSubscriberTable' ) ) {
        
        $dfdSubscriberTable = new DOIFDPremiumSubscriberTable();
        
    } else {
        
        $dfdSubscriberTable = new DOIFDAdminSubscriberTable();
    }

    $dfdSubscriberTable->prepare_items();
    echo '<form method="get" >';
    echo '<input type="hidden" name="page" value="' . $_REQUEST[ 'page' ] . '" />';
    if( class_exists( 'DOIFDPremiumSubscriberTable' ) ) {
    $dfdSubscriberTable->search_box('search', 'search_id');
    }
    $dfdSubscriberTable->display(); 

    ?>
        </form>
        </div>
     </div>
 
    <a href="#" id="doifdCSVModal" class="button button-primary" >Download Subscribers (CSV)</a>
    
    <div id="doifdCSVForm" style="display: none">

        <?php 
            $csvForm = new DOIFDAdminCSV();
            $csvForm->csvSelectForm();
            ?>
        
    </div>

</div>