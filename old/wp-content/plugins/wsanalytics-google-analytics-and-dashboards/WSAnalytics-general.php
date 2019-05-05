<?php

/**
 * Base Class to use for the Add-ons
 * It will be used to extend the functionality of WSAnalytics WordPress Plugin.
 */

    // Setting Global Values
    define( 'WSAnalytics_LIB_PATH', dirname(__FILE__) . '/lib/' );
    define( 'WSAnalytics_ID', 'wp-WSAnalytics-options' );
    define( 'WSAnalytics_NICK', 'WSAnalytics' );
    define( 'WSAnalytics_ROOT_PATH', dirname(__FILE__) );
    define( 'WSAnalytics_VERSION', '1.1.2');
    define( 'WSAnalytics_TYPE', 'FREE');
    define( 'WSAnalytics_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

    define( 'WSAnalytics_REDIRECT', 'urn:ietf:wg:oauth:2.0:oob' );  // This will redirect to window where we can copy Access code.
    define( 'WSAnalytics_SCOPE', 'https://www.googleapis.com/auth/analytics' ); // readonly scope

    define( 'WSAnalytics_STORE_URL', 'http://WSofi.com' );
    define( 'WSAnalytics_PRODUCT_NAME', 'WSAnalytics WordPress Plugin' );

if (! class_exists( 'Analytics_normal' ) ) {

	class Analytics_normal {

		function __construct() {

			if (! class_exists('WSAnalytics_Google_Client') ) {

				require_once WSAnalytics_LIB_PATH . 'Google/Client.php';
				require_once WSAnalytics_LIB_PATH . 'Google/Service/Analytics.php';

		   }

			$this->client = new WSAnalytics_Google_Client();
			$this->client->setApprovalPrompt( 'force' );
			$this->client->setAccessType( 'offline' );
			$this->client->setClientId( get_option('WSAnalytics_CLIENTID'));
			$this->client->setClientSecret( get_option('WSAnalytics_CLIENTSECRET') );
			$this->client->setRedirectUri( WSAnalytics_REDIRECT );
			$this->client->setScopes( WSAnalytics_SCOPE );
			$this->client->setDeveloperKey( get_option('WSAnalytics_DEV_KEY') ); 

			try{
				
				$this->service = new WSAnalytics_Google_Service_Analytics( $this->client );

				$this->ws_connect();
				
			}
			catch ( WSAnalytics_Google_Service_Exception $e ) {
				
			}
			
		}

	    /**
	     * Connect with Google Analytics API and get authentication token and save it.
	     */

	    public function ws_connect() {
			
			$ga_google_authtoken = get_option('ws_google_token');

	        if (! empty( $ga_google_authtoken )) {
	                
	                $this->client->setAccessToken( $ga_google_authtoken );
	        } 
	        else{
	                
	        	$authCode = get_option( 'post_analytics_token' );
	                
	                if ( empty( $authCode ) ) return false;

	                try {

	                    $accessToken = $this->client->authenticate( $authCode );
	                }
	                catch ( Exception $e ) {
	                    return false;
	                }

	                if ( $accessToken ) {
	                    
	                    $this->client->setAccessToken( $accessToken );
	                    
	                    update_option( 'ws_google_token', $accessToken );
	                    
	                    return true;
	                } //$accessToken
	                else {

	                    return false;
	                }
	            }

	            $this->token = json_decode($this->client->getAccessToken());

	    	return true;
	    }

	    /*
	     * This function grabs the data from Google Analytics
	     * For individual posts/pages.
	     */
	    public function ws_get_analytics( $metrics, $startDate, $endDate, $dimensions = false, $sort = false, $filter = false, $limit = false ) {

	    	try{
				
				$this->service = new WSAnalytics_Google_Service_Analytics($this->client);
	            $params        = array();
	           
	            if ($dimensions){
	                $params['dimensions'] = $dimensions;
	            } //$dimensions
	           
	            if ($sort){
	                $params['sort'] = $sort;
	            } //$sort
	            
	            if ($filter){
	                $params['filters'] = $filter;
	            } //$filter
	            
	            if ($limit){
	                $params['max-results'] = $limit;
	            } //$limit

	            $profile_id = get_option("pt_webprofile");

	            if (!$profile_id){
	                return false;
	            }
	            
	            return $this->service->data_ga->get('ga:' . $profile_id, $startDate, $endDate, $metrics, $params);
	        }

	        catch ( WSAnalytics_Google_Service_Exception $e ) {

	        	// Show error message only for logged in users.
	        	if ( is_user_logged_in() ) echo $e->getMessage();

	        }
		}

	    /*
	     * This function grabs the data from Google Analytics
	     * For dashboard.
	     */
	    public function ws_get_analytics_dashboard( $metrics, $startDate, $endDate, $dimensions = false, $sort = false, $filter = false, $limit = false ) {

	    	try{

	            $this->service = new WSAnalytics_Google_Service_Analytics( $this->client );
	            $params        = array();

	            if ($dimensions){
	                $params['dimensions'] = $dimensions;
	            }
	            if ($sort){
	                $params['sort'] = $sort;
	            } 
	            if ($filter){
	                $params['filters'] = $filter;
	            }
	            if ($limit){
	                $params['max-results'] = $limit;
	            } 
	            
	            $profile_id = get_option("pt_webprofile_dashboard");
	            if (!$profile_id){
	                return false;
	            }
	            
	            return $this->service->data_ga->get('ga:' . $profile_id, $startDate, $endDate, $metrics, $params);

	        }

	        catch ( WSAnalytics_Google_Service_Exception $e ) {
	        	
	        	// Show error message only for logged in users.
	        	if ( is_user_logged_in() ) echo $e->getMessage();

	        }
	    }

	}
}
?>