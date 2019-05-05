(function() {
    tinymce.PluginManager.add('cms_highlight', function( editor, url ) {
        editor.addButton( 'cms_highlight', {
            text: 'HighLight',
            icon: false,
            type: 'menubutton',
            menu: [
                {
                    text: 'HighLight Text Gray',
                    value: 'cms-highlight-gray',
                    onclick: function() {
                        editor.insertContent('<span class="'+this.value()+'">'+tinyMCE.activeEditor.selection.getContent()+'<span>');
                    }
                },
                {
                    text: 'HighLight Text Yellow',
                    value: 'cms-highlight-yellow',
                    onclick: function() {
                        editor.insertContent('<span class="'+this.value()+'">'+tinyMCE.activeEditor.selection.getContent()+'<span>');
                    }
                }
            ]
        });
    });
})();