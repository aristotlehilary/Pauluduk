<div class="wrap">
    
    <h2>DOIFD Licenses</h2>

    <?php
    
    if(has_filter('doifd_license_keys')) {
        $licenses = '<p>You are currently using the Free Version(s) of DOIFD - No Licenses needed at this time.</p>';
        $licenses = apply_filters('doifd_license_keys', $licenses);
    } else {
        echo '<p>You are currently using the Free Version(s) of DOIFD - No Licenses needed at this time.</p>';
    }
    
    ?>
        
</div>

