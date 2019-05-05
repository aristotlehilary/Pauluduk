<?php

class DOIFDAdminCreateFormFields extends DOIFDAdmin {

    protected $doifdID = '';
    protected $formID = '';
    protected $fonts = array();
    protected $formStyles = array();

    public function __construct() {
        parent::__construct();

        $this->doifdID = $this->getID();
        $this->formID = $this->getFormID();
        $this->fonts = $this->getFonts();
        $this->formStyles = $this->getFormStyleData();  
    }

    public function getID() {
        if( !empty( $_GET[ 'doifdID' ] ) ) {
            $this->doifdID = $_GET[ 'doifdID' ];
        } else {
            $this->doifdID = '';
        }
        return $this->doifdID;
    }

    public function getFormID() {
        if( !empty( $_GET[ 'formID' ] ) ) {
            $this->formID = $_GET[ 'formID' ];
        } else {
            $this->formID = '';
        }
        return $this->formID;
    }

    public function getFormStyleData() {
        $formInfo = new DOIFDAdminManageForms();

        if( !empty( $this->doifdID ) ) {
            $data = $formInfo->getDownloadData( $this->doifdID );
            $formStyles = $formInfo->getDownloadIDFormValues( $this->doifdID );
        } elseif( !empty( $this->formID ) ) {
            $formStyles = $formInfo->getFormIDValues( $this->formID );
        } else {
            $formStyles = array();
        }
        return $formStyles;
    }

    public function getFonts() {

        $fontFamilyArray = array(
            '' => 'Select Font',
            'georgia' => 'Georgia, serif',
            'Palatino' => 'Palatino Linotype, Book Antiqua, Palatino, serif',
            'Times' => 'Times New Roman, Times, serif',
            'ArialHelvetica' => 'Arial, Helvetica, sans-serif',
            'ArialBlack' => 'Arial Black, Gadget, sans-serif',
            'Comic' => 'Comic Sans MS, cursive, sans-serif',
            'Impact' => 'Impact, Charcoal, sans-serif',
            'Lucida' => 'Lucida Sans Unicode, Lucida Grande, sans-serif',
            'Tahoma' => 'Tahoma, Geneva, sans-serif',
            'Trebuchet' => 'Trebuchet MS, Helvetica, sans-serif;',
            'Verdana' => 'Verdana, Geneva, sans-serif',
            'Courier' => 'Courier New, Courier, monospace',
            'Lucida' => 'Lucida Console, Monaco, monospace'
        );

        return $fontFamilyArray;
    }

    public function formName() {

        ?>
        <fieldset><!--Beginning of Name your form fieldset-->
            <legend><?php _e( 'Name Your Form', $this->plugin_slug ); ?></legend>
            <div class="holder">
                <label for="formName"><?php _e( 'Form Name', $this->plugin_slug ); ?></label>
                <input type="text" name="formName" id="formName" size="30" value="<?php if( isset( $this->formStyles[ 'formName' ] ) ) echo $this->formStyles[ 'formName' ]; ?>"/>
                <img class="ttfnh qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>">
            </div>
        </fieldset><!--END of Name your form fieldset-->
        <?php
    }

