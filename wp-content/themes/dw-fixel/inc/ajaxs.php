<?php  

if( ! function_exists('dw_get_post_details') ) {
    function dw_get_post_details(){
        if( ! isset($_GET['post_id']) ) {
            wp_send_json_error( array( 'message' => __('Missing post id infomation.','dw') ) );
        }
        global $post, $wp_query;
        $post = get_post( $_GET['post_id'] );
        $wp_query->is_singular = true;
        if (  is_wp_error( $post ) ) {
            wp_send_json_error( array( 'message' => __('Post is not exists.','dw') ) );
        }
        if( isset($_GET['adjacent']) ) {
            switch ( $_GET['adjacent'] ) {
                case 'next':
                    $post = get_next_post( false );
                    break;
                case 'prev':
                    $post = get_previous_post( false );
                    break;
            }
        }

        if( ! empty($post) ) {
            setup_postdata( $post );
            global $is_show_modal;
            $is_show_modal = true;
            $current_post_id = $post->ID;
            $next_post = get_next_post();
            $prev_post = get_previous_post();
            
            ob_start();
            if( isset($_GET['is_single']) && $_GET['is_single'] ) {
            ?>
            <div class="scroller">
                <div class="main-content span8">
                    <?php global $more; $more = 1; ?>
                    <?php get_template_part('content','single'); ?>
                    <?php global $withcomments; $withcomments = true; ?>
                    <?php comments_template(); ?>
                </div>
                <!-- #main-content -->

                <?php get_sidebar(); ?>
                <!-- #side-bar -->
            </div>
            <?php
            } else {
                get_template_part( 'content', 'modal' );
            }   

            $modal_content = ob_get_contents();
            ob_end_clean();
            $is_show_modal = false;
            wp_reset_query();
            wp_send_json_success( array(
                'html'              => $modal_content,
                'post_id'           => $current_post_id,
                'post_title'        => get_the_title( $current_post_id ) ,
                'post_permalink'    => get_permalink( $current_post_id ),
                'next_post'         => $next_post,
                'prev_post'         => $prev_post
            ) );
        } else {
            wp_reset_query();
            wp_send_json_error( array(
                'message' => __('Empty Post','dw')
            ) );
        }
    }
    add_action( 'wp_ajax_dw-get-post-detail', 'dw_get_post_details' );
    add_action( 'wp_ajax_nopriv_dw-get-post-detail', 'dw_get_post_details' );
}

if( ! function_exists('dw_ajax_get_post') ) {
    function dw_ajax_get_post(){
        if( ! isset($_GET['post_id']) ) {
            wp_send_json_error( array( 'message' => __('Missing post id infomation.','dw') ) );
        }
        $post = get_post( $_GET['post_id'], ARRAY_A );
        $thumbnail = get_post_thumbnail_id( $post['ID'] );
        if( $thumbnail ) {
            $post['post_thumbnail'] = $thumbnail;
        }
        wp_send_json_success( array(
            'post' => $post
        ) );
    }
    add_action( 'wp_ajax_dw-ajax-get-post-detail', 'dw_ajax_get_post' );
    add_action( 'wp_ajax_nopriv_dw-ajax-get-post-detail', 'dw_ajax_get_post' );
}

if( ! function_exists( 'dw_ajax_tweets_setup' ) ) {
    function dw_ajax_tweets_setup(){
        global $social_wall_settings;
        if( ! isset($_REQUEST['page_id']) ) {
            exit(0);
        }
        $social_wall_settings = get_post_meta( $_REQUEST['page_id'], 'dw-social-wall-settings', true );
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
        if( ! $social_wall_settings['twitter-query'] ) {
            exit(0);
        }
        $tweets = get_tweets(array(
            'query'             => $social_wall_settings['twitter-query'],
            'page_id'           => $_REQUEST['page_id'],
            'consumer_key'      => $social_wall_settings['twitter-consumer-key'],
            'consumer_secret'   => $social_wall_settings['twitter-consumer-secret']
        ) ); 
    ?>
        <?php if( ! empty($tweets) ) : ?>
        <?php foreach ($tweets as $tweet ) : ?>
                <p class="twitter-content"><?php echo update_tweet_urls( $tweet->text ); ?></p>
                <p class="twitter-link"><a href="https://twitter.com/<?php echo $tweet->user->screen_name ?>"><i class="icon-twitter"></i> @<?php echo $tweet->user->screen_name; ?></a></p>
        <?php endforeach; ?>
        <?php endif; ?>
        <?php
        exit(0);
    }
    add_action( 'wp_ajax_nopriv_dw-ajax-tweets-setup', 'dw_ajax_tweets_setup' );
    add_action( 'wp_ajax_dw-ajax-tweets-setup', 'dw_ajax_tweets_setup' );

}

