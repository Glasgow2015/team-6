jQuery(function($){
    "use strict";
    var $container  = $('#main'),
        $modal      = $('#post-details');
    var isIE = /*@cc_on!@*/false;
    $(window).resize(function(){
        if( $('.masonry').length > 0 )
            resizeDiv();
    });
    $(window).load(function(){
        $('#header .nav-wrap').mCustomScrollbar("update");
        if( $('.masonry').length > 0 )
            resizeDiv();
        if( $container.hasClass('masonry') ) {
            $container.masonry('reloadItems').masonry('layout');
        }
    });
    // head scroller
    $(".head .block-inner").mCustomScrollbar({
        scrollInertia:0,
        scrollButtons:{
            enable:false
        },
        advanced:{
            updateOnContentResize: true,
            autoExpandHorizontalScroll: true
        }
    });
    // top panel scroller
    $(".top-widget").mCustomScrollbar({
        scrollInertia:0,
        scrollButtons:{
            enable:false
        },
        advanced:{
            updateOnContentResize: true,
            autoExpandHorizontalScroll: true
        }
    });
    // mobile menu scroller
    $("#header .nav-wrap").mCustomScrollbar({
        scrollInertia:0,
        scrollButtons:{
            enable:false
        },
        advanced:{
            updateOnContentResize: true,
            autoExpandHorizontalScroll: true
        }
    });
    $(document).ready(function () {
        $('body').removeClass('loading');
        if (!isIE) {
            $('body').addClass('active');
        }
        setTimeout(function(){
            $('body').removeClass('active')
        },300); 
        // set div height on resize event
        if( $('.masonry').length > 0 )
            resizeDiv();
        // show/hide top panel
        $(".topshow").on('click touchstart',function (event) {
            event.preventDefault();
            $('body').toggleClass("top-widget-showing");
            $('.topshow').toggleClass("icon-minus");
        });
        $('.navbtn .nav-btn').on('click touchstart', function(event){
            event.preventDefault();
            $(".topbtn .topshow").removeClass('icon-minus');
            $('body').removeClass("top-widget-showing");
            $('html').toggleClass('js-nav');
        });
        // Get tweets for block of twitter
        if( $('#block-social-twitter').length > 0 ) {
            $.ajax({
              url: dw.ajax_url,
              type: 'GET',
              dataType: 'html',
              data: {
                action : 'dw-ajax-tweets-setup',
                page_id : $('body').data('page-id')
              },
              success: function( data ) {
                $('#block-social-twitter .social-content').html( data );
              },
            });
        }
        // view code on typo page
        prettyPrint();
        $(".view-code").each(function() {
            var $pElem= $(this);
            $pElem.popover(
                {
                  html: true,
                  'placement' : 'left',
                  title: getPopTitle($pElem.attr("id")),
                  content: getPopContent($pElem.attr("id"))
                }
            );
        });             
        function getPopTitle(target) {
            return $("#" + target + "_content > div.popTitle").html();
        };     
        function getPopContent(target) {
            return $("#" + target + "_content > div.popContent").html();
        };
        // end: view code on typo page section
        // Get facebook for block of facebook
        if( $('#block-social-facebook').length > 0 ) {
            $.ajax({
              url: dw.ajax_url,
              type: 'GET',
              dataType: 'html',
              data: {
                action  : 'dw-ajax-facebook-setup',
                page_id : $('body').data('page-id')
              },
              success: function(data, textStatus, xhr) {
                $('#block-social-facebook .social-content').html( data );
              }
            });
        }
        // Init infinite-scroll
        if( 'infinite' == dw.show_more_type ) {

            $('#main').infinitescroll({
              navSelector   : '.paging-navigation',
              nextSelector  : '.paging-navigation .nav-next a:first',
              itemSelector  : '#main .block',
              loading: {
                  img: dw.theme_url + "assets/img/preloader.gif"
                },
              animate       : false,
              appendCallback : false
            }, function( elems ){
                if( elems.length > 0 ) {
                    $container.append( elems );
                    resizeDiv();
                    $container.masonry( 'appended', elems );
                    // $container.masonry('reloadItems').masonry('layout');
                }
            });
        } else {
            $('.show-more').on('click','.btn',function(event){
                event.preventDefault();
                var t = $(this);
                t.addClass('loading');
                $.ajax({
                    url: dw.ajax_url,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        action: 'dw-get-next-posts',
                        query_vars : t.data('query-var'),
                        paged : t.data('paged')
                    },
                })
                .done(function(resp) {
                    if( resp.success ) {
                        var elems;
                        elems = $(resp.data.html).filter(function() {
                            return this.nodeType !== 3; //Node.TEXT_NODE
                        });
                        if( elems.length > 0 ) {
                            $container.append( elems );
                            resizeDiv();
                            $container.masonry( 'appended', elems );
                        }
                        t.data('paged', resp.data.paged );
                    } else {
                        if( resp.data.code = 'empty' ) {
                            t.text( resp.data.message ).fadeOut('slow',function(){
                                $(this).remove();
                            });
                        }
                    }
                })
                .always(function() {
                    t.removeClass('loading');
                });
            });
        }
        // END infinite-scroll
        // mansonry
        var $container = $('#main');
        if( $container.hasClass('masonry') && $container.find('.block').length > 0 ) {
            $container.masonry({
                columnWidth : '.grid-sizer',
                itemSelector: '.block',
                isResizable : true
            });
        } 
        // scroll to top button
        $(window).scroll(function(){
            if ($(this).scrollTop() > 100) {
                $('.scrollup').fadeIn();
            } else {
                $('.scrollup').fadeOut();
            }
        }); 
        $('.scrollup').click(function(){
            $("html, body").animate({ scrollTop: 0 }, 600);
            return false;
        });
        // accordion activated state
        $(".accordion-toggle").click(function() {
          $('.accordion-toggle').removeClass( "activated" );
          $('.accordion-toggle').removeClass( "collapsed" );
          $(this).toggleClass( "activated" );
        });
        // show/hide social setting box
        $(".social-setting-btn").click(function () {
            $('.social-setting').toggleClass("show-social");
        });
        // Quick post form
        var addingPost = false;
        $('#dw-add-post-form').on('submit', function(event){
            event.preventDefault();
            if( addingPost ) {
                return false;
            }
            addingPost = true;
            var t = $(this),
                postContent = t.find('#new-post-content').val(),
                nonce = t.find('#_wpnonce').val();
            if( ! nonce ) {
                console.log( 'Are you cheating huh? ' );
                return false;
            }
            if( postContent.length <= 0 ) {
                console.log( 'Post content is empty ');
                return false;
            }
            var postTitle = t.find('#new-post-title').val(),
                postTags = t.find('#new-post-tags').val();
            t.find('input,textarea,button').attr( 'disabled', 'disabled');
            $.ajax({
              url: dw.ajax_url,
              type: 'POST',
              dataType: 'json',
              data: {
                action          : 'dw-add-new-post',
                nonce           : nonce,
                post_content    : postContent,
                post_title      : postTitle,
                post_tags       : postTags
              },
              complete: function( resp ) {
                addingPost = false;
                t.find('input,textarea,button').removeAttr( 'disabled' );
              },
              success: function( resp ) {
                if( resp.success ) {
                    t.find('#new-post-content,#new-post-title, #new-post-tags').val('');
                    $html = $( resp.data.html );
                    $html.find('.block-inner').css( 'height', $('.block.grid-sizer').height() + 'px' );

                    $addNew.after( $html );
                    $container.masonry('reloadItems').masonry('layout');
                } else {
                    if( resp.data.message.length > 0 ) {
                        console.log( resp.data.message );
                    }
                }
              }
            });
        });
        $('[data-toggle="input"]').on('click',function(event){
            event.preventDefault();
            var target = $(this).attr('href');
            $('[data-toggle="input"]').closest('li').removeClass('active');
            $(this).closest('li').addClass('active');
            $addNew.find('.extra-field').hide();
            $(target).show();
        });
    }); // end document ready
    function dw_get_post_detail( t, type ) {
      $('.single-detail').addClass('loading');
      if( t.closest('.block-inner').length > 0 ) {
        t.closest('.block-inner').addClass('loading');
      } 
      $.ajax({
        url: dw.ajax_url,
        type: 'GET',
        dataType: 'json',
        data: {
          action  : 'dw-get-post-detail',
          post_id : t.data('post-id'),
          adjacent    : type,
          is_single : dw.is_single
        },
        complete: function(resp){
            $('.single-detail').removeClass('loading');
            if( t.closest('.block-inner').length > 0 ) {
                t.closest('.block-inner').removeClass('loading');
            } 
        },
        success: function(resp) {
            //called when successful
            if( resp.success ) {
                if( dw.is_single ) {
                    $('.single-page .single-detail').html( resp.data.html );
                    $('.single-page').find('.prev-post,.next-post').data('post-id', resp.data.post_id );


                    if( resp.data.prev_post ) {
                        $('.single-page').find('.prev-post').attr('title', resp.data.prev_post.post_title ).data('href', resp.data.next_post.guide).removeClass('hide');
                    } else {
                        $('.single-page').find('.prev-post').addClass('hide');
                    }
                    if( resp.data.next_post ) {
                        $('.single-page').find('.next-post').attr('title', resp.data.next_post.post_title ).data('href', resp.data.next_post.guide).removeClass('hide');
                    } else {
                        $('.single-page').find('.next-post').addClass('hide');
                    }
                } else {
                    $modal.find('.modal-content').html( resp.data.html );
                    $modal.find('.prev-post,.next-post').data('post-id', resp.data.post_id );
                    if( type == 'none' ) 
                        $modal.modal('show');
                    if( resp.data.prev_post ) {
                        $modal.find('.prev-post').attr('title', resp.data.prev_post.post_title ).data('href', resp.data.prev_post.guide ).removeClass('hide');
                    }else {
                        $modal.find('.prev-post').addClass('hide');
                    }

                    if( resp.data.next_post ) {
                        $modal.find('.next-post').attr('title', resp.data.next_post.post_title ).data('href', resp.data.next_post.guide).removeClass('hide');
                    } else {
                        $modal.find('.next-post').addClass('hide');
                    }
                }
                if( history.pushState ) {
                  history.pushState( {}, resp.data.post_title, resp.data.post_permalink );
                }
            }
        }
      });
    }
    $(document).off('click.modal.data-api', '[data-toggle="modal"]');
    if( ! isIE || ( isIE && parseInt( jQuery.browser.version ) > 8 ) ) {
         //Turn off default modal show of  Twitter Bootstrap
        $(document).on('click','[data-toggle="modal"]',  function(event){
            event.preventDefault();
            var t = $(this);
            dw_get_post_detail( t, 'none' );
        });
        $modal.find('.next-post').on( 'click', function(event){
            event.preventDefault();
            var t = $(this);
            dw_get_post_detail( t, 'next' );
            $(window).scrollTop(0);
        });
        $modal.find('.prev-post').on( 'click', function(event){
            event.preventDefault();
            var t = $(this);
            dw_get_post_detail( t, 'prev' );
            $(window).scrollTop(0);
        });
        $('.single-page').find('.next-post').on('click',function(event){
            event.preventDefault();
            var t = $(this);
            dw_get_post_detail( t, 'next' );
            $(window).scrollTop(0);
        });
        $('.single-page').find('.prev-post').on( 'click', function(event){
            event.preventDefault();
            var t = $(this);
            dw_get_post_detail( t, 'prev' );
            $(window).scrollTop(0);
        });
    } else {
        $modal.find('.next-post,.prev-post').on( 'click', function(event){
            event.preventDefault();
            var t = $(this);
            document.location.href = t.data('href');
        });

        $('.single-page').find('.next-post,.prev-post').on('click',function(event){
            event.preventDefault();
            var t = $(this);
            document.location.href = t.data('href');
        });
    }
    $modal.find('.close').on('click',function(event){
        if( dw.is_single ) {
            event.preventDefault();
            window.location.href = dw.site_url;
        } else {
            if( history.pushState ) {
                history.pushState( {}, '', dw.current_url );
            }   
        }
    });
    $modal.find('.modal-header .next-post,.modal-header .prev-post').on('click',function(event){
        event.preventDefault();
        
    });
    // END on modal action
    // tooltip at socialbar on modal page
    $(".social-bar a").tooltip({
        'selector': '',
        'placement': 'right'
    });
    // show/hide body's scrollbar when modal window is open/close
    var vph = $(window).height();
    var currentScroll = null;
    $modal.on('show',function(event){
        currentScroll = $(window).scrollTop();
        $("body").addClass( "modal-showing" );
        $('body').removeClass("top-widget-showing");
        $('.topshow').removeClass("icon-minus");
        $('.single-detail').css("min-height", vph + "px");
        $(window).scrollTop(0);
    }).on('hide',function(event){ 
        $("body").removeClass( "modal-showing" );
        $(window).scrollTop(currentScroll);
    });
    // round img
    $(".round-img .avatar").load(function() {
        $(this).wrap(function(){
          return '<span class="' + $(this).attr('class') + '" style="background:url(' + $(this).attr('src') + ') no-repeat center center;" />';
        });
        $(this).css("opacity","0");
    });
    // off-canvas submenu open onclick
    $('.show-sub-menu-btn').on('click',function(event){
        event.preventDefault();
        $(this).closest('.menu-item').toggleClass('show-sub-menu');
    });
    // fb iframe hover issue on IE
    if(isIE){
        $(".view-social .mask").mouseover(function() {
            $(this).parents(".view-social").addClass("hover");
        });
        $(".view-social .mask").mouseout(function() {
            $(this).parents(".view-social").removeClass("hover");
        });
    }
});
function resizeDiv() {
    var vph = jQuery(window).height(); 
    jQuery(".head .block-inner").mCustomScrollbar('update');
    jQuery('.block').each(function(){            
        var block = jQuery(this),
            entryw = block.width();
        block.find(".new-post-content").css({'height': (entryw-80) + 'px'});
        block.find(".block-inner").css({'height': entryw + 'px'});
        block.find(".mask-content").css({'height': entryw + 'px'});
        block.find(".view-video").css({'max-height': entryw + 'px'});
        block.find(".view-pic").css({'max-height': entryw + 'px'});
        block.find(".carousel-inner .item").css({'height': entryw + 'px'});
        var aimg = block.find("img");
        if( aimg.length > 0 ) {
            aimg.each(function(index, img){
                var o = jQuery(img);
                var theImage = new Image();
                theImage.src = o.attr("src");
                var widthImg = theImage.width;
                var heightImg = theImage.height;
                if(heightImg || widthImg) {
                    if(heightImg < widthImg) {
                        o.css({
                            'width': 'auto',
                            'max-width': 'none',
                            'height': (entryw-0.5) + 'px',
                            'left': -((entryw/heightImg*widthImg)/2 - entryw/2)  + 'px'
                        });
                    } else {
                        o.css({
                            'max-height': 'none',
                            'width': '100%',
                            'top': -((entryw/widthImg*heightImg)/2 - entryw/2)  + 'px'
                        });
                    }
                }
            });
        }
    });
}
/*!
 *
 *  Copyright (c) David Bushell | http://dbushell.com/
 *
 */
