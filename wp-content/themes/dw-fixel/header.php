<!DOCTYPE html>
<!--[if (IE 8)&!(IEMobile)]>
<html class="no-js lt-ie9" <?php language_attributes(); ?>>
<![endif]-->
<!--[if (IE 9)]>
    <html class="no-js ie9" <?php language_attributes(); ?>>
<![endif]-->
<!--[if gt IE 8]><!--> 
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1.0"> 
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> <?php echo is_page() ? 'data-page-id="' . get_the_ID() . '"' : '';  ?>>
    <div id="header">
        <div class="header-wrapall">
            <div class="header-wrap">
                <header id="top" role="banner">
                    <div class="top-wrap">
                        <div class="logo">
                            <?php dw_fixel_logo() ?>
                        </div>
                    </div>
                </header> <!--/# top {banner} -->
                <div class="nav-wrap">
                    <div class="topbtn"><i class="icon-plus topshow"></i></div>
                    <?php  
                        $facebook = dw_get_theme_option('facebook_link');
                        $twitter = dw_get_theme_option('twitter_link');
                        $instagram = dw_get_theme_option('instagram_link');
                        $youtube = dw_get_theme_option('youtube_link');
                        $gplus = dw_get_theme_option('google_plus_link');
                        $linkedin = dw_get_theme_option('linkedin_link');
                        $flickr = dw_get_theme_option('flickr_link');
                        if( $facebook || $youtube || $gplus || $linkedin || $flickr || $instagram || $twitter ) : 
                    ?>
                    <div class="social-link">
                        <ul>
                            <?php if( $facebook ) : ?>
                            <li id="facebook_link"><a href="<?php echo $facebook ?>" class="facebook"><i class="icon-facebook"></i></a></li>
                            <?php endif; ?>
                            <?php if( $twitter ) : ?>
                            <li id="twitter_link"><a href="<?php echo $twitter ?>" class="twitter"><i class="icon-twitter"></i></a></li>
                            <?php endif; ?>
                            <?php if( $instagram ) : ?>
                            <li id="instagram_link"><a href="<?php echo $instagram ?>" class="instagram"><i class="icon-instagram"></i></a></li>
                            <?php endif; ?>
                            <?php if( $youtube ) : ?>
                            <li id="youtube_link"><a href="<?php echo $youtube ?>" class="youtube"><i class="icon-youtube"></i></a></li>
                            <?php endif; ?>
                            <?php if( $gplus ) : ?>
                            <li id="google_plus_link"><a href="<?php echo $gplus ?>" class="google-plus"><i class="icon-google-plus"></i></a></li>
                            <?php endif; ?>
                            <?php if( $linkedin ) : ?>
                            <li id="linkdedin_link"><a href="<?php echo $linkedin ?>" class="linkedin"><i class="icon-linkedin"></i></a></li>
                            <?php endif; ?>
                            <?php if( $flickr ) : ?>
                            <li id="flickr_link"><a href="<?php echo $flickr ?>" class="flickr"><i class="icon-flickr"></i></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <nav id="nav" role="navigation">
                        <div class="top-wrap">
                            <?php
                                wp_nav_menu( array(
                                    'theme_location'  => 'primary', 
                                    'container'       => '',
                                    'menu_class'      => 'menu',
                                    'fallback_cb'     => create_function('', ' get_template_part( \'menu\', \'default\' ); ' ),
                                    'walker'        => new dw_walker_topmenu()
                                ) );
                            ?>
                            <a class="close-btn" id="nav-close-btn" href="#top"><i class="icon-remove"></i></a>
                        </div>
                    </nav>
                </div>  <!--/# .nav-wrap -->
            </div> <!--/# header-wrap -->
        </div> <!--/. header-wrapall -->
    </div> <!--/# header -->
    <header id="mobile-header">
        <div class="top-wrap">
            <div class="logo">
                <?php dw_fixel_logo() ?>
            </div>
            <div class="navbtn">
                <a class="nav-btn" id="nav-open-btn" href="#"><i class="icon-reorder"></i></a>
            </div>
            <div class="topbtn"><i class="icon-plus topshow"></i></div>
        </div>
    </header> <!--/# mobile-header -->
    <div id="outer-wrap">
        <div id="inner-wrap">