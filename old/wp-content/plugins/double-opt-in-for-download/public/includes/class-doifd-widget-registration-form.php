<?php

if( !class_exists( 'DOIFDWidgetRegistrationForm' ) ) {

    class DOIFDWidgetRegistrationForm extends DOIFD {

        protected $downloadID;
        protected $formID = '';
        protected $WFD = array();
        protected $formLayout = '';
        protected $widgetFormValues = '';
        protected $widgetNonce = '';
        protected $privacyPolicy = '';
        protected $promoLink = '';
        protected $formNamePlaceHolder = '';
        protected $formEmailPlaceHolder = '';
        protected $headerText = '';
        protected $descriptionText = '';
        protected $buttonText = '';

        public function __construct( $downloadID = null, $widgetValues = array() ) {
            parent::__construct();
            $this->downloadID = $downloadID;
            $this->widgetFormValues = $widgetValues;
            $this->formID = $this->getFormID();
            $this->WFD = $this->getFormInfo();
            $this->formLayout = $this->getChosenFormLayout();
            $this->widgetNonce = wp_create_nonce( 'doifd-subscriber-registration-nonce' );
            $this->formNamePlaceHolder = $this->getFormNamePlaceHolder();
            $this->formEmailPlaceHolder = $this->getFormEmailPlaceHolder();
            $this->headerText = $this->getHeaderText();
            $this->descriptionText = $this->getDescriptionText();
            $this->buttonText = $this->getButtonText();
            $this->privacyPolicy = $this->getPrivacyPolicy();
            $this->promoLink = $this->getPromoLink();
        }

        public function getPrivacyPolicy() {

            if( isset( $this->doifd_options[ 'use_privacy_policy' ] ) && ( $this->doifd_options[ 'use_privacy_policy' ] == '1' ) ) {
                $text = $this->doifd_options[ 'privacy_link_text' ];
                $link = $this->doifd_options[ 'privacy_page' ];

                $this->privacyPolicy = '<div class="doifd_privacy_link"><a href="' . get_page_link( $link ) . '" target="new" >' . $text . '</a></div>';
            } else {

                $this->privacyPolicy = '';
            }
            return $this->privacyPolicy;
        }
        
        public function getPromoLink() {

            if( $this->doifd_options[ 'promo_link' ] == '1' ) {
                $this->promoLink = '<p class="doifd_promo_link"><a href="http://www.doubleoptinfordownload.com" target="new" Title="' . __( 'Powered by DOIFD', $this->plugin_slug ) . '">' . __( 'Powered by DOIFD', $this->plugin_slug ) . '</a></p>';
            } else {
                $this->promoLink = '';
            }
            return $this->promoLink;
        }

        public function getFormInfo() {
            global $wpdb;

            $sql = $wpdb->prepare( "SELECT
                doifd_download_form
                FROM
                {$wpdb->prefix}doifd_lab_forms WHERE doifd_form_id = %s", $this->formID );

            /* WFI = Widget Form Info */
            $this->WFD = unserialize(base64_decode( $wpdb->get_var( $sql ) ) );

            return $this->WFD;
        }

        public function getFormID() {
            global $wpdb;
            if( isset( $this->widgetFormValues[ 'widget_form_id' ] ) && ( $this->widgetFormValues[ 'widget_form_id' ] >= '0') ) {

                $this->formID = $this->widgetFormValues[ 'widget_form_id' ];
            } else {

                $sql = $wpdb->prepare( "SELECT
                doifd_download_form
                FROM
                {$wpdb->prefix}doifd_lab_downloads WHERE doifd_download_id = %s", $this->downloadID );

                $this->formID = $wpdb->get_var( $sql );
            }

            return $this->formID;
        }

        public function getHeaderText() {

            if( !empty( $this->WFD[ 'formHeaderTxt' ] ) ) {
                $this->headerText = $this->WFD[ 'formHeaderTxt' ];
            } elseif( isset( $this->widgetFormValues[ 'widget_form_text' ] ) ) {
                $this->headerText = $this->widgetFormValues[ 'widget_form_text' ];
            } else {
                $this->headerText = __( 'Please provide your name and email address for your free download.', $this->plugin_slug );
            }
            return $this->headerText;
        }
        
        public function getDescriptionText() {

            if( !empty( $this->WFD[ 'formDescTxt' ] ) ) {
                $this->descriptionText = html_entity_decode(stripslashes($this->WFD['formDescTxt']));
            } else {
                $this->descriptionText = '';
            }
            return $this->descriptionText;
        }

        public function getButtonText() {

            if( !empty( $this->WFD[ 'formButtonTxt' ] ) ) {
                $this->buttonText = $this->WFD[ 'formButtonTxt' ];
            } elseif( isset( $this->widgetFormValues[ 'widget_button_text' ] ) ) {
                $this->buttonText = $this->widgetFormValues[ 'widget_button_text' ];
            } else {
                $this->buttonText = __( 'Submit', $this->plugin_slug );
            }
            return $this->buttonText;
        }

        public function getFormNamePlaceHolder() {

            if( $this->WFD[ 'useFormPlaceHolders' ] === '1' ) {
                $namePlaceHolder = 'placeholder="' . $this->widgetFormValues[ "widget_name" ] . '"';
            } elseif( $this->getCustomClassName() == 'widget_doifd_user_reg_form' ) {
                $namePlaceHolder = 'placeholder="' . $this->widgetFormValues[ "widget_name" ] . '"';
            } else {
                $namePlaceHolder = '';
            }
            return $namePlaceHolder;
        }

        public function getFormEmailPlaceHolder() {

            if( $this->WFD[ 'useFormPlaceHolders' ] === '1' ) {
                $namePlaceHolder = 'placeholder="' . $this->widgetFormValues[ "widget_email" ] . '"';
            } elseif( $this->getCustomClassName() == 'widget_doifd_user_reg_form' ) {
                $namePlaceHolder = 'placeholder="' . $this->widgetFormValues[ "widget_email" ] . '"';
            } else {
                $namePlaceHolder = '';
            }
            return $namePlaceHolder;
        }

        public function getChosenFormLayout() {
            
                switch ( $this->WFD[ 'forms' ] ) {

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

        public function getCustomClassName() {

            if( !empty( $this->WFD[ 'form_class_name' ] ) ) {
                $className = $this->WFD[ 'form_class_name' ];
            } elseif( $this->formID != '0' ) {

                switch ( $this->WFD[ 'forms' ] ) {
                    case 'doifdDefault':
                        $className = 'doifdDefault' . (((!empty($this->formID) ) ) ? $this->formID : '' );
                        break;
                    case 'doifdHorizontal':
                        $className = 'doifdHorizontal' . (((!empty($this->formID) ) ) ? $this->formID : '' );
                        break;
                    case 'doifdEmailOnly':
                        $className = 'doifdEmailOnly' . (((!empty($this->formID) ) ) ? $this->formID : '' );
                        break;
                    default:
                        $className = 'widget_doifd_user_reg_form';
                        break;
                }
            } else {
                $className = 'widget_doifd_user_reg_form';
            }

            return $className;
        }

        public function getFormLayout() {
            
            $html = '';

            if( $this->formLayout == 'doifdDefault' || $this->getCustomClassName() == 'widget_doifd_user_reg_form' ) {

                $html.= '<input type="hidden" name="form" id="form" value="doifdDefault" />';
                $html.= '<input type="hidden" name="legacy" id="legacy" value="' . ((($this->getCustomClassName() == 'doifd_user_reg_form' ) ) ? '1' : '0' ) . '" />';
                $html.= '<ul>';
                $html.= '<li>';
                if( $this->WFD[ 'useFormLabels' ] == '1' || $this->getCustomClassName() == 'widget_doifd_user_reg_form' && $this->doifd_options[ 'use_widget_form_labels' ] == '1' ) {
                    $html.= '<label for="doifd_user_name">' . $this->widgetFormValues[ "widget_name" ] . ': </label>';
                }
                $html.= '<input type="text" name="doifd_user_name" ' . $this->formNamePlaceHolder . ' id="doifd_user_name" value=""/>';
                $html.= '</li>';
                $html.= '<li>';
                if( $this->WFD[ 'useFormLabels' ] == '1' || $this->getCustomClassName() == 'widget_doifd_user_reg_form' && $this->doifd_options[ 'use_widget_form_labels' ] == '1' ) {
                    $html.= '<label for="doifd_user_name">' . $this->widgetFormValues[ "widget_email" ] . ': </label>';
                }
                $html.= '<input type="text" name="doifd_user_email" ' . $this->formEmailPlaceHolder . ' id="doifd_user_email" value=""/>';
                $html.= '</li>';
                $html.= '</ul>';
                $html.= '<div class="doifdDefaultButtonHolder"><input name="doifd_widget_download_form" type="submit" id="doifd_widget_download_form" value="' . $this->buttonText . '"></div>';
            }


            if( $this->WFD[ 'forms' ] == 'doifdHorizontal' ) {

                if( $this->WFD[ 'useFormLabels' ] == '1' ) {
                    $html.= '<label for="doifd_user_name">' . $this->widgetFormValues[ "widget_name" ] . ': </label>';
                }
                $html.= '<input type="text" name="doifd_user_name" ' . $this->formNamePlaceHolder . ' id="doifd_user_name" value=""/>';
                if( $this->WFD[ 'useFormLabels' ] == '1' ) {
                    $html.= '<label for="doifd_user_email">' . $this->widgetFormValues[ "widget_email" ] . ': </label>';
                }
                $html.= '<input type="text" name="doifd_user_email" ' . $this->formEmailPlaceHolder . ' id="doifd_user_email" value=""/>';
                $html.= '<input name="doifd_widget_download_form" type="submit" id="doifd_widget_download_form" value="' . $this->buttonText . '">';
            }

            return $html;
        }

        public function render_form() {

            global $download_id;
            $download_id = $this->downloadID;
            
            $html = '';
            $html.= '<div id="doifdForm' . $this->formID . '">';
            $html.= '<div class="' . $this->getCustomClassName() . '">';
            if( !empty( $this->headerText ) ) {
                $html.= '<h4' . ((($this->getCustomClassName() == 'widget_doifd_user_reg_form' ) ) ? '' : ' class="doifdTitle' . $this->formID . '"' ) . '>' . $this->headerText . '</h4>';
            }
            if( !empty( $this->WFD[ 'formDescTxt' ] ) ) {
                $html.= '<h5' . ((($this->getCustomClassName() == 'doifd_user_reg_form' ) ) ? '' : ' class="doifdDesc' . $this->formID . '"' ) . '>' . html_entity_decode($this->WFD[ 'formDescTxt' ]) . '</h5>';
            }
            $html.= '<form id="doifd_widget_download_form" action="' . $_SERVER[ 'REQUEST_URI' ] . '" method="POST">';
            if( !empty( $this->widgetFormValues[ 'widget_error' ] ) ) {
                $html.= '<div id="doifd_widget_statusmsg" class="statusmsg">' . $this->widgetFormValues[ 'widget_error' ] . '</div>';
            }
            $html.= '<input type="hidden" name="widget_download_id" id="widget_download_id" value="' . $this->downloadID . '"/>';
            $html.= '<input type="hidden" name="form_source" id="form_source" value="widget"/>';
            $html.= '<input type="hidden" name="widget_wpnonce" id="widget_wpnonce" value="' . $this->widgetNonce . '"/>';
            $html.= $this->getFormLayout();
            $html.= '</form>';
            $html.= $this->privacyPolicy;
            $html.= $this->promoLink;
            $html.= '</div>';
            $html.= '</div>';

            echo $html;
        }

    }

}

