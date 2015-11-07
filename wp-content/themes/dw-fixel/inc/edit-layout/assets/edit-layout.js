(function( e, $, n){
    "use strict";
    var DW_edit_layout = function( element, options ){
        this.$container = $(element);
        this.getLayout();
        this.placeHolder = $('<article class="block block-placeholder block-move-placeholder"><div class="block-inner"></div></article>');
        this.overPlaceHolder = $('<article class="block block-placeholder block-over-placeholder"><div class="block-inner"></div></article>');
        this.overBlock = null;

        $('.block-placeholder').hide();
        var t = this, timeoutId;

        this.$container.find('.block').mousedown(function(event) {
            var block = $(this);
            timeoutId = setTimeout( function(){
                var text = "";
                if (window.getSelection) {
                    text = window.getSelection().toString();
                } else if (document.selection && document.selection.type != "Control") {
                    text = document.selection.createRange().text;
                }
                if( text.length <= 0 ) {
                    block.disableTextSelect();
                    t.startEditLayout(block,event);
                }
            }, 300);
        }).bind('mouseup mouseleave', function() {
            clearTimeout(timeoutId);
        });
        
        $('body.edit .edit-post a[href="#resize"]').on('click',function(event){
            event.preventDefault();
            var block = $(this).closest('.block');
            if( block.hasClass('w2') ) {
                block.removeClass('w2');
                $(this).find('i').removeClass('icon-resize-small').addClass('icon-resize-full');
            } else {
                block.addClass('w2').removeClass('grid-sizer').nextUntil('.block:not(.w2)').addClass('grid-sizer');
                $(this).find('i').removeClass('icon-resize-full').addClass('icon-resize-small');
            }
            resizeDiv();
            $('.masonry').masonry('reloadItems').masonry('layout');
            t.saveLayout();
        });
    }
    DW_edit_layout.prototype = {
        startEdit: function(){
            var dw_edit_layout = this;

            this.$container.find('.block').draggable({
                start : function(event, ui){
                    var t = $(this);
                    dw_edit_layout.$container.find('.block').disableTextSelect();
                    t.css('z-index', 9999);
                    dw_edit_layout.placeHolder.show();
                    dw_edit_layout.clone_block_style( dw_edit_layout.placeHolder, t );
                    dw_edit_layout.placeHolder.insertAfter( t );
                },
                stop : function( event, ui ) {
                    if(  dw_edit_layout.overBlock != null 
                            && dw_edit_layout.overBlock != $(this) ) {
                        var t = $(this);
                        t.insertAfter( dw_edit_layout.overPlaceHolder );
                        dw_edit_layout.overBlock.insertAfter( dw_edit_layout.placeHolder );
                    }
                    $('.block-placeholder').hide();
                    dw_edit_layout.$container.masonry('reloadItems').masonry('layout');
                    dw_edit_layout.saveLayout();

                    t.enableTextSelect();

                    //Clear current selection when drag item
                    if (window.getSelection) {
                        window.getSelection().removeAllRanges();
                    } else if (document.selection) {
                        document.selection.empty();
                    }
                    dw_edit_layout.stopEdit();
                }
            })
            .droppable({
                over: function( event, ui ) {
                    var t = $(this);
                    dw_edit_layout.overBlock = t;
                    dw_edit_layout.overPlaceHolder.show();
                    dw_edit_layout.clone_block_style( dw_edit_layout.overPlaceHolder, t );
                    dw_edit_layout.overPlaceHolder.insertAfter( t );

                }
            });
        },
        stopEdit : function(){
            this.$container.find('.block').enableTextSelect();
            this.$container.find('.block:not(.block-placeholder)').each(function(){
                $(this).draggable('destroy').droppable('destroy');
            });
        },
        getLayout : function(){
            var $blocks = this.$container.find('.block:not(.block-placeholder)'),
                $layout = {};
            $blocks.each(function(index){
                var t = $(this),
                    $id = t.attr('id');

                if( $id ){
                    if( $id.indexOf('block-') == 0 ) {
                        $layout[index+1] = {
                            size    : t.hasClass('w2') ? 'w2' : '',
                            format  : $id.replace('block-','')
                        }
                    } 
                } else if( t.hasClass('block-empty') && t.hasClass('w2') ) {
                    $layout[index+1] = {
                        size    : 'w2',
                        format  : 'empty'
                    }
                } 
            });
            this.gridLayout =  $layout;
        },
        saveLayout  : function(){
            this.getLayout();
            var $layout = this.gridLayout;
            $.ajax({
                url: dw.ajax_url,
                type: 'POST',
                dataType: 'json',
                data: {
                    action : 'dw-save-homepage-grid-layout',
                    layout : $layout
                },
                success: function(data, textStatus, xhr) {

                },
            });   
        },
        clone_block_style : function( a, b ){
            a.css({
                left    : b.css( 'left' ),
                top     : b.css( 'top' ),
                width   : b.css( 'width' ),
                height  : b.css( 'height' ),
                position: b.css( 'position')
            });
            return $(this);
        },
        startEditLayout : function( block, event ) {
            this.startEdit();
            block.trigger(event);
        }
    }

    $.fn.dw_edit_layout = function( args ){
        return this.each(function(){
            var t = $(this),
                data = t.data('dw_edit_layout');
            data || t.data( 'dw_edit_layout', data = new DW_edit_layout(t, args));
            if( typeof args == "string" ) 
                data[args]();
        });
    }
    

}(window,jQuery));