if( ! function_exists( 'dw_ajax_facebook_setup' ) ) {
    function dw_ajax_facebook_setup(){
        global $social_wall_settings;
        if( ! isset($_GET['page_id']) ) {
            exit(0);
        }
        $social_wall_settings = get_post_meta( $_REQUEST['page_id'], 'dw-social-wall-settings', true );
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
        if( ! $social_wall_settings['facebook-name'] ) {
            exit(0);
        }
        $facebook = $social_wall_settings['facebook-name'];
        if( $facebook ) {
            $result = json_decode( dw_file_get_content( 'http://graph.facebook.com/'.$facebook ) );
            $link = isset($result->link) ? $result->link : 'http://facebook.com/' . $result->id;
            $avatar = json_decode( dw_file_get_content( 'http://graph.facebook.com/'.$facebook.'?fields=picture' ) );
            $avatar = $avatar->picture->data->url;
        ?>
             <a class="fb-profile-picture" href="<?php echo $link ?>"><img src="<?php echo $avatar; ?>" alt /></a>
            <p><?php echo $result->name; ?> on <a href="<?php echo $link ?>"><span>Facebook</span></a></p>
            <iframe src="//www.facebook.com/plugins/like.php?href=<?php echo urlencode($link) ?>&amp;send=false&amp;layout=button_count&amp;show_faces=true&amp;font&amp;colorscheme=light&amp;action=like" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height: 20px; width: 77px;" allowTransparency="true"></iframe>
        <?php
        }
        exit(0);
    }
    add_action( 'wp_ajax_nopriv_dw-ajax-facebook-setup', 'dw_ajax_facebook_setup' );
    add_action( 'wp_ajax_dw-ajax-facebook-setup', 'dw_ajax_facebook_setup' );

}

if( ! function_exists( 'dw_ajax_flickrs_setup' ) ) {
    function dw_ajax_flickrs_setup(){
        $flickr_id = dw_get_theme_option('flickr-id');
        if( $flickr_id ) {
            $flickrs = get_flickrs( $flickr_id );
            $i = 0;
    ?>
        <div class="carousel-inner">
            <?php if( ! empty($flickrs) ) : ?>
              <?php foreach ( $flickrs as $flickr ) : ?>
              <div class="<?php echo $i == 0 ? 'active' : '' ?> item">
                  <a href="<?php echo $flickr['url'] ?>" ><img src="<?php echo $flickr['photo_url']; ?>" target="_blank" /></a>
                  <div class="carousel-caption">
                    <h4><a href="<?php echo $flickr['url'] ?>" ><?php echo $flickr['title'] ?></a></h4>
                    <p><?php echo strip_tags( $flickr['description'] ) ?></p>
                  </div>
              </div>
              <?php $i++; ?>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
          <a class="carousel-control left" href="#carousel-flickr" data-slide="prev"><i class="icon-long-arrow-left"></i></a>
          <a class="carousel-control right" href="#carousel-flickr" data-slide="next"><i class="icon-long-arrow-right"></i></a>
        <?php
    }
        exit(0);
    }
    add_action( 'wp_ajax_nopriv_dw-ajax-flickrs-setup', 'dw_ajax_flickrs_setup' );
    add_action( 'wp_ajax_dw-ajax-flickrs-setup', 'dw_ajax_flickrs_setup' );

}

// Add new post
if( ! function_exists('dw_add_new_post') ) {
    function dw_add_new_post(){
        if( ! isset($_POST['nonce']) || ! wp_verify_nonce( $_POST['nonce'], '_dw_add_post_nonce' ) ) {
            wp_send_json_error( array( 'message' => __('Are you cheating huh','dw') ) );
        }

        if( ! isset($_POST['post_content']) || ! $_POST['post_content'] ) {
            wp_send_json_error( array(
                'message'   => __('Your content was not empty','dw')
            ) );
        }

        $tags = isset($_POST['post_tags']) ? explode(',', $_POST['post_tags']) : array();
        $post_title = isset($_POST['post_title']) ? wp_strip_all_tags( $_POST['post_title'] ) : '';
        $args = array(
            'tags_input'    => $tags,
            'post_content'  => $_POST['post_content'],
            'post_title'    => $post_title,
            'post_status'   => 'publish'
        );

        if( isset($_POST['update_post']) && $_POST['update_post'] && isset($_POST['post_id']) ) {
            $args['ID'] = $_POST['post_id'];
        }
        $post_id = wp_insert_post( $args );

        if( isset($_POST['post_thumbnail']) && is_numeric($_POST['post_thumbnail']) ) {
            set_post_thumbnail( $post_id, $_POST['post_thumbnail'] );
            set_post_format( $post_id, 'image' );
        }
        if( ! $post_title ) {
            set_post_format( $post_id, 'status' );
        } 

        if( ! is_wp_error( $post_id ) ) {
            global $post, $block_class, $is_edit_block;
            $post = get_post( $post_id );
            setup_postdata( $post );
            $html = '';
            
            $block_class = 'block';
            ob_start();
            get_template_part( 'content', get_post_format( $post_id ) );
            $html = ob_get_contents();
            ob_end_clean();
            wp_send_json_success( array(
                'message'   => __('New post added','dw'),
                'html'      => $html
            ) );
        }

    }
    add_action( 'wp_ajax_dw-add-new-post', 'dw_add_new_post' );
}

