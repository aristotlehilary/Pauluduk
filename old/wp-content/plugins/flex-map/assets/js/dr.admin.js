jQuery(function($) {
    var drawInit = {
        init: function() {
            this.refreshVars();
            this.bindClickUI( '.btn-addpolylines', this.clickAddPolylines, this );
            this.bindClickUI( '.btn-addRectangle', this.clickRectangles, this );
            this.bindClickUI( '.btn-addCircle', this.clickAddCircles, this );
            this.bindClickUI( '.edit_poly', this.clickEditPoly, this );
            this.generateColorField();
        },
        /* Define */
        refreshVars : function () {
            this.btnSaveChange      = 'btn-saveChangePoly';
            this.btnCancelChange    = 'btn-cancelChangePoly';
            this.btnSave            = 'btn-savePoly';
            this.btnCancel          = 'btn-polycancel';
            this.oBtnSaveChange     = $('.poly-option button:first-child');
            this.oBtnCancelChange   = $('.poly-option button:nth-child(2)');
            this.oBtnSave           = $('.btn-savePoly');
            this.btnVisual          = $('#poly_content-tmce');
            this.btnText            = $('#poly_content-html');
            this.polyContent        = $('#poly_content');
        },
        bindClickUI : function( obj, func, $glb ) {
            this.event = 'ontouchstart' in window ? 'touchstart' : 'click';
            $(document).on( this.event, obj, function( e ){
                e.preventDefault();
                /* action function */
                func( $(this), $glb);
            });
        },
        clickRectangles : function( obj, $glb ) {
            $glb.resetField('rectangle');
            $('.line-gon h3').html('Add A Rectangle');
            $glb.sw2Add();
        },
        clickAddPolylines : function( obj, $glb ) {

            $glb.resetField('line');
            $('.poly_fill').hide();
            $('.line-gon h3').html('Add A Polyline Or Polygon');
            $glb.sw2Add();
        },
        clickAddCircles : function( obj, $glb ) {
            $glb.resetField('circle');
            $('.line-gon h3').html('Add A Cirlce');
            $glb.sw2Add();
        },
        clickEditPoly : function ( obj, $glb ) {
            $glb.sw2Edit();
        },
        /* Common action */
        sw2Edit : function () {
            /* Save button */
            this.oBtnSave.addClass( this.btnSaveChange );
            this.oBtnSave.html('Save Change');
            this.oBtnSaveChange.removeClass( this.btnSave );
            /* Cancel change */
            this.oBtnCancelChange.addClass( this.btnCancelChange );
            this.oBtnCancelChange.html('Cancel Change');
            this.oBtnCancelChange.removeClass(this.btnCancel);
        },
        sw2Add : function () {
            if( this.oBtnSaveChange.hasClass(this.btnSaveChange) ) {
                this.oBtnSaveChange.addClass( this.btnSave );
                this.oBtnSave.removeClass( this.btnSaveChange );
                this.oBtnSave.html('Save');
                /* Cancel change */
                this.oBtnCancelChange.addClass( this.btnCancel );
                this.oBtnCancelChange.html('Cancel');
                this.oBtnCancelChange.removeClass( this.btnCancelChange );
            }
        },
        resetField : function( status ) {
            $('#polyStatus').val( status );
            $('.pl_title').val('');
            $('#eventTrack').val('0');
            this.btnText.trigger('click');
            this.polyContent.val('');
            this.btnVisual.trigger('click');
        },
        generateColorField : function() {
            $("#polyColors").ColorPickerSliders({
                color   : 'hsla(26, 87%, 51%, 0.97)',
                flat    : true,
                order   : {
                    hsl     : 1,
                    opacity : 2
                },
                swatches        : false,
                connectedinput  : '.stroke_poly',
                onchange        : function() {
                    $( '#stroke_poly_hsl' ).trigger('click');
                }
            });
            $("#polyFillColors").ColorPickerSliders({
                color   : 'hsla(35, 85%, 52%, 0.52)',
                flat    : true,
                order   : {
                    hsl     : 1,
                    opacity : 2
                },
                swatches        : false,
                connectedinput  : '.fill_poly',
                onchange        : function() {
                    $( '#fill_poly_hsl' ).trigger('click');
                }
            });
            $( ".polo-weight" ).slider({
                animate: true,
                range: "min",
                value: 3,
                min: 1,
                max: 30,
                step: 1,

                //this gets a live reading of the value and prints it on the page
                slide: function( event, ui ) {
                    $( "#polo-weight-result" ).html(ui.value);
                    $('#polo-weight-hidden').attr('value', ui.value);
                    $('#polo-weight-hidden').trigger('click');
                }

            });
        }
    };
    drawInit.init();
});