<?php  
include_once ABSPATH . 'wp-includes/class-wp-customize-control.php';
class Color_Picker_Custom_control extends WP_Customize_Control {
  public function render_content() {
    if ( empty( $this->choices ) ) return;
    $name = '_customize-radio-' . $this->id; ?>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <table style="margin-top: 10px; text-align: center; width: 100%;">
      <tr>
        <?php foreach ( $this->choices as $value => $label ) {
                $checked = '';
                if($value == 0) $checked = 'checked'; ?>
                <td>
                  <label>
                    <div style="width: 30px; height: 30px; margin: 0 auto; background: <?php echo esc_attr( $label )?> "></div><br />
                    <?php if($value == 0) $label = '' ?>
                    <input type="radio" value="<?php echo esc_attr( $label ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); echo $checked ?> />
                  </label>
                </td>
          <?php } ?>
      </tr>
    </table><?php
  }
}

if( ! function_exists('dw_get_gfonts') ) {
  function dw_get_gfonts(){
    $fontsSeraliazed = wp_remote_fopen( get_template_directory_uri() . '/inc/font/gfonts_v2.txt' );
    $fontArray = unserialize(trim( $fontsSeraliazed ));
    if( !empty( $fontArray ) ) {
        return $fontArray->items;
    }
    return array();
  }
}

