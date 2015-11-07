<?php  
/**  
 * Install sample data from DesignWall
 * @package  dw-fixel
 * @subpackage content-builder
 * @version 1.0
 */
if( ! function_exists('dw_declare_theme_optins') ) {
    function dw_declare_theme_options(){
        global $dw_theme_options_setting, $dw_theme_options_tab;
        // List tab
        $dw_theme_options_tab = array(
            'dw_general_options'   => array(
                'title'     => __('General Settings','dw')
            ),
            'dw_homepage_options' => array(
                'title'     => __('Homepage Settings','dw')
            ),
            'dw_archive_page_options' => array(
                'title'     => __('Archive Page Settings','dw')
            )
        );

        // Create list of setting
        $dw_theme_options_setting = array(
            //General setting
            
            'general_setting'   => array(
                'title'     => __('General Settings','dw'),
                'tab'       => 'dw_general_options',
                'items'     => array(
                    'header_script' => array(
                        'title'         => __('Header script','dw'),
                        'type'          => 'textarea'
                    ),
                    'footer_script'        => array(
                        'title'         => __('Footer script','dw'),
                        'type'          => 'textarea'
                    ),
                    'facebook_link' => array(
                        'title'    => __('Facebook','dw'),
                        'description'   => __('Link to your Facebook profile ','dw'),
                        'type'      => 'text'
                    ),
                    'twitter_link' => array(
                        'title'    => __('Twitter','dw'),
                        'description'   => __('Link to your Twitter profile','dw'),
                        'type'      => 'text'
                    ),
                    'instagram_link' => array(
                        'title'    => __('Instagram','dw'),
                        'description'   => __('Link to your Instagram profile','dw'),
                        'type'      => 'text'
                    ),
                    'youtube_link' => array(
                        'title'    => __('Youtube','dw'),
                        'description'   => __('Link to your Youtube channel','dw'),
                        'type'      => 'text'
                    ),
                    'google_plus_link' => array(
                        'title'    => __('Google Plus','dw'),
                        'description'   => __('Link to your Google Plus Profile','dw'),
                        'type'      => 'text'
                    ),
                    'linkedin_link' => array(
                        'title'    => __('LinkedIn','dw'),
                        'description'   => __('Link to your LinkedIn profile','dw'),
                        'type'      => 'text'
                    ),
                    'flickr_link' => array(
                        'title'    => __('Flickr','dw'),
                        'description'   => __('Link to your Flickr profile','dw'),
                        'type'      => 'text'
                    )
                )
            ),

            //Homepage 
            'block_number_setting'      => array(
                'title'         => __('Block number', 'dw'),
                'description'   => __('Number of blocks was show on homepage','dw'),
                'items'         => array(
                    'block_number'  => array(
                        'title'    => __('Block number','dw'),
                        'type'     => 'text'
                    )
                ),
                'tab'           => 'dw_homepage_options'
            ),
            'welcome_box_setting'   => array(
                'title'         => __('Welcome Box', 'dw'),
                'description'   => __('Change your welcome box content','dw'),
                'tab'           => 'dw_homepage_options',
                'items'         => array(
                    'welcome-box-heading-1'  => array(
                        'title'         => __('Heading 1','dw'),
                        'type'          => 'textarea',
                        'description'   =>  __('Display inside h1','dw')
                    ),
                    'welcome-box-heading-2'  => array(
                        'title'     => __('Heading 2','dw'),
                        'type'      => 'textarea',
                        'description'   =>  __('Display inside h2','dw')
                    ),
                    'welcome-box-short-intro'  => array(
                        'title'     => __('Short intro','dw'),
                        'type'      => 'textarea',
                    ),
                    'welcome-box-bg-color'    => array(
                        'title'         => __('Background color','dw'),
                        'type'          => 'color',
                        'description'   => __('Background color of welcome box','dw')
                    ),
                    'welcome-box-text-color'    => array(
                        'title'         => __('Text color','dw'),
                        'type'          => 'color',
                        'description'   => __('Text color of Welcome-box content','dw')
                    )
                )
            ),
            'facebook_setting'  => array(
                'title'             => __( 'Facebook', 'dw' ),
                'description'       => __('Settings for your Facebook block','dw'),
                'tab'           => 'dw_homepage_options',
                'items'             => array(
                    'facebook-name'     => array(
                        'title'             => __('Facebook name','dw'),
                        'type'              => 'text'
                    )
                )
            ),
            'twitter_setting'   => array(
                'title'             => __( 'Twitter', 'dw' ),
                'description'       => __('Settings for your Twitter block','dw'),
                'tab'           => 'dw_homepage_options',
                'items'             => array(
                    'twitter-name'     => array(
                        'title'             => __('Username','dw'),
                        'type'              => 'text'
                    ), 
                    'twitter-consumer-key'  => array(
                        'title'     => __('Consumer Key','dw'),
                        'type'      => 'text',
                        'description'   => __('Consumer Key of your Twitter app','dw')
                    ), 
                    'twitter-consumer-secret'  => array(
                        'title'     => __('Consumer Secret','dw'),
                        'type'      => 'text',
                        'description'   => __('Consumer Secret of your Twitter app','dw')
                    )
                )
            ),
            'google-plus'   => array(
                'title'         => __( 'Google Plus','dw'),
                'description'   => __( 'Settings for your Google Plus block','dw'),
                'tab'           => 'dw_homepage_options',
                'items'         => array(
                    'google-plus-name'  => array(
                        'title'     => __('Profile Name','dw'),
                        'type'      => 'text'
                    ),
                    'google-plus-url'  => array(
                        'title'     => __('Profile URL','dw'),
                        'type'      => 'text'
                    )
                )
            ),
            'instagram-setting' => array(
                'title'     => __('Instagram', 'dw'),
                'description'   => __( 'Settings for your Instagram block','dw'),
                'tab'           => 'dw_homepage_options',
                'items'         => array(
                    'instagram-search'  => array(
                        'title'     => __('Query search','dw'),
                        'type'      => 'text'
                    )
                )
            ),
            'flickr-id'     => array(
                'title'         => __('Flickr', 'dw'),
                'description'   => __( 'Settings for your Flickr block','dw'),
                'tab'           => 'dw_homepage_options',
                'items'         => array(
                    'flickr-id'  => array(
                        'title'     => __('Flickr ID','dw'),
                        'type'      => 'text',
                        'description'   => __( 'Flickr ID, your flickr id example : 7801264@N03', 'dw')
                    )
                )
            ),

            //Contact page
            'contact_options_section'   => array(
                'title' => __('Contact Page','dw'),
                'tab'   => 'dw_contact_page_options',
                'description'   => __('Update infomation of your contact page','dw'),
                'items'     => array(
                    'contact-title'     => array(
                        'title'     => __('Page title','dw'),
                        'type'      => 'text',
                    ),
                    'contact-content'   => array(
                        'title'     => __('Page content','dw'),
                        'type'      => 'editor',
                    ),
                    'contact-address' => array(
                        'title'     => __('Page address','dw'),
                        'type'      => 'text'
                    ),
                    'contact-phone'   => array(
                        'title'     => __('Phone','dw'),
                        'type'      => 'text',
                    ),
                    'contact-fax' => array(
                        'title'     => __('Fax','dw'),
                        'type'      => 'text'
                    ),
                    'contact-map'   => array(
                        'title'     => __('Google Map link','dw'),
                        'type'      => 'text',
                        'description'   => __('Your addres link from Google Map','dw')
                    )
                )
            ),
            
            'archive_page_section'      => array(
                'title'     => __('Archive Page','dw'),
                'tab'       => 'dw_archive_page_options',
                'items'     => array(
                    'show_more_type'    => array(
                        'title'             => __('Show more type','dw'),
                        'description'       => __('Show more type for archive page','dw'),
                        'type'      => 'text'
                    )
                )
            )
        );
    }
    add_action( 'init', 'dw_declare_theme_options',9 );
}
if( !function_exists('dw_initialize_theme_options') ) {

    function dw_initialize_theme_options() {

        // If the theme options don't exist, create them.
        if( false == get_option( 'dw_theme_options' ) ) {  
            add_option( 'dw_theme_options' );
        } // end if
        global $dw_theme_options_setting, $dw_theme_options_tab;

        if( ! empty($dw_theme_options_setting) ) {
            foreach ($dw_theme_options_setting as $section_id => $section ) {
                //Add section
                add_settings_section( 
                    $section_id, 
                    $section['title'], 
                    create_function( '', '
                        echo \''.(isset($section['description']) ? $section['description'] : '').'\';
                    '), 
                    $section['tab']
                );

                if( ! empty($section['items']) ) {
                    // Add setting for each section
                    foreach ( $section['items'] as $setting_id => $setting ) {
                        $description = isset($setting['description']) ? $setting['description'] : false;
                        add_settings_field( 
                            $setting_id,     
                            $setting['title'],
                            create_function( '', '
                                call_user_func(\'dw_theme_options_'.$setting['type'].'_type\', \''.$setting_id.'\', \''.$description.'\', \''.$section['tab'].'\');
                            '),
                            $section['tab'],
                            $section_id
                        );
                    }
                }

            }
        }

        foreach ( $dw_theme_options_tab as $tab_id => $tab ) {
            register_setting( $tab_id, $tab_id );
        }
        
    } // end dw_initialize_theme_options
    add_action('admin_init', 'dw_initialize_theme_options');
}

if( ! function_exists('dw_theme_options_html') ) {
    function dw_theme_options_html(){
        global $wpdb, $dw_theme_options_setting, $dw_theme_options_tab;
        ?>
        <div class="wrap">
            <h2><?php _e('DW Theme Options', 'dw') ?></h2>
        </div>
        <?php settings_errors(); ?>  
        <?php  
            $active_tab = 'dw_general_options';
            if( isset( $_GET[ 'tab' ] ) ) {  
                $active_tab = $_GET[ 'tab' ];  
            } // end if  
        ?>  
        <h2 class="nav-tab-wrapper">  
            <?php foreach ( $dw_theme_options_tab as $tab_id => $tab ) { ?>
            <a href="?page=dw-theme-options&amp;tab=<?php echo $tab_id ?>" class="nav-tab <?php echo $active_tab == $tab_id ? 'nav-tab-active' : ''; ?>"><?php echo $tab['title'] ?></a>
            <?php } ?>

        </h2>  
        
        <form method="post" action="options.php">  
        <?php  
            settings_fields( $active_tab );
            do_settings_sections( $active_tab );
            submit_button();
        ?>
        </form>  
        <?php
    }
}

if( ! function_exists('dw_theme_options_editor_type') ) {
    function dw_theme_options_editor_type( $setting_id, $description = false, $tab = 'dw_theme_options' ){
        $editor_content = dw_get_theme_option( $setting_id );
        wp_editor( $editor_content, $setting_id.'-editor', array(
            'textarea_name'     => $tab.'['.$setting_id.']',
            'textarea_rows'     => 5,
        ) );
        if( $description ) {
            echo '<p>'.$description.'</p>';
        }
    }
}

if( ! function_exists('dw_theme_options_color_type') ) {
    function dw_theme_options_color_type( $setting_id, $description = false, $tab = 'dw_theme_options' ){
        echo '<p><input type="text" class="color-picker" name="'.$tab.'['.$setting_id.']" value="' . dw_get_theme_option( $setting_id, '#fc615d') . '" /> ';
        if( $description ) {
            echo '<br><span class="description">'.$description.'</span>';
        }
        echo '</p>';
    }
}

if( ! function_exists('dw_theme_options_text_type') ) {
    function dw_theme_options_text_type( $setting_id, $description = false, $tab = 'dw_theme_options' ){
        echo '<input class="regular-text" id="'.$setting_id.'" name="'.$tab.'['.$setting_id.']" value="'.dw_get_theme_option( $setting_id ).'">';
        if( $description ) {
            echo '<br><span class="description">'.$description.'</span>';
        }
    }
}

if( ! function_exists('dw_theme_options_textarea_type') ) {
    function dw_theme_options_textarea_type( $setting_id, $description = false, $tab = 'dw_theme_options' ){
        echo '<textarea rows="5" class="large-text code" id="'.$setting_id.'" name="'.$tab.'['.$setting_id.']">'.dw_get_theme_option( $setting_id ).'</textarea>';
        if( $description ) {
            echo '<br><span class="description">'.$description.'</span>';
        }
    }
}

if( ! function_exists('dw_get_theme_option') ) {
    function dw_get_theme_option( $option_name, $default = '' ) {
        global $dw_theme_options_setting, $dw_theme_options_tab;
        $tab = 'dw_theme_options';
        if( ! empty($dw_theme_options_setting) ) {

            foreach ($dw_theme_options_setting as $section_id => $section ) {
                if ( ! empty($section['items']) ) {
                    foreach ($section['items'] as $id => $item ) {
                        if( $id == $option_name ) {
                            $tab = $section['tab'];
                            break;
                        }
                    }
                }
            }
            $option = get_option( $tab );
            if( isset($option[$option_name]) 
                    && ! empty($option[$option_name]) ) {
                return $option[$option_name];
            } 
        }
        return $default;
    }
}

// if( ! function_exists('dw_customize_register') ) {

//     function dw_customize_register($wp_customize){

//         $wp_customize->add_section( 'dw_general_settings' , array(
//             'title'      => __( 'General Settings', 'dw' ),
//             'priority'   => 10,
//         ) );
//         //Settings of  General Settings tab

//             //Facebook Contact
//             $wp_customize->add_setting('dw_general_options[facebook_link]', array(
//                 'default'        => '',
//                 'capability'     => 'edit_theme_options',
//                 'type'           => 'option',
//                 'transport' => 'postMessage'
//             ));
         
//             $wp_customize->add_control('dw_general_options_facebook_link', array(
//                 'label'      => __('Link to your Facebook profile', 'dw'),
//                 'section'    => 'dw_general_settings',
//                 'settings'   => 'dw_general_options[facebook_link]',
//                 'type'       => 'text',
//                 'priority' => 10
//             ));

            
//             //Twitter Contact
//              $wp_customize->add_setting('dw_general_options[twitter_link]', array(
//                 'default'        => '',
//                 'capability'     => 'edit_theme_options',
//                 'type'           => 'option',
//                 'transport' => 'postMessage'
//             ));
         
//             $wp_customize->add_control('dw_general_options_twitter_link', array(
//                 'label'      => __('Link to your Twitter profile', 'dw'),
//                 'section'    => 'dw_general_settings',
//                 'settings'   => 'dw_general_options[twitter_link]',
//                 'type'       => 'text',
//                 'priority' => 11
//             ));

//             //Instagram Contact
//              $wp_customize->add_setting('dw_general_options[instagram_link]', array(
//                 'default'        => '',
//                 'capability'     => 'edit_theme_options',
//                 'type'           => 'option',
//                 'transport' => 'postMessage'
//             ));
         
//             $wp_customize->add_control('dw_general_options_instagram_link', array(
//                 'label'      => __('Link to your Instagram profile', 'dw'),
//                 'section'    => 'dw_general_settings',
//                 'settings'   => 'dw_general_options[instagram_link]',
//                 'type'       => 'text',
//                 'priority' => 12
//             ));

//             //Youtube Contact
//              $wp_customize->add_setting('dw_general_options[youtube_link]', array(
//                 'default'        => '',
//                 'capability'     => 'edit_theme_options',
//                 'type'           => 'option',
//                 'transport' => 'postMessage'
//             ));
         
//             $wp_customize->add_control('dw_general_options_youtube_link', array(
//                 'label'      => __('Link to your Youtube channel', 'dw'),
//                 'section'    => 'dw_general_settings',
//                 'settings'   => 'dw_general_options[youtube_link]',
//                 'type'       => 'text',
//                 'priority' => 13
//             ));
//             //Google Plus
//              $wp_customize->add_setting('dw_general_options[google-plus_link]', array(
//                 'default'        => '',
//                 'capability'     => 'edit_theme_options',
//                 'type'           => 'option',
//                 'transport' => 'postMessage'
//             ));
         
//             $wp_customize->add_control('dw_general_options_google_plus_link', array(
//                 'label'      => __('Google plus profile', 'dw'),
//                 'section'    => 'dw_general_settings',
//                 'settings'   => 'dw_general_options[google-plus_link]',
//                 'type'       => 'text',
//                 'priority' => 14
//             ));

//             //LinkedIn Contact
//              $wp_customize->add_setting('dw_general_options[linkedin_link]', array(
//                 'default'        => '',
//                 'capability'     => 'edit_theme_options',
//                 'type'           => 'option',
//                 'transport' => 'postMessage'
//             ));
         
//             $wp_customize->add_control('dw_general_options_linkedin_link', array(
//                 'label'      => __('LinkedIn Profile', 'dw'),
//                 'section'    => 'dw_general_settings',
//                 'settings'   => 'dw_general_options[linkedin_link]',
//                 'type'       => 'text',
//                 'priority' => 15
//             ));

//             //  Header script
//             $wp_customize->add_setting('dw_general_options[header_script]', array(
//                 'default'               => '',
//                 'capability'            => 'edit_theme_options',
//                 'type'                  => 'option',
//                 'transport' => 'postMessage'
         
//             ));
         
//             $wp_customize->add_control( new dw_customize_textarea($wp_customize, 'dw_header_script', array(
//                 'label'    => __('DW Header script', 'dw'),
//                 'section'  => 'dw_general_settings',
//                 'settings' => 'dw_general_options[header_script]',
//                 'priority' => 16
//             )));

//             //  Footer script
//             $wp_customize->add_setting('dw_general_options[footer_script]', array(
//                 'default'               => '',
//                 'capability'            => 'edit_theme_options',
//                 'type'                  => 'option',
//                 'transport' => 'postMessage'
         
//             ));
         
//             $wp_customize->add_control( new dw_customize_textarea($wp_customize, 'dw_footer_script', array(
//                 'label'    => __('DW Footer Script', 'dw'),
//                 'section'  => 'dw_general_settings',
//                 'settings' => 'dw_general_options[footer_script]',
//                 'priority' => 17
//             )));
        
//         //End General Settings
        
//         $wp_customize->add_section( 'dw_homepage_options' , array(
//             'title'      => __( 'Homepage Settings', 'dw' ),
//             'priority'   => 10,
//         ) );
//         //Title Tagline section
//             //  Logo Image
//             $wp_customize->add_setting('dw_theme_options[logo_image]', array(
//                 'default'               => DW_URI . 'assets/img/logo.png',
//                 'capability'            => 'edit_theme_options',
//                 'type'                  => 'option',
         
//             ));
         
//             $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'logo_image', array(
//                 'label'    => __('Logo', 'dw'),
//                 'section'  => 'title_tagline',
//                 'settings' => 'dw_theme_options[logo_image]',
//             )));

//             //  Footer Logo Image
//             $wp_customize->add_setting('dw_theme_options[footer_logo_image]', array(
//                 'default'               => DW_URI . 'assets/img/logo-ft.png',
//                 'capability'            => 'edit_theme_options',
//                 'type'                  => 'option',
         
//             ));
         
//             $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'footer_logo_image', array(
//                 'label'    => __('Footer Logo', 'dw'),
//                 'section'  => 'title_tagline',
//                 'settings' => 'dw_theme_options[footer_logo_image]',
//             )));
//             //  favicon images
//             $wp_customize->add_setting('dw_theme_options[favicon]', array(
//                 'default'               => DW_URI . 'assets/img/favicon.png',
//                 'capability'            => 'edit_theme_options',
//                 'type'                  => 'option',
         
//             ));
         
//             $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'dw_favicon', array(
//                 'label'    => __('Favicon', 'dw'),
//                 'section'  => 'title_tagline',
//                 'settings' => 'dw_theme_options[favicon]'
//             )));
//         // End Title Tagline section
        
//         $wp_customize->add_section( 'dw_archive_page_options' , array(
//             'title'      => __( 'Archive Page', 'dw' ),
//             'priority'   => 10,
//         ) );
//         // Archive page settings
//         $wp_customize->add_setting('dw_archive_page_options[show_more_type]', array(
//             'default'        => 'infinite',
//             'capability'     => 'edit_theme_options',
//             'type'           => 'option'
//         ));
     
//         $wp_customize->add_control('dw_homepage_options_block_number', array(
//             'label'      => __('Show more type', 'dw'),
//             'section'    => 'dw_archive_page_options',
//             'settings'   => 'dw_archive_page_options[show_more_type]',
//             'type'    => 'radio',
//             'choices' => array(
//                 'button' => __( 'Show more button', 'dw' ),
//                 'infinite'  => __( 'Infinite loading', 'dw' ),
//             ),
//             'priority' => 10
//         ));
//         // End Achive page settings
//     }
//     add_action('customize_register', 'dw_customize_register');
// }

if( ! function_exists('dw_customizer_live_preview') ) {
    function dw_customizer_live_preview() {
        $dw = array(
            'ajax_url'      => admin_url( 'admin-ajax.php' ),
            'is_single'     => is_single(),
            'site_url'      => site_url(),
            'theme_url'     => DW_URI
        );
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 
            'dw-themecustomizer',
            DW_URI.'assets/js/dw-customizer.js',
            array( 'jquery', 'customize-preview' ),
            false,
            true
        );
        wp_localize_script( 'dw-themecustomizer', 'dw', $dw );
    }
    add_action( 'customize_preview_init', 'dw_customizer_live_preview' );
}

?>