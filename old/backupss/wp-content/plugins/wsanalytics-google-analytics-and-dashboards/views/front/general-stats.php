<?php 

// View of General Statistics

function ws_include_general( $current, $stats) {
?>
<div class="WSAnalytics_popup" id="general">
  <div class="WSAnalytics_popup_header">
    <h4>General Statistics</h4>
    <span class="WSAnalytics_popup_clsbtn">&times;</span>
  </div>
  <div class="WSAnalytics_popup_body">
    <div class="table-responsive">
      <table class="WSAnalytics_table WSAnalytics_table_hover">
        <tbody>
          <tr>
            <th>SESSIONS</th>
            <td><?php echo number_format($stats->totalsForAllResults['ga:sessions']); ?></td>
          </tr> 
          <tr> 
            <th>USERS</th>
            <td><?php echo number_format($stats->totalsForAllResults['ga:users']); ?></td>
          </tr>
          <tr>
            
            <th style="min-width: 120px;">BOUNCE RATE</th>
            <td>
              <?php 
                  if ($stats->totalsForAllResults['ga:entrances'] <= 0) { ?>
                      0.00%
              <?php
                  }
                  else {
                        echo number_format(round(($stats->totalsForAllResults['ga:bounces'] / $stats->totalsForAllResults['ga:entrances']) * 100, 2), 2);
              ?>%                     
              <?php } ?>
            </td>
          </tr>
          <tr>
            <th style="min-width: 145px;">AVG TIME ON SITE</th>
            <td>
              <?php
                  if ($stats->totalsForAllResults['ga:sessions'] <= 0) {
              ?>
                    00:00:00
              <?php
                  } 
                  else {
              
                      echo $current->ws_pretty_time($stats->totalsForAllResults['ga:avgSessionDuration']);
              ?>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <th style="min-width: 130px;">AVERAGE PAGES</th>
            <td>
                <?php
                    if ($stats->totalsForAllResults['ga:sessions'] <= 0) {
                  ?>
                  0.00
                  <?php
                    } 
                    else {
                  ?>
                  <?php
                      echo number_format(round($stats->totalsForAllResults['ga:pageviews'] / $stats->totalsForAllResults['ga:sessions'], 2), 2);
                  ?>
                  <?php } ?>
            </td>
          </tr>
          <tr>
              <th style="min-width: 120px;">PAGE VIEWS</th>
              <td>
                <?php
                  if ($stats->totalsForAllResults['ga:pageviews'] <= 0) {
                ?>
                0
                <?php
                  } 
                  else {
                ?>
                <?php
                    echo $current->wws_number_format( $stats->totalsForAllResults['ga:pageviews'] );
                ?>
                <?php } ?>
              </td>
          </tr>
          <tr>
            <th style="min-width: 145px;">USER TYPE</th>
            <td>
               <?php 
                  if (isset($stats->totalsForAllResults))
                  {
                    $returning = $stats->totalsForAllResults['ga:sessions'] - $stats->totalsForAllResults['ga:newUsers'];
                ?>
                 New  (<?php echo $stats->totalsForAllResults['ga:newUsers'];?>)
                 Returning (<?php echo $returning;?>)
                <?php
                }
              ?> 
            </td>
        </tr>
        </tbody>
      </table>
    </div>  
  </div>
  <div class="WSAnalytics_popup_footer">
    <span class="WSAnalytics_popup_info"></span> These are the general statistics of this page.
  </div>
</div>
<?php } ?>