    public function formLayoutSelect() {

        ?>
        <fieldset><!--Beginning of select form layout fieldset-->
            <legend><?php _e( 'Select a Form Layout', $this->plugin_slug ); ?></legend>
            <div>
                <div class="formselectHolder">

                    <div class="formselect">
                        <h2>Default Form</h2>
                        <a href="<?php echo DOIFD_URL . 'admin/assets/img/default-form-big.jpg' ?>" title="Double OPT-IN For Download Default Form" data-jbox-image="forms"><img src="<?php echo DOIFD_URL . 'admin/assets/img/default-form-thumb.jpg' ?>"></a>
                        <div class="formSelectTxt">This is the standard two field form. Optional form fields work with this form.</div>
                        <hr>
                        <input type="radio" name="forms" id="forms1" value="doifdDefault" checked >Default Form
                    </div>
                    <div class="formselect">
                        <h2>Horizontal Form</h2>
                        <a href="<?php echo DOIFD_URL . 'admin/assets/img/horizontal-form-big.jpg' ?>" title="Double OPT-IN For Download Horizonal Form" data-jbox-image="forms"><img src="<?php echo DOIFD_URL . 'admin/assets/img/horizontal-form-thumb.jpg' ?>"></a>
                        <div class="formSelectTxt">Fields are aligned horizontally for a slimmer look. The optional form fields are not compatible with the horizontal form. Available in the Premium Version</div>
                        <hr>
                        <input type="radio" name="forms" id="forms2" value="" disabled="disabled" >Select Horizontal Form
                        <p><i>Premium Version Only</i></p>
                    </div>
                    <div class="formselect">
                        <h2>Email Address Only</h2>
                        <a href="<?php echo DOIFD_URL . 'admin/assets/img/emailOnly-Big.jpg' ?>" title="Double OPT-IN For Download Email Only Form" data-jbox-image="forms"><img src="<?php echo DOIFD_URL . 'admin/assets/img/emailOnly-thumb.jpg' ?>"></a>
                        <div class="formSelectTxt">This form only requires that the user submit their email address. The optional form fields are not compatible with the Email Only form. Available in the Premium Version</div>
                        <hr>
                        <input type="radio" name="forms" id="forms3" value="" disabled="disabled"/>Select Email Address Only
                        <p><i>Premium Version Only</i></p>
                    </div>
                </div>

            </div>
        </fieldset><!--End of select form layout fieldset-->
        <?php
    }

    public function generalFormOptions() {

        ?>
        <fieldset><!-- Begining of General Form Options-->

            <legend><?php _e( 'General Form Options', $this->plugin_slug ); ?></legend>
            <table>
                <tr>
                    <td>
                        <label for="useFormLabels"><?php _e( 'Use Form Labels', $this->plugin_slug ); ?></label>
                    </td>
                    <td>

                        <input type="hidden" name="useFormLabels" id="useFormLabels1" value="0" >
                        <input type="checkbox" name="useFormLabels" id="useFormLabels" value="1" <?php
                        if( isset( $this->formStyles[ 'useFormLabels' ] ) && ( $this->formStyles[ 'useFormLabels' ] ) == '1' ) {
                            echo 'checked="checked"';
                        }

                        ?> >

                    </td>
                    <td>
                        <img class="ttuflh qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="useFormPlaceHolders"><?php _e( 'Use Form Place Holders', $this->plugin_slug ); ?></label> 
                    </td>
                    <td>
                        <input type="hidden" name="useFormPlaceHolders" id="useFormPlaceHolders1" value="0" >
                        <input type="checkbox" name="useFormPlaceHolders" id="useFormPlaceHolders" value="1" <?php
                        if( isset( $this->formStyles[ 'useFormPlaceHolders' ] ) && ( $this->formStyles[ 'useFormPlaceHolders' ] ) == '1' ) {
                            echo 'checked="checked"';
                        }

                        ?> >
                    </td>
                    <td>
                        <img class="ttuphh qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>">
                    </td>
                </tr>


            </table>

        </fieldset><!-- End of General Form Options-->
        <?php
    }

