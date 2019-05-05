/* ---------------------------- */
/* Admin Options Tabs Script */
/* ---------------------------- */



jQuery(document).ready(function () {
    jQuery("div#tabs").tabs({
        beforeLoad: function (event, ui) {
            ui.jqXHR.error(function () {
                ui.panel.html(
                        "Couldn't load this tab. We'll try to fix this as soon as possible. " +
                        "If this wouldn't be a demo.");
            });
        }
    });
});

jQuery(document).ready(function () {
    jQuery("#doifdDownloadFormTabs").tabs({
        beforeLoad: function (event, ui) {
            ui.jqXHR.error(function () {
                ui.panel.html(
                        "Couldn't load this tab. We'll try to fix this as soon as possible. " +
                        "If this wouldn't be a demo.");
            });

        },
//        collapsible: true,
        active: 2,
    });
});

/*
 *  Hide Privacy Options if not seclected
 */

jQuery(document).ready(function () {

    jQuery("#priv_text").hide();
    jQuery("#priv_font_size").hide();
    jQuery("#priv_sel_pag").hide();
    if (jQuery("#use_privacy_policy_y:checked").length > 0) {
        jQuery("#priv_text").show();
        jQuery("#priv_font_size").show();
        jQuery("#priv_sel_pag").show();

    }

    jQuery('#use_privacy_policy_y').click(function () {
        jQuery('#priv_text').show();
        jQuery("#priv_font_size").show();
        jQuery("#priv_sel_pag").show();
    });

    jQuery('#use_privacy_policy_n').click(function () {
        jQuery('#priv_text').hide();
        jQuery("#priv_font_size").hide();
        jQuery("#priv_sel_pag").hide();
    });

});

/*
 *  Hide Generic Options if form one  not seclected
 */

//jQuery(document).ready(function() {
//    
//    if (jQuery("#form1").is(":checked")) {
//        
//         jQuery("#formOptions").show();
//         
//    } else {
//        
//        jQuery("#formOptions").hide();
//    }
//    
//    jQuery("input:radio").change(function () {
//        if (jQuery("#form1").is(":checked")) {
//             jQuery("#formOptions").show();
//        }
//        else {
//            jQuery("#formOptions").hide();
//        }
//    });
//});
//
///*
// *  Hide Generic CSS Options if not seclected
// */
//
//jQuery(document).ready(function() {
//    
//    if (jQuery("#generic1").is(":checked")) {
//        
//         jQuery("#cssOptions").show();
//         
//    } else {
//        
//        jQuery("#cssOptions").hide();
//    }
//    
//    jQuery("input:radio").change(function () {
//        if (jQuery("#generic1").is(":checked")) {
//             jQuery("#cssOptions").show();
//        }
//        else {
//            jQuery("#cssOptions").hide();
//        }
//    });
//});
/*
 * Check the file size
 */

jQuery(document).ready(function () {

    jQuery('#userfile').bind('change', function () {

        var fsize = jQuery('#userfile')[0].files[0].size;

        // Get the PHP maximum file upload size
        var fmax = jQuery('#max_upload_size').val();

        // If file exceeds PHP max, show error message
        if (fsize > fmax)
        {
            fileSizeNotice();
            jQuery('#userfile').val('')
        }

    });
});

// Notice at the bottom left with an offset
function fileSizeNotice() {
    new jBox('Notice', {
        content: ajaxupload.filetoolarge, /* Get Content From wp_localize */
        color: 'red',
        attributes: {
            x: 'left',
            y: 'top'
        },
        position: {// The position attribute defines the distance to the window edges
            x: 175,
            y: 75
        }
    });
}



// Validate Upload Form