(function(window, document, undefined) {
    var trim = function(str){
        return str.trim ? str.trim() : str.replace(/^\s+|\s+$/g,'');
    };
    var hasClass = function(el, cn){
        return (' ' + el.className + ' ').indexOf(' ' + cn + ' ') !== -1;
    };
    var addClass = function(el, cn){
        if (!hasClass(el, cn)) {
            el.className = (el.className === '') ? cn : el.className + ' ' + cn;
        }
    };
    var removeClass = function(el, cn){
        el.className = trim((' ' + el.className + ' ').replace(' ' + cn + ' ', ' '));
    };
    var hasParent = function(el, id){
        if (el) {
            do {
                if (el.id === id) {
                    return true;
                }
                if (el.nodeType === 9) {
                    break;
                }
            }
            while((el = el.parentNode));
        }
        return false;
    };
    var doc = document.documentElement;
    var transform_prop = window.Modernizr.prefixed('transform'),
        transition_prop = window.Modernizr.prefixed('transition'),
        transition_end = (function() {
            var props = {
                'WebkitTransition' : 'webkitTransitionEnd',
                'MozTransition'    : 'transitionend',
                'OTransition'      : 'oTransitionEnd otransitionend',
                'msTransition'     : 'MSTransitionEnd',
                'transition'       : 'transitionend'
            };
            return props.hasOwnProperty(transition_prop) ? props[transition_prop] : false;
        })();
    window.App = (function(){
        var _init = false, app = { };
        var nav_open = false,
            nav_class = 'js-nav';
        app.init = function(){
            var inner = document.getElementById('inner-wrap');
            if (_init) {
                return;
            }
            _init = true;
            var closeNavEnd = function(e){
                if (e && e.target === inner) {
                    document.removeEventListener(transition_end, closeNavEnd, false);
                }
                nav_open = false;
            };
            app.closeNav =function(){
                if (nav_open) {
                    // close navigation after transition or immediately
                    var duration = (transition_end && transition_prop) ? parseFloat(window.getComputedStyle( inner, '')[transition_prop + 'Duration']) : 0;
                    if (duration > 0) {
                        document.addEventListener(transition_end, closeNavEnd, false);
                    } else {
                        closeNavEnd(null);
                    }
                }
                removeClass(doc, nav_class);
            };
            app.openNav = function(){
                if (nav_open) {
                    return;
                }
                addClass(doc, nav_class);
                nav_open = true;
            };
            app.toggleNav = function(e){
                if (nav_open && hasClass(doc, nav_class)) {
                    app.closeNav();
                } else {
                    app.openNav();
                }
                if (e) {
                    e.preventDefault();
                }
            };
            document.getElementById('nav-open-btn').addEventListener('click', app.toggleNav, false);
            document.getElementById('nav-close-btn').addEventListener('click', app.toggleNav, false);
            document.addEventListener('click', function(e) {
                if (nav_open && !hasParent(e.target, 'header')) {
                    e.preventDefault();
                    app.closeNav();
                }
            },
            true);
            addClass(doc, 'js-ready');
        };
        return app;
    })();
    if (window.addEventListener) {
        window.addEventListener('DOMContentLoaded', window.App.init, false);
    }
})(window, window.document);