    public function formHeaderOptions() {

        ?>
        <fieldset><!-- Beginning of Form Header Text Style-->

            <legend><?php _e( 'Style Your Forms Header Text', $this->plugin_slug ); ?></legend>

            <div class="holder">
                <table>
                    <tr>
                        <td valign="top"><label for="formHeaderTxt"><?php _e( 'Form Header Text', $this->plugin_slug ); ?></label></td>
                        <td><textarea rows="5" cols="60" name="formHeaderTxt" id="formHeaderTxt"><?php if( isset( $this->formStyles[ 'formHeaderTxt' ] ) ) echo stripslashes( $this->formStyles[ 'formHeaderTxt' ] ); ?></textarea></td>
                        <td><img class="ttfht qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>"></td>
                    </tr>
                </table>
            </div>
            <div class="holder">
                <table>
                    <tr>
                        <td><label for="formHeaderfont"><?php _e( 'Select Font', $this->plugin_slug ); ?></label></td>
                        <td>
                            <select name="formHeaderfont" id="formHeaderfont">
                                <?php
                                echo "<option value=''>";
                                echo esc_attr( __( 'Select Font', $this->plugin_slug ) );
                                echo '</option>';

                                foreach ( $this->fonts as $hFont ) {
                                    $option = '<option value="' . $hFont . '" ' . (isset( $this->formStyles[ 'formHeaderfont' ] ) && ($this->formStyles[ 'formHeaderfont' ] == $hFont ) ? 'selected="selected"' : "") . '>';
                                    $option .= $hFont;
                                    $option .= '</option>';
                                    echo $option;
                                }

                                ?>
                            </select>
                        </td>
                        <td><img class="ttfhf qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>"></td>
                    </tr>
                </table>
            </div>
            <div class="holder">
                <label for="formHeaderFntSze"><?php _e( 'Font Size', $this->plugin_slug ); ?></label>
                <input type="text" size="5" value="<?php if( isset( $this->formStyles[ 'formHeaderFntSze' ] ) ) echo $this->formStyles[ 'formHeaderFntSze' ]; ?>" name="formHeaderFntSze" id="formHeaderFntSze" />
                <img class="ttfhfs qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>">
            </div>
            <div class="holder">
                <table>
                    <tr>
                        <td><label for="formHeaderTxtClr"><?php _e( 'Font Color', $this->plugin_slug ); ?></label></td>
                        <td><input type="text" value="<?php if( isset( $this->formStyles[ 'formHeaderTxtClr' ] ) ) echo $this->formStyles[ 'formHeaderTxtClr' ]; ?>" name="formHeaderTxtClr" id="formHeaderTxtClr" class="wp-color-picker-field" data-default-color="#ffffff" /></td>
                        <td><img class="ttfhtc qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>"></td>
                    </tr>
                </table>
            </div>
        </fieldset>
        <?php
    }

    public function formDescriptionOptions() {

        ?>
        <fieldset>
            <legend><?php _e( 'Style Your Form Description Text', $this->plugin_slug ); ?></legend>
            <div class="holder">
                <table>
                    <tr>
                        <td valign="top"><label for="formDescTxt" style="float: left;"><?php _e( 'Form Description Text', $this->plugin_slug ); ?></label></td>
                        <td><textarea rows="5" cols="60" name="formDescTxt" id="formDescTxt"><?php if( isset( $this->formStyles[ 'formDescTxt' ] ) ) echo stripslashes( $this->formStyles[ 'formDescTxt' ] ); ?></textarea></td>
                        <td><img class="ttfdt qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>"></td>
                    </tr>
                </table>
            </div>
            <div class="holder">
                <table>
                    <tr>
                        <td><label for="formDescfont"><?php _e( 'Select Font', $this->plugin_slug ); ?></label></td>
                        <td>
                            <select name="formDescfont" id="formDescfont">
                                <?php
                                echo "<option value=''>";
                                echo esc_attr( __( 'Select Font', $this->plugin_slug ) );
                                echo '</option>';
                                foreach ( $this->fonts as $dFont ) {
                                    $option = '<option value="' . $dFont . '" ' . (isset( $this->formStyles[ 'formDescfont' ] ) && ($this->formStyles[ 'formDescfont' ] == $dFont ) ? 'selected="selected"' : "") . '>';
                                    $option .= $dFont;
                                    $option .= '</option>';
                                    echo $option;
                                }

                                ?>
                            </select>
                        </td>
                        <td><img class="ttfdf qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>"></td>
                    </tr>
                </table>        
            </div>
            <div class="holder">
                <label for="formDescFntSze"><?php _e( 'Form Description Font Size', $this->plugin_slug ); ?></label>
                <input type="text" size="5" value="<?php if( isset( $this->formStyles[ 'formDescFntSze' ] ) ) echo $this->formStyles[ 'formDescFntSze' ]; ?>" name="formDescFntSze" id="formDescFntSze" />
                <img class="ttfdfs qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>">
            </div>
            <div class="holder">
                <table>
                    <tr>
                        <td><label for="formDescTxtClr"><?php _e( 'Font Color', $this->plugin_slug ); ?></label></td>
                        <td><input type="text" size="7" value="<?php if( isset( $this->formStyles[ 'formDescTxtClr' ] ) ) echo $this->formStyles[ 'formDescTxtClr' ]; ?>" name="formDescTxtClr" id="formDescTxtClr" class="wp-color-picker-field" data-default-color="#ffffff" /></td>
                        <td><img class="ttfdtc qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>"></td>
                    </tr>
                </table>
            </div>

        </fieldset>
        <?php
    }

