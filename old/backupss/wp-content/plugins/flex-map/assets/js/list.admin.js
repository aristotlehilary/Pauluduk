jQuery(function($) {
    var listMap = {
      init : function () {
        this.bindClickUI('#delete_map',this.deleteMap, this);
        this.bindClickUI('#edit_map',this.clickEditMap, this);
        this.clickSelect();
        this.scrollFixedOption();
      },
        bindClickUI : function( obj, func, $glb ) {
            this.event = 'ontouchstart' in window ? 'touchstart' : 'click';
            $(document).on( this.event, obj, function( e ){
                e.preventDefault();
                /* action function */
                func( $(this), $glb);
            });
        },
        deleteMap : function (obj, $glb) {
            var $this   = this;
            $this.IDS   = '';
            $this.count = 0;
            if( window.confirm('Are you really want to delete this map? ( A deleted map cannot be recovered. )') ) {
                $('.post_map').each(function () {
                    if( this.checked == true ) {
                        $this.IDS += $(this).attr('id') + ',';
                        $(this).trigger('click');
                        $(this).parent().parent().parent().hide('slow');
                        $(this).parent().parent().parent().remove();
                        $this.count += 1;
                    }
                });
                $this.data = {
                     'action': 'flx_delete_map',
                     '_ajax_nonce' : ajax_data,
                     'map_id' : $this.IDS
                 };
                 $.post( ajaxurl, $this.data, function ( responsive ) {
                     if( $this.count > 1 ) {
                         $this.message = "<i class='fa fa-check'></i> These map was deleted!";
                     } else {
                         $this.message = "<i class='fa fa-check'></i> This map was deleted!";
                     }
                     if(responsive != 'fail') {
                         $.growl.notice({ message: $this.message });
                     } else {
                         $.growl.error({ message: "<i class='fa fa-times'></i> Delete was fail!"  });
                     }
                 });
            }
        },
        clickSelect : function () {
            /* click to check, uncheck all */
            $(document).on( 'click', '#check_all', function( e ) {
                if ( this.checked ) { // check select status
                    $('.post_map').each(function () { //loop through each checkbox
                        this.checked = true;  //select all checkboxes with class "checkbox1"
                        $(this).parent().parent().parent().addClass('selecting');
                        $('#delete_map').show();
                    });
                } else {
                    $('.post_map').each(function () { //loop through each checkbox
                        this.checked = false; //deselect all checkboxes with class "checkbox1"
                        $(this).parent().parent().parent().removeClass('selecting');
                        $('#delete_map').hide();
                    });
                }
            });
            /* click on each checkbox */
            $(document).on( 'click', '.post_map', function( e ) {
                    $this = this;
                    /* check for show edit button */
                    $this.count = 0;
                    $('.post_map').each(function () {
                        if( this.checked == true ) {
                            $this.count += 1;
                        }
                    });
                     /* to show edit map button  */
                    if( $this.count == 1 ) {
                        $('#edit_map').show();
                    } else {
                        $('#edit_map').hide();
                    }
                    /* to show delete button or hide all button */
                    if( $this.count > 0 ) {
                        $('#delete_map').show();
                    } else {
                        $('#delete_map').hide();
                        $('#edit_map').hide();
                    }
                    if( this.checked == true ) {
                        $(this).parent().parent().parent().addClass('selecting');
                    } else {
                        $(this).parent().parent().parent().removeClass('selecting');
                    }
                /* Check to check all */
                    if( this.checked == false && $('#check_all').is(':checked') ) {
                        $('#check_all').prop( 'checked', false );
                    }
            });

        },
        scrollFixedOption : function () {
            $(window).scroll( function(){
                /* Check the location of each desired element */
                var wpadminbar_height = $('#wpadminbar').outerHeight();
                var bottom_of_object = $('.map-list-table').position().top - $('.action-option').outerHeight();
                var bottom_of_object_fixed = $('.map-list-table').position().top;
                var top_of_window = $(window).scrollTop();
                /* If the object is completely visible in the window, fade it in */
                if( top_of_window > bottom_of_object ){
                    $('.action-option').attr('style', 'position:fixed;top:' + wpadminbar_height + 'px;');
                }else if( top_of_window < bottom_of_object_fixed ){
                    $('.action-option').removeAttr('style');
                }
            });
        },
        clickEditMap : function (obj, $glb) {
            $('.post_map').each(function () {
                if (this.checked == true) {
                    $(this).parent().parent().parent().find('td:nth-child(2) a').trigger('click');
                    window.location.replace($(this).parent().parent().parent().find('td:nth-child(2) a').attr('href'));
                }
            });
        }
    };
    listMap.init();
});