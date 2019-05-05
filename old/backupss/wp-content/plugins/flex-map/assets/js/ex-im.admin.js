jQuery(function($) {
    var map_data = ( mapData )? mapData : '';
    var backup = {
        init : function () {
            this.clickSelect();
            this.clickExport();
            this.importData();
        },
        bindClickUI : function( obj, func, $glb ) {
            this.event = 'ontouchstart' in window ? 'touchstart' : 'click';
            $(document).on( this.event, obj, function( e ){
                e.preventDefault();
                /* action function */
                func( $(this), $glb);
            });
        },
        clickExport : function () {
            var $this = this;
            document.getElementById('export-btn').onclick = function(code) {
                if( map_data != '' ) {
                    /* extract info */
                    $this.style     = $('#style-export').is(':checked');
                    $this.icon      = $('#icon-export').is(':checked');
                    $this.check_all = $('.check_all').is(':checked');
                    $this.data      = {};

                    $this.data['_host_'] = mapData._host_;

                    if( $this.style == true ) {
                        $this.data['_mystyles_'] = encodeURIComponent(JSON.stringify(mapData._mystyles_ ));
                    }

                    if( $this.icon == true ) {
                        $this.data['_icons_'] = encodeURIComponent(JSON.stringify(mapData._icons_));
                    }

                    if( $this.check_all == true ) {
                        $this.data['_map_posts_'] =  encodeURIComponent(JSON.stringify(mapData._map_posts_));
                    } else {
                        $this.posts = [];
                        $('.post_map').each(function(){
                            if( this.checked === true) {
                                $this.ids = parseInt( $(this).attr('id') );
                                $this.posts.push( mapData._map_posts_[$this.ids] );
                            }
                        });
                        if( $this.posts.length > 0 ) {
                            $this.data['_map_posts_']  = encodeURIComponent(JSON.stringify($this.posts));
                        }
                    }
                    if($this.data.length == 0 ) {
                        alert('Emty data!');return false;
                    }
                    this.href = 'data:text/plain;charset=utf-8,'
                    + encodeURIComponent(JSON.stringify($this.data));
                }
            };
        },
        clickSelect : function () {
            /* click to check, uncheck all */
            $(document).on( 'click', '#check_all', function( e ) {
                if ( this.checked ) { // check select status
                    $('.post_map').each(function () { //loop through each checkbox
                        this.checked = true;  //select all checkboxes with class "checkbox1"
                        $(this).parent().parent().parent().addClass('selecting');
                    });
                } else {
                    $('.post_map').each(function () { //loop through each checkbox
                        this.checked = false; //deselect all checkboxes with class "checkbox1"
                        $(this).parent().parent().parent().removeClass('selecting');
                    });
                }
            });
            /* click on each checkbox */
            $(document).on( 'click', '.post_map', function( e ) {
                $this = this;
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
        importData  : function () {
            var $this = this;
            $this.result = $('#files');
                $('#fileupload').fileupload({
                    url         : ajaxurl,
                    'action'        : 'file_upload_import_map',
                    '_ajax_nonce'   : map_data._nonce_,
                    done: function (e, data) {

                        var files = data.files[0];

                        var file_content;
                        var reader = new FileReader();
                        var blob = files.slice(0, files.size);
                        reader.readAsBinaryString(blob);
                        /* If we use onloadend, we need to check the readyState.*/
                        reader.onloadend = function(evt) {
                            if (evt.target.readyState == FileReader.DONE) { /* DONE == 2*/
                                file_content = evt.target.result;
                                /* Valid null content*/
                                if(file_content == '' || file_content == null)
                                {
                                    alert(' File content is empty! ');return false;
                                }

                                if( $this.getExtension(files.name) != 'json' && $this.getExtension(files.name) != 'txt' )
                                {
                                    alert(' Require file\'s extension is \'.json\' or \'.txt\' ! ');return false;
                                }
                                $this.importMap( files, file_content, $('#append').is(':checked'), true );
                            }
                        };
                        /*$.each(data.result.files, function (index, file) {
                            $('<p/>').text(file.name).appendTo('#files');
                        });*/
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                        );
                    }
                }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
        },
        importMap : function ( files, file_content, append, notice ) {
            var $this = this;
            /* Ajax */
            var data = {
                'action'        : 'flx_import_map',
                '_ajax_nonce'   : map_data._nonce_,
                'file_content'  : file_content,
                'append'        : append
            };
            $.post(
                ajaxurl, data, function ( responsive ) {
                    if( notice === true ) {
                        var result = responsive.trim();
                        if( result.indexOf('success') !== -1 ) {
                            $this.result.append('<p class="color-green"> <i class="fa fa-check"></i> <b>' + files.name + '</b> was updated successfully. </p>');
                        } else if( result.indexOf('content_incorrect')  !== -1 ){
                            $this.result.append('<p class="color-red"> <i class="fa fa-times"></i> <b>' + files.name + '</b> incorrect file content. </p>');
                        } else  if( result.indexOf('file_content_exist')  !== -1 ){
                            $this.result.append('<p class="color-red"> <i class="fa fa-times"></i> <b>' + files.name + '</b> file content doesn\'t exists. </p>');
                        } else  if( result.indexOf('nothing_change')  !== -1 ){
                            $this.result.append('<p class="color-red"> <i class="fa fa-times"></i> <b>' + files.name + '</b> the content of update file has nothing new. </p>');
                        } else {
                            $this.result.append('<p class="color-red"> <i class="fa fa-times"></i> <b>' + files.name + '</b> undefined error. </p>');
                        }
                    }
                });
        },
        /**
         * Get extension from file name
         *
         * @param filename : dir name or file name
         * @reuturn parts : file's extensions
         */
        getExtension : function( filename ) {
            var parts = filename.split('.');
            return parts[parts.length-1];
        }
    };
    backup.init();
});