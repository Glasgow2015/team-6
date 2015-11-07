<?php  
// Homepage layout define
if( ! function_exists('dw_homepage_layout_define') ) {
    function dw_homepage_layout_define(){
        global $dw_homepage_layout;

        $dw_homepage_layout = array(
            'number'    => 23 ,
            'items'     => array(
                1           => array(
                    'format'    => 'welcome-box',
                    'size'      => 'w2'
                ),
                3           => array( 'format'    => 'social-facebook' ),
                7           => array( 
                    'format'    => 'social-instagram',
                    'size'      => 'w2'
                ),
                11          => array( 'format'    => 'social-google-plus' ),
                14          => array( 'format'    => 'social-twitter' ),
                17          => array(
                    'format'    => 'social-flickr',
                    'size'      => 'w2'
                )
            )
        );
        $dw_homepage_layout['number'] = dw_get_theme_option('block_number',23);
    }
    add_action( 'init', 'dw_homepage_layout_define' );
}

if( ! function_exists('dw_modify_main_query') ) {
    function dw_modify_main_query( $query ) {
        global $dw_homepage_layout;
        if ( $query->is_home() ) {
            $query->query_vars['posts_per_page'] = $dw_homepage_layout['number']; 
        }
    }
    add_action( 'pre_get_posts', 'dw_modify_main_query' );
}


// Make screen loading for homepage
if( ! function_exists('dw_body_class') ) {
    function dw_body_class($classes){
        $classes[] = 'loading';
        return $classes;
    }
    add_action( 'body_class', 'dw_body_class' );
}


// Display content of homepage
if( ! function_exists('dw_homepage_display') ) {
    function dw_homepage_display(){
        global $block_class, $dw_homepage_layout, $wp_query, $social_wall_settings;
        $social_wall_settings = get_post_meta( get_the_ID(), 'dw-social-wall-settings', true );
        $social_wall_settings = wp_parse_args( $social_wall_settings, array(
            'heading-1'                 => '',
            'heading-2'                 => '',
            'short-intro'               => '',
            'welcome-box-bg-color'      => '#fc615d',
            'welcome-box-text-color'    => '#fff',
            'facebook-name'             => '',
            'twitter-query'             => '',
            'twitter-consumer-key'      => '',
            'twitter-consumer-secret'   => '',
            'google-plus-name'          => '',
            'google-plus-url'           => '',
            'flickr-id'                 => '',
            'instagram-search'          => ''
        ) );

        $i = 0; $unwind_loop = false;
        if( ! empty($dw_homepage_layout['items']) ) {
            $blocks = $dw_homepage_layout['items'];
        }
        $args = array(
            'posts_per_page'    => get_option( 'posts_per_page' ),
            'post_status'       => 'publish',
            'post_type'         => 'post'
        );
        //Exlcuded post
        $showed = array();
        for ( $i=1 ;   $i <= $dw_homepage_layout['number'] ; $i++ ) { 
            if( isset($blocks[$i]) ) {
                $format = $blocks[$i]['format'];
                if( $format == 'post' ) {
                    $showed[] = $blocks[$i]['post_id'] ;
                }
            }
        }
        if( ! empty($showed) ) {
            $args['post__not_in'] = $showed;
        }
        query_posts( $args );

        for ( $i=1 ;   $i <= $dw_homepage_layout['number'] ; $i++ ) { 
            $block_class = 'block';
            $format      = '';
            

            if( isset($blocks[$i]) ) {
                $format = $blocks[$i]['format'];

                if( isset($blocks[$i]['size']) ) {
                    $block_class .= ' ' . $blocks[$i]['size'];
                } 
                // if( $format == 'post' ) {
                //     global $post;
                //     $post = get_post( $blocks[$i]['post_id'] );

                //     if( ! is_wp_error( $post ) && ! empty($post)  ) {
                //         setup_postdata( $post );
                //         $format = get_post_format( $post->ID );
                //     } else {
                //         $format = 'empty';
                //     }
                // }
            } else {

                if( have_posts() && ! $unwind_loop ) {
                    the_post();
                    $format = get_post_format();
                } else {
                    $unwind_loop = true;
                    $format = 'empty';
                }
            }
            if( strpos($block_class, 'w2') === false ) {
                $block_class .= ' grid-sizer';
            }
            get_template_part( 'content', $format );
        }

        wp_reset_query();
    }
}