if( ! function_exists('dw_save_homepage_grid_layout') ) {
    function dw_save_homepage_grid_layout() {
        $dw_homepage_layout = get_option( 'dw_homepage_layout', array(
            'number'    => 23,
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
        ) );
        $dw_homepage_layout['items'] = $_POST['layout'];
        update_option( 'dw_homepage_layout', $dw_homepage_layout );
    }
    add_action( 'wp_ajax_dw-save-homepage-grid-layout', 'dw_save_homepage_grid_layout' );
}

if( ! function_exists('dw-get-edit-block') ) {
    function dw_get_edit_block(){
        global $is_edit_block;
        ob_start();

        $is_edit_block = true;
        get_template_part( 'content', 'add-new' );
        $html = ob_get_contents();
        $is_edit_block = false;
        ob_end_clean();
        wp_send_json_success( array(
            'html'  =>  $html
        ) );
    }
    add_action( 'wp_ajax_dw-get-edit-block', 'dw_get_edit_block' );
}

if( ! function_exists('dw_remove_block') ) {
    function dw_remove_block(){
        if( current_user_can( 'manage_options' ) ) {
            $dw_homepage_layout = get_option( 'dw_homepage_layout' );

            if( isset($_POST['index']) && isset($dw_homepage_layout['items'][$_POST['index']]) ) {
                unset($dw_homepage_layout['items'][$_POST['index']]);
                update_option( 'dw_homepage_layout', $dw_homepage_layout );
            }

            //Get empty box replace for current block
            ob_start();
            get_template_part( 'content', 'empty' );
            $html = ob_get_contents();
            ob_end_clean();

            wp_send_json_success( array(
                'html'  =>  $html
            ) );
        }
    }   
    add_action( 'wp_ajax_dw-remove-block', 'dw_remove_block' );
}

if( ! function_exists('dw_get_new_block') ) {
    function dw_get_new_block(){
        //Get empty box replace for current block
        global $block_class, $is_edit_block;
        $block_class = 'block';
        $is_edit_block = true;

        if( isset($_POST['submit']) && isset($_POST['type']) && $_POST['type'] != 'post' ) {
            $homepage_options = get_option( 'dw_homepage_options' );
            foreach ($_POST['submit'] as $key => $value ) {
                $homepage_options[$key] = $value;
            }
            update_option( 'dw_homepage_options', $homepage_options );
            ob_start();
            get_template_part( 'content', $_POST['type'] );
            $html = ob_get_contents();
            ob_end_clean();
            if( $html ) {
                wp_send_json_success( array(
                    'html'  => $html
                ) );   
            } else {
                wp_send_json_error( array(
                    'message'   => __('Do not have any post content block','dw')
                ) );
            }
        } else {
            wp_send_json_error( array(
                'message'       => __('It is special block','dw')
            ) );
        }

        
    }
    add_action( 'wp_ajax_dw-get-new-block', 'dw_get_new_block' );
}

if ( ! function_exists('dw_get_next_posts') ) {
    function dw_get_next_posts(){
        if( ! isset($_REQUEST['query_vars'])  ) {
            wp_send_json_error( array(
                'message'   => __('Missing query var','dw')
            ) );
        }
        wp_parse_str( $_REQUEST['query_vars'], $query_vars );
        //get paged
        $paged = ! isset($_REQUEST['paged']) || (int) $_REQUEST['paged'] <= 1 ? 1 : (int) $_REQUEST['paged'];
        $query_vars['paged'] = $paged + 1;
        query_posts( $query_vars );

        if( have_posts() ) {
            ob_start();
            global $block_class;
            $first = true;
            while( have_posts() ) : the_post();
                $block_class = 'block';
                if( dw_is_featured_post() ) { 
                    $block_class .= ' w2';
                } 
                if ( $first && ! dw_is_featured_post() ) {
                    $first = false;
                    $block_class .= ' grid-sizer';
                }
                get_template_part( 'content', get_post_format() );
            endwhile;
            $content =  ob_get_contents();
            ob_end_clean();

            wp_send_json_success( array(
                'html'      => $content,
                'query'     => $_REQUEST['query_vars'],
                'paged'     => $paged + 1
            ) ); 
        } else {
            wp_send_json_error( array(
                'code'      => 'empty',
                'message'   => __('Reach over the content','dw')
            ) );
        }

        wp_reset_query();
    }
    add_action( 'wp_ajax_dw-get-next-posts', 'dw_get_next_posts' );
    add_action( 'wp_ajax_nopriv_dw-get-next-posts', 'dw_get_next_posts' );
}

?>