function dw_fixel_customize_register($wp_customize) {
    // GENERAL SETTINGS --------------------------------------------------------------------------------------
    $wp_customize->add_section( 'dw_general_settings' , array(
        'title'      => __( 'General Settings', 'dw' ),
        'priority'   => 10,
    ) );
    // Facebook
    $wp_customize->add_setting('dw_general_options[facebook_link]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_control('dw_general_options_facebook_link', array(
        'label'      => __('Facebook link', 'dw'),
        'section'    => 'dw_general_settings',
        'settings'   => 'dw_general_options[facebook_link]',
        'type'       => 'text'
    ));
    // Twitter
     $wp_customize->add_setting('dw_general_options[twitter_link]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_control('dw_general_options_twitter_link', array(
        'label'      => __('Twitter link', 'dw'),
        'section'    => 'dw_general_settings',
        'settings'   => 'dw_general_options[twitter_link]',
        'type'       => 'text'
    ));
    // Instagram
     $wp_customize->add_setting('dw_general_options[instagram_link]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_control('dw_general_options_instagram_link', array(
        'label'      => __('Instagram link', 'dw'),
        'section'    => 'dw_general_settings',
        'settings'   => 'dw_general_options[instagram_link]',
        'type'       => 'text'
    ));
    // Youtube
     $wp_customize->add_setting('dw_general_options[youtube_link]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_control('dw_general_options_youtube_link', array(
        'label'      => __('Youtube link', 'dw'),
        'section'    => 'dw_general_settings',
        'settings'   => 'dw_general_options[youtube_link]',
        'type'       => 'text'
    ));
    // Google Plus
     $wp_customize->add_setting('dw_general_options[google_plus_link]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_control('dw_general_options_google_plus_link', array(
        'label'      => __('Google+ profile link', 'dw'),
        'section'    => 'dw_general_settings',
        'settings'   => 'dw_general_options[google_plus_link]',
        'type'       => 'text'
    ));
    // LinkedIn
     $wp_customize->add_setting('dw_general_options[linkedin_link]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_control('dw_general_options_linkedin_link', array(
        'label'      => __('LinkedIn link', 'dw'),
        'section'    => 'dw_general_settings',
        'settings'   => 'dw_general_options[linkedin_link]',
        'type'       => 'text'
    ));
    // Flickr
     $wp_customize->add_setting('dw_general_options[flickr_link]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_control('dw_general_options_flickr_link', array(
        'label'      => __('Flickr link', 'dw'),
        'section'    => 'dw_general_settings',
        'settings'   => 'dw_general_options[flickr_link]',
        'type'       => 'text'
    ));
    // ARCHIVE PAGE SETTINGS --------------------------------------------------------------------------------------
	$wp_customize->add_section( 'dw_archive_page_options' , array(
	    'title'      => __( 'Archive Page Settings', 'dw' ),
	    'priority'   => 20,
	) );
	$wp_customize->add_setting('dw_archive_page_options[show_more_type]', array(
	    'default'        => 'infinite',
	    'capability'     => 'edit_theme_options',
	    'type'           => 'option'
	));
	$wp_customize->add_control('dw_homepage_options_block_number', array(
	    'label'      => __('Show more type', 'dw'),
	    'section'    => 'dw_archive_page_options',
	    'settings'   => 'dw_archive_page_options[show_more_type]',
	    'type'    => 'radio',
	    'choices' => array(
	        'button' => __( 'Show more button', 'dw' ),
	        'infinite'  => __( 'Infinite loading', 'dw' ),
	    )
	));
    // SITE TITLE & TAG LINE --------------------------------------------------------------------------------------
    $wp_customize->add_setting('dw_theme_options[logo_image]', array(
        'default'               => DW_URI . 'assets/img/logo.png',
        'capability'            => 'edit_theme_options',
        'type'                  => 'option'
    ));
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'logo_image', array(
        'label'    => __('Logo', 'dw'),
        'section'  => 'title_tagline',
        'settings' => 'dw_theme_options[logo_image]'
    )));
    $wp_customize->add_setting('dw_theme_options[header_display]', array(
        'default'        => 'site_logo',
        'capability'     => 'edit_theme_options',
        'type'           => 'option'
    ));
    $wp_customize->add_control( 'header_display', array(
        'settings' => 'dw_theme_options[header_display]',
        'label'   => 'Display as',
        'section' => 'title_tagline',
        'type'    => 'select',
        'choices'    => array(
          'site_logo' => 'Site Logo',
          'site_title' => 'Site Title'
        )
    ));
    $wp_customize->add_setting('dw_theme_options[favicon]', array(
        'default'               => DW_URI . 'assets/img/favicon.png',
        'capability'            => 'edit_theme_options',
        'type'                  => 'option'
    ));
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'dw_favicon', array(
        'label'    => __('Favicon', 'dw'),
        'section'  => 'title_tagline',
        'settings' => 'dw_theme_options[favicon]'
    )));
    // STYLE SELECTOR --------------------------------------------------------------------------------------
    $wp_customize->add_section('dw_fixel_primary_color', array(
        'title'    => __('Style Selector', 'dw'),
        'priority' => 110,
    ));
    $wp_customize->add_setting('dw_theme_options[background-color]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background-color', array(
        'label'        => __('Background Color', 'dw'),
        'section'    => 'dw_fixel_primary_color',
        'settings'   => 'dw_theme_options[background-color]',
        'choices' => '#111111'
    )));
    $wp_customize->add_setting('dw_theme_options[page-title-color]', array(
        'default'        => 'Page Title Color',
        'capability'     => 'edit_theme_options',
        'type'           => 'option'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'page-title-color', array(
        'label'        => __('Page Title Color', 'dw'),
        'section'    => 'dw_fixel_primary_color',
        'settings'   => 'dw_theme_options[page-title-color]',
        'choices' => '#ffffff'
    )));
    $wp_customize->add_setting('dw_theme_options[select-color]', array(
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));
    $wp_customize->add_control( new Color_Picker_Custom_control($wp_customize, 'select-color', array(
        'label' => __('Color Schemes', 'dw'),
        'section' => 'dw_fixel_primary_color',
        'settings' => 'dw_theme_options[select-color]',
        'choices' => array('#fc615d', '#38B7EA', '#7cc576', '#B39964', '#e07798')
    )));
    $wp_customize->add_setting('dw_theme_options[custom-color]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'custom-color', array(
        'label'        => __( 'Custom Color', 'dw' ),
        'section'    => 'dw_fixel_primary_color',
        'settings'   => 'dw_theme_options[custom-color]',
        'choices' => '#fc615d'
    )));
    // FONT SELECTOR --------------------------------------------------------------------------------------
    $fonts = dw_get_gfonts();
    $newarray = array();
    $newarray[] = '';
    foreach ($fonts as $index => $font) {
    foreach ($font->files as $key => $value) {
      $newarray[$font->family . ':dw:' . $value ] = $font->family . ' - ' . $key;
    }
    }
    $wp_customize->add_section('dw_fixel_typo', array(
        'title'    => __('Font Selector', 'dw'),
        'priority' => 111
    ));
    $wp_customize->add_setting('dw_theme_options[heading_font]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option'
    ));
    $wp_customize->add_control( 'heading_font', array(
        'settings' => 'dw_theme_options[heading_font]',
        'label'   => __('Select headding font', 'dw'),
        'section' => 'dw_fixel_typo',
        'type'    => 'select',
        'choices'    => $newarray
    ));
    $wp_customize->add_setting('dw_theme_options[body_font]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option'
    ));
    $wp_customize->add_control( 'body_font', array(
        'settings' => 'dw_theme_options[body_font]',
        'label'   => __('Select body font', 'dw'),
        'section' => 'dw_fixel_typo',
        'type'    => 'select',
        'choices'    => $newarray
    ));
    // CUSTOM CODE --------------------------------------------------------------------------------------
    $wp_customize->add_section('dw_fixel_custom_code', array(
        'title'    => __('Custom Code', 'dw'),
        'priority' => 200,
    ));
    $wp_customize->add_setting('dw_theme_options[header_code]', array(
        'default'               => '',
        'capability'            => 'edit_theme_options',
        'type'                  => 'option',
    ));
    $wp_customize->add_control( new dw_customize_textarea($wp_customize, 'dw_header_code', array(
        'label'    => __('Header Code', 'dw'),
        'section'  => 'dw_fixel_custom_code',
        'settings' => 'dw_theme_options[header_code]'
    )));
    $wp_customize->add_setting('dw_theme_options[footer_code]', array(
        'default'               => '',
        'capability'            => 'edit_theme_options',
        'type'                  => 'option',
    ));
    $wp_customize->add_control( new dw_customize_textarea($wp_customize, 'dw_footer_code', array(
        'label'    => __('Footer Code', 'dw'),
        'section'  => 'dw_fixel_custom_code',
        'settings' => 'dw_theme_options[footer_code]'
    )));
}
add_action('customize_register', 'dw_fixel_customize_register');