    public function formGeneralOptions() {

        ?>
        <fieldset>
            <legend><?php _e( 'General Form Styling', $this->plugin_slug ); ?></legend>
            <h2><?php _e( 'Form Styling', $this->plugin_slug ); ?></h2>
            <div class="holder">
                <label for="formWidth"><?php _e( 'Form Width', $this->plugin_slug ); ?></label>
                <input type="text" name="formWidth" id="formWidth" size="5" value="<?php if( isset( $this->formStyles[ 'formWidth' ] ) ) echo $this->formStyles[ 'formWidth' ]; ?>">
                <img class="ttfw qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>">
            </div>
            <div class="holder">
                <label for="formInsidePadding"><?php _e( 'Form Inside Padding', $this->plugin_slug ); ?></label>
                <input type="text" name="formInsidePadding" id="formInsidePadding" size="5" value="<?php if( isset( $this->formStyles[ 'formInsidePadding' ] ) ) echo $this->formStyles[ 'formInsidePadding' ]; ?>">
                <img class="ttfip qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>">
            </div>
            <div class="holder">
                <table>
                    <tr>
                        <td><label for="formBkgdClr"><?php _e( 'Form Background Color', $this->plugin_slug ); ?></label></td>
                        <td><input type="text" size="7" value="<?php if( isset( $this->formStyles[ 'formBkgdClr' ] ) ) echo $this->formStyles[ 'formBkgdClr' ]; ?>" name="formBkgdClr" id="formBkgdClr" class="wp-color-picker-field" data-default-color="#ffffff" /></td>
                        <td><img class="ttfbc qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>"></td>
                    </tr>
                </table>
            </div>
            <div class="holder">
                <table>
                    <tr>
                        <td><label for="formTxtClr"><?php _e( 'Form Text Color (Labels)', $this->plugin_slug ); ?></label></td>
                        <td><input type="text" size="7" value="<?php if( isset( $this->formStyles[ 'formTxtClr' ] ) ) echo $this->formStyles[ 'formTxtClr' ]; ?>" name="formTxtClr" id="formTxtClr" class="wp-color-picker-field" data-default-color="#ffffff" /></td>
                        <td><img class="ttftc qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>"></td>
                    </tr>
                </table>
            </div>
            <div class="holder">
                <label for="formMarginRgt"><?php _e( 'Form Margin Right', $this->plugin_slug ); ?></label>
                <input type="text" name="formMarginRgt" id="formMarginRgt" size="5" value="<?php if( isset( $this->formStyles[ 'formMarginRgt' ] ) ) echo $this->formStyles[ 'formMarginRgt' ]; ?>">
                <img class="ttfmr qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>">
            </div>
            <div class="holder">
                <label for="formMarginLft"><?php _e( 'Form Margin Left', $this->plugin_slug ); ?></label>
                <input type="text" name="formMarginLft" id="formMarginLft" size="5" value="<?php if( isset( $this->formStyles[ 'formMarginLft' ] ) ) echo $this->formStyles[ 'formMarginLft' ]; ?>">
                <img class="ttfml qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>">
            </div>
            <div class="holder">
                <label for="formMarginTop"><?php _e( 'Form Margin Top', $this->plugin_slug ); ?></label>
                <input type="text" name="formMarginTop" id="formMarginTop" size="5" value="<?php if( isset( $this->formStyles[ 'formMarginTop' ] ) ) echo $this->formStyles[ 'formMarginTop' ]; ?>">
                <img class="ttfmt qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>">
            </div>
            <div class="holder">
                <label for="formMarginBtm"><?php _e( 'Form Margin Bottom', $this->plugin_slug ); ?></label>
                <input type="text" name="formMarginBtm" id="formMarginBtm" size="5" value="<?php if( isset( $this->formStyles[ 'formMarginBtm' ] ) ) echo $this->formStyles[ 'formMarginBtm' ]; ?>">
                <img class="ttfmb qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>">
            </div>
            <div class="holder">
                <table>
                    <tr>
                        <td><label for="formTxtInputBkgdClr"><?php _e( 'Form Text Input Background Color', $this->plugin_slug ); ?></label></td>
                        <td><input type="text" size="7" value="<?php if( isset( $this->formStyles[ 'formTxtInputBkgdClr' ] ) ) echo $this->formStyles[ 'formTxtInputBkgdClr' ]; ?>" name="formTxtInputBkgdClr" id="formTxtInputBkgdClr" class="wp-color-picker-field" data-default-color="#ffffff" /></td>
                        <td><img class="ttftibc qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>"></td>
                    </tr>
                </table>
            </div>
            <div class="holder">
                <label for="formTxtInputWidth"><?php _e( 'Form Text Input Width', $this->plugin_slug ); ?></label>
                <input type="text" name="formTxtInputWidth" id="formTxtInputWidth" size="5" value="<?php if( isset( $this->formStyles[ 'formTxtInputWidth' ] ) ) echo $this->formStyles[ 'formTxtInputWidth' ]; ?>">
                <img class="ttftiw qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>">
            </div>
        </fieldset>
        <?php
    }

