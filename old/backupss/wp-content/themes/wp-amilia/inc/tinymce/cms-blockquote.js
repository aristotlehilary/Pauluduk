(function() {
    tinymce.PluginManager.add('cshero_quote_btn', function( editor, url ) {
        editor.addButton( 'cshero_quote_btn', {
            text: 'Quote',
            icon: false,
            type: 'menubutton',
            menu: [
                {
                    text: 'Default Blockquote',
                    value: 'cms-quote-default',
                    onclick: function() {
                        editor.insertContent('<blockquote class="'+this.value()+'">'+tinyMCE.activeEditor.selection.getContent()+'<blockquote>');
                    }
                },
                {
                    text: 'Custom Blockquote',
                    value: 'cms-quote-custom',
                    onclick: function() {
                        editor.insertContent('<blockquote class="'+this.value()+'">'+tinyMCE.activeEditor.selection.getContent()+'<blockquote>');
                    }
                },
                {
                    text: 'Alternate Blockquote',
                    value: 'blockquote-reverse',
                    onclick: function() {
                        editor.insertContent('<blockquote class="'+this.value()+'">'+tinyMCE.activeEditor.selection.getContent()+'<blockquote>');
                    }
                }
           ]
        });
    });
})();