function dw_print_customization_style(){
    /**
     * Color Selector
     */
    if ( dw_get_theme_option('background-color') != '' ) {
        $background_color = dw_get_theme_option('background-color');
    }
    if ( dw_get_theme_option('page-title-color') != '' ) {
        $page_title_color = dw_get_theme_option('page-title-color');
    }
    if ( dw_get_theme_option('custom-color') != '' ) {
        $fixel_color = dw_get_theme_option('custom-color');
    } else {
        $fixel_color = dw_get_theme_option('select-color');
    }
    ?>
    <style type="text/css" id="custom_style" media="screen">
        <?php if(isset($background_color) && $background_color != '') { ?>
            body,.modal,.page-404,body.loading:before {
                background-color: <?php echo $background_color ?>;
            } 
            .grid-wrap, .col-grid [class*="col-"] {
                border-color: <?php echo $background_color ?>;
            }
            @media (max-width: 979px) {
                #inner-wrap {
                    background-color: <?php echo $background_color ?>;
                }
            }
        <?php } ?>
        <?php if(isset($page_title_color) && $page_title_color != '') { ?>
        .headline .entry-title,.page-404 .page-title,.page-404 p {
            color: <?php echo $page_title_color ?>;
        } 
        <?php } ?>
        <?php if($fixel_color != '') { ?>
            .accordion-toggle.activated,.btn,#submit,.btn-link:hover,.btn-link:focus,.carousel-control,#nav li > span,.block.head .block-inner,.no-touch #back-to-top,.modal-buttons .left,.modal-buttons .right,.modal-buttons .close:hover i,.progress .bar,.slider-selection,.top-widget .tooltip-inner,.top-widget .tooltip.top .tooltip-arrow,.highlight,.dropcap.color,#nav li > span,.top-widget .widget .socials-connect a:hover i{
                background-color: <?php echo $fixel_color; ?>;
            }
            .accordion-toggle:hover,.top-widget .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
                background-color: <?php echo $fixel_color; ?> !important;
            }
            a:hover,a:focus,a:active,#nav li:hover i,#nav li.current-menu-item i,#nav li.current-menu-item a,#nav li:hover > a,#nav .menu ul a:hover,.top-widget-wrap a,.top-widget .widget .socials-connect a:hover,.block .block-meta a:hover, .block:hover .block-title a,.social-setting-btn:hover i,.single-detail .entry-meta a:hover,.single-detail .meta-bottom a:hover,.view-product span.price,.headline .entry-header a,.headline .entry-meta a:hover,.single .single-page .entry-meta a:hover,.single .single-page .meta-bottom a:hover,.main-content p a,.main-content .entry-meta a:hover, .main-content .main-content p > a,.main-content .entry-intro a,.main-content .entry-block a,.main-content .meta-bottom a:hover,.comments-area .comment-reply a,.product-detail .product .summary .price ins,.product-detail .product .summary .stock span,.product-detail .product .summary .add-to-cart .add-to-wishlist,.product-detail .product .summary .show_review_form,.page-404 a,.site-footer a,#nav ul li.current-menu-item > a,#nav li.current-menu-item > a,#nav a:hover,#nav li:hover i,#nav li.current-menu-item i,#nav li:hover > a,#nav .menu ul a:hover {
                color: <?php echo $fixel_color; ?>;
            }
            input[type="text"]:focus,input[type="password"]:focus,input[type="email"]:focus,textarea:focus,select:focus {
                border: 1px solid <?php echo $fixel_color; ?>;
            }
            .nav .dropdown-toggle:hover .caret,.nav .dropdown-toggle:focus .caret {
                border-top-color: <?php echo $fixel_color; ?>;
                border-bottom-color: <?php echo $fixel_color; ?>;
            }
            .contact-form input:not([type=range]):not([type=url]):not([type=date]):not([type=submit]):not([type=button]):not([type=checkbox]):not([type=number]):focus:invalid,.contact-form textarea:focus:invalid {
                border-bottom: 1px solid <?php echo $fixel_color; ?>;
            }
            blockquote {
                border-left: 5px solid <?php echo $fixel_color; ?>;
            }
        <?php } ?>
    </style>
    <?php
    /**
     * Font Selector
     */
    if (dw_get_theme_option('heading_font') && dw_get_theme_option('heading_font') != '') {
        $heading_font = explode(':dw:', dw_get_theme_option('heading_font') );
    ?>
        <style type="text/css" id="heading_font" media="screen">
            @font-face {
              font-family: "<?php echo $heading_font[0]; ?>";
              src: url('<?php echo $heading_font[1] ?>');
            } 
            h1,h2,h3,h4,h5,h6,.block-title,.entry-title,.btn,#submit,.block.head h1,.block.head h2,.headline .entry-title,.wpcf7-form .wpcf7-submit,.block .block-title {
              font-family: "<?php echo $heading_font[0]; ?>";
            }
        </style>
    <?php 
    }
    if (dw_get_theme_option( 'body_font') && dw_get_theme_option( 'body_font') != '') {
        $body_font = explode( ':dw:', dw_get_theme_option( 'body_font' ));
    ?>
    <style type="text/css" id="body_font" media="screen">
        @font-face {
          font-family: "<?php echo $body_font[0]; ?>";
          src: url('<?php echo $body_font[1] ?>');
        } 
        body,input,button,select,textarea,#nav a,.block-meta,.single-detail .entry-content,.single .single-page .entry-content,.block .block-meta,.modal {
          font-family: "<?php echo $body_font[0]; ?>";
        }
    </style>
    <?php
    }
}
add_action('wp_head','dw_print_customization_style');