    public function formBorderOptions() {

        ?>
        <fieldset>
            <legend><?php _e( 'Form Border Styling', $this->plugin_slug ); ?></legend>
            <div class="holder">
                <label for="formBorderWidth"><?php _e( 'Form Border Width', $this->plugin_slug ); ?></label>
                <input type="text" name="formBorderWidth" id="formBorderWidth" size="5" value="<?php if( isset( $this->formStyles[ 'formBorderWidth' ] ) ) echo $this->formStyles[ 'formBorderWidth' ]; ?>"/>
                <img class="ttfborw qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>">
            </div>

            <div class="holder">
                <table>
                    <tr>
                        <td><label for="formBorderClr"><?php _e( 'Form Border Color', $this->plugin_slug ); ?></label></td>
                        <td><input type="text" value="<?php if( isset( $this->formStyles[ 'formBorderClr' ] ) ) echo $this->formStyles[ 'formBorderClr' ]; ?>" name="formBorderClr" id="formBorderClr" class="wp-color-picker-field" data-default-color="#ffffff" /></td>
                        <td><img class="ttfborc qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>"></td>
                    </tr>
                </table>
            </div>

            <div class="holder">
                <table>
                    <tr>
                        <td><label for="formBorderStyle"><?php _e( 'Select Form Border Style', $this->plugin_slug ); ?></label></td>
                        <td>
                            <select name="formBorderStyle" id="formBorderStyle">
                                option value=""><?php _e( 'Select Border Style', $this->plugin_slug ); ?></option>
                                <option value="none"<?php
                                if( isset( $this->formStyles[ 'formBorderStyle' ] ) && $this->formStyles[ 'formBorderStyle' ] = "none" ) {
                                    echo ' selected="selected"';
                                }

                                ?>><?php _e( 'None', $this->plugin_slug ); ?></option>
                                <option value="solid"<?php
                                if( isset( $this->formStyles[ 'formBorderStyle' ] ) && $this->formStyles[ 'formBorderStyle' ] = "solid" ) {
                                    echo ' selected="selected"';
                                }

                                ?>><?php _e( 'Solid', $this->plugin_slug ); ?></option>
                            </select>
                        </td>
                        <td><img class="ttfbors qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>"></td>
                    </tr>
                </table>        


                <div class="holder">
                    <label for="formBorderRadius"><?php _e( 'Form Border Radius', $this->plugin_slug ); ?></label>
                    <input type="text" name="formBorderRadius" id="formBorderRadius" size="5" value="<?php if( isset( $this->formStyles[ 'formBorderRadius' ] ) ) echo $this->formStyles[ 'formBorderRadius' ]; ?>"/>
                    <img class="ttfborr qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>">
                </div>
        </fieldset> 
        <?php
    }