if( ! function_exists('dw_modal_init') ) {
    function dw_modal_init(){
        if( is_home() || is_front_page() ) {
            get_template_part( 'modal' );
        }
    }
    add_action( 'wp_footer', 'dw_modal_init' );
}


if( ! function_exists('dw_update_social_settings') ) {
    function dw_update_social_settings(){
        if( ! isset($_POST['action']) 
            || 'dw-update-social-settings' != $_POST['action'] ) {
            return;
        }

        if( ! isset($_POST['_wpnonce']) 
            || ! wp_verify_nonce( $_POST['_wpnonce'],'_dw_update_social_settings'  ) ) {
            return;
        }

        if( ! isset($_POST['dw_general_options']) || empty($_POST['dw_general_options']) ) {
            return;
        }
        $option = get_option( 'dw_general_options' );
        if( ! empty($option) ) {
            foreach ($_POST['dw_general_options'] as $key => $value) {
                $option[$key]   = $value;
            }
            update_option( 'dw_general_options', $option );
        }

    }
    add_action( 'init', 'dw_update_social_settings' );
}

if( ! function_exists('dw_block_edit_body') ) {
    function dw_block_edit_body($classes){
        if( is_home() && current_user_can( 'manage_options' ) ) {
            $classes[] = 'edit';
        }
        return $classes;
    }
    add_action( 'body_class', 'dw_block_edit_body' );
}

if( ! function_exists('dw_social_wall_metabox') ) {
    function dw_social_wall_metabox(){
        add_meta_box( 'dw_social_wall_meta_box', __('Social Wall Settings', 'dw'), 'dw_social_wall_metabox_html', 'page' );
    }
    add_action( 'add_meta_boxes', 'dw_social_wall_metabox' );
}

