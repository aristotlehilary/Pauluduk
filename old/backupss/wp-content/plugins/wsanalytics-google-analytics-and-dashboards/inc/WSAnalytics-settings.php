<?php
	$wp_WSAnalytics = new WS_Analytics();

	if (! function_exists( 'curl_init' ) ) {
			esc_html_e('This plugin requires the CURL PHP extension');
		return false;
	}

	if (! function_exists( 'json_decode' ) ) {
		esc_html_e('This plugin requires the JSON PHP extension');
		return false;
	}

	if (! function_exists( 'http_build_query' )) {
		esc_html_e('This plugin requires http_build_query()');
		return false;
	}

	// Save access code
	if ( isset( $_POST[ 'save_code' ] ) ) {

		if( isset($_POST['auth_step']) and $_POST['auth_step'] == 'user_keys' ) {

			update_option('WSAnalytics_CLIENTID' , $_POST['WSAnalytics_clientid']);
			update_option('WSAnalytics_CLIENTSECRET' , $_POST['WSAnalytics_clientsecret']);
			update_option('WSAnalytics_DEV_KEY' , $_POST['WSAnalytics_apikey']);

		}


		if( isset($_POST['auth_step']) and $_POST['auth_step'] == 'user_access_code' ) {

			$key_google_token = $_POST[ 'key_google_token' ];

			if( $wp_WSAnalytics->pt_save_data( $key_google_token )){
					$update_message = '<div id="setting-error-settings_updated" class="updated settings-error below-h2"><p><strong>Access code saved.</strong></p></div>';
			}
		}


	}

	$url = http_build_query( array(
								'next'            =>  $wp_WSAnalytics->ws_setting_url(),
								'scope'           =>  WSAnalytics_SCOPE,
								'response_type'   =>  'code',
								'redirect_uri'    =>  WSAnalytics_REDIRECT,
								'client_id'       =>  get_option('WSAnalytics_CLIENTID'),
								'access_type'     =>  'offline',
								'approval_prompt' =>  'auto'
								)
							);

// Saving settings for back end Analytics for Posts and Pages.
if ( isset( $_POST[ 'save_settings_admin' ] ) ) {

		update_option( 'post_analytics_settings_back' , $_POST[ 'backend' ] );
		update_option( 'WSAnalytics_posts_stats' , $_POST[ 'posts' ] );
		update_option( 'post_analytics_access_back' , $_POST[ 'access_role_back' ] );
		update_option( 'post_analytics_disable_back' , $_POST[ 'disable_back' ] );
		update_option( 'post_analytics_exclude_posts_back', @$_POST[ 'exclude_posts_back' ]);
		
		$update_message = '<div id="setting-error-settings_updated" class="updated settings-error below-h2"><p><strong>Admin changes are saved.</strong></p></div>';
	
} // endif

	// Saving Profiles
	if (isset($_POST[ 'save_profile' ])) {

		$profile_id            = $_POST[ 'webprofile' ];
		$web_profile_dashboard = $_POST[ 'webprofile_dashboard' ];
		$web_profile_url       = $_POST[ $web_profile_dashboard ];
		$webPropertyId         = $_POST[ $profile_id."-1"];
		
		update_option( 'pt_webprofile', $profile_id );
		update_option( 'webPropertyId', $webPropertyId);
		update_option( 'pt_webprofile_dashboard', $web_profile_dashboard );
		update_option( 'pt_webprofile_url', urldecode( urldecode( $web_profile_url )));
		
		$update_message = '<div id="setting-error-settings_updated" class="updated settings-error below-h2"> 
												<p><strong>Your Google Analytics Profile Saved.</strong></p></div>';
	}
	// Saving General Setting 
	if (isset($_POST[ 'save_general' ])) {

		
		$display_tracking_code = $_POST[ 'display_tracking_code' ];
		$tracking_code         = $_POST[ 'tracking_code' ];
								
		update_option( 'WSAnalytics_tracking_code', $tracking_code);
		update_option( 'display_tracking_code', $display_tracking_code);
				
		if( isset( $_POST[ 'display_demographic' ] ) ) {
			update_option( 'display_demographic_code', 1 );
		}
		else{
			 update_option( 'display_demographic_code', 0 );
		}
		
		if( isset( $_POST[ 'ga_code' ] ) ) {
			update_option( 'wsanalytics_code', 1 );
		}
		else{
			 update_option( 'wsanalytics_code', 0 );
		}
		$update_message = '<div id="setting-error-settings_updated" class="updated settings-error below-h2"> 
												<p><strong>Your Google Analytics General Tracking has been Recorded.</strong></p></div>';
	}
	
	
	

	// Clear Authorization and other data
	if (isset($_POST[ "clear" ])) {

		delete_option( 'pt_webprofile' );
		delete_option( 'pt_webprofile_dashboard' );
		delete_option( 'pt_webprofile_url' );
		delete_option( 'ws_google_token' );
		delete_option( 'ws_welcome_message' );
		delete_option( 'post_analytics_token' );
		$update_message = '<div id="setting-error-settings_updated" class="updated settings-error below-h2"> 
												<p><strong>Authentication Cleared login again.</strong></p></div>';
	}
