// JavaScript Document
(function() {
  "use strict";
    // Creates a new plugin class and a custom listbox
    tinymce.create('tinymce.plugins.dws_outer_grid', {
        createControl: function(n, cm) {
            switch (n) {                
                case 'dws_outer_grid':
                var c = cm.createSplitButton('dws_outer_grid', {
                    title : 'DW outer grid system',
                    onclick : function() {
                    }
                });

                c.onRenderMenu.add(function(c, m) {
                    // Boxes & frames
                    m.add({title : 'DW outer grid system', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
                    m.add({title : 'Outer Wrap', onclick : function() {
                            tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, '[col_grid_wrap]<br class="nc"/>[/col_grid_wrap]' );
                        }
                    })
                    m.add({title : '3 Columns', onclick : function() {
                        tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, '[col_grid]<br class="nc"/>[col_size class="col-1"]Text[/col_size]<br class="nc"/>[col_size class="col-2"]Text[/col_size]<br class="nc"/>[col_size class="col-1"]Text[/col_size]<br class="nc"/>[/col_grid]' );
                    }});
                    m.add({title : '3 Columns content padding', onclick : function() {
                        tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, '[col_grid]<br class="nc"/>[col_size class="col-1" padding="yes"]Text[/col_size]<br class="nc"/>[col_size class="col-2" padding="yes"]Text[/col_size]<br class="nc"/>[col_size class="col-1" padding="yes"]Text[/col_size]<br class="nc"/>[/col_grid]' );
                    }});
                    m.add({title : '2 Columns', onclick : function() {
                        tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, '[col_grid]<br class="nc"/>[col_size class="col-2"]Text[/col_size]<br class="nc"/>[col_size class="col-2"]Text[/col_size]<br class="nc"/>[/col_grid]' );
                    }});

                    m.add({title : '2 Columns content padding', onclick : function() {
                        tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, '[col_grid]<br class="nc"/>[col_size class="col-2" padding="yes"]Text[/col_size]<br class="nc"/>[col_size class="col-2" padding="yes"]Text[/col_size]<br class="nc"/>[/col_grid]' );
                    }});
                });

                // Return the new splitbutton instance
                return c;
                
            }
            return null;
        }
    });
    tinymce.PluginManager.add('dws_outer_grid', tinymce.plugins.dws_outer_grid);
})();