jQuery(document).ready(function($) {
    // Init edit layout
    $('#main').dw_edit_layout({
        'edit-layout-button' : '.dw-edit-layout-button-link'
    });
    $.fn.disableTextSelect = function() {
        return this.each(function() {
            $(this).css({
                'MozUserSelect':'none',
                'webkitUserSelect':'none'
            }).attr('unselectable','on').bind('selectstart', function() {
                return false;
            });
        });
    };
     
    $.fn.enableTextSelect = function() {
        return this.each(function() {
            $(this).css({
                'MozUserSelect':'',
                'webkitUserSelect':''
            }).attr('unselectable','off').unbind('selectstart');
        });
    };
});

jQuery(function($){
    $('#main').on('submit','#publish-new-block-form',function(event){
        event.preventDefault();
        var t = $(this),
            active = t.find('.tab-pane.active'),
            type = active.find('[name="type"]').val(),
            nonce = t.find('#_wpnonce').val();

        var submit = {};

        t.find(".tab-pane.active").find("input, textarea").each(function(){
            var e = $(this);
            if( e.attr('name') == 'type' ) {
                return true;
            } 
            submit[ e.attr('name') ] = e.val();
        });

        if( type == 'post' ) {
            $.ajax({
                url: dw.ajax_url,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'dw-add-new-post',
                    nonce: nonce,
                    post_content: submit['new-post-content'],
                    post_title: submit['new-post-title'],
                    post_thumbnail: submit['new-post-thumbnail'],
                    update_post: submit['update-post'] ? submit['update-post'] : false,
                    post_id: submit['post-id'] ? submit['post-id'] : false
                },
            })
            .done(function( resp ) {
                if( resp.success ) {
                    var addBlock = $( resp.data.html ),
                        addForm = t.closest('.block');

                    addBlock.css({
                        'position': 'absolute', 
                        'top': addForm.css('top'),
                        'left': addForm.css('left'),
                        'width': addForm.css('width'),   
                        'height': addForm.css('width')
                    });
                    if( $('#'+addBlock.attr('id') ).length > 0 ) {
                        removeBlock( $('#'+addBlock.attr('id')) );
                    } 
                    
                    if( addForm.hasClass('w2') ) {
                        addBlock.addClass('w2');
                    }
                    addForm.replaceWith( addBlock );
                    $('.masonry').masonry('reloadItems').masonry('layout').dw_edit_layout('saveLayout');

                }
            });
            
        } else {
            $.ajax({
                url: dw.ajax_url,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'dw-get-new-block',
                    submit: submit,
                    type: type,
                    nonce: nonce
                }
            })
            .done(function( resp ) {
                if( resp.success ) {
                    var addBlock = $( resp.data.html ),
                        addForm = t.closest('.block');

                    addBlock.css({
                        'position': 'absolute', 
                        'top': addForm.css('top'),
                        'left': addForm.css('left'),
                        'width': addForm.css('width'),   
                        'height': addForm.css('width')
                    });
                    if( $( '#block-social-'+type ).length > 0 ) {
                        removeBlock( $( '#block-social-'+type ) );
                    } 
                    addForm.replaceWith( addBlock );
                    if( addForm.hasClass('w2') ) {
                        addBlock.addClass('w2');
                    }
                    $('.masonry').masonry('reloadItems').masonry('layout').dw_edit_layout('saveLayout');
                    if( type == 'social-facebook' ) {

                        // Get facebook for block of facebook
                        if( $('#block-social-facebook').length > 0 ) {
                            $.ajax({
                              url: dw.ajax_url,
                              type: 'GET',
                              dataType: 'html',
                              data: {
                                action  : 'dw-ajax-facebook-setup'
                              },
                              success: function(data, textStatus, xhr) {
                                $('#block-social-facebook .social-content').html( data );
                              }
                            });
                            
                        }
                    } else if( 'social-twitter' == type ) {

                        // Get tweets for block of twitter
                        if( $('#block-social-twitter').length > 0 ) {
                            $.ajax({
                              url: dw.ajax_url,
                              type: 'GET',
                              dataType: 'html',
                              data: {
                                action : 'dw-ajax-tweets-setup'
                              },
                              success: function( data ) {
                                $('#block-social-twitter .social-content').html( data );
                              },
                            });
                        }
                    } 
                }
                
            });
            
        }        
    });

    // Create new block 
    var updateBlock = function(event){
        event.preventDefault();
        if( $('body').hasClass('edit') ) {

            var t = $(this),
            block = t.hasClass('block') ? t : t.closest('.block');

            var current_block = block.attr('id');
            
            if( $('#main').find('#add-block-container').length > 0 ) {
                var addBlock = $('#main').find('#add-block-container');
                addBlock.replaceWith( $('#main').data('dw-editing-block'));
                $('.masonry').masonry('reloadItems').masonry('layout');
            }
            $.ajax({
                url: dw.ajax_url,
                type: 'GET',
                dataType: 'json',
                data: {
                    action  : 'dw-get-edit-block'
                }
            })
            .done(function(resp) {
                if( resp.success ) {
                    var addBlock = $( resp.data.html );

                    addBlock.css({
                        'position': 'absolute', 
                        'top': block.css('top'),
                        'left': block.css('left'),
                        'width': block.css('width'),   
                        'height': block.css('width')
                    });

                     
                    if( current_block ) {
                        if( current_block.indexOf('post-') >= 0 ) {
                            $.ajax({
                                url: dw.ajax_url,
                                type: 'GET',
                                dataType: 'json',
                                data: {
                                    action: 'dw-ajax-get-post-detail',
                                    post_id: current_block.replace('post-','')
                                },
                                async: false
                            })
                            .done(function( resp ) {
                                addBlock.find('input[name="type"]').after('<input type="hidden" name="update-post" value="true" ><input type="hidden" name="post-id" value="' + resp.data.post.ID + '" >');
                                if( resp.data.post.post_content ) {
                                    addBlock.find('#new-post-content').val( resp.data.post.post_content );
                                }

                                if( resp.data.post.post_title ) {
                                    addBlock.find('#new-post-title').val( resp.data.post.post_title );
                                }
                                if( resp.data.post.post_thumbnail ) {

                                    addBlock.find('#new-post-thumbnail').val( resp.data.post.post_thumbnail );
                                }
                            })
                        }
                    }
                    $('#main').data('dw-editing-block', block);
                    if( block.hasClass('w2') ) {
                        addBlock.addClass('w2');
                    }
                    addBlock.find(".new-post-content").css({'height': (block.width()-80) + 'px'});
                    block.replaceWith( addBlock );
                    $('.masonry').masonry('reloadItems').masonry('layout');
                    if( current_block ) {
                        if( current_block.indexOf('block-social') == 0 ) { // for social block
                            var social = current_block.replace('block-social-','');
                            addBlock.find('[href="#new-post-'+social+'"]').tab('show');
                        } else if( current_block == 'block-welcome-box') {
                            addBlock.find('[href="#block-welcome-box"]').tab('show');
                        }

                    }
                }
            });

        }
    }
    $('body.edit #main').on('click', '.block:not(#block-welcome-box) .edit-post .icon-pencil, .block-empty',updateBlock);
    
    $('body.edit #main').on('click', '#block-welcome-box .edit-post a[href="#edit"]', function(event){
        event.preventDefault();
        var block = $(this).closest('.block');
        block.data('editing', '1' );
        var first_heading = block.find('h1').text(),
                second_heading = block.find('h2').text(),
                info = block.find('p').text();
        block.data('last-content', {
            'h1' : first_heading,
            'h2' : second_heading,
            'info' : info
        });
        var saveBtn = $('<a href="#save" title="Save"><i class="icon-save"></i></a>');
        block.find('.edit-post').prepend( saveBtn );
        $(this).remove();


        block.find('h1,h2,p').attr('contenteditable', true);
        saveBtn.on('click',function(event){
            event.preventDefault();
            var first_heading = block.find('h1').text(),
                second_heading = block.find('h2').text(),
                info = block.find('p').text();
            
            $.ajax({
                url: dw.ajax_url,
                type: 'POST',
                dataType: 'json',
                data: {
                    action : 'dw-save-welcome-box',
                    heading1st: first_heading,
                    heading2nd: second_heading,
                    info: info
                }
            })
            .always(function() {
                block.find('h1,h2,p').attr('contenteditable', 'false');
                saveBtn.replaceWith('<a href="#edit" title="Edit"><i class="icon-pencil"></i></a>');
            });
            
        });
        block.find('h1').focus();
    });

    $(window).on('keydown',function(event){
        if( $('body').hasClass('edit') && $('#main').data('dw-editing-block') ){
            var key = event.which || event.keyCode;
            if( key == 27 ) {
                var addBlock = $('#main').find('#add-block-container');

                if( addBlock.length > 0 ) {
                    addBlock.replaceWith( $('#main').data('dw-editing-block'));
                    $('.masonry').masonry('reloadItems').masonry('layout');
                }
            }
        }
    });

    
    $('body.edit .edit-post .icon-remove').on('click',function(event){
        event.preventDefault();
        var t = $(this);
        var block = t.closest('.block');
        if( 'block-welcome-box' == block.attr('id') && block.data('editing') ) {
            block.find('.edit-post a[href="#save"]').replaceWith('<a href="#edit" title="Edit"><i class="icon-pencil"></i></a>');
            block.find('h1').attr('contenteditable', false).text( block.data('last-content').h1 );
            block.find('h2').attr('contenteditable', false).text( block.data('last-content').h2 );
            block.find('p').attr('contenteditable', false).text( block.data('last-content').info );
            block.data('editing',0);
        } else {
            if( confirm('Are you sure you want to remove this block') ) {
                removeBlock( t );
            }
        }
    });

    
    function removeBlock( t ) {
        var indexOfBlock = -1;
        $('#main .block').each(function(index){
            if( $(this).get(0) ==  t.closest('.block').get(0) ) {
                indexOfBlock = index + 1;
                return false;
            }
        });
        if( indexOfBlock >= 0 ) {
            $.ajax({
                url: dw.ajax_url,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'dw-remove-block',
                    index:  indexOfBlock
                },
                success: function( resp ) {
                    if( resp.success ) {
                        var block = t.closest('.block'),
                            emptyBlock = $(resp.data.html);

                        emptyBlock.css({
                            'position' : block.css('position'),
                            'top' : block.css('top'),
                            'left' : block.css('left'),
                            'width': block.css('width'),
                            'height': block.css('width')
                        });
                        if( block.hasClass('w2') ) {
                            emptyBlock.addClass('w2').removeClass('grid-sizer');
                        }
                        t.closest('.block').replaceWith(emptyBlock);
                        $('.masonry').masonry('reloadItems').masonry('layout').dw_edit_layout('saveLayout');
                    }
                }
            });
        }
    }


    jQuery.fn.disableTextSelect = function() {
        return this.each(function() {
            $(this).css({
                'MozUserSelect':'none',
                'webkitUserSelect':'none'
            }).attr('unselectable','on').bind('selectstart', function() {
                return false;
            });
        });
    };
     
    jQuery.fn.enableTextSelect = function() {
        return this.each(function() {
            $(this).css({
                'MozUserSelect':'',
                'webkitUserSelect':''
            }).attr('unselectable','off').unbind('selectstart');
        });
    };

    $(document).ready(function() {
        $('img').on('dragstart', function(event) { event.preventDefault(); });
        var custom_uploader;
 
        $('#main').on('click', '#new-post-thumbnail-select',function(e) {
     
            e.preventDefault();
     
            //If the uploader object has already been created, reopen the dialog
            if (custom_uploader) {
                custom_uploader.open();
                return;
            }
     
            //Extend the wp.media object
            custom_uploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: false
            });
     
            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader.on('select', function() {
                attachment = custom_uploader.state().get('selection').first().toJSON();
                $("#new-post-thumbnail").val( attachment.id );
            });
     
            //Open the uploader dialog
            custom_uploader.open();
     
        });
    });
});