?>

<div class="wrap">
	<h2 class='opt-title'><span id='icon-options-general' class='analytics-options'><img src="<?php echo plugins_url('wsanalytics-google-analytics-and-dashboards/images/wp-analytics-logo.png');?>" alt=""></span>
		<?php echo __( 'WSAnalytics Settings', 'wp-WSAnalytics'); ?>
	</h2>

	<?php
	if (isset($update_message)) echo $update_message;
	
	if ( isset ( $_GET['tab'] ) ) $wp_WSAnalytics->ws_settings_tabs($_GET['tab']); 
	else $wp_WSAnalytics->ws_settings_tabs( 'authentication' );

	if ( isset ( $_GET['tab'] ) ) 
		$tab = $_GET['tab']; 
	else 
		$tab = 'authentication';
	
	// Authentication Tab section
	if( $tab == 'authentication' ) {
	?>

	<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post" name="settings_form" id="settings_form">
		<table width="1004" class="form-table">
			<tbody>
			<?php if( get_option( 'ws_google_token' ) ) { ?>
				<tr>
					<p class="description"><br />Do you want to re-authenticate ? Click reset button and get your new Access code.<p>
					
				</tr>
				<tr>
					<th><?php esc_html_e( 'Clear Authentication', 'wp-WSAnalytics' ); ?></th>
					<td><input type="submit" class="button-primary" value="Reset" name="clear" /></td>
				</tr>
			<?php 
			}
			else { ?>

				<tr>
					<th></th>
						
					<td>
						<p class="description"> In-order to have Data from Google Analytics you need to create a Project in <a target="_blank" href="https://console.developers.google.com/project">Google Console</a> or you can use Pre-Generated Keys to get stared Quickly.  For Creating Google Project We present you a very detailed <a target="_blank" href="http://www.wsofi.com/how-to-setup-google-api-for-wsanalytics/?utm_source=WSAnalytics&utm_medium=tutorial&utm_campaign=setup-google-api">tutorial</a> to get your ClientID, Client Secret and API Key. </p>
						
					</td>
				</tr>


				<tr>
					<th></th>
						
					<td>
						<input type="radio" value="user_keys" <?php if(!get_option('WSAnalytics_CLIENTID')) echo 'checked'; ?> name="auth_step" id="user_keys" />  Step 1. Enter Your API Credentials<br />   
						
						<?php

						if( get_option('WSAnalytics_CLIENTID') and get_option('WSAnalytics_CLIENTSECRET') and get_option('WSAnalytics_DEV_KEY') ) {
							?>
							<input type="radio" checked value="user_access_code" name="auth_step" id ="user_access_code" />  Step 2. Enter Access Code<br />
							<?php 
						}
							?>
					</td>
				</tr>

				<tr class="user_keys">
					<th></th>
					<td>
						<span><a href="#nogo" id="populate_credss">Use Pre-Generated Credentials</a></span>
					</td>
				</tr>
				<tr class="user_keys">
					<th></th>
						<td>
							<p class="description"><?php esc_html_e('ClientID:')?></p>
							<input type="text" placeholder="<?php esc_html_e('Your ClientID')?>" name="WSAnalytics_clientid" id="WSAnalytics_clientid" value="<?php echo get_option('WSAnalytics_CLIENTID'); ?>" style="width:450px;"/>
						</td>
				</tr>

				<tr class="user_keys">
					<th></th>
						<td>
							<p class="description"><?php esc_html_e('Client Secret:')?> </p>
							<input type="text" placeholder="<?php esc_html_e('Your Client Secret')?>" name="WSAnalytics_clientsecret" id="WSAnalytics_clientsecret" value="<?php echo get_option('WSAnalytics_CLIENTSECRET'); ?>" style="width:450px;"/>
						</td>
				</tr>


				<tr class="user_keys">
					<th width="115"></th>
							<td width="877">
								<p class="description"><?php esc_html_e( 'API Key:' )?></p>
								<input type="text" placeholder="<?php esc_html_e('Your API Key')?>" name="WSAnalytics_apikey" id="WSAnalytics_apikey" value="<?php echo get_option('WSAnalytics_DEV_KEY'); ?>" style="width:450px;"/>
							</td>
				</tr>

				<tr class="user_access_code">
					<th width="115"></th>
							<td width="877">
										<a target="_blank" href="javascript:void(0);" onclick="window.open('https://accounts.google.com/o/oauth2/auth?<?php echo $url ?>','activate','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');">Get Your Access Code</a>
							</td>
				</tr>
				<tr class="user_access_code">
					<th></th>
						<td>
							<input type="text" name="key_google_token" placeholder="<?php esc_html_e('Your Access Code')?>" value="<?php echo get_option( 'post_analytics_token'); ?>" style="width:450px;"/>
							<p class="description">Paste here Access Code.</p>
						</td>
				</tr>
				<tr>
					<th></th>
					<td>
						<p class="submit">
							<input type="submit" class="button-primary" value="Save Changes" name="save_code" />
						</p>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</form>
	<?php
	} // endif
// Choose profiles for dashboard and posts at front/back.
if( $tab == 'profile' ){

	$profiles = $wp_WSAnalytics->pt_get_analytics_accounts();
	if( isset( $profiles ) ) { ?>
	
	<p class="description"><br /><?php esc_html_e( 'Select your profiles for front-end and backend sections.', 'wp-WSAnalytics' ); ?></p>
	<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post">
		<table width="1004" class="form-table">
			<tbody>
					<tr>
						<th width="115"><?php esc_html_e( 'Profile for posts (Backend/Front-end) :', 'wp-WSAnalytics' ); ?></th>
							<td width="877">
							<?php ?>
								<select name='webprofile' class="WSAnalytics-chosen">
									<?php foreach ( $profiles->items as $profile ) { ?>
												<option value="<?php echo $profile[ 'id' ];?>"
																<?php selected( $profile[ 'id' ], get_option( 'pt_webprofile' ) ); ?>>
																<?php echo $profile[ 'websiteUrl' ];?> - <?php echo $profile[ 'name' ];?>
												</option>
									<?php } ?>
								</select>
								 <?php 
								foreach ( $profiles->items as $profile ) { ?>
									<input type="hidden" name="<?php echo $profile[ 'id' ]; ?>-1" value="<?php echo $profile['webPropertyId'] ?>">
								<?php } ?>
								 <p class="description">Select your website profile for wp-admin edit pages and fron-end pages. Select profile which matches your current WordPress website.</p>
							</td>

					</tr>
					<tr>
						<th width="115"><?php esc_html_e( 'Profile for Dashboard :', 'wp-WSAnalytics' );?></th>
						<td width="877">
								<select name='webprofile_dashboard' class="WSAnalytics-chosen">
									<?php foreach ($profiles->items as $profile) { ?>
									<option value="<?php echo $profile[ 'id' ];?>"
															<?php selected( $profile[ 'id' ], get_option( 'pt_webprofile_dashboard' )); ?>
															>
															<?php echo $profile[ 'websiteUrl' ];?> - <?php echo $profile[ 'name' ];?>
									</option>
									<?php } ?>
								</select>
								<?php 
								foreach ( $profiles->items as $profile ) { ?>
									<input type="hidden" name="<?php echo $profile[ 'id' ]; ?>" value="<?php echo urlencode(urlencode($profile[ 'websiteUrl' ])); ?>">
								<?php } ?>
								<p class="description">Please Select a website profile for Dashboard Statistics. It can be any Website profile of you choice. </p>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<p class="submit">
								<input type="submit" name="save_profile" value="Save Changes" class="button-primary">
							</p>
						</td>
					</tr>
					<?php } ?>
			</tbody>
		</table>
	</form>
<?php }

	// Choose metrics for posts at admin.
	if( $tab == 'admin' ) { ?>

		<p class="description"><br /><?php esc_html_e( ' Do You want to see your Page and Post stats right under each Post/Page ?  Use Following settings Admin side Implementaiton of WSAnalytics', 'wp-WSAnalytics' ); ?></p>

		<form action="" method="post">
			<table width="1004" class="form-table">
				<tbody>
					<tr></tr>
					<tr>
						<th><?php _e( 'Disable Analytics under posts/pages (wp-admin):', 'wp-WSAnalytics') ?></th>
						<td>
								<input type="checkbox" name="disable_back" value="1" <?php if ( get_option( 'post_analytics_disable_back') == 1 ) { ?> checked <?php } ?>>
								<p class="description">Check it, If you don't want to see Stats by default under All Posts/pages.</p>
						</td>
						
					</tr>
					<tr>
						<th width="115"><?php esc_html_e( 'Show Analytics to (roles) :', 'wp-WSAnalytics' ); ?></th>
						<td>
							<select multiple name="access_role_back[]" class="WSAnalytics-chosen" style="width:400px">	
								<?php
								if ( !isset( $wp_roles ) ){
									
									$wp_roles = new WP_Roles();
								}
								
								$i=0;
								foreach ( $wp_roles->role_names as $role => $name ) {
									
									if ($role!='subscriber'){
										
										$i++;
										
										?>
										<option value="<?php echo $role; ?>"
											<?php
											
											if ( is_array( get_option( 'post_analytics_access_back' ) ) ) {
												selected( in_array( $role, get_option( 'post_analytics_access_back' ) ) );
											}
											?>>
											<?php echo $name; ?>
										</option>
										<?php
									}
								}
								?>
							</select>
							<p class="description">Show Analytics to above selected user roles only.</p>
						</td>
					</tr>
					<tr>
						<!-- Area For backend settings -->
						<th width="115"><?php esc_html_e( 'Analytics on Post types :' ,'wp-WSAnalytics'); ?></th>
						<td>
							 <select class="WSAnalytics-chosen" name="posts[]" multiple="multiple" style="width:400px">

								<option value="post" <?php if ( is_array( get_option( 'WSAnalytics_posts_stats' ) ) ) {
                                selected(in_array('post', get_option('WSAnalytics_posts_stats')));
                              }  ?>
                              >Posts</option>
								<option value="page" <?php if ( is_array( get_option( 'WSAnalytics_posts_stats' ) ) ) {
                                selected(in_array('page', get_option('WSAnalytics_posts_stats')));
                              }  ?>
                              >Pages</option>

							 </select>
							 <p class="description">Show Analytics under the above post types only.</p>
						</td>
						</tr>
					<tr>
						<!-- Area For backend settings -->
						<th width="115"><?php esc_html_e( 'Edit pages/posts Analytics panels:' ); ?></th>
						<td>
							<select class="WSAnalytics-chosen" name="backend[]" multiple="multiple" style="width:400px">
								<option value="show-overall-back"
												<?php
												if ( is_array( get_option( 'post_analytics_settings_back' ) ) ) {
													selected(in_array("show-overall-back", get_option('post_analytics_settings_back')));
												}
												?>>
												<?php esc_html_e( 'General Stats' )?>
								</option>
								<option value="show-country-back"
												<?php
												if ( is_array( get_option( 'post_analytics_settings_back' ) ) ) {
													selected( in_array( "show-country-back", get_option( 'post_analytics_settings_back' ) ) );
												}
												?>>
												<?php esc_html_e( 'Country Stats' )?>
								</option>
								
								<option value="show-keywords-back"
												<?php
												if ( is_array ( get_option( 'post_analytics_settings_back' ) ) ) {
													selected( in_array( "show-keywords-back", get_option( 'post_analytics_settings_back' ) ) );
												}
												?>>
												<?php esc_html_e( 'Keywords Stats' ); ?>
								</option>
								<option value="show-social-back"
												<?php
												if ( is_array ( get_option( 'post_analytics_settings_back' ) ) ) {
													selected( in_array( "show-social-back", get_option( 'post_analytics_settings_back' ) ) );
												}
												?>>
												<?php esc_html_e( 'Social Media Stats' ); ?>
								</option>
								<option value="show-browser-back"
												<?php
												if ( is_array( get_option( 'post_analytics_settings_back' ) ) ) {
													selected( in_array( "show-browser-back", get_option( 'post_analytics_settings_back') ) );
												}
												?>>
												<?php esc_html_e( 'Browser Stats' ); ?>
								</option>
								<option value="show-referrer-back"
												<?php
												if ( is_array( get_option( 'post_analytics_settings_back' ) ) ) {
													selected( in_array( "show-referrer-back", get_option( 'post_analytics_settings_back') ) );
												}
												?>>
												<?php esc_html_e( 'Referrers' ); ?>
								</option>
								<option value="show-pages-back"
												<?php
												if ( is_array( get_option( 'post_analytics_settings_back' ) ) ) {
													selected( in_array( "show-pages-back", get_option( 'post_analytics_settings_back' ) ) );
												}
												?>>
												<?php esc_html_e(' Page bounce and exit stats '); ?>
								</option>
								<option value="show-mobile-back"
												<?php
												if ( is_array ( get_option( 'post_analytics_settings_back' ) ) ) {
													selected( in_array( "show-mobile-back", get_option( 'post_analytics_settings_back' ) ) );
												}
												?>>
												<?php esc_html_e( 'Mobile Devices Stats' ); ?>
								</option>
								<option value="show-os-back"
												<?php
												if ( is_array ( get_option( 'post_analytics_settings_back' ) ) ) {
													selected( in_array( "show-os-back", get_option( 'post_analytics_settings_back' ) ) );
												}
												?>>
												<?php esc_html_e( 'Operating System Stats' ); ?>
								</option>
								<option value="show-city-back"
												<?php
												if ( is_array ( get_option( 'post_analytics_settings_back' ) ) ) {
													selected( in_array( "show-city-back", get_option( 'post_analytics_settings_back' ) ) );
												}
												?>>
												<?php esc_html_e( 'City Stats' ); ?>
								</option>
							</select>
							<p class="description">You can select Stats panels you want to display under posts/pages. </p>
						</td>
					</tr>
					 <tr>
						 <th width="115"><?php esc_html_e( 'Exclude Analytics on specific pages:', 'wp-WSAnalytics' ); ?></th>
							<td>
								<input type="text" name="exclude_posts_back" id="exclude_posts_back" value="<?php echo get_option('post_analytics_exclude_posts_back'); ?>" class="regular-text" />
							<p class="description">Please Enter ID's of posts or pages separated by commas on which you don't want to see Analytics e.g 220,23,91</p>
						</td>
					</tr>       
					<tr>
						<th></th>
						<td>
							<p class="submit">
								<input type="submit" name="save_settings_admin" value="Save Changes" class="button-primary">
							</p>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	<?php 
	}
	
	
	if( $tab == 'general_tracking' ) { ?>
	
		<p class="description"><br /><?php esc_html_e( 'Following are the settings for Admin side. Google Analytics will appear under the posts, custom post types or pages.', 'wp-WSAnalytics' ); ?></p>
	
	<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post">
		<table width="1004" class="form-table">
			<tbody>
				<tr>
						<th width="115"><?php esc_html_e( 'Install Google Analytics tracking code :', 'wp-WSAnalytics' ); ?></th>
							<td width="877">
							<input type="checkbox" name="ga_code" value="1" 
									<?php if( get_option( 'wsanalytics_code' ) == 1 ) { echo 'checked'; } ?>>
									<p class="description">Insert Google Analytics JS code in header to track the visitors. You can uncheck this option if you have already insert the GA code in your website.</p>
							</td>
				</tr>
						<th width="115"><?php esc_html_e( 'Enable Demographic Tracking :', 'wp-WSAnalytics' ); ?></th>
						<td width="877">
							<input type="checkbox" name="display_demographic" value="1" 
									<?php if( get_option( 'display_demographic_code' ) == 1 ) { echo 'checked'; } ?>>
									<p class="description">Insert Demographic JS code.  You can uncheck this option if you Don't want to see demographics data in Google Analytics.</p>
							</td>
			<tr>
				<th width="115">
						<?php esc_html_e( 'Exclude users from tracking :', 'wp-WSAnalytics' ); ?>
				</th>
				<td>
					<select multiple name="display_tracking_code[]" class="WSAnalytics-chosen" style="width:306px">
							<?php
							
							if ( !isset( $wp_roles ) ) {
								
								$wp_roles = new WP_Roles();
							}
							
							foreach ( $wp_roles->role_names as $role => $name ) { ?>
								
								<option value="<?php echo $role; ?>"
								<?php
								
								if ( is_array( get_option( 'display_tracking_code' ) ) ) {
									
									selected( in_array( $role, get_option('display_tracking_code') ) );
								
								}
								
								?>>
										<?php echo $name; ?>
								</option>
							<?php 
								} 
							?>
					</select>
					<p class="description">Don't insert the tracking code for above user roles.</p>
				</td>
			</tr>
				<tr>
						<th width="115"><?php esc_html_e( 'Tracking code type :', 'wp-WSAnalytics' ); ?></th>
							<td width="877">
							<select name='tracking_code' class="WSAnalytics-chosen">
								<option value="universal" <?php selected( 'universal', get_option( 'WSAnalytics_tracking_code' ) ); ?>>
									Universal Code (analytics.js)
								</option>
								<option value="ga"  <?php selected( 'ga', get_option( 'WSAnalytics_tracking_code' ) ); ?>>
									Tranditional Code (ga.js)
								</option>
								 
							</select>
							<p class="description">Which type of tracking code to use i-e (Analytics.js , ga.js) Google recommends to use Analytics.js now <a href="https://developers.google.com/analytics/devguides/collection/upgrade/reference/gajs-analyticsjs" target="_blank">Read More</a>.</p>
							</td>
				</tr>
				
				<tr>
						<th></th>
						<td>
							<p class="submit">
								<input type="submit" name="save_general" value="Save Changes" class="button-primary">
							</p>
						</td>
					</tr>	
			</tbody>
		</table>
	</form>
	
<?php }?>
</div>
</div>
<div class="right-area">
	<div class="postbox-container side">
				<div class="metabox-holder">
					<div class="grids_auto_size wws_side_box" style="width: 95%;">
						<div class="grid_title cen">Thanks For Using </div>
								
							<div class="grid_footer cen" style="background-color:white;">
								<a href="mailto:WSA@Wsofi.com" target="_blank" title="WSAnalytics Support">Provide You Feedback </a> With our user's feedback and support we are sure we can build the best Analytics plugin for WordPress. Do not hesitate to reach out us. Please contact and provide your feedback to enrich this plugin with more awesomeness. 
							</div>
					</div>
					<div class="grids_auto_size wws_side_box" style=" width: 95%;">
								<div class="grid_footer cen">
									made with ♥ by <a href="http://WSofi.com" target="_blank" title="WSofi | Solution to All your Digital Needs." />WSofi</a>
								</div>
					</div>
			 </div>
	</div>
</div>