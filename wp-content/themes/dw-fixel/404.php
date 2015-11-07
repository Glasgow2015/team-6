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
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"> 
    
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div id="outer-wrap">
        <div id="inner-wrap">
            <article class="page">
                <div class="page-404">
                    <br><br>
                    <img src="<?php echo DW_URI ?>assets/img/404.png" alt="<?php _e('Page not found','dw') ?>">
                    <h1 class="page-title"><?php _e('Oops! This page is lost! Sorry about that!','dw'); ?></h1>
                    <p><?php _e('Return to','dw') ?>: <a href="<?php echo site_url() ?>"><?php _e('Home','dw') ?></a></p>
                </div>
            </article>
        </div>
        <!--/#inner-wrap-->
    </div>
    <!--/#outer-wrap-->
<?php wp_footer(); ?>
</body>
</html>