if( ! function_exists('dw_social_wall_metabox_html') ) {
    function dw_social_wall_metabox_html( $post ) {
        wp_nonce_field( '_dw_social_wall_nonce', 'dw_social_wall_nonce', false );
        $settings = get_post_meta( $post->ID, 'dw-social-wall-settings', true );
        $settings = wp_parse_args( $settings, array(
            'heading-1'                 => '',
            'heading-2'                 => '',
            'short-intro'               => '',
            'welcome-box-bg-color'      => '#fc615d',
            'welcome-box-text-color'    => '#fff',
            'facebook-name'             => '',
            'twitter-query'             => '',
            'twitter-consumer-key'      => '',
            'twitter-consumer-secret'   => '',
            'google-plus-name'          => '',
            'google-plus-url'           => '',
            'flickr-id'                 => '',
            'instagram-search'          => ''
        ) );

        ?>
        <p class="description"><?php _e(' Build a social wall page and share your social network','dw') ?></p> 
        <h4 class="title"><?php _e('Welcomebox Settings','dw') ?></h4>
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row">
                        <label for="dw_social_wall_heading_1"><?php _e('Heading 1','dw') ?></label>
                    </th>
                    <td>
                        <input type="text" class="widefat" id="dw_social_wall_heading_1" name="dw_social_wall[heading-1]" value="<?php echo htmlentities( $settings['heading-1'] ) ?>">
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="dw_social_wall_heading_1"><?php _e('Heading 2','dw') ?></label>
                    </th>
                    <td>
                        <input type="text" class="widefat" id="dw_social_wall_heading_2" name="dw_social_wall[heading-2]" value="<?php echo htmlentities( $settings['heading-2'] ) ?>">
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="dw_social_wall_short_intro"><?php _e('Short Intro','dw') ?></label>
                    </th>
                    <td>
                        <textarea id="dw_social_wall_short_intro" name="dw_social_wall[short-intro]" class="widefat"><?php echo $settings['short-intro'] ?></textarea>
                    </td>
                </tr>
            </tbody>
        </table> 
        <h4><?php _e('Facebook','dw') ?></h4>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <label for="dw_social_wall_facebook_username"><?php _e('Facebook Username','dw') ?></label>
                </th>
                <td>
                    <input id="dw_social_wall_facebook_username" type="text" class="regular-text" name="dw_social_wall[facebook-name]" value="<?php echo $settings['facebook-name'] ?>">
                </td>
            </tr>
        </table>
        <h4><?php _e('Twitter','dw') ?></h4>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <label for="dw_social_wall_twitter_query"><?php _e('Twitter Query Search','dw') ?></label>
                </th>
                <td>
                    <input type="text" class="regular-text" id="dw_social_wall_twitter_query" name="dw_social_wall[twitter-query]" value="<?php echo $settings['twitter-query'] ?>">
                    <br><span class="description"><?php _e('Returns a collection of relevant Tweets matching a specified query.','dw') ?> <a href="https://dev.twitter.com/docs/api/1.1/get/search/tweets">?</a></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="dw_social_wall_twitter_consumer_key"><?php _e('Twitter Consumer Key','dw') ?></label>
                </th>
                <td>
                    <input type="text" class="regular-text" name="dw_social_wall[twitter-consumer-key]"  id="dw_social_wall_twitter_consumer_key" value="<?php echo $settings['twitter-consumer-key'] ?>">
                    <br><span class="description"><?php _e('Consumer Key of your Twitter App, How to get it', 'dw') ?>&nbsp;<a target="_blank" href="https://dev.twitter.com/apps">?</a></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="dw_social_wall_twitter_consumer_secret"><?php _e('Twitter Consumer Secret','dw') ?></label>
                </th>
                <td>
                    <input type="text" class="regular-text" id="dw_social_wall_twitter_consumer_secret" name="dw_social_wall[twitter-consumer-secret]" value="<?php echo $settings['twitter-consumer-secret'] ?>">
                    <br><span class="description"><?php _e('Consumer Secret of your Twitter App, How to get it', 'dw') ?>&nbsp;<a target="_blank" href="https://dev.twitter.com/apps">?</a></span>
                </td>
            </tr>
        </table>
        <h4><?php _e('Google Plus','dw') ?></h4>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <label for="dw_social_wall_google_plus_name"><?php _e('Google Plus Profile Name','dw') ?></label>
                </th>
                <td>
                    <input type="text" class="regular-text" id="dw_social_wall_google_plus_name" name="dw_social_wall[google-plus-name]" value="<?php echo $settings['google-plus-name'] ?>">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="dw_social_wall_google_plus_profile"><?php _e('Google Plus Profile URL','dw') ?></label>
                </th>
                <td>
                    <input type="text" class="regular-text" id="dw_social_wall_google_plus_profile" name="dw_social_wall[google-plus-url]" value="<?php echo $settings['google-plus-url'] ?>">
                </td>
            </tr>
        </table>
        <h4><?php _e('Instagram','dw') ?></h4>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <label for="dw_social_wall_instagram_search"><?php _e('Instagram Search','dw') ?></label>
                </th>
                <td>
                    <input type="text" class="regular-text" id="dw_social_wall_instagram_search" name="dw_social_wall[instagram-search]" value="<?php echo $settings['instagram-search'] ?>">
                </td>
            </tr>
        </table>

        <h4><?php _e('Flickr','dw') ?></h4>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <label for="dw_social_wall_flickr_id"><?php _e('Flickr ID','dw') ?></label>
                </th>
                <td>
                    <input type="text" class="regular-text" id="dw_social_wall_flickr_id" name="dw_social_wall[flickr-id]" value="<?php echo $settings['flickr-id'] ?>">
                    <br><span class="description"><?php _e('How to get Flickr ID', 'dw') ?>&nbsp;<a target="_blank" href="http://idgettr.com/">?</a></span>
                </td>
            </tr>
        </table>
        <?php
    }
}


if( ! function_exists('dw_social_wall_metabox_save') ) {
    function dw_social_wall_metabox_save( $post_id ){  
        // Bail if we're doing an auto save  
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
         
        // if our nonce isn't there, or we can't verify it, bail 
        if( !isset( $_POST['dw_social_wall_nonce'] ) || !wp_verify_nonce( $_POST['dw_social_wall_nonce'], '_dw_social_wall_nonce' ) ) return; 
         
        // if our current user can't edit this post, bail  
        if( !current_user_can( 'edit_post' ) ) return;  

        if( empty($_POST['dw_social_wall']) ) return;

        update_post_meta( $post_id, 'dw-social-wall-settings', $_POST['dw_social_wall'] );
    } 

    add_action( 'save_post', 'dw_social_wall_metabox_save' );  
}

?>