jQuery(function($) {
    var general = {
        init: function() {
            this.generateField();
            this.bindClickUI('input[name="short_code"]', this.selectAll, this );
            this.changeUI('#df_ui', this.clickDefaultUI, this );
            this.changeUI('#map_layout_res', this.clickLayoutRes, this );
            this.changeUI('#map_layout_cus', this.clickLayoutFix, this );
        },
        bindClickUI : function( obj, func, $glb ) {
            this.event = 'ontouchstart' in window ? 'touchstart' : 'click';
            $(document).on( this.event, obj, function( e ){
                e.preventDefault();
                /* action function */
                func( $(this), $glb);
            });
        },
        changeUI : function( obj, func, $glb ) {
            $(document).on( 'change', obj, function( e ){
                e.preventDefault();
                /* action function */
                func( $(this), $glb);
            });
        },
        resetField : function( status ) {
            $('#polyStatus').val( status );
            $('.pl_title').val('');
            $('#eventTrack').val('0');
        },
        generateField : function() {
            $( ".map-zoom" ).slider({
                animate: true,
                range: "min",
                value: 0,
                min: 0,
                max: 21,
                step: 1,

                //this gets a live reading of the value and prints it on the page
                slide: function( event, ui ) {
                    $( "#map-zoom-result" ).html(ui.value);
                    $('#map-zoom-hidden').attr('value', ui.value);
                    $('#map-zoom-hidden').trigger('change');
                }
            });

        },
        selectAll : function ( obj, $glb ) {
            obj.select();
        },
        /* Setting show & hdiden */
        clickDefaultUI : function ( obj, $glb ) {
            if( obj.is(':checked') ) {
                if( $('.field-container tr').hasClass('hidden') ) {
                    $('.field-container tr').removeClass('hidden')
                }
            } else {
                if( !$('.field-container tr').hasClass('hidden') ) {
                    $('tr.defaultUI').nextAll().addClass('hidden');
                }
            }
        },
        clickLayoutRes : function ( obj, $glb ) {
            $('#unit_width option[value="%"]').prop("selected", true);
            $('#unit_width option[value="px"]').attr('disabled','disabled');
            $('#unit_height option[value="%"]').attr('disabled','disabled');
            $('.heightUn').removeClass('hidden');
            if( $('#map_width').val() == '' ) {
                $('#map_width').val('100');
            }
            if( $('#map_height').val() == '' ) {
                $('#map_height').val('350');
            }
        },
        clickLayoutFix : function (obj, $glb) {
            $('.heightUn').addClass('hidden');
            $('#unit_width option[value="px"]').removeAttr('disabled');
            $('#unit_height option[value="%"]').removeAttr('disabled');
        }
    };
    general.init();
});