/**
 * Change Favicon
 */
function dw_fixel_favicon() {
  $favicon = dw_get_theme_option('favicon');
  if($favicon)
    echo '<link type="image/x-icon" href="'.$favicon.'" rel="shortcut icon">';
}
add_action( 'wp_head', 'dw_fixel_favicon' );

/**
 * Site Title
 */
function dw_fixel_wp_title( $title, $sep ) {
    global $page, $paged;
    if ( is_feed() )
        return $title;
    $title .= get_bloginfo( 'name' );
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        $title .= " $sep $site_description";
    if ( $paged >= 2 || $page >= 2 )
        $title .= " $sep " . sprintf( __( 'Page %s', 'dw' ), max( $paged, $page ) );
    return $title;
}
add_filter( 'wp_title', 'dw_fixel_wp_title', 10, 2 );

/**
 * Display Logo
 */
function dw_fixel_logo() {
    $logo           = dw_get_theme_option( 'logo_image' );
    if(!$logo) {
        $logo = esc_url( home_url( '/' ) ).'wp-content/themes/dw-fixel/assets/img/logo.png';
    }
    $tagline        = get_bloginfo( 'description' );
    $sitetitle      = get_bloginfo( 'name', 'display' );
    if (dw_get_theme_option( 'header_display', 'site_logo') == 'site_logo') {
        echo '<a href="'.esc_url( home_url( '/' ) ).'" title="'.esc_attr($sitetitle).'">';
        echo '  <img alt="'.esc_attr($sitetitle).'" src="'.$logo.'" />';
        echo '</a>';
    } else {
        echo '<a title="'.esc_attr($sitetitle).'" href="'.esc_url( home_url( '/' ) ).'"><span>'.esc_attr($sitetitle).'</span></a>';
    }
}

/**
 * Header Code
 */
function dw_fixel_custom_header_code() {
  echo dw_get_theme_option( 'header_code' );
}
add_action('wp_head', 'dw_fixel_custom_header_code');

/**
 * Footer Code
 */
function dw_fixel_custom_footer_code() {
  echo dw_get_theme_option( 'footer_code' );
}
add_action('wp_footer', 'dw_fixel_custom_footer_code');