    public function formButtonOptions() {

        ?>
        <fieldset>
            <legend><?php _e( 'Form Button Styling', $this->plugin_slug ); ?></legend>
            <div class="holder">
                <label for="formButtonTxt"><?php _e( 'Form Button Text', $this->plugin_slug ); ?></label>
                <input type="text" name="formButtonTxt" id="formButtonTxt" size="30" value="<?php if( isset( $this->formStyles[ 'formButtonTxt' ] ) ) echo $this->formStyles[ 'formButtonTxt' ]; ?>"/>
                <img class="ttfbt qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>">
            </div>

            <div class="holder">
                <table>
                    <tr>
                        <td><label for="formButtonTxtClr"><?php _e( 'Text Color', $this->plugin_slug ); ?></label></td>
                        <td><input type="text" value="<?php if( isset( $this->formStyles[ 'formButtonTxtClr' ] ) ) echo $this->formStyles[ 'formButtonTxtClr' ]; ?>" name="formButtonTxtClr" id="formButtonTxtClr" class="wp-color-picker-field" data-default-color="#ffffff" /></td>
                        <td><img class="ttfbtc qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>"></td>
                    </tr>
                </table>
            </div>

            <div class="holder">
                <table>
                    <tr>
                        <td><label for="formButtonBkgdClr"><?php _e( 'Button Color', $this->plugin_slug ); ?></label></td>
                        <td><input type="text" value="<?php if( isset( $this->formStyles[ 'formButtonBkgdClr' ] ) ) echo $this->formStyles[ 'formButtonBkgdClr' ]; ?>" name="formButtonBkgdClr" id="formButtonBkgdClr" class="wp-color-picker-field" data-default-color="#000000" /></td>
                        <td><img class="ttfbbc qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>"></td>
                    </tr>
                </table>
            </div>
        </fieldset>
        <?php
    }

    public function advancedOptions() {

        ?>
        <fieldset><!-- Beginnig of Custom CSS fieldset-->
            <legend><?php _e( 'Custom CSS', $this->plugin_slug ); ?></legend>
            <div><?php _e( 'Use the Custom Css feature to create your own CSS for the form. Please note that if you choose custom css, the standard form options will not be used.', $this->plugin_slug ); ?></div>
            <div class="holder">
                <label for="form_class_name"><?php _e( 'Form Class Name:', $this->plugin_slug ); ?></label>
                <input type="text" name="form_class_name" id="form_class_name" size="30" value="<?php if( isset( $this->formStyles[ 'form_class_name' ] ) ) echo $this->formStyles[ 'form_class_name' ]; ?>"/>
                <img class="ttfcn qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>">
            </div>
            <div class="holder">
                <table>
                    <tr>
                        <td><label for="form_class_css"><?php _e( 'Form Class CSS:', $this->plugin_slug ); ?></label></td>
                        <td>
                            <?php
                            if( !empty( $this->formStyles[ 'form_css' ] ) ) {
                                $formCSS = preg_replace( "/<br[^>]*>\s*\r*\n*/is", "\n", $this->formStyles[ 'form_css' ] );
                            } else {
                                $formCSS = '';
                            }

                            ?>
                            <textarea rows="10" cols="60" name="form_class_css" id="form_class_css"><?php if( isset( $this->formStyles[ 'form_css' ] ) ) echo $formCSS; ?></textarea>
                        </td>
                        <td><img class="ttfcc qmimg" src="<?php echo DOIFD_URL . 'admin/assets/img/qm.png' ?>"></td>
                    </tr>
                </table>
            </div>
        </fieldset><!-- END of Custom CSS fieldset-->
        <?php
    }

    public function generateFormFields() {
        $this->formName();
        $this->formLayoutSelect();
    }

    public function generateFormOptions() {
        $this->generalFormOptions();
        $this->formHeaderOptions();
        $this->formDescriptionOptions();
        $this->formGeneralOptions();
        $this->formBorderOptions();
        $this->formButtonOptions();
    }

    public function generateFormAdvancedOptions() {
        $this->advancedOptions();
    }

}
