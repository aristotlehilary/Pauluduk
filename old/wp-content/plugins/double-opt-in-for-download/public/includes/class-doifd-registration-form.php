<?php

if( !class_exists( 'DOIFDRegistrationForm' ) ) {

    class DOIFDRegistrationForm extends DOIFD {

        protected $errorMessages = array( );
        protected $validDownload = true;
        protected $attr;
        protected $download_id = '';
        protected $form_id = '';
        protected $data = array( );
        protected $formLayout = '';
        protected $fileExists = true;
        protected $promoLink = '';
        protected $headerText = '';
        protected $descriptionText = '';
        protected $buttonText = '';
        protected $nonce = '';
        protected $privacyPolicy = '';
        protected $msg = '';
        protected $formStyleData = '';
        protected $form_values = '';
        protected $formNamePlaceHolder = '';
        protected $formEmailPlaceHolder = '';

        public function __construct( $attr = array( ), $content = array( ), $msg = null ) {
            parent::__construct();
            $this->attr = $attr;
            $this->download_id = $this->getDownloadID();
            $this->data = $this->getDownloadInfo();
            $this->form_id = $this->getFormID();
            $this->formStyleData = $this->getFormStyleData();
            $this->formLayout = $this->getChosenFormLayout();
            $this->nonce = $this->getNonce();
            $this->msg = $msg;           
            $this->fileExists = $this->file_exists();
            $this->promoLink = $this->getPromoLink();
            $this->headerText = $this->getHeaderText();
            $this->descriptionText = $this->getDescriptionText();
            $this->buttonText = $this->getButtonText();
            $this->privacyPolicy = $this->getPrivacyPolicy();
            $this->form_values = $this->getFormValues();
            $this->formNamePlaceHolder = $this->getFormNamePlaceHolder();
            $this->formEmailPlaceHolder = $this->getFormEmailPlaceHolder();
            
        }
        
        public function getErrors() {
            return '<div class="exceeded"><img src="' . DOIFD_URL . 'public/assets/img/warning.png" alt="Warning" title="Warning" /><br />' . $this->errorMessages . '</div>';
        }
        
        public function getValidDownload() {
            return $this->validDownload;
        }
        
        public function getDownloadID() {
            if( isset($this->attr[ 'download_id' ])) {
                $this->download_id = $this->attr[ 'download_id' ];
            } else {
                $this->download_id = '';
            }
            return $this->download_id;
        }
        
        public function getFormID() {
            if( isset($this->attr[ 'form_id' ])) {
                $this->form_id = $this->attr[ 'form_id' ];
            } else {
                $this->form_id = $this->data[ 'doifd_download_form' ];
            }
            return $this->form_id;
        }
 
        public function getDownloadInfo() {
            global $wpdb;

            $sql = $wpdb->prepare( "SELECT
                doifd_download_name,
                doifd_download_file_name,
                doifd_download_type,
                doifd_download_form
                FROM
                {$wpdb->prefix}doifd_lab_downloads WHERE doifd_download_id = %s", $this->download_id );

            $this->data = $wpdb->get_row( $sql, ARRAY_A );
            return $this->data;
        }
        
        public function getFormStyleData() {
            global $wpdb;

            $sql = $wpdb->prepare( "SELECT
                doifd_download_form
                FROM
                {$wpdb->prefix}doifd_lab_forms WHERE doifd_form_id = %s", $this->form_id );

            $formStyleData = $wpdb->get_var( $sql );
            
            $formStyle = unserialize(base64_decode( $formStyleData ));

            return $formStyle;
        }
        
        public function getFormValues() {
            
                $this->form_values = apply_filters( 'doifd_form_setup_values', array(
                "form_text" => $this->headerText,
                "id" => $this->download_id,
                "name" => __( 'Name', $this->plugin_slug ),
                "nonce" => $this->nonce,
                "email" => __( 'Email', $this->plugin_slug ),
                "button_text" => $this->buttonText,
                "privacy" => $this->privacyPolicy,
                "promo" => $this->promoLink,
                "error" => $this->msg,
                "formClass" => $this->formStyleData['form_class_name'],
                "formCSS" => $this->formStyleData['form_css']
                    ) );
                
                return $this->form_values;
        }
        
        public function getFormNamePlaceHolder() {
            if ($this->formStyleData['useFormPlaceHolders'] === '1' ) {
                $namePlaceHolder = 'placeholder="'. $this->form_values["name"] .'"';
            } elseif($this->getCustomClassName() == 'doifd_user_reg_form') {
                $namePlaceHolder = 'placeholder="'. $this->form_values["name"] .'"';
            } else {
                $namePlaceHolder = '';
            }
            return $namePlaceHolder;
        }
        
        public function getFormEmailPlaceHolder() {
            if ($this->formStyleData['useFormPlaceHolders'] === '1' ) {
                $emailPlaceHolder = 'placeholder="'. $this->form_values["email"] .'"';
            } elseif($this->getCustomClassName() == 'doifd_user_reg_form' ) {
                $emailPlaceHolder = 'placeholder="'. $this->form_values["email"] .'"';
            } else {
                $emailPlaceHolder = '';
            }
            return $emailPlaceHolder;
        }
        
        public function getChosenFormLayout() {
            
                switch ( $this->formStyleData[ 'forms' ] ) {

                    case 'doifdHorizontal':
                        $layout = 'doifdHorizontal';
                        break;
                    case 'doifdEmailOnly':
                        $layout = 'doifdEmailOnly';
                        break;
                    default:
                        $layout = 'doifdDefault';
                        break;
            }

            return $layout;
        }

        public function file_exists() {

            $upload_dir = wp_upload_dir();
            $file = $upload_dir[ 'basedir' ] . '/doifd_downloads/' . $this->data[ 'doifd_download_file_name' ];

            if( ( $this->data[ 'doifd_download_type' ] == '0' ) && !file_exists( $file ) ) {
                $this->fileExists = false;
            } else {
                $this->fileExists = true;
            }
            return $this->fileExists;
        }

        public function getHeaderText() {

            if(!empty($this->formStyleData['formHeaderTxt'])) {
                $this->headerText = $this->formStyleData['formHeaderTxt'];
            } elseif( isset( $this->attr[ 'text' ] ) ) {
                $this->headerText = $this->attr[ 'text' ];
            } elseif($this->form_id != '0' ) {
                $this->headerText = '';
            } else {
                $this->headerText = __( 'Please provide your name and email address for your free download.', $this->plugin_slug );
            }
            return html_entity_decode(stripslashes($this->headerText));
        }
        
        public function getDescriptionText() {
            if( !empty($this->formStyleData['formDescTxt'])) {
                $this->descriptionText = html_entity_decode(stripslashes($this->formStyleData['formDescTxt']));
            } else {
                $this->descriptionText = '';
            }
            return $this->descriptionText;
        }
        
        public function getButtonText() {

            if(!empty($this->formStyleData['formButtonTxt'])) {
                $this->buttonText = $this->formStyleData['formButtonTxt'];
            } elseif( isset( $this->attr[ 'button_text' ] ) ) {
                $this->buttonText = $this->attr[ 'button_text' ];
            } else {
                $this->buttonText = __( 'Submit', $this->plugin_slug );
            }
            return $this->buttonText;
        }
        
        public function getCustomClassName() {
            
            if (!empty($this->formStyleData['form_class_name'] ) ) {
                $className = $this->formStyleData['form_class_name'];
            } else {
                
                switch ( $this->formStyleData['forms'] ) {
                    case 'doifdDefault':
                        $className = 'doifdDefault' . (((!empty($this->form_id) ) ) ? $this->form_id : '' );
                        break;
                    case 'doifdHorizontal':
                        $className = 'doifdHorizontal' . (((!empty($this->form_id) ) ) ? $this->form_id : '' );
                        break;
                    case 'doifdEmailOnly':
                        $className = 'doifdEmailOnly' . (((!empty($this->form_id) ) ) ? $this->form_id : '' );
                        break;
                    default:
                        $className = 'doifd_user_reg_form';
                        break;
                }

            }
            
            return $className;
        }
        
        public function getCustomFormCSS() {
            
            $html = '';
        if (!empty( $this->formStyleData['form_class_name']) ) {
            
            $html.= '<style type="text/css">';
            $html.= preg_replace("/<br[^>]*>\s*\r*\n*/is", "\n", $this->formStyleData['form_css'] );        
            $html.= '</style>';

        }
        
        echo $html;
            
        }
        
        public function getFormLayout() {
            
            $html = '';

            if ( $this->formLayout == 'doifdDefault' || $this->getCustomClassName() == 'doifd_user_reg_form' ) {
                
                $html.= '<ul>';
                $html.= '<li>';
                if ( $this->formStyleData['useFormLabels'] == '1' || $this->getCustomClassName() == 'doifd_user_reg_form' && $this->doifd_options['use_form_labels'] == '1' ) { $html.= '<label for="doifd_user_name">' . $this->form_values["name"] . ': </label>'; }
                $html.= '<input type="text" name="doifd_user_name" ' . $this->formNamePlaceHolder . ' id="doifd_user_name" value=""/>';
                $html.= '</li>';
                $html.= '<li>';
                if ( $this->formStyleData['useFormLabels'] == '1' || $this->getCustomClassName() == 'doifd_user_reg_form' && $this->doifd_options['use_form_labels'] == '1'  ) { $html.= '<label for="doifd_user_email">' . $this->form_values["email"] . ': </label>'; }
                $html.= '<input type="text" name="doifd_user_email" ' . $this->formEmailPlaceHolder . ' id="doifd_user_email" value=""/>';
                $html.= '</li>';
                $html.= '</ul>';
                $html.= '<div class="doifdDefaultButtonHolder"><input name="doifd_download_form" type="submit" id="doifd_download_form" value="' . $this->buttonText . '"></div>';
            }
            
            return $html;
        }

        public function getPromoLink() {

            if( $this->doifd_options[ 'promo_link' ] == '1' ) {
                $this->promoLink = '<p class="doifd_promo_link"><a href="http://www.doubleoptinfordownload.com" target="new" Title="' . __( 'Powered by DOIFD', $this->plugin_slug ) . '">' . __( 'Powered by DOIFD', $this->plugin_slug ) . '</a></p>';
            } else {
                $this->promoLink = '';
            }
            return $this->promoLink;
        }

        public function getNonce() {
            global $wpdb;
            $this->nonce = wp_create_nonce( 'doifd-subscriber-registration-nonce' );
            return $this->nonce;
        }

        public function getPrivacyPolicy() {

            if( isset($this->doifd_options[ 'use_privacy_policy' ]) && ( $this->doifd_options[ 'use_privacy_policy' ] == '1' ) ) {
                $text = $this->doifd_options[ 'privacy_link_text' ];
                $link = $this->doifd_options[ 'privacy_page' ];

                $this->privacyPolicy = '<div class="doifd_privacy_link"><a href="' . get_page_link( $link ) . '" target="new" >' . $text . '</a></div>';
            } else {

                $this->privacyPolicy = '';
            }
            return $this->privacyPolicy;
        }

        public function getCaptch() {
            /*
             * @TODO
             * How am I going to integrate captcha
             * Old code below
             */
            $options = get_option( 'doifd_lab_options' );

            if( class_exists( 'DOIFDPremium' ) && ( $options[ 'doifd_recaptcha_enable_form' ] ) == 1 ) {

                $doifd_captcha = TRUE;
            } else {

                $doifd_captcaha = FALSE;
            }
        }
        
        public function render_form() {
            
            global $download_id;
            $download_id = $this->download_id;
                    
                $html = '';
                $html.= '<div id="doifdForm' . $this->form_id . '">';
                $html.= '<div class="'. $this->getCustomClassName() . '">';
                if (!empty($this->headerText)) {
                $html.= '<h4' . ((($this->getCustomClassName() == 'doifd_user_reg_form' ) ) ? '' : ' class="doifdTitle' . $this->form_id . '"' ) . '>' . $this->headerText . '</h4>';
                }
                if (!empty($this->formStyleData['formDescTxt'])) {
                $html.= '<h5' . ((($this->getCustomClassName() == 'doifd_user_reg_form' ) ) ? '' : ' class="doifdDesc' . $this->form_id . '"' ) . '>' . $this->descriptionText . '</h5>';
                }
                if (!empty($this->form_values['error'])) {
                $html.= '<div id="doifd_statusmsg" class="statusmsg">'. $this->form_values['error'] . '</div>';
                }
                $html.= '<form id="doifd_form" action="' . $_SERVER['REQUEST_URI'] . '" method="POST">';
                $html.= '<input type="hidden" name="download_id" id="download_id" value="' . $this->form_values['id'] . '"/>';
                $html.= '<input type="hidden" name="form_source" id="form_source" value="form"/>';
                $html.= '<input type="hidden" name="_wpnonce" id="_wpnonce" value="'. $this->form_values['nonce'] . '"/>';
                $html.= $this->getFormLayout();
                $html.= '</form>';
                $html.= $this->privacyPolicy;
                $html.= $this->promoLink;
                $html.= '</div>';
                $html.= '</div>';
                
                return $html;
                
        }

        public function registration_form() {

            global $wpdb;

            /* If there is no download id in the shortcode show error message */ 
            if( empty( $this->download_id ) ) {
                $this->errorMessages = __( 'There is no download ID specified', $this->plugin_slug );
            }

            /* If the download id does not exist in the download table show error message */
            if( empty( $this->data ) ) {
                $this->errorMessages = __( 'The download ID does not exist', $this->plugin_slug );
            }

            /* Is the physical donwload on the server? */
            if( $this->fileExists == false ) {
                $this->errorMessages = __( 'The download files does not exist', $this->plugin_slug );
            }

            /* Set validDownload to false if any errors were generated */
            if( !empty( $this->errorMessages ) ) {
                $this->validDownload = false;
            }            

            
        }

    }

}