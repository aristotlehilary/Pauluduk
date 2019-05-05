<?php 
/*
* View of RealTime Statistics
*/
function ws_include_realtime( $current ) {
  $code = '';
?>
<div class="data_boxes">
  <div class="data_boxes_title"><?php echo _e('Real Time Statistics', 'wp-WSAnalytics');?><div class="arrow_btn"></div></div>
    <div class="data_container">
    <?php
    $code .= '<div class="realtime">
                <div class="ws-tdo-left">
                  <div class="active-visitors"><div class="ws-online" id="ws-online">&nbsp;</div></div>
                </div>
                <div class="ws-tdo-right" id="ws-tdo-right">
                  <div class="ws-bigtext"><span class=" count-visits">0</span><span class="source"><a href="#nogo">"' . __ ( "REFERRAL", 'wp-WSAnalytics' ) . '"</a></span></div>
                  <div class="ws-bigtext"><span class=" count-visits">0</span><span class="source"><a href="#nogo">"' . __ ( "ORGANIC", 'wp-WSAnalytics' ) . '"</a></span></div>
                  <div class="ws-bigtext"><span class=" count-visits">0</span><span class="source"><a href="#nogo">"' . __ ( "SOCIAL", 'wp-WSAnalytics' ) . '"</a></span></div>
                </div>
                <div class="ws-tdo-rights" id="ws-tdo-rights">
                  <div class="ws-bigtext"><span class=" count-visits">0</span><span class="source"><a href="#nogo">"' . __ ( "DIRECT", 'wp-WSAnalytics' ) . '"</a></span></div>
                  <div class="ws-bigtext"><span class=" count-visits">0</span><span class="source"><a href="#nogo">"' . __ ( "NEW", 'wp-WSAnalytics' ) . '"</a></span></div>
                  <div class="ws-bigtext"><span class=" count-visits">0</span><span class="source"><a href="#nogo">"' . __ ( "RETURNING", 'wp-WSAnalytics' ) . '"</a></span></div>
                </div>
                <div id="ws-wsges" class="ws-wsges">&nbsp;</div>
              </div>';
    echo $code;
    echo $current->ws_realtime(); ?>
    </div>
    <div class="data_boxes_footer">
      <span class="blk">
        <span class="dot"></span>
        <span class="line"></span>
      </span>
      <span class="information-txt"> <?php echo _e('These are the realtime statistics of your site.', 'wp-WSAnalytics');?></span></div>
</div>
<?php } ?>
