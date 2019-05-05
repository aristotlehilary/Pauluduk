<?php
/**
 * Menu class.
 *
 * @since 1.0.0
 *
 * @package OMAPI
 * @author  Thomas Griffin
 */
class OMAPI_Menu {

	/**
	 * Holds the class object.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	public static $instance;

	/**
	 * Path to the file.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $file = __FILE__;

	/**
	 * Holds the base class object.
	 *
	 * @since 1.0.0
	 *
	 * @var OMAPI
	 */
	public $base;

	/**
	 * Holds the admin menu slug.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $hook;

	/**
	 * Holds a tabindex counter for easy navigation through form fields.
	 *
	 * @since 1.0.0
	 *
	 * @var int
	 */
	public $tabindex = 429;

	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $isTesting
	 */
	public function __construct( $isTesting = false ) {

		if ( ! $isTesting ) {
			// Set our object.
			$this->set();

			// Load actions and filters.
			add_action( 'admin_menu', array( $this, 'menu' ) );
			// Load helper body classes
			add_filter( 'admin_body_class', array( $this, 'admin_body_classes' ) );

		}

	}

	/**
	 * Sets our object instance and base class instance.
	 *
	 * @since 1.0.0
	 */
	public function set() {

		self::$instance = $this;
		$this->base     = OMAPI::get_instance();
		$this->view     = isset( $_GET['optin_monster_api_view'] ) ? stripslashes( $_GET['optin_monster_api_view'] ) : $this->base->get_view();

	}

	/**
	 * Loads the OptinMonster admin menu.
	 *
	 * @since 1.0.0
	 */
	public function menu() {

		$this->hook = add_menu_page(
			__( 'OptinMonster', 'optin-monster-api' ),
			__( 'OptinMonster', 'optin-monster-api' ),
			apply_filters( 'optin_monster_api_menu_cap', 'manage_options' ),
			'optin-monster-api-settings',
			array( $this, 'page' ),
			'none',
			579
		);

		// Load global icon font styles.
		add_action( 'admin_head', array( $this, 'icon' ) );

		// Load settings page assets.
		if ( $this->hook ) {
			add_action( 'load-' . $this->hook, array( $this, 'assets' ) );
		}

	}

