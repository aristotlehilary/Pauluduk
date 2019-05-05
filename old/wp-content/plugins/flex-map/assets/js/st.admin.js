jQuery(function($) {
    var stylesInit = {
        init : function() {

            this.triggerLoadMyStyles();
            this.bindClickUI('.styles_map_container > h3', this.ajaxLoadMyStyles, this);
            this.bindClickUI('.back_mystyle', this.backMyStyles, this);
            this.bindClickUI('.add_style', this.triggerLoadSnazzy, this);
            this.bindClickUI('.pagination li a', this.clickPagination, this);
            this.bindClickUI('.btn-delete-style', this.clickDeleteStyle, this);
            this.bindClickUI('.btn-save-style', this.clickSaveStyle, this);
            this.bindClickUI('.btn.btn-ad-tive', this.clickDeAc, this);
            this.bindClickUI('.btn.btn-active', this.clickActiveStyle, this);
            this.bindClickUI('.btn.btn-deactived', this.clickDeactiveStyle, this);
        },
        bindClickUI         : function (obj, func, $glb) {
            $(document).on('click', obj, function (e) {
                e.preventDefault();
                /* action function */
                func($(this), $glb);
            });
        },
        triggerLoadMyStyles : function() {
            $(document).on('click', 'label[for="marker_tab_id_6"]', function () {
                $('.styles_map_container > h3').trigger('click');
            });
        },
        triggerLoadSnazzy   : function( obj, $glb ) {
            $glb.flip('back');
            $glb.generateSnazzy(1);
        },
        ajaxLoadMyStyles    : function( obj, $glb ) {
            $this = this;
            $this.data = {
                'action'      : 'flx_load_my_styles',
                '_ajax_nonce' : ajax_data
            };
            $.post( ajaxurl, $this.data, function ( responsive ) {
                $glb.generateMyStyles(JSON.parse(responsive) );
            });
        },
        /* Click */
        clickPagination     : function ( obj, $glb ) {
            this.current = parseInt(obj.attr('page'));
            $glb.generateSnazzy(this.current);
            $( '.marker_tab_id_6' ).scrollTop(0);
        },
        clickDeleteStyle    : function ( obj, $glb ) {
            $this = this;
            if (confirm(' Are you sure want to delete this style? ')) {
                obj.parent().parent().parent().remove();
                $this.style_name = obj.parent().attr('style-name');
                /* to update mystyle data */
                $this.data = {
                    'action'        : 'flx_delete_mystyle',
                    'style_name'    : $this.style_name,
                    '_ajax_nonce'   : ajax_data
                };
                $.post(
                    ajaxurl, $this.data, function ( responsive ) {
                    }
                );
            }
        },
        clickDeAc           : function ( obj, $glb ) {

        },
        clickSaveStyle      : function ( obj, $glb ) {
            $this = this;
            /* Get json */
            $this.style_json = obj.parent().attr('style-json');
            /* Get image */
            $this.style_image = obj.parent().prev().attr('src');
            /* Get style name */
            $this.style_name = obj.parent().attr('style-name');
            obj.remove();
            /* Ajax to save my style */
            $this.data = {
                'action'        : 'flx_save2_mystyles',
                '_ajax_nonce'   : ajax_data,
                'style_json'    : $this.style_json,
                'style_image'   : $this.style_image,
                'style_name'    : encodeURIComponent($this.style_name)
            };
            $.post(
                ajaxurl, $this.data, function ( responsive ) {
                    obj.addClass('btn-hidden');
                });
        },
        clickActiveStyle    : function ( obj, $glb ) {
            this.wrapper = $('.maps_style_wrapper');
            /* remove all defaut */
            $('.maps_style_wrapper').each( function(){
                if( $(this).hasClass('default') ) {
                    $(this).removeClass('default');
                }
                if($(this).find('.btn-ad-tive').hasClass('btn-deactived')) {
                    $(this).find('.btn-ad-tive').removeClass('btn-deactived');
                    $(this).find('.btn-ad-tive').html('<i class="fa fa-check"></i>');
                }
            });
            obj.addClass('btn-deactived');
            obj.removeClass('btn-active');
            obj.parent().parent().parent().addClass('default');
            obj.html('<i class="fa fa-times"></i>');
            if( obj.parent().find('div:nth-child(2)').hasClass('btn-save-style') ) {
                obj.parent().find('div:nth-child(2)').trigger('click');
            }
        },
        clickDeactiveStyle  : function ( obj, $glb ) {
            obj.removeClass('btn-deactived');
            obj.addClass('btn-active');
            obj.parent().parent().parent().removeClass('default');
            obj.html('<i class="fa fa-check"></i>');
        },
        /* Helper */
        backMyStyles        : function ( obj, $glb ) {
            $glb.flip('front');
            $('.styles_map_container > h3').trigger('click');
        },
        generateMyStyles    : function( mystyles_json ) {
        this.myMaps = '';
        /* Get default style */
        this.style_default = $('input[name="style_default"]').val();
        /* Get my styles */
        this.style_default = ( this.style_default!='' )? JSON.parse(this.style_default) : '';
        this.style_default['style_name'] = ( decodeURIComponent(this.style_default['style_name']) )? decodeURIComponent(this.style_default['style_name']) : this.style_default['style_name'];
        /* LOOP */
        this.i = 0;
        for (var style_name in mystyles_json )
        {
            this.mystyle_name   = ( decodeURIComponent(style_name) )? decodeURIComponent(style_name) : style_name;
            this.mystyle_json   = mystyles_json[style_name]['json'];
            this.mystyle_image  = mystyles_json[style_name]['image'];

            this.isActived      = ( this.style_default['style_name'] && ( this.style_default['style_name'] == this.mystyle_name ) )? 1 : 0;
            this.default        = ( this.isActived == 1 ) ? 'default' : '';

            this.myMaps +=
                '<div class="maps_style_wrapper ' +  this.default + '">' +
                '<div class="image_wrap">';
            /* Check for exists image demo, if image is null, it will be generate google map live demo using json */
            if( this.mystyle_image != '' )
            {
                this.myMaps += '<img src="' + this.mystyle_image + '" style="height:100%;"> ';
            }

            this.myMaps += '<div class="button-container" style-json=\'' + this.mystyle_json.replace(new RegExp("\\\\", "g"), "") + '\' style-name=\'' + this.mystyle_name + '\'> ';
            /* Check actived or not active */
            if( this.isActived == 1 )
            {
                this.myMaps +=  '<div class="btn btn-ad-tive btn-deactived"><i class="fa fa-times"></i></div> ';
            } else {
                this.myMaps +=  '<div class="btn btn-ad-tive btn-active"><i class="fa fa-check"></i></div> ';
            }
            this.myMaps +=      '<div class="btn btn-delete-style"><i class="fa fa-trash-o"></i></div> ';
            this.myMaps +=  '</div> ' +
            '</div>' +
            '<div class="style-name">' +
                this.mystyle_name +
            '</div>' +
            '</div>';
        }
        this.myMaps += '<button class="add_style btn-orange map-btn" style="width:100%;text-align:center;"> <i class="fa fa-th-large"></i> Add More Style</button>';
        $('.styles_map_container .styles').html(this.myMaps);
    },
        generateSnazzy      : function( current ){
        var $this = this;
        /* Get default style */
        $this.style_default = $('input[name="style_default"]').val();
        /* Get my styles */
        $this.style_default = ( $this.style_default!='' )? JSON.parse($this.style_default) : '';
        $this.snazzy_maps = '<h3>Download Styles</h3><br clear="all">';
        $this.json_link = 'https://snazzymaps.com/explore.json?key=7c2db2be-c360-4fc0-b96f-5a49fb8d0017&page=' + current;

        $this.data = {
            'action'        : 'flx_load_styles_libs',
            '_ajax_nonce'   : ajax_data
        };
        $.get( $this.json_link, $this.data, function( snazzy_explore ) {
            for ($this.style in snazzy_explore.styles )
            {
                $this.snazzy_maps +=
                    '<div class="maps_style_wrapper">' +
                    '<div class="image_wrap">' +
                    '<img src="' + snazzy_explore.styles[$this.style]['imageUrl'] + '" style="height:100%;"> ' +
                    '<div class="button-container" style-json=\'' + snazzy_explore.styles[$this.style]['json'] + '\' style-name=\'' + snazzy_explore.styles[$this.style]['name'] + '\'> ';
                /* Check actived or not active */
                if( $this.style_default['style_name'] && ( decodeURIComponent($this.style_default['style_name']) == snazzy_explore.styles[$this.style]['name'] ) )
                {
                    $this.snazzy_maps +=      '<div class="btn btn-ad-tive btn-deactived"><i class="fa fa-times"></i></div> ';
                } else {
                    $this.snazzy_maps +=      '<div class="btn btn-ad-tive btn-active"><i class="fa fa-check"></i></div> ';
                }
                $this.snazzy_maps +=      '<div class="btn btn-save-style"><i class="fa fa-floppy-o"></i></div> ';
                $this.snazzy_maps +=  '</div> ' +
                '</div>' +
                '<div class="style-name">' +
                snazzy_explore.styles[$this.style]['name'] +
                '</div>' +
                '</div>';
            }
            $this.snazzy_maps += '<br clear="all">' + stylesInit.generatePagination( current, snazzy_explore.pagination['totalPages'] );
            $this.snazzy_maps += '<div class="wrap-button"><button class="back_mystyle btn-red map-btn" style="width:100%;text-align:center;"> <i class="fa fa-arrow-left"></i> Back To My Styles</button></div>';
            $('.style-flip-container .back').html($this.snazzy_maps);
        });
        return false;
    },
        generatePagination  : function( current, total ) {
            $this = this;
            $this.pagination = '';
            $this.pre_button = ''; $this.pre_disable = '';
            $this.next_button = ''; $this.next_disable = '';
            $this.active = '';

            if( current <= 3)
            {
                $this.begin = 1;
                $this.end = (total <= 3)? total : 5;
            } else {
                $this.begin = current - 3;
                $this.end = (total <= (current + 3) )? total : (current + 3);
            }

            /* Check for display previous button */
            if( current == 1 )
            {
                $this.pre_button += '<span class="previous">«</span>';
                $this.pre_disable = 'disable';
            } else {
                $this.pre_button = '<a class="previous" page="' + ( current-1 ) + '">«</a>';
            }
            $this.pre_button = '<li class="previous ' + $this.pre_disable + '">' + $this.pre_button + '</li>';

            /* Check for next button */
            if( current == total )
            {
                $this.next_button += '<span class="previous">»</span>';
                $this.next_disable = 'disable';
            } else {
                $this.next_button += '<a class="previous" page="' + ( current + 1 ) + '">»</a>';
            }
            $this.next_button = '<li class="next ' + $this.next_disable + '">' + $this.next_button + '</li>';

            /* Loop for page */
            for(var i = $this.begin; i<= $this.end; i++ )
            {
                $this.active = (current == i )? 'class="active"':'';
                $this.pagination += '<li ' + $this.active + '>';
                if( current == i )
                {
                    $this.pagination +=  '<span>' + i + '</span> ';
                } else {
                    $this.pagination +=  '<a page="' + i + '">' + i + '</a> ';
                }
                $this.pagination += '</li>';
            }
            $this.pagination = '<ul class="pagination"> ' + $this.pre_button + $this.pagination + $this.next_button + '</ul>';
            return $this.pagination;
        },
        flip                : function( face ) {
            this.flipContainer = $('.style-flip-container');

            if( face == 'back' ) {
                if( this.flipContainer.hasClass('flip') === false)
                {
                    /* Flip to back */
                    this.flipContainer.addClass('flip');
                    $('.marker_tab_id_6 .front').scrollTop(0);
                } else {
                    return false;
                }
            } else if( face == 'front' ) {
                if( this.flipContainer.hasClass('flip') === true)
                {
                    /* Flip to front */
                    this.flipContainer.removeClass('flip');
                    $('.marker_tab_id_6 .back').scrollTop(0);
                } else {
                    return false;
                }
            }
        }
    };
    stylesInit.init();
});