jQuery(document).ready(function () {
    
    var edit = jQuery("h2").html();

    jQuery('#doifdManageForms').validate({
        errorElement: 'span',
        errorClass: 'generalError',
        rules: {
            download_name: {
                required: true,
                minlength: 4
            },
            doifd_download_landing_page: {
                required: true
            },
            listMailchimpID: {
                required: true
            },
            listConstantContactID: {
                required: true
            },
            userfile: {
                required: function() { return edit == "Create Download"; }
            },
            doifd_selected_form: {
                required: true
            },
            formName: {
                required: true
            }
        },
        messages: {
            download_name: {
                required: function() {
                    if (edit == "Create Mailing List") {
                        return "Please name your Mailing List"
                    } else {
                        return "Please name your download"
                    }
                    },
                minlength: "Name has to be at least 4 characters"
            },
            doifd_download_landing_page: {
                required: "Please select a landing page"
            },
            listMailchimpID: {
                required: "Please select a Mailchimp list"
            },
            listConstantContactID: {
                required: "Please select a Constant Contact list"
            },
            userfile: {
                required: "Please select a file to upload"
            },
            doifd_selected_form: {
                required: "Please select a form"
            },
            formName: {
                required: "Please name your form"
            }
        },
        errorPlacement: function (error, element) {
            error.insertBefore(element.parents(".holder")).addClass("uploadError");
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

});

jQuery.fn.nl2br = function(){
   return this.each(function(){
     jQuery(this).val().replace(/(<br>)|(<br \/>)|(<p>)|(<\/p>)/g, "\r\n");
   });
};

(function (global, $) {

$.fn.newACE = function(csstextarea) {

   var editor = ace.edit("doifd_ace_css");
   editor.session.setValue(csstextarea, 1);
   editor.getSession().setMode("ace/mode/css");
   
   $('#doifdManageForms').submit(function() {
        var syncCSS = $('#form_class_css').val(editor.getSession().getValue());
});

}
    
})(this, jQuery);

/*
 * Populate Form Portion of Upload form based on Form select if changed.
 */

jQuery(document).ready(function () {

    jQuery('#doifd_selected_form').change(function() {

        console.log(jQuery('#doifd_selected_form'))
        /* Get the id of the new selected form */
        var id = jQuery(this).val();

        /* Clear all the text fields, uncheck the checkboxes and reset the color pickers */
        jQuery('#formCreation').find("input[type=text], textarea, select, input[type=checkbox], hidden").val("");
        jQuery('#formCreation').find("input[type=checkbox]").attr("checked", false);
        jQuery('#formBkgdClr, #formHeaderTxtClr, #formDescTxtClr, #formTxtInputBkgdClr, #formBorderClr, #formButtonTxtClr, #formButtonTxt, #formTxtClr').val('#ffffff');
        jQuery('#formBkgdClr, #formHeaderTxtClr, #formDescTxtClr, #formTxtInputBkgdClr, #formBorderClr, #formButtonTxtClr, #formButtonTxt, #formTxtClr').trigger('change');
        var editor = ace.edit("doifd_ace_css");
        editor.destroy();

        jQuery.getJSON({
            type: "POST",
            url: ajaxurl,
            data: {
                action: "doifd_GFD",
                formID: id
            },
            success: function (data) {
           
                    /* Populate Text inputs and Textareas */
                    jQuery('#doifdAdminDownloadForm').find('#doifd_form_id').val(id).trigger('change');
                    jQuery('#formCreation').find('#formName').val(data.formName);
                    var headerTxt = data.formHeaderTxt.replace(/\\/g, '');
                    jQuery('#formCreation').find('#formHeaderTxt').val(headerTxt);
                    jQuery('#formCreation').find('#formHeaderFntSze').val(data.formHeaderFntSze);
                    var descriptionTxt = data.formDescTxt.replace(/\\/g, '');
                    jQuery('#formCreation').find('#formDescTxt').val(descriptionTxt);
                    jQuery('#formCreation').find('#formDescFntSze').val(data.formDescFntSze);
                    jQuery('#formCreation').find('#formWidth').val(data.formWidth);
                    jQuery('#formCreation').find('#formInsidePadding').val(data.formInsidePadding);
                    jQuery('#formCreation').find('#formMarginRgt').val(data.formMarginRgt);
                    jQuery('#formCreation').find('#formMarginLft').val(data.formMarginLft);
                    jQuery('#formCreation').find('#formMarginTop').val(data.formMarginTop);
                    jQuery('#formCreation').find('#formMarginBtm').val(data.formMarginBtm);
                    jQuery('#formCreation').find('#formTxtInputWidth').val(data.formTxtInputWidth);
                    jQuery('#formCreation').find('#formBorderWidth').val(data.formBorderWidth);
                    jQuery('#formCreation').find('#formBorderRadius').val(data.formBorderRadius);
                    jQuery('#formCreation').find('#formButtonTxt').val(data.formButtonTxt);
                    jQuery('#formCreation').find('#form_class_name').val(data.form_class_name);
                    
                    /* Need to clear out the <br> from the data returned for the css before populating
                     * the textarea
                     */
                    
                    var csstextarea = data.form_css.replace(/[<]br[^>]*[>]/gi,""); 
                    jQuery('#formCreation').find('#form_class_css').val(csstextarea);
//                    editor.session.insert(csstextarea, 1);
                    jQuery(this).newACE(csstextarea);
                    
                    
                    /* Populate DropDown Selects correct values */
                    
                    jQuery('#formCreation').find('#formHeaderfont option[value="'+ data.formHeaderfont +'"]').attr('selected', 'selected').trigger('change');
                    jQuery('#formCreation').find('#formDescfont option[value="'+ data.formDescfont +'"]').attr('selected', 'selected').trigger('change');
                    jQuery('#formCreation').find('#formBorderStyle option[value="'+ data.formBorderStyle +'"]').attr('selected', 'selected').trigger('change');
                    
                    
                    /* Populate the form radio buton to the correct selection */
                    if (data.forms == 'doifdDefault') {
                    jQuery('#formCreation').find('#forms1').prop("checked", true).trigger('change');
                    }
                    if (data.forms == 'doifdHorizontal') {
                    jQuery('#formCreation').find('#forms2').prop("checked", true).trigger('change');
                    }
                    if (data.forms == 'doifdEmailOnly') {
                    jQuery('#formCreation').find('#forms3').prop("checked", true).trigger('change');
                    }
                    
                    /* Populate the checkboxes if need be */
                    if (data.useFormLabels == '1') {
                    jQuery('#formCreation').find('#useFormLabels').prop("checked", true).trigger('change');
                    }
                    if (data.useFormPlaceHolders == '1') {
                     jQuery('#formCreation').find('#useFormPlaceHolders').prop("checked", true).trigger('change'); 
                    }
                    
                    /* Populate the color paletts */
                    
                    jQuery('#formCreation').find('#formHeaderTxtClr').val(data.formHeaderTxtClr).trigger('change');
                    jQuery('#formCreation').find('#formDescTxtClr').val(data.formDescTxtClr).trigger('change');
                    jQuery('#formCreation').find('#formBkgdClr').val(data.formBkgdClr).trigger('change');
                    jQuery('#formCreation').find('#formTxtClr').val(data.formTxtClr).trigger('change');
                    jQuery('#formCreation').find('#formTxtInputBkgdClr').val(data.formTxtInputBkgdClr).trigger('change');
                    jQuery('#formCreation').find('#formBorderClr').val(data.formBorderClr).trigger('change');
                    jQuery('#formCreation').find('#formButtonTxtClr').val(data.formButtonTxtClr).trigger('change');
                    jQuery('#formCreation').find('#formButtonBkgdClr').val(data.formButtonBkgdClr).trigger('change');
                    
                    
            },
            error: function (errorThrown) {
                alert(errorThrown);
            }

        });

//        		var data = {
//			'action': 'getFormStyleData',
//			'whatever': 1234
//		};
//                
//                jQuery.post(ajaxurl, data, function(response) {
//			alert('Got this from the server: ' + response);
//		});


//        var downloadID = {
//            action: 'my_action_callback',
//            id: id
//        };
//
//        jQuery.ajax({url: ajaxurl,
//            data: downloadID,
//            dataType: 'json',
//            type: 'post',
//            success: function (data) {
//                alert(data);
//                jQuery("#doifd_download_id").val(data.doifd_download_id);
//                jQuery("#doifd_edit_name").val(data.doifd_download_name);
//                jQuery("#doifd_download_name").val(data.doifd_download_name);
//                jQuery("#doifd_download_file_name").val(data.doifd_download_file_name);
//                jQuery("#doifd_download_edit_landing_page").val(data.doifd_download_landing_page);
//                jQuery("#doifd_edit_tumessage").val(data.doifd_download_tumessage);
//
//                if (jQuery('#listMailchimpID').length)
//                {
//
//                    jQuery('#listMailchimpID option').prop('selected', false)
//                            .filter('[value="' + data.doifd_download_mailchimp_list_id + '"]')
//                            .prop('selected', true);
//                    jQuery('input[name=listMailchimpName]').val(data.doifd_download_mailchimp_list_name)
//                }
//
//                if (jQuery('#listConstantContactID').length)
//                {
//                    /* Needed to remove the http:// from the retrieved data so it would populate correctly */
//                    var ccURL = data.doifd_download_constant_contact_list_id.replace("http://", "");
//
//                    jQuery('#listConstantContactID option').prop('selected', false)
//                            .filter('[value="' + ccURL + '"]')
//                            .prop('selected', true);
//                    jQuery('input[name=listConstantContactName]').val(data.doifd_download_constant_contact_list_name)
//                }
//                if (jQuery('#listAWeberID').length)
//                {
//
//                    jQuery('#listAWeberID option').prop('selected', false)
//                            .filter('[value="' + data.doifd_download_aweber_list_id + '"]')
//                            .prop('selected', true);
//                    jQuery('input[name=listAWeberName]').val(data.doifd_download_aweber_list_name)
//                }
//                if (jQuery('#listMailPoetID').length)
//                {
//
//                    jQuery('#listMailPoetID option').prop('selected', false)
//                            .filter('[value="' + data.doifd_download_mailpoet_list_id + '"]')
//                            .prop('selected', true);
//                    jQuery('input[name=listMailPoetName]').val(data.doifd_download_mailpoet_list_name)
//                }
//
//
//            }

//        });

    });


});

/*
 * CSV Form
 */

jQuery(document).ready(function () {

    jQuery('#doifdCSVModal').jBox('Modal', {
        title: 'Download Subscribers',
        content: jQuery('#doifdCSVForm'),
        closeButton: 'title',
        overlay: true
    });

});

/*
 * jBox Tooltip for Allowed File Types
 */

jQuery(document).ready(function () {
    jQuery('.uploadallowedfiletypes').jBox('Tooltip', {
        id: 'jBoxUploadAllowed',
        trigger: 'click',
        target: jQuery('.uploadallowedfiletypes'),
        getTitle: 'data-jbox-title',
        getContent: 'data-jbox-content',
        offset: {x: 50, y: -70},
        pointer: 'bottom:185',
        theme: 'TooltipBorder'
    });
});

jQuery(document).ready(function () {
    jQuery('.uploadfilesizelimit').jBox('Tooltip', {
        id: 'jBoxUploadLimit',
        trigger: 'click',
        target: jQuery('.uploadfilesizelimit'),
        getTitle: 'data-jbox-title',
        getContent: 'data-jbox-content',
        offset: {x: 140, y: -70},
        pointer: 'bottom',
        theme: 'TooltipBorder',
    });
});

jQuery(document).ready(function () {
    jQuery('.editallowedfiletypes').jBox('Tooltip', {
        id: 'jBoxEditAllowed',
        trigger: 'click',
        target: jQuery('.editallowedfiletypes'),
        getTitle: 'data-jbox-title',
        getContent: 'data-jbox-content',
        offset: {x: 40, y: -70},
        pointer: 'bottom:200',
        theme: 'TooltipBorder'
    });
});

jQuery(document).ready(function () {
    jQuery('.editfilesizelimit').jBox('Tooltip', {
        id: 'jBoxEditLimit',
        trigger: 'click',
        target: jQuery('.editfilesizelimit'),
        getTitle: 'data-jbox-title',
        getContent: 'data-jbox-content',
        offset: {x: 140, y: -70},
        pointer: 'bottom',
        theme: 'TooltipBorder',
    });
});

/*
 * jBox Delete Confirmation
 */

jQuery(document).ready(function () {

    new jBox('Confirm', {
        confirmButton: 'OK!',
        cancelButton: 'Cancel'
    });
});


var myModal;

jQuery(document).ready(function () {

    myModal = new jBox('Modal', {
        title: 'Edit Download',
        closeButton: 'title',
        overlay: true
    });

});

function openModal() {
    myModal.open().ajax({
        url: ajaxupload.editdownloadform,
        reload: true
    });
}

jQuery(document).ready(function () {
    jQuery('#listMailchimpID').live('change', function () {

        jQuery('input[name="listMailchimpName"]').val(this.options[this.selectedIndex].text);

    });
});

jQuery(document).ready(function () {
    jQuery('#listConstantContactID').live('change', function () {

        jQuery('input[name="listConstantContactName"]').val(this.options[this.selectedIndex].text);

    });
});

jQuery(document).ready(function () {
    jQuery('#listAWeberID').live('change', function () {

        jQuery('input[name="listAWeberName"]').val(this.options[this.selectedIndex].text);

    });
});

jQuery(document).ready(function () {
    jQuery('#listMadMimiID').live('change', function () {

        jQuery('input[name="listMadMimiName"]').val(this.options[this.selectedIndex].text);

    });
});

jQuery(document).ready(function () {
    jQuery('#listMailPoetID').live('change', function () {

        jQuery('input[name="listMailPoetName"]').val(this.options[this.selectedIndex].text);

    });
});

/* Facebook Script */

jQuery(document).ready(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id))
        return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

jQuery(window).load(function () {
    jQuery(".doifdAdminLoader").fadeOut("slow");
})

/* Opens Support submenu link in new window */
jQuery(document).ready(function ($) {
    $('#doifd-support').parent().attr('target', '_blank');
});

jQuery(document).ready(function ($) {
    $('#doifd-premium').parent().attr('target', '_blank');
});

/* For the Color Picker */

jQuery(document).ready(function ($) {
    $('.wp-color-picker-field').wpColorPicker();
});

/* Tooltip for Download Name */
jQuery(document).ready(function () {

    jQuery('.ttdnh').jBox('Tooltip', {
        title: 'Download File Name',
        content: jQuery('#downloadNameHelp'),
        trigger: 'click',
        target: jQuery('.ttdnh'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
});

/* Tooltip for select landing page */
jQuery(document).ready(function () {

    jQuery('.ttslph').jBox('Tooltip', {
        title: 'Select your Landing Page',
        content: jQuery('#landingPageHelp'),
        trigger: 'click',
        target: jQuery('.ttslph'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
});

/* Tooltip for download file */
jQuery(document).ready(function () {

    jQuery('.ttsdfh').jBox('Tooltip', {
        title: 'Select your download file',
        content: jQuery('#selectDownloadHelp'),
        trigger: 'click',
        target: jQuery('.ttsdfh'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
});

/* Tooltip for selecting form */
jQuery(document).ready(function () {

    jQuery('.ttsdfmh').jBox('Tooltip', {
        title: 'Select a form for your download',
        content: jQuery('#selectDownloadFormHelp'),
        trigger: 'click',
        target: jQuery('.ttsdfmh'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
});

/* Tooltip for selecting form */
jQuery(document).ready(function () {

    jQuery('.ttfnh').jBox('Tooltip', {
        title: 'Name your form',
        content: jQuery('#downloadFormNameHelp'),
        trigger: 'click',
        target: jQuery('.ttfnh'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
});

jQuery(document).ready(function () {

    jQuery('.ttulfh').jBox('Tooltip', {
        title: 'Use Legacy Forms',
        content: jQuery('#ttulfh'),
        trigger: 'click',
        target: jQuery('.ttulfh'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
});

jQuery(document).ready(function () {

    jQuery('.ttuflh').jBox('Tooltip', {
        title: 'Use Form Labels',
        content: jQuery('#ttuflh'),
        trigger: 'click',
        target: jQuery('.ttuflh'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
});

jQuery(document).ready(function () {

    jQuery('.ttuphh').jBox('Tooltip', {
        title: 'Use Form Placeholders',
        content: jQuery('#ttuphh'),
        trigger: 'click',
        target: jQuery('.ttuphh'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
});

jQuery(document).ready(function () {

    jQuery('.ttfht').jBox('Tooltip', {
        title: 'Form Header Text',
        content: jQuery('#ttfht'),
        trigger: 'click',
        target: jQuery('.ttfht'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
});

jQuery(document).ready(function () {

    jQuery('.ttfhf').jBox('Tooltip', {
        title: 'Form Header Font',
        content: jQuery('#ttfhf'),
        trigger: 'click',
        target: jQuery('.ttfhf'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
});

jQuery(document).ready(function () {

    jQuery('.ttfhfs').jBox('Tooltip', {
        title: 'Form Header Font Size',
        content: jQuery('#ttfhfs'),
        trigger: 'click',
        target: jQuery('.ttfhfs'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
});

jQuery(document).ready(function () {

    jQuery('.ttfhtc').jBox('Tooltip', {
        title: 'Form Header Font Color',
        content: jQuery('#ttfhtc'),
        trigger: 'click',
        target: jQuery('.ttfhtc'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
});

jQuery(document).ready(function () {

    jQuery('.ttfdt').jBox('Tooltip', {
        title: 'Form Description Text',
        content: jQuery('#ttfdt'),
        trigger: 'click',
        target: jQuery('.ttfdt'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
});

jQuery(document).ready(function () {

    jQuery('.ttfdf').jBox('Tooltip', {
        title: 'Form Description Font',
        content: jQuery('#ttfdf'),
        trigger: 'click',
        target: jQuery('.ttfdf'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
});

jQuery(document).ready(function () {

    jQuery('.ttfdfs').jBox('Tooltip', {
        title: 'Form Description Font Size',
        content: jQuery('#ttfdfs'),
        trigger: 'click',
        target: jQuery('.ttfdfs'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
});

jQuery(document).ready(function () {

    jQuery('.ttfdtc').jBox('Tooltip', {
        title: 'Form Description Font Color',
        content: jQuery('#ttfdtc'),
        trigger: 'click',
        target: jQuery('.ttfdtc'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
});

jQuery(document).ready(function () {

    jQuery('.ttfw').jBox('Tooltip', {
        title: 'Form Width',
        content: jQuery('#ttfw'),
        trigger: 'click',
        target: jQuery('.ttfw'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });

    jQuery('.ttfip').jBox('Tooltip', {
        title: 'Form Inside Padding',
        content: jQuery('#ttfip'),
        trigger: 'click',
        target: jQuery('.ttfip'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });

    jQuery('.ttftiw').jBox('Tooltip', {
        title: 'Form Text Input Field Width',
        content: jQuery('#ttftiw'),
        trigger: 'click',
        target: jQuery('.ttftiw'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });

    jQuery('.ttfbc').jBox('Tooltip', {
        title: 'Form Background Color',
        content: jQuery('#ttfbc'),
        trigger: 'click',
        target: jQuery('.ttfbc'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });

    jQuery('.ttftibc').jBox('Tooltip', {
        title: 'Form Text Input Field Background Color',
        content: jQuery('#ttftibc'),
        trigger: 'click',
        target: jQuery('.ttftibc'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });

    jQuery('.ttfmb').jBox('Tooltip', {
        title: 'Form Margin Bottom',
        content: jQuery('#ttfmb'),
        trigger: 'click',
        target: jQuery('.ttfmb'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });

    jQuery('.ttfmt').jBox('Tooltip', {
        title: 'Form Margin Top',
        content: jQuery('#ttfmt'),
        trigger: 'click',
        target: jQuery('.ttfmt'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });

    jQuery('.ttfmr').jBox('Tooltip', {
        title: 'Form Margin Right',
        content: jQuery('#ttfmr'),
        trigger: 'click',
        target: jQuery('.ttfmr'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });

    jQuery('.ttfml').jBox('Tooltip', {
        title: 'Form Margin Left',
        content: jQuery('#ttfml'),
        trigger: 'click',
        target: jQuery('.ttfml'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });

    jQuery('.ttfbt').jBox('Tooltip', {
        title: 'Form Button Text',
        content: jQuery('#ttfbt'),
        trigger: 'click',
        target: jQuery('.ttfbt'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });

    jQuery('.ttfbtc').jBox('Tooltip', {
        title: 'Form Button Text Color',
        content: jQuery('#ttfbtc'),
        trigger: 'click',
        target: jQuery('.ttfbtc'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });

    jQuery('.ttfcn').jBox('Tooltip', {
        title: 'Form Class Name',
        content: jQuery('#ttfcn'),
        trigger: 'click',
        target: jQuery('.ttfcn'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });

    jQuery('.ttfcc').jBox('Tooltip', {
        title: 'Form Class',
        content: jQuery('#ttfcc'),
        trigger: 'click',
        target: jQuery('.ttfcc'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
    
    jQuery('.ttfborw').jBox('Tooltip', {
        title: 'Form Border Width',
        content: jQuery('#ttfborw'),
        trigger: 'click',
        target: jQuery('.ttfborw'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
    
    jQuery('.ttfborc').jBox('Tooltip', {
        title: 'Form Border Color',
        content: jQuery('#ttfborc'),
        trigger: 'click',
        target: jQuery('.ttfborc'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
    
    jQuery('.ttfbors').jBox('Tooltip', {
        title: 'Form Border Style',
        content: jQuery('#ttfbors'),
        trigger: 'click',
        target: jQuery('.ttfbors'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
    
    jQuery('.ttfbbc').jBox('Tooltip', {
        title: 'Submit Button Color',
        content: jQuery('#ttfbbc'),
        trigger: 'click',
        target: jQuery('.ttfbbc'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
    
    jQuery('.ttfborr').jBox('Tooltip', {
        title: 'Form Border Radius',
        content: jQuery('#ttfborr'),
        trigger: 'click',
        target: jQuery('.ttfborr'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });
    
    jQuery('.ttftc').jBox('Tooltip', {
        title: 'Form Text Color (Labels)',
        content: jQuery('#ttftc'),
        trigger: 'click',
        target: jQuery('.ttftc'),
        position: {
            x: 'right',
            y: 'center'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        closeOnClick: true
    });

    /* Mouse over fieldsets to show help icon */

    jQuery("fieldset").mouseover(function () {
        jQuery(this).find(".qmimg").show();
    });

    /*Mouse out fieldsets to hide help icons */

    jQuery("fieldset").mouseout(function ()
    {
        jQuery(this).find(".qmimg").hide();
    });
    
    new jBox('Image');

});

/* Button click to show Create Form */

jQuery(document).ready(function () {

    var image = "<div class='doifdFormIcons'><img class='doifdShowdownloadFromFields' src='" + ajaxupload.adminImage + "show.png' ><img class='doifdCloseFromFields' src='" + ajaxupload.adminImage + "close.png' ></div>";

    jQuery("#doifdCreateForm").click(function () {

        jQuery("#formCreation").toggle();
        jQuery("#downloadFields").hide();
        jQuery("#doifdDownloadFormTabs").prepend(image);

    });
});

jQuery(document).ready(function () {

    jQuery(".wrap").on("click", ".doifdShowdownloadFromFields", function () {
        jQuery("#downloadFields").toggle();
        jQuery("#doifdCreateForm").hide();
        jQuery("h2:contains('-- OR --')").hide();

    });
});

jQuery(document).ready(function () {

    jQuery(".wrap").on("click", ".doifdCloseFromFields", function () {
        jQuery("#formCreation").toggle();
        jQuery("#downloadFields").show();
        jQuery("#doifdCreateForm").show();
        jQuery("h2:contains('-- OR --')").show();
        jQuery(".doifdFormIcons").hide();
    });
});

/* Legacy Form Selected Hide Create Form */

jQuery(document).ready(function () {

    jQuery("#doifd_selected_form").change(function() {
      if(jQuery(this).find("option:selected").val() == "0") {
         jQuery("#fsha").hide();
      }
   });
   
    jQuery("#doifd_selected_form").change(function() {
      if(jQuery(this).find("option:selected").val() != "0") {
         jQuery("#fsha").show();
      }
   });
   
});


/* Send Email to User check box Hide/Show*/

jQuery(document).ready(function () {

    jQuery("#sendUserEmaildiv").hide();

    if (jQuery("#add_to_wpusers_y:checked").length > 0) {
        jQuery("#sendUserEmaildiv").show();
    }

    jQuery('#add_to_wpusers_y').click(function () {
        jQuery('#sendUserEmaildiv').show();
    });

    jQuery('#add_to_wpusers_n').click(function () {
        jQuery('#sendUserEmaildiv').hide();
    });

});


/* Customer Info Box */


(function (global, $) {
    
var jbox_tag;
    
$(document).ready(function () {

    jbox_tag = new jBox('Modal', {
        width: 450,
        title: 'Subscriber Info',
        position: {
            x: 'center',
            y: 'center'
        }
    });

    $(document).on('click', '.cusInfo', function (e) {
        e.preventDefault();
        
        var id = ( $( this ).find( 'input:hidden' ).val());

        jbox_tag.open().ajax({
            url: ajaxurl,
            data: {
                action: "doifd_GSI",
                subID: id
                
            },
            type: 'GET'
        });
    });
});

})(this, jQuery);