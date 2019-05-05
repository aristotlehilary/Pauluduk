<?php
$wp_WSAnalytics = new WS_Analytics();

$start_date_val =   strtotime("- 30 days"); 
$end_date_val   =   strtotime("now");
$start_date     =   date( "Y-m-d", $start_date_val);
$end_date       =   date( "Y-m-d", $end_date_val);

if( isset( $_POST["view_data"] ) ) {

	$s_date   = $_POST["st_date"];
	$ed_date  = $_POST["ed_date"];

}

if( isset( $s_date ) ) {
	$start_date = $s_date;
}

if( isset( $ed_date ) ) {
	$end_date = $ed_date;
}

?>
<div class="wrap">
	<h2 class='opt-title'><span id='icon-options-general' class='analytics-options'><img src="<?php echo plugins_url('wsanalytics-google-analytics-and-dashboards/images/wp-analytics-logo.png');?>" alt=""></span>
		<?php echo __( 'WSAnalytics Dashboard', 'wp-WSAnalytics' ); ?>
	</h2>
	<?php

	$acces_token  = get_option( "post_analytics_token" );
	if( $acces_token ) {
	
	?>
	<div id="col-container">
		<div class="metabox-holder">
			<div class="postbox" style="width:100%;">
					<div id="main-sortables" class="meta-box-sortables ui-sortable">
						<div class="postbox ">
							<div class="handlediv" title="Click to toggle"><br />
							</div>
							<h3 class="hndle">
								<span>
										<?php 
										echo _e('Complete Statistics of the Site ', 'wp-WSAnalytics'); 
										echo _e(get_option("pt_webprofile_url"));
										echo _e(' Starting From ', 'wp-WSAnalytics'); 
										echo _e(date("jS F, Y", strtotime($start_date))); 
										echo _e(' to ', 'wp-WSAnalytics'); 
										echo _e(date("jS F, Y", strtotime($end_date))); 
										?>
								</span>
							</h3>
							<div class="inside">
								<div class="pa-filter">
									<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post">
										<input type="text" id="st_date" name="st_date" value="<?php echo $start_date; ?>">
										<input type="text" id="ed_date" name="ed_date" value="<?php echo $end_date; ?>">
										<input type="submit" id="view_data" name="view_data" value="View Data" class="button-primary btn-green">
									</form>
								</div>


								<?php

								// Real time stats //
                
								include WSAnalytics_ROOT_PATH . '/views/admin/realtime-stats.php'; 
								ws_include_realtime( $wp_WSAnalytics );
                
								// End Real time stats //
								
								// General statistic  //

								$stats = $wp_WSAnalytics->ws_get_analytics_dashboard( 'ga:sessions,ga:bounces,ga:newUsers,ga:entrances,ga:pageviews,ga:sessionDuration,ga:avgSessionDuration,ga:users', $start_date, $end_date);
								if ( isset( $stats->totalsForAllResults ) ) {
									include WSAnalytics_ROOT_PATH . '/views/admin/general-stats.php'; 
									ws_include_general($wp_WSAnalytics,$stats);
								}
								
								// End General statistic //
								
								// Top Pages statistic //
								$top_page_stats = $wp_WSAnalytics->ws_get_analytics_dashboard('ga:pageviews', $start_date, $end_date, 'ga:PageTitle', '-ga:pageviews', false, 5);
								if ( isset( $top_page_stats->totalsForAllResults ) ) {
									include WSAnalytics_ROOT_PATH . '/views/admin/top-pages-stats.php'; 
									ws_include_top_pages_stats( $wp_WSAnalytics, $top_page_stats );
								}
								// End Top Pages statistic //

								// Country statistic //
								
								$country_stats = $wp_WSAnalytics->ws_get_analytics_dashboard( 'ga:sessions', $start_date, $end_date, 'ga:country', '-ga:sessions', false, 5);
								if ( isset( $country_stats->totalsForAllResults )) {
									include WSAnalytics_ROOT_PATH . '/views/admin/country-stats.php'; 
									ws_include_country($wp_WSAnalytics,$country_stats);
								}
							
								// End Country statistic //

								$city_stats = $wp_WSAnalytics->ws_get_analytics_dashboard( 'ga:sessions', $start_date, $end_date, 'ga:city', '-ga:sessions', false, 5);
								if ( isset( $city_stats->totalsForAllResults )) {
									include WSAnalytics_ROOT_PATH . '/views/admin/city-stats.php'; 
									ws_include_city($wp_WSAnalytics,$city_stats);
								}

								// Keywords statistic //

								$keyword_stats = $wp_WSAnalytics->ws_get_analytics_dashboard( 'ga:sessions', $start_date, $end_date, 'ga:keyword', '-ga:sessions', false, 10);
								if ( isset( $keyword_stats->totalsForAllResults )){
									include WSAnalytics_ROOT_PATH . '/views/admin/keywords-stats.php'; 
									ws_include_keywords($wp_WSAnalytics,$keyword_stats);
								}

								// End Keywords statistic //

								// Browser statistic //

								$browser_stats = $wp_WSAnalytics->ws_get_analytics_dashboard( 'ga:sessions', $start_date, $end_date, 'ga:browser,ga:operatingSystem', '-ga:sessions',false,5);
								if ( isset( $browser_stats->totalsForAllResults ) ) {
									include WSAnalytics_ROOT_PATH . '/views/admin/browser-stats.php'; 
									ws_include_browser( $wp_WSAnalytics,$browser_stats );
								}
								
								// End Browser statistic //
								
								$operating_stats = $wp_WSAnalytics->ws_get_analytics_dashboard( 'ga:sessions', $start_date, $end_date, 'ga:operatingSystem,ga:operatingSystemVersion', '-ga:sessions', false, 5);
								if ( isset( $city_stats->totalsForAllResults )) {
									include WSAnalytics_ROOT_PATH . '/views/admin/os-stats.php'; 
									ws_include_operating($wp_WSAnalytics,$operating_stats);
								}

								$mobile_stats = $wp_WSAnalytics->ws_get_analytics_dashboard( 'ga:sessions', $start_date, $end_date, 'ga:mobileDeviceInfo', '-ga:sessions', false, 5);
								if ( isset( $city_stats->totalsForAllResults )) {
									include WSAnalytics_ROOT_PATH . '/views/admin/mobile-stats.php'; 
									ws_include_mobile($wp_WSAnalytics,$mobile_stats);
								}

								// Referral statistic //
								$referr_stats = $wp_WSAnalytics->ws_get_analytics_dashboard( 'ga:sessions', $start_date, $end_date, 'ga:source,ga:medium', '-ga:sessions', false, 10);
								if ( isset( $referr_stats->totalsForAllResults ) ) {
									include WSAnalytics_ROOT_PATH.'/views/admin/referrers-stats.php'; 
									ws_include_referrers($wp_WSAnalytics,$referr_stats);
								}

								// End Referral statistic //


								// Exit statistic //
								$page_stats = $wp_WSAnalytics->ws_get_analytics_dashboard('ga:entrances,ga:pageviews,ga:exits', $start_date, $end_date, 'ga:PagePath', '-ga:exits', false, 5);
								$top_page_stats = $wp_WSAnalytics->ws_get_analytics_dashboard('ga:pageviews', $start_date, $end_date, 'ga:PageTitle', '-ga:pageviews', false, 5);
								if ( isset( $page_stats->totalsForAllResults ) ) {
									include WSAnalytics_ROOT_PATH . '/views/admin/pages-stats.php'; 
									ws_include_pages_stats( $wp_WSAnalytics, $page_stats );
								}

								// End Exit statistic //
								?>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php 
	}
	else{
		print(_e( 'You must be authenticate to see the WSAnalytics Dashboard.', 'wp-WSAnalytics' ));
	}

?>
</div>
<script type="text/javascript">

jQuery(document).ready(function ($) {

	$("#st_date").datepicker({
						dateFormat : 'yy-mm-dd',
						changeMonth : true,
						changeYear : true,
						beforeShow: function() {
							 $('#ui-datepicker-div').addClass('mycalander');
					 },
						yearRange: '-9y:c+nn',
						defaultDate: "<?php echo $start_date;?>"    
				});

	$("#ed_date").datepicker({
						dateFormat : 'yy-mm-dd',
						changeMonth : true,
						changeYear : true,
						beforeShow: function() {
							 $('#ui-datepicker-div').addClass('mycalander');
					 },
						yearRange: '-9y:c+nn',
						defaultDate: "<?php echo $end_date; ?>"
				});
});

jQuery(window).resize(function(){
	drawChart();
	drawRegionsMap();
});
</script>