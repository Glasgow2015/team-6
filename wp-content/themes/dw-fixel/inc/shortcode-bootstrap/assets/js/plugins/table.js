// JavaScript Document
(function() {
  "use strict";
    // Creates a new plugin class and a custom listbox
    tinymce.create('tinymce.plugins.dws_table', {
        createControl: function(n, cm) {
            switch (n) {                
                case 'dws_table':
                var c = cm.createSplitButton('dws_table', {
                    title : 'Table',
                    onclick : function() {

                    }
                    //'class':'mceListBoxMenu'
                });
                

                c.onRenderMenu.add(function(c, m) {
                    m.onShowMenu.add(function(c,m){
                        jQuery('#menu_'+c.id).height('auto').width('auto');
                        jQuery('#menu_'+c.id+'_co').height('auto').addClass('mceListBoxMenu'); 
                        var $menu = jQuery('#menu_'+c.id+'_co').find('tbody:first');
                        if($menu.data('added')) return;
                        $menu.append('');
                        $menu.append('<div style="padding:0 10px 10px">\
                        <label>Rows\
                        <input type="text" name="table_rows" value="1" onclick="this.select()"  /></label>\
                        <label>Columns\
                        <input type="text" name="table_columns" value="2" onclick="this.select()"  /></label>\
                        </div>');

                        jQuery('<input type="button" class="button" value="Insert" />').appendTo($menu)
                                .click(function(){

                                var uID =  Math.floor((Math.random()*100)+1);
                                var shortcode = '[table id="table_'+uID+'"]<br class="nc"/>';
                                var rows = $menu.find('input[name=table_rows]').val();
                                var cols = $menu.find('input[name=table_columns]').val();

                                    for(i=0;i<rows;i++) {
                                        shortcode+= '[tr]<br class="nc"/>';
                                        var width = 100 / cols;
                                        for(j=0;j<cols;j++) {
                                            shortcode+= '[td width="'+width+'%"]Text[/td]<br class="nc"/>';
                                        }
                                        shortcode += '[/tr]<br class="nc"/>';
                                    }

                                shortcode+= '[/table]';

                                    tinymce.activeEditor.execCommand('mceInsertContent',false,shortcode);
                                    c.hideMenu();
                                }).wrap('<div style="padding: 0 10px 10px"></div>')
                 
                        $menu.data('added',true); 

                    });

                   // XSmall
                    m.add({title : 'Table', 'class' : 'mceMenuItemTitle'}).setDisabled(1);

                 });
                // Return the new splitbutton instance
                return c;
                
            }
            return null;
        }
    });
    tinymce.PluginManager.add('dws_table', tinymce.plugins.dws_table);
})();