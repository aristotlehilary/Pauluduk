<?php
function fl_header( $page_name ) {
?>
    <br clear="all"/>
    <link rel="shortcut icon" href="<?php echo plugins_url('../../img/icon-lage.png', __FILE__); ?>" />
    <div class="map-banner">
        <div class="inner-banner">
            <div class="logo-container">
                <div class="logo-wrapper">
                    <img src="<?php echo plugins_url('../../img/icon-lage.png', __FILE__); ?>" alt="Flex GMap"/>
                </div>
            </div>
            <div class="logo-text">
                <div class="inner-text">
                    <span class="name">Flex Map</span>
                    <span class="state"> - <?php echo $page_name; ?></span>
                </div>
            </div>
            <br clear="all"/>
        </div>
    </div>
<?php
}