jQuery(function($) {
    var markerPanel = {
        init : function() {
            this.bindClickUI( 'button.btn-addmarker', this.clickAddMarker );
            this.bindClickUI( '.btn-addFastMarkers', this.clickAddFastMarker );

            this.bindClickUI( '.icon_library .marker_wrap', this.clickChooseIcon );
            this.bindClickUI( '.edit_chose_marker_icon', this.clickShowIcon );
            this.bindClickUI( '.view_marker', this.clickViewMarker );
            this.bindClickUI( '#delete-icon', this.deleteIcons );
            this.focusSearchField();
            this.uploadImage();
        },
        bindClickUI : function( obj, func ) {
            $glb = this;
            this.event = 'ontouchstart' in window ? 'touchstart' : 'click';
            $(document).on( this.event, obj, function( e ){
                e.preventDefault();
                /* action function */
                func( $(this), $glb);
            });
        },
        clickAddMarker : function( obj, $glb ) {
            var marker_tab = '.marker_tab_id_1';
            $('.flip-container .back h3').html('Add A Marker');
            if( !$( marker_tab + ' .fast_add_options').hasClass('hidden') ) {
                $( marker_tab + ' .fast_add_options').addClass('hidden');
                $( marker_tab + ' .lat_field').removeClass('hidden');
                $( marker_tab + ' .long_field').removeClass('hidden');
            }
            /* Reset all field */
            reset_field_marker();
            $('.marker_wrap_button').html('<button id="save_marker" class="save_marker btn-orange map-btn"> <i class="fa fa-floppy-o"></i> Save</button> <button id="cancel_marker" class="cancel_marker btn-red map-btn"> Cancel <i class="fa fa-arrow-right"></i> </button>');
        },
        clickAddFastMarker : function (obj, $glb) {
            var marker_tab = '.marker_tab_id_1';
            if( $( marker_tab + ' .fast_add_options').hasClass('hidden') ) {
                $( marker_tab + ' .fast_add_options').removeClass('hidden');
                $( marker_tab + ' .lat_field').addClass('hidden');
                $( marker_tab + ' .long_field').addClass('hidden');
            }
            /* Reset all field */
            reset_field_marker();
            $('.flip-container .back h3').html('Add Fast Markers');
            $('.marker_wrap_button').html('<button id="cancel_add_fast_markers" class="cancel_marker btn-red map-btn"> Cancel <i class="fa fa-arrow-right"></i> </button>');
        },
        /* Chose icon marker */
        clickChooseIcon : function( obj, $glb ) {
            if( $('.icon_library .marker_wrap').hasClass('selected') )
            {
                $('.icon_library .marker_wrap').removeClass('selected');
            }
            obj.addClass('selected');
            /* Remove current image was chose */
            $('.chose_wrapper img.marker_icon_chose').remove();
            /* Add new image to icon chose */
            var image_chose = obj.html();
            $('.chose_wrapper').prepend(image_chose);
            $('.chose_wrapper > img:first-child').addClass('marker_icon_chose');
            /* show or hidden delete button if it is custom icon */
            if( obj.parent().hasClass('custom-group') ) {
                $('.delete-icon').removeClass('hidden');
            } else {
                $('.delete-icon').addClass('hidden');
            }
            /* Set icon if in edit marker page */
            /*                 var marker_id = jQuery('button#apply_changes_edit_marker').attr('marker-data');
             markers[marker_id].setIcon( jQuery('.chose_wrapper img:first-child').attr('src') );*/

        },
        /* Focus search field */
        focusSearchField : function() {
            var $this = this;
            $this.searchInput = $('#pac-input');
            /* Search focus and focus out*/
            $this.searchInput.focus(function(){
                $(this).addClass('focus');
            });
            $this.searchInput.focusout(function(){
                $(this).removeClass('focus');
            });
        },
        /* Show marker icon library */
        clickShowIcon : function( obj, $glb ) {
            this.libsIcon = $('.marker_libs_icon');
            if( this.libsIcon.hasClass('hidden') )
            {
                this.libsIcon.show('fast');
                this.libsIcon.removeClass('hidden');
            } else {
                this.libsIcon.addClass('hidden');
                this.libsIcon.hide('fast');
            }
            $('.icon_library img[src=\"' + $('.marker_icon_chose').attr('src') + '\"]').parent().addClass('selected');
        },
        clickViewMarker : function( obj, $glb ) {
            /* Remove if have the view to some of marker before */
            if ($('table.marker_list tr').hasClass('selecting') === true) {
                $('table.marker_list tr').removeClass('selecting');
            }
        },
        uploadImage : function () {
            var $this = this;
            $(document).on('change', '#marker-upoad-image', function ( e ) {
                e.preventDefault();
                $obj  = $(this);
                $this.data = {
                    'action'        : 'flx_upload_marker_icon',
                    'link'          : $(this).val(),
                    '_ajax_nonce'   : ajax_data
                };
                $.post( ajaxurl, $this.data, function ( responsive ) {
                    if( responsive!= 'not_get' && responsive !='not_isset' ) {
                        $this.show  = '<div class="marker_wrap">';
                        $this.show += '<img src="' + $obj.val() + '" alt="" width="32" height="37" title="' + responsive + ' ">';
                        $this.show += '</div>';
                        $('.custom-group').append( $this.show );
                    }
                });
            });
        },
        deleteIcons : function ( obj, $glb ) {
            if( window.confirm('Are you sure you want to delete this icon? ') ) {
                $link = $('.custom-group .selected img').attr('src');
                /* ajax to delete icon */
                $this.data = {
                    'action'    : 'flx_delete_marker_icon',
                    'link'      : $link,
                    '_ajax_nonce'   : ajax_data
                };
                $.post( ajaxurl, $this.data, function ( responsive ) {
                    /* reset to default */
                    $('.custom-group .selected').remove();
                    $('.base-icon div:first-child').trigger('click');
                });
            }
        }
    };
    markerPanel.init();
});
/* Helper */
/* To clear field's value */
function reset_field_marker() {
    jQuery('#latitude').val('');
    jQuery('#longitude').val('');
    jQuery('#marker_title').val('');
    jQuery('#marker_timeout').val('');
    jQuery('#marker_icon_label').val('');
    jQuery('.marker_des_wrapper button#marker_des-html').trigger('click');
    jQuery('#des_open').prop('checked', false);
    jQuery('textarea[name=\"marker_des\"]').val('');
    jQuery('.marker_des_wrapper button#marker_des-tmce').trigger('click');
    jQuery('.base-icon div:first-child').trigger('click');
    this.libsIcon = jQuery('.marker_libs_icon');
    if( !this.libsIcon.hasClass('hidden') )
    {
        jQuery('.edit_chose_marker_icon').trigger('click');
    }
    /* Reset options effect */
    var img = jQuery('.base-icon div:first-child img').attr('src');
    jQuery('.marker_icon_chose').attr('src', img);
    jQuery('#marker_effect').find('option').removeAttr('selected');
}