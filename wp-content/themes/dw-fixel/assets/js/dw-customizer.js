
/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {

    "use strict";
    var update_social_link = function( newval, id ){
        if( newval.length > 0 ) {
            if( $('#'+ id).length <= 0 ) {
                $('#header .social-link ul').prepend( $('<li id="'+id+'"><a href="'+newval+'" class="'+ id.replace('_link','') +'"><i class="icon-'+ id.replace('_link','') +'"></i></a></li>') );
            } else {
                $('#'+id+' a').attr( 'href', newval );
            }
        } else {
            $('#'+id ).remove();
        }
    }
    // Update social link of facebook in real time...
    wp.customize( 'dw_general_options[facebook_link]', function( value ) {
        value.bind( function( newval ) {
            update_social_link( newval, 'facebook_link' );
        } );
    } );
    // Update social link of twitter in real time...
    wp.customize( 'dw_general_options[twitter_link]', function( value ) {
        value.bind( function( newval ) {
            update_social_link( newval, 'twitter_link' );
        } );
    } );
    // Update social link of instagram in real time...
    wp.customize( 'dw_general_options[instagram_link]', function( value ) {
        value.bind( function( newval ) {
            update_social_link( newval, 'instagram_link' );
        } );
    } );
    // Update social link of linkedin in real time...
    wp.customize( 'dw_general_options[linkedin_link]', function( value ) {
        value.bind( function( newval ) {
            update_social_link( newval, 'linkedin_link' );
        } );
    } );
    // Update social link of youtube in real time...
    wp.customize( 'dw_general_options[youtube_link]', function( value ) {
        value.bind( function( newval ) {
            update_social_link( newval, 'youtube_link' );
        } );
    } );
    
    // Update social link of youtube in real time...
    wp.customize( 'dw_general_options[flickr_link]', function( value ) {
        value.bind( function( newval ) {
            update_social_link( newval, 'flickr_link' );
        } );
    } );


    // Update social link of youtube in real time...
    wp.customize( 'dw_general_options[google-plus_link]', function( value ) {
        value.bind( function( newval ) {
            update_social_link( newval, 'google-plus_link' );
        } );
    } );

    // Homepage section
        // Welcome box heading 1
        wp.customize( 'dw_homepage_options[welcome-box-heading-1]', function( value ) {
            value.bind( function( newval ) {
                $('#block-welcome-box .block-inner h1').text( newval );
            } );
        } );
        // Welcome box heading 2
        wp.customize( 'dw_homepage_options[welcome-box-heading-2]', function( value ) {
            value.bind( function( newval ) {
                $('#block-welcome-box .block-inner h2').text( newval );
            } );
        } );
        // Welcome box short intro
        wp.customize( 'dw_homepage_options[welcome-box-short-intro]', function( value ) {
            value.bind( function( newval ) {
                $('#block-welcome-box .block-inner p').text( newval );
            } );
        } );
        
        //Welcomebox background color
        wp.customize( 'dw_homepage_options[welcome-box-bg-color]',function(value){
            value.bind( function(newval) {
                $('#block-welcome-box .block-inner').css('background-color', newval);
            });
        });
        //Welcomebox text color
        wp.customize( 'dw_homepage_options[welcome-box-text-color]',function(value){
            value.bind( function(newval) {
                $('#block-welcome-box .block-inner').find( 'h1, h2, p').css('color', newval );
            });
        });
    
} )( jQuery );