	/**
	 * Loads the custom Archie icon.
	 *
	 * @since 1.0.0
	 */
	public function icon() {

		?>
		<style type="text/css">@font-face{font-family: 'archie';src:url('<?php echo plugins_url( '/assets/fonts/archie.eot?velzrt', OMAPI_FILE ); ?>');src:url('<?php echo plugins_url( '/assets/fonts/archie.eot?#iefixvelzrt', OMAPI_FILE ); ?>') format('embedded-opentype'),url('<?php echo plugins_url( '/assets/fonts/archie.woff?velzrt', OMAPI_FILE ); ?>') format('woff'),url('<?php echo plugins_url( '/assets/fonts/archie.ttf?velzrt', OMAPI_FILE ); ?>') format('truetype'),url('<?php echo plugins_url( '/assets/fonts/archie.svg?velzrt#archie', OMAPI_FILE ); ?>') format('svg');font-weight: normal;font-style: normal;}#toplevel_page_optin-monster-api-settings .dashicons-before,#toplevel_page_optin-monster-api-settings .dashicons-before:before,#toplevel_page_optin-monster-api-welcome .dashicons-before,#toplevel_page_optin-monster-api-welcome .dashicons-before:before{font-family: 'archie';speak: none;font-style: normal;font-weight: normal;font-variant: normal;text-transform: none;line-height: 1;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;}#toplevel_page_optin-monster-api-settings .dashicons-before:before,#toplevel_page_optin-monster-api-welcome .dashicons-before:before{content: "\e600";font-size: 38px;margin-top: -9px;margin-left: -8px;}</style>
		<?php

	}

	public function admin_body_classes( $classes ) {

		$classes .= ' omapi-screen ';

		if ( $this->base->get_api_key_errors() ) {
			$classes .= ' omapi-has-api-errors ';
		}

		return $classes;

	}

	/**
	 * Loads assets for the settings page.
	 *
	 * @since 1.0.0
	 */
	public function assets() {

		add_action( 'admin_enqueue_scripts', array( $this, 'styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		add_filter( 'admin_footer_text', array( $this, 'footer' ) );
		add_action( 'in_admin_header', array( $this, 'output_plugin_screen_banner') );
		add_action( 'admin_enqueue_scripts', array( $this, 'fix_plugin_js_conflicts'), 100 );

	}

	/**
	 * Register and enqueue settings page specific CSS.
	 *
	 * @since 1.0.0
	 */
	public function styles() {

		wp_register_style( $this->base->plugin_slug . '-select2', plugins_url( '/assets/css/select2.min.css', OMAPI_FILE ), array(), $this->base->version );
		wp_enqueue_style( $this->base->plugin_slug . '-select2' );
		wp_register_style( $this->base->plugin_slug . '-settings', plugins_url( '/assets/css/settings.css', OMAPI_FILE ), array(), $this->base->version );
		wp_enqueue_style( $this->base->plugin_slug . '-settings' );

		// Run a hook to load in custom styles.
		do_action( 'optin_monster_api_admin_styles', $this->view );

	}

	/**
	 * Register and enqueue settings page specific JS.
	 *
	 * @since 1.0.0
	 */
	public function scripts() {
		global $wpdb;

		// Posts query.
		$postTypes = implode( '","', get_post_types( array( 'public' => true ) ) );
		$posts     = $wpdb->get_results( "SELECT ID AS `id`, post_title AS `text` FROM {$wpdb->prefix}posts WHERE post_type IN (\"{$postTypes}\") AND post_status IN('publish', 'future') ORDER BY post_title ASC", ARRAY_A );

		// Taxonomies query.
		$tags = $wpdb->get_results( "SELECT terms.term_id AS 'id', terms.name AS 'text' FROM {$wpdb->prefix}term_taxonomy tax  LEFT JOIN {$wpdb->prefix}terms terms ON terms.term_id = tax.term_id WHERE tax.taxonomy = 'post_tag' ORDER BY text ASC", ARRAY_A );

		wp_register_script( $this->base->plugin_slug . '-select2', plugins_url( '/assets/js/select2.min.js', OMAPI_FILE ), array( 'jquery' ), $this->base->version, true );
		wp_enqueue_script( $this->base->plugin_slug . '-select2' );
		wp_register_script( $this->base->plugin_slug . '-settings', plugins_url( '/assets/js/settings.js', OMAPI_FILE ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', $this->base->plugin_slug . '-select2' ), $this->base->version, true );
		wp_localize_script( $this->base->plugin_slug . '-settings', 'OMAPI', array(
			'posts' => $posts,
			'tags'  => $tags
		) );
		wp_enqueue_script( $this->base->plugin_slug . '-settings' );
		wp_register_script( $this->base->plugin_slug . '-clipboard', plugins_url( '/assets/js/clipboard.min.js', OMAPI_FILE ), array( $this->base->plugin_slug . '-settings' ), $this->base->version, true );
		wp_enqueue_script( $this->base->plugin_slug . '-clipboard' );
		wp_register_script( $this->base->plugin_slug . '-tooltip', plugins_url( '/assets/js/tooltip.min.js', OMAPI_FILE ), array( $this->base->plugin_slug . '-settings' ), $this->base->version, true );
		wp_enqueue_script( $this->base->plugin_slug . '-tooltip' );
		wp_register_script( $this->base->plugin_slug . '-jspdf', plugins_url( '/assets/js/jspdf.min.js', OMAPI_FILE ), array( $this->base->plugin_slug . '-settings' ), $this->base->version, true );
		wp_enqueue_script( $this->base->plugin_slug . '-jspdf' );
		wp_localize_script(
			$this->base->plugin_slug . '-settings',
			'omapi',
			array(
				'ajax'        => admin_url( 'admin-ajax.php' ),
				'nonce'       => wp_create_nonce( 'omapi-query-nonce' ),
				'confirm'     => __( 'Are you sure you want to reset these settings?', 'optin-monster-api' ),
				'date_format' => 'F j, Y',
				'supportData' => $this->get_support_data(),
			)
		);

		// Run a hook to load in custom styles.
		do_action( 'optin_monster_api_admin_scripts', $this->view );

	}

	/**
	 * Deque specific scripts that cause conflicts on settings page
	 *
	 * @since 1.1.5.9
	 */
	public function fix_plugin_js_conflicts(){

		// Get current screen.
		$screen = get_current_screen();

		// Bail if we're not on the OptinMonster Settings screen.
		if ( isset( $screen->id ) && 'toplevel_page_optin-monster-api-settings' !== $screen->id ) {
			return;
		}

		// Dequeue scripts that might cause our settings not to work properly.
		wp_dequeue_script( 'optimizely_config' );

	}

	/**
	 * Combine Support data together to pass into localization
	 *
	 * @since 1.1.5
	 * @return array
	 */
	public function get_support_data() {
		$server_data = '';
		$optin_data = '';

		if ( isset($_GET['optin_monster_api_view']) && $_GET['optin_monster_api_view'] == 'support') {
			$optin_data = $this->get_optin_data();
			$server_data = $this->get_server_data();
		}
		$data = array(
			'server' => $server_data,
			'optins' => $optin_data
		);

		return $data;
	}

	/**
	 * Build Current Optin data array to localize
	 *
	 * @since 1.1.5
	 *
	 * @return array
	 */
	private function get_optin_data() {

		$optins = $this->base->get_optins();
		$optin_data = array();

		if ( $optins ) {
			foreach ( $optins as $optin ) {
				$optin = get_post( $optin->ID );
				$slug = $optin->post_name;
				$design_type = get_post_meta( $optin->ID, '_omapi_type', true );
				$optin_data[ $slug ] = array(
					'Campaign Type'                    => $design_type,
					'WordPress ID'                     => $optin->ID,
					'Associated IDs'                   => get_post_meta( $optin->ID, '_omapi_ids', true ),
					'Current Status'                   => get_post_meta( $optin->ID, '_omapi_enabled', true ) ? 'Live' : 'Disabled',
					'User Settings'                    => get_post_meta( $optin->ID, '_omapi_users', true ),
					'Pages to Never show on'           => get_post_meta( $optin->ID, '_omapi_never', true ),
					'Pages to Only show on'            => get_post_meta( $optin->ID, '_omapi_only', true ),
					'Categories'                       => get_post_meta( $optin->ID, '_omapi_categories', true ),
					'Taxonomies'                       => get_post_meta( $optin->ID, '_omapi_taxonomies', true ),
					'Template types to Show on'        => get_post_meta( $optin->ID, '_omapi_show', true ),
					'Shortcodes Synced and Recognized' => get_post_meta( $optin->ID, '_omapi_shortcode', true ) ? htmlspecialchars_decode( get_post_meta( $optin->ID, '_omapi_shortcode_output', true ) ) : 'None recognized',
				);
				if ( OMAPI_Utils::is_inline_type( $design_type ) ) {
					$optin_data[$slug]['Automatic Output Status'] = get_post_meta( $optin->ID, '_omapi_automatic', true ) ? 'Enabled' : 'Disabled';
				}

			}
		}
		return $optin_data;
	}

	/**
	 * Build array of server information to localize
	 *
	 * @since 1.1.5
	 *
	 * @return array
	 */
	private function get_server_data() {

		$theme_data = wp_get_theme();
		$theme      = $theme_data->Name . ' ' . $theme_data->Version;

		$plugins        = get_plugins();
		$active_plugins = get_option( 'active_plugins', array() );
		$used_plugins   = "\n";
		$api_ping       = wp_remote_request( OPTINMONSTER_APP_URL . '/v1/ping' );
		foreach ( $plugins as $plugin_path => $plugin ) {
			if ( ! in_array( $plugin_path, $active_plugins ) ) {
				continue;
			}
			$used_plugins .= $plugin['Name'] . ': ' . $plugin['Version'] . "\n";
		}


		$array = array(
			'Server Info'        => esc_html( $_SERVER['SERVER_SOFTWARE'] ),
			'PHP Version'        => function_exists( 'phpversion' ) ? esc_html( phpversion() ) : 'Unable to check.',
			'Error Log Location' => function_exists( 'ini_get' ) ? ini_get( 'error_log' ) : 'Unable to locate.',
			'Default Timezone'   => date_default_timezone_get(),
			'WordPress Home URL' => get_home_url(),
			'WordPress Site URL' => get_site_url(),
			'WordPress Version'  => get_bloginfo( 'version' ),
			'Multisite'          => is_multisite() ? 'Multisite Enabled' : 'Not Multisite',
			'Language'           => get_locale(),
			'API Ping Response'  => wp_remote_retrieve_response_code( $api_ping ),
			'Active Theme'       => $theme,
			'Active Plugins'     => $used_plugins,

		);

		return $array;
	}

	/**
	 * Customizes the footer text on the OptinMonster settings page.
	 *
	 * @since 1.0.0
	 *
	 * @param string $text  The default admin footer text.
	 * @return string $text Amended admin footer text.
	 */
	public function footer( $text ) {

		$url  = 'https://wordpress.org/support/plugin/optinmonster/reviews?filter=5#new-post';
		$text = sprintf( __( 'Please rate <strong>OptinMonster</strong> <a href="%s" target="_blank" rel="noopener">&#9733;&#9733;&#9733;&#9733;&#9733;</a> on <a href="%s" target="_blank" rel="noopener noreferrer">WordPress.org</a> to help us spread the word. Thank you from the OptinMonster team!', 'optin-monster-api' ), $url, $url );
		return $text;

	}

	/**
	 * Outputs the OptinMonster settings page.
	 *
	 * @since 1.0.0
	 */
	public function page() {

		?>

		<div class="wrap omapi-page">
			<h2></h2>
			<div class="omapi-ui">
				<div class="omapi-tabs">
					<ul class="omapi-panels">
						<?php
							$i = 0; foreach ( $this->get_panels() as $id => $panel ) :
							$first  = 0 == $i ? ' omapi-panel-first' : '';
							$active = $id == $this->view ? ' omapi-panel-active' : '';
						?>
						<li class="omapi-panel omapi-panel-<?php echo sanitize_html_class( $id ); ?><?php echo $first . $active; ?>"><a href="<?php echo esc_url_raw( add_query_arg( 'optin_monster_api_view', $id, admin_url( 'admin.php?page=optin-monster-api-settings' ) ) ); ?>" class="omapi-panel-link" data-panel="<?php echo $id; ?>" data-panel-title="<?php echo $panel; ?>"><?php echo $panel; ?></a></li>
						<?php $i++; endforeach; ?>
					</ul>
				</div>
				<div class="omapi-tabs-content">
					<?php
						foreach ( $this->get_panels() as $id => $panel ) :
						$active = $id == $this->view ? ' omapi-content-active' : '';
					?>
					<div class="omapi-content omapi-content-<?php echo sanitize_html_class( $id ); ?><?php echo $active; ?>">
						<?php
						do_action( 'optin_monster_api_content_before', $id, $panel, $this );
						do_action( 'optin_monster_api_content_' . $id, $panel, $this );
						do_action( 'optin_monster_api_content_after', $id, $panel, $this ); ?>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<?php

	}

	/**
	 * Retrieves the available tab panels.
	 *
	 * @since 1.0.0
	 *
	 * @return array $panels Array of tab panels.
	 */
	public function get_panels() {

		// Only load the API panel if no API credentials have been set.
		$panels      = array();
		$creds       = $this->base->get_api_credentials();
		$can_migrate = $this->base->can_migrate();
		$is_legacy_active = $this->base->is_legacy_active();

		// Set panels requiring credentials.
		if ( $creds ) {
			$panels['optins'] = __( 'Campaigns', 'optin-monster-api' );
		}

		// Set default panels.
		$panels['api']  = __( 'API Credentials', 'optin-monster-api' );

		// Set the settings panel.
		//$panels['settings'] = __( 'Settings', 'optin-monster-api' );

		// Set the Support panel
		$panels['support'] = __( 'Support', 'optin-monster-api' );

		// Set the migration panel.
		if ( $creds && $can_migrate && $is_legacy_active ) {
			$panels['migrate'] = __( 'Migration', 'optin-monster-api' );
		}

		return apply_filters( 'optin_monster_api_panels', $panels );

	}

	/**
	 * Retrieves the setting UI for the setting specified.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id      The optin ID to target.
	 * @param string $setting The possible subkey setting for the option.
	 * @return string         HTML setting string.
	 */
	public function get_setting_ui( $id, $setting = '' ) {

		// Prepare variables.
		$ret      = '';
		$optin_id = isset( $_GET['optin_monster_api_id'] ) ? absint( $_GET['optin_monster_api_id'] ) : 0;
		$value    = 'optins' == $id ? get_post_meta( $optin_id, '_omapi_' . $setting, true ) : $this->base->get_option( $id, $setting );
		$optin = get_post( $optin_id);

		// Load the type of setting UI based on the option.
		switch ( $id ) {
			case 'api' :
				switch ( $setting ) {
					case 'user' :
						$ret = $this->get_password_field( $setting, $value, $id, __( 'Legacy API Username', 'optin-monster-api' ), __( 'The Legacy API Username found in your OptinMonster Account API area.', 'optin-monster-api' ), __( 'Enter your Legacy API Username here...', 'optin-monster-api' ) );
					break 2;

					case 'key' :
						$ret = $this->get_password_field( $setting, $value, $id, __( 'Legacy API Key', 'optin-monster-api' ), __( 'The Legacy API Key found in your OptinMonster Account API area.', 'optin-monster-api' ), __( 'Enter your Legacy API Key here...', 'optin-monster-api' ) );
					break 2;

					case 'apikey' :
						$ret = $this->get_password_field( $setting, $value, $id, __( 'API Key', 'optin-monster-api'), __( 'A single API Key found in your OptinMonster Account API area.', 'optin-monster-api'), __( 'Enter your API Key here...', 'optin-monster-api') );
					break 2;
				}
			break;

			case 'settings' :
				switch ( $setting ) {
					case 'cookies' :
						$ret = $this->get_checkbox_field( $setting, $value, $id, __( 'Clear local cookies on campaign update?', 'optin-monster-api' ), __( 'If checked, local cookies will be cleared for all campaigns after campaign settings are adjusted and saved.', 'optin-monster-api' ) );
					break 2;
				}
			break;

			case 'support' :
				switch ( $setting ) {
					case 'video' :
						$ret = '<div class="omapi-half-column"><div class="omapi-video-container"><iframe width="640" height="360" src="https://www.youtube.com/embed/tUoJcp5Z9H0?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe></div></div>';
						break 2;

					case 'links' :
						$ret = $this->get_support_links( $setting, 'Helpful Links' );
						break 2;

					case 'server-report';
						$ret = $this->get_plugin_report($setting, 'Server / Plugin Report');
						break 2;
				}
				break;

			case 'toggle' :
				switch ( $setting ) {
					case 'advanced-start' :
						$ret = $this->get_toggle_start( $setting, __( 'Advanced Settings', 'optin-monster-api'), __('More specific settings available for campaign visibility.', 'optin-monster-api') );
					break 2;
					case 'advanced-end' :
						$ret = $this->get_toggle_end();
					break 2;
					case 'woocommerce-start' :
						$ret = $this->get_toggle_start( $setting, __( 'WooCommerce Settings', 'optin-monster-api'), __('More specific settings available for WooCommerce integration.', 'optin-monster-api') );
						break 2;
					case 'woocommerce-end' :
						$ret = $this->get_toggle_end();
						break 2;
				}
			break;

			case 'optins' :
				switch ( $setting ) {
					case 'enabled' :
						$ret = $this->get_checkbox_field( $setting, $value, $id, __( 'Enable campaign on site?', 'optin-monster-api' ), __( 'The campaign will not be displayed on this site unless this setting is checked.', 'optin-monster-api' ) );
					break 2;

					case 'automatic' :
						$ret = $this->get_checkbox_field( $setting, $value, $id, __( 'Display the campaign automatically after blog posts', 'optin-monster-api' ), sprintf( __( 'If no advanced settings are selected below, the campaign will display after every post. You can turn this off and add it manually to your posts by <a href="%s" target="_blank" rel="noopener">clicking here and viewing the tutorial.</a>', 'optin-monster-api' ), 'https://optinmonster.com/docs/how-to-manually-add-an-after-post-or-inline-optin/' ), array('omapi-after-post-auto-select') );
					break 2;
					case 'automatic_shortcode' :
						$full_shortcode ='[optin-monster-shortcode id="'. $optin->post_name .'"]';
						$ret = $this->get_text_field(
							$setting,
							$full_shortcode,
							$id,
							__( 'Shortcode for this campaign', 'optin-monster-api' ),
							sprintf( __( 'Use the shortcode to manually add this campaign to inline to a post or page. <a href="%s" title="Click here to learn more about how this work" target="_blank" rel="noopener">Click here to learn more about how this works.</a>', 'optin-monster-api' ), 'https://optinmonster.com/docs/how-to-manually-add-an-after-post-or-inline-optin/' ),
							false,
							array(),
							true
						);
					break 2;

					case 'users' :
						$ret = $this->get_dropdown_field( $setting, $value, $id, $this->get_user_output(), __( 'Who should see this campaign?', 'optin-monster-api' ), sprintf( __( 'Determines who should be able to view this campaign. Want to hide for newsletter subscribers? <a href="%s" target="_blank" rel="noopener">Click here to learn how.</a>', 'optin-monster-api' ), 'https://optinmonster.com/docs/how-to-hide-optinmonster-from-existing-newsletter-subscribers/' ) );
					break 2;

					case 'never' :
						$val = is_array( $value ) ? implode( ',', $value ) : $value;
						$ret = $this->get_custom_field( $setting, '<input type="hidden" value="' . $val . '" id="omapi-field-' . $setting . '" class="omapi-select" name="omapi[' . $id . '][' . $setting . ']" data-placeholder="' . esc_attr__( 'Type to search and select post(s)...', 'optin-monster-api' ) . '">', __( 'Never load campaign on:', 'optin-monster-api' ), __( 'Never loads the campaign on the selected posts and/or pages. Does not disable automatic Global output.', 'optin-monster-api' ) );
					break 2;

					case 'only' :
						$val = is_array( $value ) ? implode( ',', $value ) : $value;
						$ret = $this->get_custom_field( $setting, '<input type="hidden" value="' . $val . '" id="omapi-field-' . $setting . '" class="omapi-select" name="omapi[' . $id . '][' . $setting . ']" data-placeholder="' . esc_attr__( 'Type to search and select post(s)...', 'optin-monster-api' ) . '">', __( 'Load campaign specifically on:', 'optin-monster-api' ), __( 'Loads the campaign on the selected posts and/or pages.', 'optin-monster-api' ) );
					break 2;

					case 'categories' :
						$categories = get_categories();
						if ( $categories ) {
							ob_start();
							wp_category_checklist( 0, 0, (array) $value, false, null, true );
							$cats = ob_get_clean();
							$ret  = $this->get_custom_field( 'categories', $cats, __( 'Load campaign on post categories:', 'optin-monster-api' ) );
						}
					break;

					case 'taxonomies' :
						// Attempt to load post tags.
						$html = '';
						$tags = get_taxonomy( 'post_tag' );
						if ( $tags ) {
							$tag_terms = get_tags();
							if ( $tag_terms ) {
								$display = (array) $value;
								$display = isset( $display['post_tag'] ) ? implode( ',', $display['post_tag'] ) : '';
								$html    = $this->get_custom_field( $setting, '<input type="hidden" value="' . $display . '" id="omapi-field-' . $setting . '" class="omapi-select" name="tax_input[post_tag][]" data-placeholder="' . esc_attr__( 'Type to search and select post tag(s)...', 'optin-monster-api' ) . '">', __( 'Load campaign on post tags:', 'optin-monster-api' ), __( 'Loads the campaign on the selected post tags.', 'optin-monster-api' ) );
							}
						}

						// Possibly load taxonomies setting if they exist.
						$taxonomies                = get_taxonomies( array( 'public' => true, '_builtin' => false ) );
						$taxonomies['post_format'] = 'post_format';
						$data                      = array();

						// Allow returned taxonmies to be filtered before creating UI.
						$taxonomies = apply_filters('optin_monster_api_setting_ui_taxonomies', $taxonomies );

						if ( $taxonomies ) {
							foreach ( $taxonomies as $taxonomy ) {
								$terms = get_terms( $taxonomy );
								if ( $terms ) {
									ob_start();
									$display = (array) $value;
									$display = isset( $display[ $taxonomy ] ) ? $display[ $taxonomy ] : array();
									$tax     = get_taxonomy( $taxonomy );
									$args    = array(
										'descendants_and_self' => 0,
										'selected_cats'        => (array) $display,
										'popular_cats'         => false,
										'walker'               => null,
										'taxonomy'             => $taxonomy,
										'checked_ontop'        => true
									);
									wp_terms_checklist( 0, $args );
									$output = ob_get_clean();
									if ( ! empty( $output ) ) {
										$data[ $taxonomy ] = $this->get_custom_field( 'taxonomies', $output, __( 'Load campaign on ' . strtolower( $tax->labels->name ) . ':', 'optin-monster-api' ) );
									}
								}
							}
						}

						// If we have taxonomies, add them to the taxonomies key.
						if ( ! empty( $data ) ) {
							foreach ( $data as $setting ) {
								$html .= $setting;
							}
						}

						// Return the data.
						$ret = $html;
					break;

					case 'show' :
						$ret = $this->get_custom_field( 'show', $this->get_show_fields( $value ), __( 'Load campaign on post types and archives:', 'optin-monster-api' ) );
					break;

					case 'mailpoet' :
						$ret = $this->get_checkbox_field( $setting, $value, $id, __( 'Save lead to MailPoet?', 'optin-monster-api' ), __( 'If checked, successful campaign leads will be saved to MailPoet.', 'optin-monster-api' ) );
					break 2;

					case 'mailpoet_list' :
						$ret = $this->get_dropdown_field( $setting, $value, $id, $this->get_mailpoet_lists(), __( 'Add lead to this MailPoet list:', 'optin-monster-api' ), __( 'All successful leads for the campaign will be added to this particular MailPoet list.', 'optin-monster-api' ) );
					break 2;

					// Start WooCommerce settings.
					case 'show_on_woocommerce' :
						$ret = $this->get_checkbox_field( $setting, $value, $id, __( 'Show on all WooCommerce pages', 'optin-monster-api' ), __( 'The campaign will show on any page where WooCommerce templates are used.', 'optin-monster-api' ) );
						break 2;

					case 'is_wc_shop' :
						$ret = $this->get_checkbox_field( $setting, $value, $id, __( 'Show on WooCommerce shop', 'optin-monster-api' ), __( 'The campaign will show on the product archive page (shop).', 'optin-monster-api' ) );
						break 2;

					case 'is_wc_product' :
						$ret = $this->get_checkbox_field( $setting, $value, $id, __( 'Show on WooCommerce products', 'optin-monster-api' ), __( 'The campaign will show on any single product.', 'optin-monster-api' ) );
						break 2;

					case 'is_wc_cart' :
						$ret = $this->get_checkbox_field( $setting, $value, $id, __( 'Show on WooCommerce Cart', 'optin-monster-api' ), __( 'The campaign will show on the cart page.', 'optin-monster-api' ) );
						break 2;

					case 'is_wc_checkout' :
						$ret = $this->get_checkbox_field( $setting, $value, $id, __( 'Show on WooCommerce Checkout', 'optin-monster-api' ), __( 'The campaign will show on the checkout page.', 'optin-monster-api' ) );
						break 2;

					case 'is_wc_account' :
						$ret = $this->get_checkbox_field( $setting, $value, $id, __( 'Show on WooCommerce Customer Account', 'optin-monster-api' ), __( 'The campaign will show on the WooCommerce customer account pages.', 'optin-monster-api' ) );
						break 2;

					case 'is_wc_endpoint' :
						$ret = $this->get_checkbox_field( $setting, $value, $id, __( 'Show on all WooCommerce Endpoints', 'optin-monster-api' ), __( 'The campaign will show when on any WooCommerce Endpoint.', 'optin-monster-api' ) );
						break 2;
					case 'is_wc_endpoint_order_pay' :
						$ret = $this->get_checkbox_field( $setting, $value, $id, __( 'Show on WooCommerce Order Pay endpoint', 'optin-monster-api' ), __( 'The campaign will show when the endpoint page for order pay is displayed.', 'optin-monster-api' ) );
						break 2;

					case 'is_wc_endpoint_order_received' :
						$ret = $this->get_checkbox_field( $setting, $value, $id, __( 'Show on WooCommerce Order Received endpoint', 'optin-monster-api' ), __( 'The campaign will show when the endpoint page for order received is displayed.', 'optin-monster-api' ) );
						break 2;

					case 'is_wc_endpoint_view_order' :
						$ret = $this->get_checkbox_field( $setting, $value, $id, __( 'Show on WooCommerce View Order endpoint', 'optin-monster-api' ), __( 'The campaign will show when the endpoint page for view order is displayed.', 'optin-monster-api' ) );
						break 2;

					case 'is_wc_endpoint_edit_account' :
						$ret = $this->get_checkbox_field( $setting, $value, $id, __( 'Show on WooCommerce Edit Account endpoint', 'optin-monster-api' ), __( 'The campaign will show when the endpoint page for edit account is displayed.', 'optin-monster-api' ) );
						break 2;

					case 'is_wc_endpoint_edit_address' :
						$ret = $this->get_checkbox_field( $setting, $value, $id, __( 'Show on WooCommerce Edit Address endpoint', 'optin-monster-api' ), __( 'The campaign will show when the endpoint page for edit address is displayed.', 'optin-monster-api' ) );
						break 2;

					case 'is_wc_endpoint_lost_password' :
						$ret = $this->get_checkbox_field( $setting, $value, $id, __( 'Show on WooCommerce Lost Password endpoint', 'optin-monster-api' ), __( 'The campaign will show when the endpoint page for lost password is displayed.', 'optin-monster-api' ) );
						break 2;

					case 'is_wc_endpoint_customer_logout' :
						$ret = $this->get_checkbox_field( $setting, $value, $id, __( 'Show on WooCommerce Customer Logout endpoint', 'optin-monster-api' ), __( 'The campaign will show when the endpoint page for customer logout is displayed.', 'optin-monster-api' ) );
						break 2;

					case 'is_wc_endpoint_add_payment_method' :
						$ret = $this->get_checkbox_field( $setting, $value, $id, __( 'Show on WooCommerce Add Payment Method endpoint', 'optin-monster-api' ), __( 'The campaign will show when the endpoint page for add payment method is displayed.', 'optin-monster-api' ) );
						break 2;

					case 'is_wc_product_category' :
						$taxonomy = 'product_cat';
						$terms = get_terms( $taxonomy );
						if ( $terms ) {
							ob_start();
							$display = isset( $value ) ? (array) $value : array();
							$args    = array(
								'descendants_and_self' => 0,
								'selected_cats'        => $display,
								'popular_cats'         => false,
								'walker'               => null,
								'taxonomy'             => $taxonomy,
								'checked_ontop'        => true
							);
							wp_terms_checklist( 0, $args );
							$output = ob_get_clean();
							if ( ! empty( $output ) ) {
								$ret = $this->get_custom_field( $setting, $output, __( 'Show on WooCommerce Product Categories:', 'optin-monster-api' ) );
							}
						}
						break 2;

					case 'is_wc_product_tag' :
						$taxonomy = 'product_tag';
						$terms = get_terms( $taxonomy );
						if ( $terms ) {
							ob_start();
							$display = isset( $value ) ? (array) $value : array();
							$args    = array(
								'descendants_and_self' => 0,
								'selected_cats'        => $display,
								'popular_cats'         => false,
								'walker'               => null,
								'taxonomy'             => $taxonomy,
								'checked_ontop'        => true
							);
							wp_terms_checklist( 0, $args );
							$output = ob_get_clean();
							if ( ! empty( $output ) ) {
								$ret = $this->get_custom_field( $setting, $output, __( 'Show on WooCommerce Product Tags:', 'optin-monster-api' ) );
							}
						}
						break 2;

				}
			break;
			case 'note' :
				switch ( $setting ) {
					case 'sidebar_widget_notice' :
						$ret = $this->get_optin_type_note( $setting, __('Use Widgets to set Sidebar output', 'optin-monster-api'), __('You can set this campaign to show in your sidebars using the OptinMonster widget within your sidebars.', 'optin-monster-api'), 'widgets.php', __('Go to Widgets', 'optin-monster-api') );
					break 2;
				}
			break;
		}

		// Return the setting output.
		return apply_filters( 'optin_monster_api_setting_ui', $ret, $setting, $id );

	}

	/**
	 * Returns the user output settings available for an optin.
	 *
	 * @since 1.0.0
	 *
	 * @return array An array of user dropdown values.
	 */
	public function get_user_output() {

		return apply_filters( 'optin_monster_api_user_output',
			array(
				array(
					'name'  => __( 'Show campaign to all visitors and users', 'optin-monster-api' ),
					'value' => 'all'
				),
				array(
					'name'  => __( 'Show campaign to only visitors (not logged-in)', 'optin-monster-api' ),
					'value' => 'out'
				),
				array(
					'name'  => __( 'Show campaign to only users (logged-in)', 'optin-monster-api' ),
					'value' => 'in'
				)
			)
		);

	}

	/**
	 * Returns the available MailPoet lists.
	 *
	 * @since 1.0.0
	 *
	 * @return array An array of MailPoet lists.
	 */
	public function get_mailpoet_lists() {

		// Prepare variables.
		$mailpoet  = null;
		$lists     = array();
		$ret       = array();
		$listIdKey = 'id';

		// Get lists. Check for MailPoet 3 first. Default to legacy.
		if ( class_exists( '\\MailPoet\\Config\\Initializer' ) ) {
			$lists = \MailPoet\API\API::MP('v1')->getLists();
		} else {
			$mailpoet  = WYSIJA::get( 'list', 'model' );
			$lists     = $mailpoet->get( array( 'name', 'list_id' ), array( 'is_enabled' => 1 ) );
			$listIdKey = 'list_id';
		}

		// Add default option.
		$ret[]    = array(
			'name'  => __( 'Select your MailPoet list...', 'optin-monster-api' ),
			'value' => 'none'
		);

		// Loop through the list data and add to array.
		foreach ( (array) $lists as $list ) {
			$ret[] = array(
				'name'  => $list['name'],
				'value' => $list[ $listIdKey ],
			);
		}

		/**
		 * Filters the MailPoet lists.
		 *
		 *
		 * @param array       $ret      The MailPoet lists array.
		 * @param array       $lists    The raw MailPoet lists array. Format differs by plugin verison.
		 * @param WYSIJA|null $mailpoet The MailPoet object if using legacy. Null otherwise.
		 */
		return apply_filters( 'optin_monster_api_mailpoet_lists', $ret, $lists, $mailpoet );

	}

	/**
	 * Retrieves the UI output for the single posts show setting.
	 *
	 * @since 2.0.0
	 *
	 * @param array $value  The meta index value for the show setting.
	 * @return string $html HTML representation of the data.
	 */
	public function get_show_fields( $value ) {

		// Increment the global tabindex counter.
		$this->tabindex++;

		$output  = '<label for="omapi-field-show-index" class="omapi-custom-label">';
		$output .= '<input type="checkbox" id="omapi-field-show-index" name="omapi[optins][show][]" value="index"' . checked( in_array( 'index', (array) $value ), 1, false ) . ' /> ' . __( 'Front Page and Search Pages', 'optin-monster-api' ) . '</label><br />';
		$post_types = get_post_types( array( 'public' => true ) );
		foreach ( (array) $post_types as $show ) {
			$pt_object = get_post_type_object( $show );
			$label     = $pt_object->labels->name;
			$output   .= '<label for="omapi-field-show-' . esc_html( strtolower( $label ) ) . '" class="omapi-custom-label">';
			$output   .= '<input type="checkbox" id="omapi-field-show-' . esc_html( strtolower( $label ) ) . '" name="omapi[optins][show][]" tabindex="' . $this->tabindex . '" value="' . $show . '"' . checked( in_array( $show, (array) $value ), 1, false ) . ' /> ' . esc_html( $label ) . '</label><br />';

			// Increment the global tabindex counter and iterator.
			$this->tabindex++;
		}

		return $output;

	}

	/**
	 * Retrieves the UI output for a plain text input field setting.
	 *
	 * @since 1.0.0
	 *
	 * @param string $setting The name of the setting to be saved to the DB.
	 * @param mixed $value    The value of the setting.
	 * @param string $id      The setting ID to target for name field.
	 * @param string $label   The label of the input field.
	 * @param string $desc    The description for the input field.
	 * @param string $place   Placeholder text for the field.
	 * @param array $classes  Array of classes to add to the field.
	 * @param boolean $copy   Turn on clipboard copy button and make field readonly
	 * @return string $html   HTML representation of the data.
	 */
	public function get_text_field( $setting, $value, $id, $label, $desc = false, $place = false, $classes = array(), $copy = false ) {

		// Increment the global tabindex counter.
		$this->tabindex++;

		// Check for copy set
		$readonly_output = $copy ? 'readonly' : '';

		// Build the HTML.
		$field  = '<div class="omapi-field-box omapi-text-field omapi-field-box-' . $setting . ' omapi-clear">';
				$field .= '<p class="omapi-field-wrap"><label for="omapi-field-' . $setting . '">' . $label . '</label><br />';
				$field .= '<input type="text" id="omapi-field-' . $setting . '" class="' . implode( ' ', (array) $classes ) . '" name="omapi[' . $id . '][' . $setting . ']" tabindex="' . $this->tabindex . '" value="' . esc_attr( $value ) . '"' . ( $place ? ' placeholder="' . $place . '"' : '' ) . $readonly_output .' />';
				if ( $copy ) {
					$field .= '<span class="omapi-copy-button button"  data-clipboard-target="#omapi-field-' . $setting . '">Copy to clipboard</span>';
				}
				if ( $desc ) {
					$field .= '<br /><label for="omapi-field-' . $setting . '"><span class="omapi-field-desc">' . $desc . '</span></label>';
				}
				$field .= '</p>';
		$field .= '</div>';

		// Return the HTML.
		return apply_filters( 'optin_monster_api_text_field', $field, $setting, $value, $id, $label );

	}


	/**
	 * Retrieves the UI output for a password input field setting.
	 *
	 * @since 1.0.0
	 *
	 * @param string $setting The name of the setting to be saved to the DB.
	 * @param mixed $value    The value of the setting.
	 * @param string $id      The setting ID to target for name field.
	 * @param string $label   The label of the input field.
	 * @param string $desc    The description for the input field.
	 * @param string $place   Placeholder text for the field.
	 * @param array $classes  Array of classes to add to the field.
	 * @return string $html   HTML representation of the data.
	 */
	public function get_password_field( $setting, $value, $id, $label, $desc = false, $place = false, $classes = array() ) {

		// Increment the global tabindex counter.
		$this->tabindex++;

		// Build the HTML.
		$field  = '<div class="omapi-field-box omapi-password-field omapi-field-box-' . $setting . ' omapi-clear">';
			$field .= '<p class="omapi-field-wrap"><label for="omapi-field-' . $setting . '">' . $label . '</label><br />';
				$field .= '<input type="password" id="omapi-field-' . $setting . '" class="' . implode( ' ', (array) $classes ) . '" name="omapi[' . $id . '][' . $setting . ']" tabindex="' . $this->tabindex . '" value="' . $value . '"' . ( $place ? ' placeholder="' . $place . '"' : '' ) . ' />';
				if ( $desc ) {
					$field .= '<br /><label for="omapi-field-' . $setting . '"><span class="omapi-field-desc">' . $desc . '</span></label>';
				}
			$field .= '</p>';
		$field .= '</div>';

		// Return the HTML.
		return apply_filters( 'optin_monster_api_password_field', $field, $setting, $value, $id, $label );

	}

	/**
	 * Retrieves the UI output for a hidden input field setting.
	 *
	 * @since 1.0.0
	 *
	 * @param string $setting The name of the setting to be saved to the DB.
	 * @param mixed $value    The value of the setting.
	 * @param string $id      The setting ID to target for name field.
	 * @param array $classes  Array of classes to add to the field.
	 * @return string $html   HTML representation of the data.
	 */
	public function get_hidden_field( $setting, $value, $id, $classes = array() ) {

		// Increment the global tabindex counter.
		$this->tabindex++;

		// Build the HTML.
		$field  = '<div class="omapi-field-box omapi-hidden-field omapi-field-box-' . $setting . ' omapi-clear omapi-hidden">';
		$field .= '<input type="hidden" id="omapi-field-' . $setting . '" class="' . implode( ' ', (array) $classes ) . '" name="omapi[' . $id . '][' . $setting . ']" tabindex="' . $this->tabindex . '" value="' . $value . '" />';
		$field .= '</div>';

		// Return the HTML.
		return apply_filters( 'optin_monster_api_hidden_field', $field, $setting, $value, $id );

	}
	/**
	 * Retrieves the UI output for a plain textarea field setting.
	 *
	 * @since 1.0.0
	 *
	 * @param string $setting The name of the setting to be saved to the DB.
	 * @param mixed $value    The value of the setting.
	 * @param string $id      The setting ID to target for name field.
	 * @param string $label   The label of the input field.
	 * @param string $desc    The description for the input field.
	 * @param string $place   Placeholder text for the field.
	 * @param array $classes  Array of classes to add to the field.
	 * @return string $html   HTML representation of the data.
	 */
	public function get_textarea_field( $setting, $value, $id, $label, $desc = false, $place = false, $classes = array() ) {

		// Increment the global tabindex counter.
		$this->tabindex++;

		// Build the HTML.
		$field  = '<div class="omapi-field-box omapi-textarea-field omapi-field-box-' . $setting . ' omapi-clear">';
			$field .= '<p class="omapi-field-wrap"><label for="omapi-field-' . $setting . '">' . $label . '</label><br />';
				$field .= '<textarea id="omapi-field-' . $setting . '" class="' . implode( ' ', (array) $classes ) . '" name="omapi[' . $id . '][' . $setting . ']" rows="5" tabindex="' . $this->tabindex . '"' . ( $place ? ' placeholder="' . $place . '"' : '' ) . '>' . $value . '</textarea>';
				if ( $desc ) {
					$field .= '<br /><label for="omapi-field-' . $setting . '"><span class="omapi-field-desc">' . $desc . '</span></label>';
				}
			$field .= '</p>';
		$field .= '</div>';

		// Return the HTML.
		return apply_filters( 'optin_monster_api_textarea_field', $field, $setting, $value, $id, $label );

	}

	/**
	 * Retrieves the UI output for a checkbox setting.
	 *
	 * @since 1.0.0
	 *
	 * @param string $setting The name of the setting to be saved to the DB.
	 * @param mixed $value    The value of the setting.
	 * @param string $id      The setting ID to target for name field.
	 * @param string $label   The label of the input field.
	 * @param string $desc    The description for the input field.
	 * @param array $classes  Array of classes to add to the field.
	 * @return string $html   HTML representation of the data.
	 */
	public function get_checkbox_field( $setting, $value, $id, $label, $desc = false, $classes = array() ) {

		// Increment the global tabindex counter.
		$this->tabindex++;

		// Build the HTML.
		$field  = '<div class="omapi-field-box omapi-checkbox-field omapi-field-box-' . $setting . ' omapi-clear">';
			$field .= '<p class="omapi-field-wrap"><label for="omapi-field-' . $setting . '">' . $label . '</label><br />';
				$field .= '<input type="checkbox" id="omapi-field-' . $setting . '" class="' . implode( ' ', (array) $classes ) . '" name="omapi[' . $id . '][' . $setting . ']" tabindex="' . $this->tabindex . '" value="' . $value . '"' . checked( $value, 1, false ) . ' /> ';
				if ( $desc ) {
					$field .= '<label for="omapi-field-' . $setting . '"><span class="omapi-field-desc">' . $desc . '</span></label>';
				}
			$field .= '</p>';
		$field .= '</div>';

		// Return the HTML.
		return apply_filters( 'optin_monster_api_checkbox_field', $field, $setting, $value, $id, $label );

	}

	/**
	 * Retrieves the UI output for a dropdown field setting.
	 *
	 * @since 1.0.0
	 *
	 * @param string $setting The name of the setting to be saved to the DB.
	 * @param mixed $value    The value of the setting.
	 * @param string $id      The setting ID to target for name field.
	 * @param array $data     The data to be used for option fields.
	 * @param string $label   The label of the input field.
	 * @param string $desc    The description for the input field.
	 * @param array $classes  Array of classes to add to the field.
	 * @return string $html   HTML representation of the data.
	 */
	public function get_dropdown_field( $setting, $value, $id, $data, $label, $desc = false, $classes = array() ) {

		// Increment the global tabindex counter.
		$this->tabindex++;

		// Build the HTML.
		$field  = '<div class="omapi-field-box omapi-dropdown-field omapi-field-box-' . $setting . ' omapi-clear">';
			$field .= '<p class="omapi-field-wrap"><label for="omapi-field-' . $setting . '">' . $label . '</label><br />';
				$field .= '<select id="omapi-field-' . $setting . '" class="' . implode( ' ', (array) $classes ) . '" name="omapi[' . $id . '][' . $setting . ']" tabindex="' . $this->tabindex . '">';
				foreach ( $data as $i => $info ) {
					$field .= '<option value="' . $info['value'] . '"' . selected( $info['value'], $value, false ) . '>' . $info['name'] . '</option>';
				}
				$field .= '</select>';
				if ( $desc ) {
					$field .= '<br /><label for="omapi-field-' . $setting . '"><span class="omapi-field-desc">' . $desc . '</span></label>';
				}
			$field .= '</p>';
		$field .= '</div>';

		// Return the HTML.
		return apply_filters( 'omapi_dropdown_field', $field, $setting, $value, $id, $label, $data );

	}

	/**
	 * Retrieves the UI output for a field with a custom output.
	 *
	 * @since 1.0.0
	 *
	 * @param string $setting The name of the setting to be saved to the DB.
	 * @param mixed $value    The value of the setting.
	 * @param string $label   The label of the input field.
	 * @param string $desc    The description for the input field.
	 * @return string $html   HTML representation of the data.
	 */
	public function get_custom_field( $setting, $value, $label, $desc = false ) {

		// Build the HTML.
		$field = '<div class="omapi-field-box omapi-custom-field omapi-field-box-' . $setting . ' omapi-clear">';
			$field .= '<p class="omapi-field-wrap"><label for="omapi-field-' . $setting . '">' . $label . '</label></p>';
			$field .= $value;
			if ( $desc ) {
				$field .= '<br /><label for="omapi-field-' . $setting . '"><span class="omapi-field-desc">' . $desc . '</span></label>';
			}
		$field .= '</div>';

		// Return the HTML.
		return apply_filters( 'optin_monster_api_custom_field', $field, $setting, $value, $label );

	}

	/**
	 * Starts the toggle wrapper for a toggle section.
	 *
	 * @since 1.1.5
	 *
	 * @param $label
	 * @param $desc
	 *
	 * @return mixed|void
	 */
	public function get_toggle_start( $setting, $label, $desc ) {
		$field = '<div class="omapi-ui-toggle-controller">';
			$field .= '<p class="omapi-field-wrap"><label for="omapi-field-' . $setting . '">' . $label . '</label></p>';
			if ( $desc ) {
				$field .= '<span class="omapi-field-desc">' . $desc . '</span>';
			}
		$field .= '</div>';
		$field .= '<div class="omapi-ui-toggle-content">';

		return apply_filters( 'optin_monster_api_toggle_start_field', $field, $label, $desc  );
	}

	/**
	 * Closes toggle wrapper.
	 *
	 * @since 1.1.5
	 * @return string HTML end for toggle start
	 */
	public function get_toggle_end(){

		$field = '</div>';

		return apply_filters( 'optin_monster_api_toggle_end_field', $field );
	}

	/**
	 *  Helper note output with title, text, and admin linked button.
	 *
	 * @since 1.1.5
	 *
	 * @param $setting
	 * @param $title
	 * @param $text
	 * @param $admin_page
	 * @param $button
	 *
	 * @return mixed|void
	 */
	public function get_optin_type_note( $setting, $title, $text, $admin_page, $button ) {

		$field = '<div class="omapi-field-box  omapi-inline-notice omapi-field-box-' . $setting . ' omapi-clear">';
		if ($title ) {
			$field .= '<p class="omapi-notice-title">' . $title . '</p>';
		}
		if ($text) {
			$field .= '<p class="omapi-field-desc">' . $text . '</p>';
		}
		if ( $admin_page && $button ) {
			// Increment the global tabindex counter.
			$this->tabindex++;
			$field .= '<a href="' . esc_url_raw( admin_url( $admin_page ) ) . '" class="button button-small" title="' . $button . '" target="_blank">' . $button . '</a>';
		}
		$field .= '</div>';

		return apply_filters('optin_monster_api_inline_note_display', $field, $title, $text, $admin_page, $button );
	}

	/**
	 * Support Link output
	 *
	 * @param $setting
	 *
	 * @return mixed|void HTML of the list filtered as needed
	 */
	public function get_support_links( $setting, $title ) {

		$field ='';

		$field .= '<div class="omapi-support-links ' . $setting . '"><h3>' . $title . '</h3><ul>';
		$field .= '<li><a target="_blank" rel="noopener" href="' . esc_url( 'https://optinmonster.com/docs/' ) . '">'. __('Documentation','optin-monster-api') . '</a></li>';
		$field .= '<li><a target="_blank" rel="noopener noreferrer" href="' . esc_url( 'https://wordpress.org/plugins/optinmonster/changelog/' ) . '">'. __('Changelog','optin-monster-api') . '</a></li>';
		$field .= '<li><a target="_blank" rel="noopener" href="' . esc_url( OPTINMONSTER_APP_URL . '/account/support/' ) . '">'. __('Create a Support Ticket','optin-monster-api') . '</a></li>';
		$field .= '</ul></div>';

		return apply_filters( 'optin_monster_api_support_links', $field, $setting);
	}

	public function get_plugin_report( $setting, $title ) {

		$field ='';

		$field .= '<div class="omapi-support-data ' . $setting . '"><h3>' . $title . '</h3>';
		$link = OPTINMONSTER_APP_URL . '/account/support/';
		$field .= '<p>' . sprintf( wp_kses( __( 'Download the report and attach to your <a href="%s">support ticket</a> to help speed up the process.', 'optin-monster-api' ), array(  'a' => array( 'href' => array() ) ) ), esc_url( $link ) ) . '</p>';
		$field .= '<a href="' . esc_url_raw( '#' ) . '" id="js--omapi-support-pdf" class="button button-primary button-large omapi-support-data-button" title="Download a PDF Report for Support" target="_blank">Download PDF Report</a>';
		$field .= '</div>';

		return apply_filters( 'optin_monster_api_support_data', $field, $setting, $title );
	}

	/*
	 * Returns svg of OM Logo
	 */
	public function get_svg_logo() {
		return '<svg class ="omapi-svg-logo" width="100%" height="100%" viewBox="0 0 716 112" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;">
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M565.437,342.797C565.437,343.888 564.892,344.524 563.711,344.707C561.166,345.071 547.717,345.071 545.355,344.616C544.174,344.344 543.54,343.526 543.54,342.162C543.54,338.891 543.903,328.168 543.903,324.897C543.903,322.354 543.63,313.993 543.63,311.447C543.63,305.905 541.268,303.179 536.451,303.179C533.543,303.179 527.546,306.541 527.546,309.813L527.546,342.526C527.546,343.889 526.91,344.616 525.635,344.799C523,345.161 510.097,345.072 507.735,344.708C506.462,344.525 505.827,343.798 505.827,342.709L505.917,314.176C505.917,304.089 505.099,296.183 503.555,290.458C503.372,289.64 503.281,288.459 504.371,288.187C506.916,287.914 510.277,287.46 514.549,286.823C520.999,285.551 524.544,284.916 525.361,284.916C526.544,284.916 526.272,293.094 527.451,293.094C527.906,293.094 529.178,291.731 533.994,288.914C538.81,286.097 542.992,284.733 546.536,284.733C556.35,284.733 565.164,289.548 565.164,299.998C565.164,311.63 565.164,318.809 565.255,331.167C565.255,336.44 565.346,340.346 565.346,342.981L565.437,342.797ZM605.785,295.545C605.785,295.908 605.51,296.453 604.875,297.18C599.967,295.908 592.516,297.453 592.516,303.45C592.516,308.72 604.421,313.358 604.421,325.352C604.421,329.35 602.695,334.984 599.697,337.436C593.699,342.525 584.975,346.795 577.251,346.795C575.343,346.795 567.619,333.892 567.619,332.165C567.619,331.802 567.891,331.62 568.255,331.529C571.071,330.984 573.98,330.439 576.796,329.984C580.342,328.802 582.158,326.986 582.158,324.351C582.158,322.533 581.158,320.534 579.07,318.171C575.344,314.082 573.434,311.901 573.254,311.629C562.803,296.088 580.615,281.277 597.063,281.277C598.607,281.277 605.695,294.272 605.695,295.453L605.785,295.545ZM652.946,326.804C652.946,328.714 652.038,335.8 652.038,337.71C652.038,340.073 651.765,340.162 649.675,341.345C644.496,344.16 638.679,345.615 632.319,345.615C620.596,345.615 614.781,341.162 614.781,332.166C614.781,327.716 615.417,312.631 615.417,308.086C615.417,303.272 608.42,307.27 608.42,303.815C608.42,302.725 608.693,298.908 608.693,297.909C608.693,296.454 608.42,291.547 608.42,290.185C608.42,289.367 609.692,288.913 612.328,288.821C613.782,288.821 614.599,288.367 614.69,287.64C614.962,286.095 615.053,283.642 614.962,280.371C614.781,275.191 614.69,273.192 614.69,272.919C614.69,268.194 615.145,265.922 616.053,265.922C617.78,265.922 624.049,267.376 625.504,267.557C627.592,267.83 630.683,268.284 634.864,268.739C635.864,268.83 636.408,269.193 636.408,269.738C636.408,272.464 635.589,281.734 635.589,284.46C635.589,286.459 636.137,287.458 637.317,287.458C639.679,287.458 647.767,287.094 650.222,287.094C651.13,287.094 651.584,287.368 651.584,288.004C651.584,289.821 650.947,294.547 650.947,296.364L651.039,304.815C651.039,305.633 650.494,306.087 649.311,306.087C645.132,305.996 640.863,305.905 636.68,305.905C636.044,305.905 635.772,306.814 635.772,308.54L635.864,317.173C635.864,323.534 636.679,326.805 643.405,326.805C647.222,326.805 652.946,323.718 652.946,326.716L652.946,326.804ZM690.476,307.903C690.476,299.906 680.572,294.727 675.119,301.633C673.575,303.632 672.847,305.904 672.847,308.63C672.847,309.719 673.392,310.266 674.575,310.266C677.573,310.266 682.208,309.811 688.568,308.902C689.931,308.719 690.568,308.358 690.568,307.903L690.476,307.903ZM711.74,311.629C711.74,315.719 710.379,318.079 707.742,318.626C707.289,318.717 703.107,319.171 695.202,319.989C690.385,320.534 683.298,321.17 673.847,321.898C675.575,330.166 689.295,331.712 697.836,326.714C699.381,325.714 700.927,324.804 702.471,323.804C704.289,324.715 709.741,335.163 709.741,337.073C709.741,337.346 709.469,337.798 708.834,338.437C703.926,343.706 696.292,346.342 685.842,346.342C666.759,346.342 653.492,334.256 653.492,315.08C653.492,296.726 665.124,283.003 683.844,283.003C691.567,283.003 698.201,285.82 703.653,291.545C709.103,297.179 711.83,303.903 711.83,311.717L711.74,311.629ZM752.813,306.813C752.813,309.902 749.363,309.175 746.816,308.995C743.092,308.72 738.639,308.72 736.64,310.447C735.457,311.446 734.822,313.629 734.822,316.808C734.822,319.718 735.005,329.714 735.005,332.62C735.005,334.528 735.459,341.161 735.459,343.07C735.459,344.07 734.822,344.615 733.46,344.706C729.552,345.069 719.376,345.069 715.287,344.615C713.923,344.434 713.288,343.797 713.288,342.615L713.377,313.537C713.377,303.995 712.469,296.181 710.743,290.092C710.56,289.274 710.469,288.184 711.56,288.002C713.832,287.73 717.012,287.275 721.375,286.639C727.735,285.367 731.097,284.731 731.279,284.731C733.097,284.731 732.37,292.364 733.733,292.364C734.278,292.364 734.821,291.274 738.731,289.184C742.637,287.093 746.364,286.003 749.906,286.003C752.177,286.003 753.268,286.457 753.268,287.457C753.268,288.638 753.177,290.274 752.905,292.455C752.268,298.361 752.632,301.815 752.632,306.813L752.813,306.813ZM404.505,342.344C404.505,343.706 403.869,344.524 402.687,344.706C400.236,345.069 386.967,345.069 384.515,344.615C383.333,344.343 382.698,343.343 382.698,341.616C382.698,338.437 383.061,328.075 383.061,324.987C383.061,317.899 382.97,312.901 382.788,309.902C382.516,305.086 380.244,302.724 375.973,302.724C372.156,302.724 367.613,306.54 367.159,310.447C366.977,312.174 366.886,317.08 366.886,325.352C366.886,328.531 367.249,339.436 367.249,342.708C367.249,344.071 366.704,344.707 365.523,344.707L347.166,344.707C346.077,344.707 345.44,343.889 345.44,342.253C345.44,338.983 345.804,328.351 345.804,325.081C345.804,322.534 345.531,313.994 345.531,311.447C345.531,296.546 329.72,304.178 329.72,309.54L329.81,342.436C329.81,344.524 329.628,344.616 327.539,344.797C323.177,345.159 315.816,345.159 310.273,344.707C308.274,344.524 308.274,344.524 308.274,342.436L308.365,313.358C308.365,306.723 307.91,299.272 306.911,291.002C306.729,290.003 306.548,288.913 307.638,288.549C309.637,287.731 316.725,287.368 318.088,287.094C319.451,286.822 325.358,285.005 327.629,285.005C329.447,285.005 328.538,293.547 329.356,293.456C331.81,292.819 337.535,284.551 349.439,284.551C356.526,284.551 363.796,287.913 365.704,294.819C369.976,289.003 378.335,284.551 385.515,284.551C395.69,284.551 404.234,289.548 404.234,300.18C404.234,303.815 403.871,315.901 403.871,319.535C403.871,323.807 404.234,338.255 404.234,342.526L404.505,342.344Z" style="fill:white;fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M79.096,314.536C79.096,308.448 75.098,302.45 68.465,302.45C58.559,302.45 54.379,315.445 60.558,322.988C66.738,330.529 79.096,326.35 79.096,314.536M145.432,315.081C145.432,303.359 132.619,298.815 126.713,306.63C121.806,313.173 123.714,327.35 134.709,327.35C141.798,327.349 145.432,323.26 145.432,315.081M167.878,315.173C167.878,332.165 156.973,345.523 139.525,345.523C132.801,345.523 124.441,340.889 124.714,340.889C124.168,340.889 123.896,341.524 123.896,342.707C123.896,346.342 124.532,357.7 124.532,361.335C124.532,362.607 123.896,363.243 122.533,363.243C119.443,363.243 106.993,363.515 104.813,362.971C103.631,362.698 102.995,361.971 102.995,360.699L103.087,313.991C103.087,304.54 102.359,296.635 100.996,290.183C100.814,289.365 100.724,288.274 101.632,287.911C104.904,286.639 116.445,284.913 120.079,284.913C123.805,284.913 122.442,291.182 123.623,291.182C123.169,291.182 124.986,290.092 128.803,287.911C132.71,285.729 136.163,284.64 139.344,284.64C157.245,284.64 167.968,297.453 167.968,315.081L167.878,315.173ZM214.221,326.622C214.221,329.258 213.313,334.982 213.313,337.526C213.313,339.709 213.131,339.98 210.95,341.161C205.771,343.978 199.955,345.434 193.594,345.434C181.871,345.434 176.056,340.981 176.056,331.985C176.056,327.35 176.692,312.538 176.692,307.904C176.692,302.997 169.695,307.177 169.695,303.634C169.695,302.543 169.967,298.726 169.967,297.726C169.967,296.273 169.695,291.366 169.695,290.002C169.695,289.184 170.967,288.73 173.602,288.64C175.056,288.64 175.874,288.185 175.965,287.458C176.238,285.913 176.328,283.46 176.238,280.188C176.056,275.009 175.965,272.464 175.965,272.737C175.965,268.012 176.419,265.74 177.328,265.74C179.509,265.74 184.507,267.103 186.779,267.376C188.868,267.648 191.958,268.102 196.138,268.557C197.138,268.648 197.683,269.012 197.683,269.557C197.683,272.646 196.865,281.188 196.865,284.277C196.865,286.277 197.41,287.276 198.592,287.276C200.954,287.276 209.042,286.913 211.496,286.913C212.404,286.913 212.858,287.185 212.858,287.822C212.858,289.639 212.222,294.364 212.222,296.182L212.313,304.633C212.313,305.451 211.768,305.905 210.587,305.905C206.225,305.814 202.318,305.723 197.956,305.723C197.32,305.723 197.047,306.632 197.047,308.359L197.138,316.991C197.138,323.352 198.047,326.624 204.68,326.624C208.951,326.624 214.221,323.441 214.221,326.532L214.221,326.622ZM237.757,316.535C237.757,321.533 238.12,337.89 238.12,342.888C238.12,343.706 237.575,344.251 236.575,344.434C233.759,344.887 220.764,344.979 217.947,344.434C217.038,344.251 216.493,343.98 216.312,343.616C216.039,343.071 216.584,318.719 216.584,316.537C216.584,305.087 216.13,295.909 215.221,289.094C214.857,286.095 215.585,286.277 221.946,287.004C230.124,287.822 231.487,286.731 237.757,286.731C239.484,286.731 239.211,287.822 239.12,289.094C238.212,296.998 237.757,306.086 237.757,316.535M239.302,271.464C239.302,278.46 235.304,282.005 227.398,282.005C214.857,282.005 212.04,269.464 219.129,263.739C226.58,257.742 239.302,261.831 239.302,271.464M304.366,342.615C304.366,343.706 303.821,344.343 302.639,344.523C300.095,344.887 286.646,344.887 284.283,344.434C283.102,344.16 282.466,343.344 282.466,341.98C282.466,338.71 282.829,327.987 282.829,324.716C282.829,322.17 282.556,313.809 282.556,311.266C282.556,305.723 280.194,302.997 275.378,302.997C272.288,302.997 266.472,306.45 266.472,309.631L266.472,342.345C266.472,343.708 265.836,344.434 264.564,344.616C261.565,344.979 249.479,344.979 246.662,344.524C245.39,344.344 244.754,343.616 244.754,342.525L244.845,313.994C244.845,303.907 244.027,296.001 242.482,290.276C242.301,289.368 242.301,288.277 243.3,288.005C245.845,287.732 249.207,287.277 253.478,286.641C259.93,285.369 263.473,284.733 264.292,284.733C265.472,284.733 265.2,292.912 266.382,292.912C265.928,292.912 268.108,291.549 272.924,288.732C277.741,285.915 281.921,284.552 285.465,284.552C295.279,284.552 304.093,289.368 304.093,299.818C304.093,311.449 304.093,318.629 304.184,330.987C304.184,336.257 304.275,340.163 304.275,342.799L304.366,342.615ZM98.907,314.536C98.907,332.983 86.73,345.614 68.192,345.614C50.381,345.614 37.659,333.165 37.659,315.264C37.659,296.726 49.2,283.64 68.192,283.64C86.548,283.64 98.907,296.181 98.907,314.536" style="fill:white;fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<g opacity="0.149002">
			<clipPath id="_clip1">
				<rect x="385.878" y="344.16" width="139.94" height="15.086"/>
			</clipPath>
			<g clip-path="url(#_clip1)">
				<path d="M455.848,344.16C494.47,344.16 525.819,347.522 525.819,351.704C525.819,355.884 494.469,359.246 455.848,359.246C417.228,359.246 385.879,355.884 385.879,351.704C385.878,347.522 417.228,344.16 455.848,344.16" style="fill:black;fill-rule:nonzero;"/>
			</g>
		</g>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M497.921,284.186C498.831,283.641 499.012,280.278 499.104,279.279C499.376,277.007 502.193,276.008 504.011,277.189C507.192,279.46 508.827,283.823 509.28,287.548C509.735,291.364 509.372,296.453 506.646,299.452C503.738,302.724 496.377,303.724 492.016,303.269C490.835,303.178 489.744,302.905 488.653,302.724L486.563,284.004L488.837,284.458C491.108,284.912 495.743,285.368 497.833,284.186L497.921,284.186Z" style="fill:rgb(153,153,102);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M505.009,280.551C504.464,279.824 503.828,279.097 503.101,278.643C502.374,278.097 501.011,278.552 500.918,279.461L500.829,280.096C502.193,279.642 503.737,280.006 505.009,280.551M507.554,293.364C508.099,290.456 507.826,287.093 506.827,284.186C506.1,283.277 505.372,282.551 504.009,282.005C502.282,281.278 501.374,281.551 500.559,282.278C500.467,283.005 500.283,283.55 500.104,284.095C504.829,285.64 506.828,290.183 507.555,293.454L507.555,293.364L507.554,293.364ZM493.741,286.639C492.106,286.639 490.379,286.457 488.653,286.094L490.287,301.178C492.471,301.633 495.013,301.633 497.284,301.361C498.92,295.545 497.284,288.73 493.651,286.549L493.741,286.639ZM498.83,285.64C498.195,286.003 497.283,286.276 496.196,286.457C499.466,289.911 500.466,296.181 499.282,301.088C502.009,300.543 504.28,299.543 505.462,298.271C505.735,297.998 505.916,297.634 506.19,297.362C506.19,292.182 504.1,286.639 499.102,285.549C499.01,285.64 499.01,285.64 498.918,285.64L498.83,285.64Z" style="fill:rgb(192,192,160);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M497.921,295.453C495.74,295.999 493.378,296.09 491.65,295.908C490.924,295.817 490.287,295.726 489.651,295.544L488.561,286.185C490.287,286.548 492.015,286.73 493.65,286.73C496.013,288.184 497.56,291.637 497.832,295.453L497.921,295.453ZM504.556,282.277C504.644,282.823 504.736,283.368 504.827,283.912C505.009,285.003 505.009,286.275 504.918,287.548C503.735,286.094 502.192,284.822 500.103,284.095C500.283,283.55 500.466,283.004 500.557,282.277C501.281,281.641 502.281,281.277 504.008,282.005C504.192,282.095 504.373,282.186 504.556,282.277M503.192,278.733C503.465,279.188 503.645,279.642 503.828,280.096C502.828,279.824 501.829,279.732 500.738,280.006L500.829,279.37C500.918,278.46 502.281,278.006 503.01,278.552L503.193,278.642L503.193,278.733L503.192,278.733ZM498.83,285.64C498.194,286.003 497.283,286.275 496.195,286.457C498.194,288.547 499.282,291.637 499.647,294.909C500.918,294.453 502.1,293.818 502.828,292.91C503.556,292.182 501.646,286.094 499.012,285.549C498.92,285.64 498.92,285.64 498.83,285.64" style="fill:rgb(251,250,196);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M412.685,284.186C411.774,283.641 411.594,280.278 411.501,279.279C411.229,277.007 408.412,276.008 406.595,277.189C403.413,279.46 401.779,283.823 401.325,287.548C400.871,291.364 401.234,296.453 403.96,299.452C406.868,302.724 414.228,303.724 418.59,303.269C419.771,303.178 420.862,302.905 421.953,302.724L424.042,284.004L421.769,284.458C419.498,284.912 414.863,285.368 412.773,284.186L412.685,284.186Z" style="fill:rgb(153,153,102);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M405.597,280.551C406.142,279.824 406.778,279.097 407.504,278.643C408.232,278.097 409.595,278.552 409.688,279.461L409.776,280.096C408.413,279.642 406.868,280.006 405.597,280.551M403.051,293.364C402.507,290.456 402.78,287.093 403.779,284.186C404.506,283.277 405.233,282.551 406.596,282.005C408.323,281.278 409.232,281.551 410.047,282.278C410.139,283.005 410.323,283.55 410.502,284.095C405.777,285.64 403.778,290.183 403.05,293.454L403.05,293.364L403.051,293.364ZM416.865,286.639C418.5,286.639 420.227,286.457 421.953,286.094L420.318,301.178C418.135,301.633 415.592,301.633 413.321,301.361C411.685,295.545 413.321,288.73 416.955,286.549L416.865,286.639ZM411.776,285.64C412.411,286.003 413.323,286.276 414.41,286.457C411.139,289.911 410.14,296.181 411.323,301.088C408.597,300.543 406.326,299.543 405.143,298.271C404.87,297.998 404.69,297.634 404.416,297.362C404.416,292.182 406.506,286.639 411.504,285.549C411.595,285.64 411.595,285.64 411.688,285.64L411.776,285.64Z" style="fill:rgb(192,192,160);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M412.685,295.453C414.866,295.999 417.228,296.09 418.955,295.908C419.682,295.817 420.318,295.726 420.954,295.544L422.044,286.185C420.318,286.548 418.591,286.73 416.956,286.73C414.593,288.184 413.048,291.637 412.774,295.453L412.685,295.453ZM406.05,282.277C405.961,282.823 405.87,283.368 405.778,283.912C405.597,285.003 405.597,286.275 405.689,287.548C406.87,286.094 408.414,284.822 410.503,284.095C410.323,283.55 410.14,283.004 410.048,282.277C409.324,281.641 408.325,281.277 406.598,282.005C406.414,282.095 406.233,282.186 406.05,282.277M407.414,278.733C407.141,279.188 406.961,279.642 406.778,280.096C407.777,279.824 408.777,279.732 409.868,280.006L409.776,279.37C409.688,278.46 408.325,278.006 407.596,278.552L407.413,278.642L407.413,278.733L407.414,278.733ZM411.776,285.64C412.412,286.003 413.323,286.275 414.411,286.457C412.412,288.547 411.323,291.637 410.959,294.909C409.688,294.453 408.505,293.818 407.777,292.91C407.051,292.182 408.96,286.094 411.594,285.549C411.685,285.64 411.685,285.64 411.776,285.64" style="fill:rgb(251,250,196);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M422.77,280.551C419.59,280.278 416.499,280.914 413.41,281.369L416.136,278.733C418.773,276.189 422.316,273.917 425.681,272.281C430.677,269.737 436.403,267.829 442.126,267.284C438.126,265.557 433.583,264.739 429.314,263.739C445.763,260.287 466.843,259.014 481.929,271.827C490.563,279.188 495.287,292.819 495.287,305.177C495.287,351.796 415.866,351.796 415.866,305.177C415.866,298.907 417.41,292.91 420.319,287.457C419.229,287.73 418.229,288.093 417.136,288.548L412.323,290.547L415.773,286.639C417.864,284.277 420.227,282.278 422.953,280.733L422.77,280.551Z" style="fill:rgb(142,212,30);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M458.393,266.193C466.118,267.101 473.659,269.646 479.927,275.007C487.56,281.459 491.65,293.454 491.65,304.268C491.65,324.076 475.293,334.346 458.392,334.891L458.392,266.193L458.393,266.193Z" style="fill:rgb(112,169,27);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M429.131,276.28C435.129,272.281 444.944,271.009 456.758,271.646C454.668,269.193 452.76,267.647 449.943,266.284C455.304,266.102 459.574,267.284 470.206,270.919C461.03,265.557 449.763,263.104 439.22,264.285C443.036,265.375 446.671,267.102 450.033,269.374C439.22,268.193 426.769,273.372 421.771,277.643C425.044,277.28 427.95,277.915 431.042,279.279C426.68,280.823 423.862,282.187 421.135,284.822C425.86,282.459 429.586,280.46 435.584,279.188C433.221,278.37 431.949,276.916 429.131,276.28" style="fill:rgb(161,225,65);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M455.483,265.284C466.39,265.284 475.203,273.826 475.203,284.458C475.203,294.999 466.39,303.632 455.483,303.632C444.58,303.632 435.767,295.09 435.767,284.458C435.765,273.917 444.58,265.284 455.483,265.284" style="fill:rgb(112,169,27);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M424.225,302.36C424.861,301.178 484.654,300.724 485.836,302.36C487.924,305.086 486.745,307.721 485.836,309.993L424.225,309.993C423.68,307.539 422.771,304.904 424.225,302.36" style="fill:rgb(112,169,27);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M425.043,304.086C425.679,302.541 483.926,301.905 485.108,304.086C487.107,307.811 485.925,311.446 485.108,314.536L425.043,314.536C424.497,311.173 423.68,307.63 425.043,304.086" style="fill:rgb(75,113,19);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M473.477,264.467C472.66,248.928 451.758,247.292 446.307,259.469C455.939,254.198 465.752,256.107 473.477,264.467" style="fill:rgb(112,169,27);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M461.845,251.563C455.759,250.654 449.125,253.29 446.399,259.377C450.033,257.378 453.76,256.47 457.303,256.47C458.031,255.107 459.757,252.472 461.938,251.563L461.845,251.563Z" style="fill:rgb(133,197,31);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M455.483,263.285C465.297,263.285 473.204,271.191 473.204,281.005C473.204,290.819 465.297,298.725 455.483,298.725C445.671,298.725 437.766,290.819 437.766,281.005C437.766,271.191 445.67,263.285 455.483,263.285" style="fill:rgb(211,232,239);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M444.308,267.829C450.214,262.922 458.484,262.922 462.663,268.011C466.843,273.009 465.39,281.096 459.483,286.094C453.575,291.001 445.307,291.001 441.125,285.912C436.947,280.914 438.402,272.827 444.308,267.829" style="fill:white;fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M455.938,275.008C462.844,275.008 468.388,280.188 468.388,286.639C468.388,293.091 462.842,298.271 455.938,298.271C449.034,298.271 443.489,293.091 443.489,286.639C443.489,280.188 449.033,275.008 455.938,275.008" style="fill:rgb(13,130,223);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M455.938,275.008C459.3,275.008 462.39,276.28 464.571,278.279C463.754,281.096 462.027,283.913 459.482,286.094C454.575,290.183 448.034,290.82 443.58,288.093C443.489,287.639 443.489,287.185 443.489,286.639C443.489,280.188 449.033,275.008 455.938,275.008" style="fill:rgb(3,153,237);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M455.938,279.188C460.3,279.188 463.935,282.55 463.935,286.639C463.935,290.729 460.391,294.09 455.938,294.09C451.577,294.09 447.942,290.729 447.942,286.639C447.942,282.55 451.485,279.188 455.938,279.188" style="fill:rgb(35,35,35);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M455.938,279.188C458.755,279.188 461.209,280.551 462.663,282.55C461.844,283.822 460.754,285.003 459.482,286.003C456.209,288.73 452.21,289.911 448.668,289.638C448.214,288.73 447.942,287.639 447.942,286.548C447.942,282.459 451.485,279.097 455.938,279.097L455.938,279.188Z" style="fill:rgb(50,50,50);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M448.941,275.644C452.212,275.644 454.847,278.098 454.847,281.187C454.847,284.277 452.212,286.731 448.941,286.731C445.67,286.731 443.035,284.277 443.035,281.187C443.035,278.098 445.67,275.644 448.941,275.644" style="fill:white;fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M414.138,308.448C441.581,304.359 469.117,304.722 496.56,308.448C498.559,322.805 497.468,336.438 496.56,350.157C469.117,351.248 441.581,351.431 414.138,350.157C412.502,336.255 412.322,322.351 414.138,308.448" style="fill:rgb(156,174,179);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M422.044,347.341C444.308,348.157 466.481,348.069 488.743,347.341C480.747,342.796 472.75,338.437 463.754,335.983C460.844,337.346 457.757,338.437 454.667,339.345C454.212,339.435 454.212,339.435 453.758,339.345C451.212,338.527 448.669,337.527 446.214,336.438C437.49,338.981 429.585,342.707 421.952,347.433L422.044,347.341ZM416.773,313.173C415.592,324.169 415.773,335.255 416.956,346.25C424.953,341.253 433.494,337.254 442.489,334.438C432.13,328.986 424.86,321.17 416.773,313.173M491.65,310.993C467.389,308.083 443.035,307.811 418.773,310.993C428.768,322.168 439.766,331.348 454.396,336.162C469.933,331.712 480.655,321.988 491.65,310.993M493.741,346.25C494.469,335.255 495.195,324.26 494.014,313.265C485.837,321.353 477.112,329.076 466.934,334.436C476.385,337.253 485.201,341.435 493.834,346.249L493.741,346.249L493.741,346.25Z" style="fill:rgb(211,232,239);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M422.044,347.341C432.765,347.705 443.487,347.886 454.303,347.886L454.303,339.345C454.212,339.345 454.122,339.345 453.849,339.253C451.305,338.438 448.762,337.437 446.307,336.346C437.583,338.89 429.678,342.615 422.044,347.341M416.773,313.173C415.592,324.169 415.773,335.255 416.956,346.25C424.953,341.253 433.494,337.254 442.489,334.438C432.13,328.986 424.86,321.17 416.773,313.173M454.303,308.72C442.399,308.72 430.586,309.447 418.773,310.994C428.679,322.17 439.766,331.258 454.303,336.163L454.303,308.72Z" style="fill:white;fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M438.855,315.264C438.765,315.627 438.583,315.992 438.403,316.355C438.219,316.9 437.856,317.443 437.403,317.807C436.312,318.625 434.95,318.354 433.766,317.898C431.131,316.807 429.315,314.172 428.223,311.628C426.952,308.718 426.86,306.63 427.587,303.449C445.943,302.45 464.754,302.268 482.564,303.358L482.564,303.449L482.838,303.449C483.111,306.539 482.838,307.811 482.112,310.358C481.293,313.265 479.565,316.807 476.659,318.17C475.568,318.717 474.296,318.989 473.296,318.261C472.843,317.898 472.481,317.353 472.206,316.807C471.57,315.808 471.39,314.356 471.207,313.264C470.844,313.991 470.39,314.445 469.662,314.626C468.481,314.899 467.118,315.079 465.936,315.171C464.755,315.263 463.485,315.355 462.21,315.355C460.302,315.355 458.211,315.171 456.396,314.628C456.124,315.719 455.669,316.716 454.579,317.079C453.398,317.443 451.943,317.626 450.671,317.718C449.308,317.807 447.945,317.899 446.673,317.899C444.583,317.899 442.22,317.718 440.312,316.9C439.584,316.627 439.128,316.081 438.858,315.355L438.858,315.264L438.855,315.264Z" style="fill:rgb(153,153,102);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M469.66,302.814C470.388,306.903 470.205,312.174 469.024,312.446C467.206,312.901 460.209,313.629 456.757,312.357C455.846,310.631 455.846,306.269 455.938,302.725C460.664,302.724 465.389,302.724 469.66,302.814M440.308,303.632C439.673,305.541 439.037,307.721 438.401,310.358C438.037,311.994 437.764,313.629 437.49,314.809C437.127,316.444 436.309,316.718 434.764,316.081C430.765,314.356 428.678,307.632 428.857,303.541C431.584,303.359 435.674,303.178 440.307,302.996C444.761,302.905 449.759,302.814 454.757,302.814C455.209,307.812 455.209,313.81 454.121,315.081C452.21,315.72 444.761,316.628 441.124,314.992C439.488,314.266 440.124,308.177 440.215,303.724L440.308,303.632ZM470.388,302.814C470.931,304.995 471.568,307.267 472.203,310.175C472.566,311.992 472.75,313.721 473.021,314.9C473.385,316.717 474.112,316.99 475.565,316.264C479.111,314.445 481.11,307.72 481.017,303.269C478.384,303.087 474.658,302.905 470.388,302.814" style="fill:rgb(192,192,160);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M455.938,305.268C460.209,305.268 464.482,305.268 468.388,305.358C469.024,307.631 469.024,311.72 466.297,312.719C463.39,312.993 459.209,313.082 456.756,312.174C456.121,310.901 455.938,308.084 455.938,305.268M440.217,305.54C444.125,305.449 448.578,305.358 453.031,305.358C453.483,308.63 454.302,315.173 450.213,315.536C447.214,315.809 443.489,315.809 441.125,314.809C439.765,314.173 439.945,309.63 440.126,305.631L440.217,305.54ZM429.041,306.086C430.949,305.904 433.492,305.812 436.49,305.722C436.854,305.722 437.581,314.718 437.581,314.718C437.217,316.354 436.4,316.627 434.855,315.991C431.674,314.628 429.675,310.082 429.129,306.176L429.041,306.086ZM473.022,314.9C473.385,316.717 474.113,316.99 475.566,316.264C478.476,314.809 480.292,310.083 480.838,305.995C479.112,305.812 477.022,305.722 474.566,305.631C473.113,306.722 472.839,314.264 473.022,314.9" style="fill:rgb(251,250,196);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M448.123,305.449C448.307,308.995 448.123,312.537 447.671,312.809C446.763,313.357 443.4,314.082 441.765,312.719C441.126,312.266 441.218,308.811 441.31,305.54C443.49,305.449 445.763,305.449 448.216,305.358L448.123,305.449ZM463.391,305.358C463.481,307.994 463.299,310.447 462.936,310.629C462.119,311.082 458.937,311.629 457.302,310.538C456.757,310.175 456.757,307.72 456.847,305.268L463.392,305.268L463.392,305.358L463.391,305.358ZM434.675,305.812C434.584,306.812 434.584,307.995 434.584,309.175L434.584,312.809C434.584,314.173 434.221,314.445 433.493,313.809C432.041,312.719 430.767,309.266 430.222,306.086C431.494,305.994 433.04,305.904 434.675,305.812M479.747,305.904C478.563,305.812 477.201,305.722 475.657,305.722C475.657,306.721 475.749,307.811 475.749,308.994L475.749,312.901C475.749,314.355 476.021,314.628 476.748,313.991C478.02,312.809 479.202,309.357 479.747,305.904" style="fill:white;fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M419.591,348.068C418.591,352.611 414.045,355.61 409.504,355.428C403.234,355.154 393.51,348.249 393.692,341.434C393.783,337.618 396.6,334.163 399.508,331.984C402.325,329.8 407.05,327.531 410.686,328.53C414.32,329.53 416.864,334.528 418.046,337.798C419.135,340.616 420.227,345.071 419.498,348.069L419.591,348.069L419.591,348.068Z" style="fill:rgb(133,197,31);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M418.046,347.613C418.135,347.068 418.228,346.522 418.228,345.886C417.047,340.888 414.229,335.164 411.049,334.256C406.142,332.8 396.238,339.344 396.781,346.069C399.508,350.249 405.325,353.702 409.504,353.882C413.32,354.065 417.228,351.519 418.047,347.703L418.047,347.613L418.046,347.613Z" style="fill:rgb(112,169,27);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M413.502,342.524C414.773,339.98 412.686,335.527 409.504,335.89C406.142,336.345 398.872,341.343 398.872,345.251C398.872,347.705 402.234,349.432 405.777,348.433C408.413,347.705 412.502,344.615 413.502,342.524M416.319,348.885C416.955,347.34 416.046,344.615 414.229,344.886C412.321,345.251 407.776,348.521 407.959,350.339C408.048,351.794 410.594,353.066 412.594,352.338C414.047,351.794 415.773,350.157 416.319,348.885" style="fill:rgb(93,141,23);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M408.504,330.712C408.595,332.348 405.414,333.8 404.142,332.62C403.051,330.529 403.326,327.985 404.233,327.44C405.233,326.895 407.687,327.895 408.504,330.712" style="fill:rgb(44,68,12);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M402.325,333.711C402.686,335.526 400.235,337.073 399.052,336.255C397.508,334.71 396.964,331.984 397.688,331.348C398.417,330.712 401.052,331.712 402.325,333.711" style="fill:rgb(44,68,12);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M397.69,338.254C398.238,339.436 397.054,341.071 395.691,340.981C394.239,339.89 392.876,337.346 393.419,336.709C393.965,335.983 396.419,336.709 397.69,338.254" style="fill:rgb(44,68,12);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M420.953,321.352C421.681,319.989 419.682,319.078 418.046,318.442C416.408,317.898 415.592,317.898 414.956,319.261C414.228,320.624 413.865,322.713 415.592,323.258C417.227,323.804 420.317,322.713 421.045,321.35L420.953,321.35L420.953,321.352Z" style="fill:rgb(44,68,12);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M422.408,316.264C422.59,317.808 420.407,318.626 418.592,318.99C416.865,319.354 416.137,319.171 415.957,317.626C415.773,316.079 416.229,313.628 418.047,313.265C419.771,312.902 422.225,314.718 422.408,316.264" style="fill:rgb(44,68,12);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M422.77,311.174C422.955,312.629 420.771,313.358 418.956,313.721C417.229,314.082 416.501,313.902 416.321,312.358C416.136,310.903 416.593,308.632 418.319,308.268C420.047,307.904 422.499,309.631 422.682,311.083L422.77,311.174Z" style="fill:rgb(44,68,12);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M408.504,307.812C408.776,308.996 411.048,308.72 412.775,308.36C414.501,307.905 415.138,307.541 414.774,306.36C414.501,305.178 413.41,303.543 411.687,303.997C409.96,304.451 408.233,306.633 408.504,307.905L408.504,307.812Z" style="fill:rgb(44,68,12);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M406.96,322.261L407.504,323.805L406.323,322.897C405.776,322.442 405.324,321.806 404.96,321.079C405.049,321.806 405.142,322.262 405.324,322.897C403.598,320.079 402.051,316.99 403.05,312.902C403.961,309.175 407.687,307.448 410.322,306.722C411.957,306.268 413.773,305.995 415.408,306.177C416.408,306.268 418.135,306.54 418.862,307.448C419.589,308.36 419.953,310.266 420.134,311.538C420.406,313.537 420.317,315.627 420.045,317.626C419.771,319.442 419.227,321.17 418.318,322.624C417.591,323.715 416.772,324.532 415.684,324.988C414.409,325.532 413.137,325.623 411.773,325.351C409.958,324.988 408.322,323.897 406.867,322.352L406.96,322.261Z" style="fill:rgb(133,197,31);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M417.955,308.72C419.046,309.994 419.591,315.357 418.318,319.263C417.955,319.355 417.5,319.445 417.047,319.445C415.047,319.628 413.137,318.72 411.866,317.629C411.957,318.174 412.139,318.537 412.321,318.81C411.23,318.358 410.322,316.994 409.685,315.448C409.774,316.721 409.958,317.266 410.139,317.994C408.775,317.539 407.686,315.994 406.867,314.36C406.14,312.905 406.231,310.814 407.503,309.907C410.865,307.453 416.591,307.271 417.862,308.816L417.955,308.72Z" style="fill:rgb(161,225,65);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M491.106,348.068C492.105,352.611 496.648,355.61 501.193,355.428C507.462,355.154 517.185,348.249 517.002,341.434C516.914,337.618 514.094,334.163 511.188,331.984C508.371,329.8 503.644,327.531 500.01,328.53C496.377,329.53 493.832,334.528 492.65,337.798C491.559,340.616 490.469,345.071 491.198,348.069L491.106,348.069L491.106,348.068Z" style="fill:rgb(133,197,31);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M492.561,347.613C492.469,347.068 492.376,346.522 492.376,345.886C493.559,340.888 496.375,335.164 499.556,334.256C504.463,332.8 514.367,339.344 513.823,346.069C511.096,350.249 505.279,353.702 501.101,353.882C497.284,354.065 493.376,351.519 492.558,347.703L492.558,347.613L492.561,347.613Z" style="fill:rgb(112,169,27);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M497.194,342.524C495.92,339.98 498.01,335.527 501.193,335.89C504.555,336.345 511.824,341.343 511.824,345.251C511.824,347.705 508.462,349.432 504.918,348.433C502.282,347.705 498.194,344.615 497.194,342.524M494.377,348.885C493.741,347.34 494.649,344.615 496.467,344.886C498.375,345.251 502.917,348.521 502.737,350.339C502.646,351.794 500.102,353.066 498.102,352.338C496.648,351.794 494.922,350.157 494.377,348.885" style="fill:rgb(93,141,23);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M502.102,330.712C502.01,332.348 505.192,333.8 506.463,332.62C507.554,330.529 507.28,327.985 506.373,327.44C505.373,326.895 502.918,327.895 502.102,330.712" style="fill:rgb(44,68,12);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M508.28,333.711C507.919,335.526 510.37,337.073 511.553,336.255C513.097,334.71 513.641,331.984 512.917,331.348C512.188,330.712 509.552,331.712 508.28,333.711" style="fill:rgb(44,68,12);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M512.915,338.254C512.368,339.436 513.552,341.071 514.914,340.981C516.366,339.89 517.729,337.346 517.186,336.709C516.64,335.983 514.187,336.709 512.915,338.254" style="fill:rgb(44,68,12);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M489.651,321.352C488.924,319.989 490.923,319.078 492.561,318.442C494.197,317.898 495.012,317.898 495.649,319.261C496.376,320.624 496.74,322.713 495.012,323.258C493.378,323.804 490.287,322.713 489.56,321.35L489.651,321.35L489.651,321.352Z" style="fill:rgb(44,68,12);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M488.288,316.264C488.107,317.808 490.287,318.626 492.105,318.99C493.832,319.354 494.559,319.171 494.74,317.626C494.922,316.079 494.469,313.628 492.65,313.265C490.924,312.902 488.471,314.718 488.288,316.264" style="fill:rgb(44,68,12);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M487.835,311.174C487.651,312.629 489.834,313.358 491.649,313.721C493.376,314.082 494.104,313.902 494.284,312.358C494.469,310.903 494.013,308.632 492.285,308.268C490.559,307.904 488.106,309.631 487.924,311.083L487.835,311.174Z" style="fill:rgb(44,68,12);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M502.192,307.812C501.918,308.996 499.646,308.72 497.919,308.36C496.195,307.905 495.557,307.541 495.92,306.36C496.195,305.178 497.283,303.543 499.009,303.997C500.737,304.451 502.463,306.633 502.192,307.905L502.192,307.812Z" style="fill:rgb(44,68,12);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M503.646,322.261L503.101,323.805L504.282,322.897C504.83,322.442 505.282,321.806 505.645,321.079C505.556,321.806 505.464,322.262 505.282,322.897C507.008,320.079 508.555,316.99 507.555,312.902C506.645,309.175 502.918,307.448 500.284,306.722C498.648,306.268 496.833,305.995 495.197,306.177C494.198,306.268 492.471,306.54 491.744,307.448C491.016,308.36 490.653,310.266 490.472,311.538C490.2,313.537 490.288,315.627 490.562,317.626C490.835,319.442 491.378,321.17 492.288,322.624C493.014,323.715 493.834,324.532 494.922,324.988C496.197,325.532 497.468,325.623 498.832,325.351C500.647,324.988 502.283,323.897 503.739,322.352L503.646,322.261Z" style="fill:rgb(133,197,31);fill-rule:nonzero;"/>
	</g>
	<g transform="matrix(1,0,0,1,-37.6592,-251.388)">
		<path d="M492.65,308.72C491.559,309.994 491.014,315.357 492.287,319.263C492.65,319.355 493.105,319.445 493.558,319.445C495.558,319.628 497.467,318.72 498.739,317.629C498.647,318.174 498.466,318.537 498.284,318.81C499.375,318.358 500.283,316.994 500.919,315.448C500.83,316.721 500.646,317.266 500.466,317.994C501.83,317.539 502.918,315.994 503.738,314.36C504.464,312.905 504.374,310.814 503.102,309.907C499.74,307.453 494.014,307.271 492.743,308.816L492.65,308.72Z" style="fill:rgb(161,225,65);fill-rule:nonzero;"/>
	</g>
</svg>';
	}

	/**
	 * Return html of header banner
	 *
	 * @return string
	 */
	public function get_plugin_screen_banner() {

		$screen = get_current_screen();

		$html = '';

		$html .= '<div class="omapi-static-banner">';
			$html .= '<div class="inner-container">';
			$html .= '<div class="logo-wrapper">' . $this->get_svg_logo() . '<span class="omapi-logo-version">' . sprintf( __( 'v%s', 'optin-monster-api' ), $this->base->version ) . '</span></div>';
			$html .= '<div class="static-menu"><ul>';
			$html .= '<li><a target="_blank" rel="noopener" href="' . esc_url_raw( 'https://optinmonster.com/docs/' ) . '">' . __('Need Help?', 'optin-monster-api') . '</a></li>';
			$html .= '<li><a href="' . esc_url_raw( 'https://optinmonster.com/contact-us/' ) . '" target="_blank" rel="noopener">' .  __('Send Us Feedback', 'optin-monster-api') . '</a></li>';
			if( $screen->id === 'toplevel_page_optin-monster-api-settings' ) {
				$html .= '<li class="omapi-menu-button"><a id="omapi-create-new-optin-button" href="' . OPTINMONSTER_APP_URL . '/campaigns/new/" class="button button-secondary omapi-new-optin" title="' . __( 'Create New Campaign', 'optin-monster-api' ) . '" target="_blank" rel="noopener">' . __( 'Create New Campaign', 'optin-monster-api' ) . '</a></li>';
			}
			$html .= '</ul></div>';
		$html .= '</div>';
		$html .= '</div>';

		return $html;

	}

	/**
	 * Echo out plugin header banner
	 *
	 * @since 1.1.5.2
	 */
	public function output_plugin_screen_banner() {
		echo $this->get_plugin_screen_banner();
	}

	/**
	 * Called whenever a signup link is displayed, this function will
	 * check if there's an affiliate ID specified.
	 *
	 * There are three ways to specify an ID, ordered by highest to lowest priority
	 * - add_filter( 'optinmonster_sas_id', function() { return 1234; } );
	 * - define( 'OPTINMONSTER_SAS_ID', 1234 );
	 * - get_option( 'optinmonster_sas_id' ); (with the option being in the wp_options
	 * table) If an ID is present, returns the affiliate link with the affiliate ID. If no ID is
	 * present, just returns the OptinMonster WP landing page link instead.
	 */
	public function get_sas_link() {

		global $omSasId;
		$omSasId = '';

		// Check if sas ID is a constant
		if ( defined( 'OPTINMONSTER_SAS_ID' ) ) {
			$omSasId = OPTINMONSTER_SAS_ID;
		}

		// Now run any filters that may be on the sas ID
		$omSasId = apply_filters( 'optinmonster_sas_id', $omSasId );

		/**
		 * If we still don't have a sas ID by this point
		 * check the DB for an option
		 */
		if ( empty( $omSasId ) ) {
			$sasId = get_option( 'optinmonster_sas_id', $omSasId );
		}

		// Return the sas link if we have a sas ID
		if ( ! empty( $omSasId ) ) {
			return 'https://www.shareasale.com/r.cfm?u='
				   . urlencode( trim( $omSasId ) )
				   . '&b=601672&m=49337&afftrack=&urllink=optinmonster.com';
		}

		// Return the regular WP landing page by default
		return 'https://optinmonster.com/wp/?utm_source=orgplugin&utm_medium=link&utm_campaign=wpdashboard';

	}

	/**
	 * Called whenever a signup link is displayed, this function will
	 * check if there's a trial ID specified.
	 *
	 * There are three ways to specify an ID, ordered by highest to lowest priority
	 * - add_filter( 'optinmonster_trial_id', function() { return 1234; } );
	 * - define( 'OPTINMONSTER_TRIAL_ID', 1234 );
	 * - get_option( 'optinmonster_trial_id' ); (with the option being in the wp_options
	 * table) If an ID is present, returns the trial link with the affiliate ID. If no ID is
	 * present, just returns the OptinMonster WP landing page URL.
	 */
	public function get_trial_link() {

		global $omTrialId;
		$omTrialId = '';

		// Check if trial ID is a constant
		if ( defined( 'OPTINMONSTER_TRIAL_ID' ) ) {
			$omTrialId = OPTINMONSTER_TRIAL_ID;
		}

		// Now run any filters that may be on the trial ID
		$omTrialId = apply_filters( 'optinmonster_trial_id', $omTrialId );

		/**
		 * If we still don't have a trial ID by this point
		 * check the DB for an option
		 */
		if ( empty( $omTrialId ) ) {
			$omTrialId = get_option( 'optinmonster_trial_id', $omTrialId );
		}

		// Return the trial link if we have a trial ID
		if ( ! empty( $omTrialId ) ) {
			return 'https://www.shareasale.com/r.cfm?u='
				   . urlencode( trim( $omTrialId ) )
				   . '&b=601672&m=49337&afftrack=&urllink=optinmonster.com%2Ffree-trial%2F%3Fid%3D' . urlencode( trim( $omTrialId ) );
		}

		// Return the regular WP landing page by default
		return 'https://optinmonster.com/wp/?utm_source=orgplugin&utm_medium=link&utm_campaign=wpdashboard';

	}

	public function get_action_link() {
		global $omTrialId, $omSasId;
		$trial = $this->get_trial_link();
		$sas   = $this->get_sas_link();

		if ( ! empty( $omTrialId ) ) {
			return $trial;
		} else if ( ! empty( $omSasId ) ) {
			return $sas;
		} else {
			return 'https://optinmonster.com/wp/?utm_source=orgplugin&utm_medium=link&utm_campaign=wpdashboard';
		}
	}

	public function has_trial_link() {

		$link = $this->get_trial_link();
		return strpos( $link, 'optinmonster.com/wp' ) === false;

	}

	public function get_dashboard_link() {

		return $this->has_trial_link() ? esc_url_raw( admin_url( 'admin.php?page=optin-monster-api-welcome' ) ) : esc_url_raw( admin_url( 'admin.php?page=optin-monster-api-settings' ) );

	}

}
