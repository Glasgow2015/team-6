<?php
if( ! defined('DW_URI') ) {
    define( 'DW_URI', get_template_directory_uri() . '/');
}  
if( ! defined('DW_DIR') ) {
    define( 'DW_DIR', get_template_directory() . '/' );
}

if ( ! isset( $content_width ) )
    $content_width = 600;

if( ! function_exists('dw_excerpt_more') ) {
    function dw_excerpt_more( $more ) {
        return ' <a class="read-more" data-toggle="modal" data-post-id="'.get_the_ID().'" href="'. get_permalink( get_the_ID() ) . '">. '.__(' ...','dw').'</a>';;
    }
    add_filter('excerpt_more', 'dw_excerpt_more');
}

if( ! function_exists('dw_excerpt_length') ) {
    function dw_excerpt_length( $length ) {
        return 20;
    }
    add_filter( 'excerpt_length', 'dw_excerpt_length', 999 );
}

if( ! function_exists('dw_setup') ) {
    function dw_setup() {
        require_once( trailingslashit(DW_DIR) . 'inc/home.php' );
        require_once( trailingslashit(DW_DIR) . 'inc/class-customization.php' );
        require_once( trailingslashit(DW_DIR) . 'inc/class-navmenu.php' );
        require_once( trailingslashit(DW_DIR) . 'inc/ajaxs.php' );
        require_once( trailingslashit(DW_DIR) . 'inc/theme-options/theme-options.php' );
        require_once( trailingslashit(DW_DIR) . 'inc/theme-customization.php' );
        require_once( trailingslashit(DW_DIR) . 'inc/social-instagram.php' );
        require_once( trailingslashit(DW_DIR) . 'inc/social-twitter.php' );
        require_once( trailingslashit(DW_DIR) . 'inc/social-flickr.php' );
        require_once( trailingslashit(DW_DIR) . 'inc/widgets.php' );
        require_once( trailingslashit(DW_DIR) . 'inc/social-share-count.php' );
        require_once( trailingslashit(DW_DIR) . 'inc/widgets/dw-next_posts.php' );
        require_once( trailingslashit(DW_DIR) . 'inc/widgets/dw-flickrs.php' );
        require_once( trailingslashit(DW_DIR) . 'inc/shortcode-bootstrap/shortcode-bootstrap.php' );
        require_once( trailingslashit(DW_DIR) . 'inc/shortcode-bootstrap/inc/dws_grid.php');
        require_once( trailingslashit(DW_DIR) . 'inc/shortcode-bootstrap/inc/dws_outer_grid.php');
        require_once( trailingslashit(DW_DIR) . 'inc/shortcode-bootstrap/inc/dws_alert.php');
        require_once( trailingslashit(DW_DIR) . 'inc/shortcode-bootstrap/inc/dws_buttons.php');
        require_once( trailingslashit(DW_DIR) . 'inc/shortcode-bootstrap/inc/dws_tabs.php');
        require_once( trailingslashit(DW_DIR) . 'inc/shortcode-bootstrap/inc/dws_collapse.php');
        require_once( trailingslashit(DW_DIR) . 'inc/shortcode-bootstrap/inc/dws_icons.php');
        require_once( trailingslashit(DW_DIR) . 'inc/shortcode-bootstrap/inc/dws_table.php');
    }
    add_action( 'after_setup_theme', 'dw_setup' );
}

if( ! function_exists('dw_enqueue_scripts') ) {
    function dw_enqueue_scripts() {
        $version = 1389776043;
        wp_enqueue_style( 'dw-fixel-template', DW_URI . 'assets/css/template.css' );
        wp_enqueue_style( 'dw-fixel-style', get_stylesheet_uri() );
        wp_enqueue_style( 'font-awesome', DW_URI . 'assets/css/font-awesome.css' );
        wp_enqueue_style( 'print', DW_URI . 'assets/css/print.css', false,false, 'print' );
        wp_enqueue_style( 'jquery-mcustomScrollbar', DW_URI . 'assets/css/jquery.mCustomScrollbar.css' );
        wp_enqueue_style( 'prettify', DW_URI . 'assets/prettyprint/prettify.css' );
        wp_enqueue_script( 'plusone', 'https://apis.google.com/js/plusone.js', false, false, true );
        wp_enqueue_script( 'jquery' );   
        wp_enqueue_script( 'modernizr', DW_URI . 'assets/js/modernizr.js', array('jquery'), $version, true );
        wp_enqueue_script( 'bootstrap', DW_URI . 'assets/js/bootstrap.js', array('jquery'), $version, true );
        wp_enqueue_script( 'masonry', DW_URI . 'assets/js/masonry.js', array('jquery'), $version, true );
        //Showmore type on archive page
        $show_more_type = dw_get_theme_option('show_more_type', 'infinite');
        if( 'infinite' ==  $show_more_type ) {
            wp_enqueue_script( 'infinitescroll', DW_URI . 'assets/js/jquery.infinitescroll.min.js', array('jquery'), $version, true );
        }
        wp_enqueue_script( 'jquery-mcustomScrollbar', DW_URI . 'assets/js/jquery.mCustomScrollbar.concat.min.js', array('jquery'), $version, true  );
        wp_enqueue_script( 'dw-fixel', DW_URI . 'assets/js/main.js', array( 'jquery', 'modernizr', 'bootstrap', 'masonry' ), $version, true  );
        wp_enqueue_script( 'prettify', DW_URI . 'assets/prettyprint/prettify.js', false, false, true  );
        $current_url = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
        $current_url = remove_query_arg( 'paged', $current_url );
        $dw = array(
            'ajax_url'      => admin_url( 'admin-ajax.php' ),
            'current_url'   => $current_url,
            'is_single'     => is_single(),
            'site_url'      => site_url(),
            'theme_url'     => DW_URI,
            'show_more_type'=> $show_more_type    
        );
        wp_localize_script( 'dw-edit-layout', 'dw', $dw );
        wp_localize_script( 'dw-fixel', 'dw', $dw );
        if ( ! is_404() && have_posts() && comments_open() )
            wp_enqueue_script( 'comment-reply' );
    }
    add_action( 'wp_enqueue_scripts', 'dw_enqueue_scripts' );
}

if( ! function_exists('dw_admin_enqueue_scripts') ) {
    function dw_admin_enqueue_scripts() {
        global $pagenow, $typenow;   
        $version = 1389776043;
        if( $pagenow == 'post.php' && $typenow == 'page' ) {
            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'wp-color-picker' );
            wp_enqueue_style( 'wp-color-picker' );

            wp_enqueue_script( 'dw-admin-scripts', DW_URI . 'assets/js/wp-admin.js', array('jquery', 'wp-color-picker'), $version, true  );
        }
    }
    add_action( 'admin_enqueue_scripts', 'dw_admin_enqueue_scripts' );
}

if( ! function_exists('dw_fixel_setup') ) {
    function dw_fixel_setup() {
        load_theme_textdomain( 'dw', get_template_directory() . '/languages' );
        add_editor_style();
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'post-formats', array( 'gallery', 'video' ) );
        register_nav_menu( 'primary', __( 'Primary Menu', 'dw' ) );
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 598, 598 ); // Unlimited height, soft crop
    }
    add_action( 'after_setup_theme', 'dw_fixel_setup' );
}

if( ! function_exists('dw_homepage_endloop') ) {
    function dw_homepage_endloop(){
        global $rewind;
        $rewind = true;
    }
    add_action( 'loop_end', 'dw_homepage_endloop' );
}

if( ! function_exists('dw_comment') ) {
    function dw_comment( $comment, $args, $depth ) {
        $GLOBALS['comment'] = $comment;
        switch ( $comment->comment_type ) :
            case 'pingback' :
            case 'trackback' :
            // Display trackbacks differently than normal comments.
        ?>
        <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
            <p><?php _e( 'Pingback:', 'twentytwelve' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?></p>
        <?php
                break;
            default :
            // Proceed with normal comments.
            global $post;
        ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php if ( '0' == $comment->comment_approved ) : ?>
                <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'dw' ); ?></p>
            <?php endif; ?>
            <article id="comment-<?php comment_ID(); ?>" class="comment">
                  <div class="comment-avatar round-img">
                    <?php echo get_avatar( $comment, 46 ); ?>
                  </div>
                  <div class="comment-meta">

                    <?php  
                        $url    = get_comment_author_url( $comment->comment_ID );
                        $author = get_comment_author( $comment->comment_ID );
                        if ( empty( $url ) || 'http://' == $url ) {
                            if ( !empty($comment->user_id) ){
                                $author_link = "<a href='".get_author_posts_url( $comment->user_id )."' rel='external nofollow' class='url'>$author</a>"; 
                            } else {
                                $author_link = $author;
                            }
                        } else {
                            $author_link = "<a href='$url' rel='external nofollow' class='url'>$author</a>";
                        }
                    ?>
                    <?php echo $author_link ?>  <i class="icon-time"></i>&nbsp;<time><?php echo get_comment_date() . ' ' . __('at','dw') . ' ' . get_comment_time() ?> </time>
                  </div>
                  <div class="comment-body">
                    <?php comment_text(); ?>
                    <?php edit_comment_link( __( 'Edit', 'dw' ), '<p class="edit-link">', '</p>' ); ?>
                  </div>
                  <div class="comment-reply">
                    <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( '<i class="icon-reply"></i> Reply', 'dw' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                </div><!-- .reply -->
            </article><!-- #comment-## -->
        <?php
            break;
        endswitch; // end comment_type check
    }
}


if( ! function_exists('dw_is_featured_post') ) {
    function dw_is_featured_post( $post_id = null ){
        if( ! $post_id ) {
            $post_id = get_the_ID();
        }
        $featured = get_post_meta( $post_id, '_dw_featured_post', true );
        if( $featured ) {
            return true;
        } 
        return false;
    }
}

if( ! function_exists('dw_add_post_featured_setting') ) {
    function dw_add_post_featured_setting(){
        add_meta_box( 'dw-featured-setting', __('Set featured post','dw'), 'dw_add_post_featured_setting_html', 'post', 'side', 'high' );
    }
    add_action( 'admin_init', 'dw_add_post_featured_setting' );
}

if( ! function_exists('dw_add_post_featured_setting_html') ) {
    function dw_add_post_featured_setting_html( $post ){
        $feature = get_post_meta( $post->ID, '_dw_featured_post', true );
        echo '<p><label for="dw-featured-post"><input '.checked( true, $feature, false ).' id="dw-featured-post" type="checkbox" value="1" name="dw-featured-post">&nbsp;<span class="description">'.__('Set this post as feature and will display with big size of block','dw').'</span></label>';
    }
}

if( ! function_exists('dw_add_post_featured_save_setting') ) {
    function dw_add_post_featured_save_setting( $post_id ) {

        if ( !wp_is_post_revision( $post_id ) && ( ! isset($_POST['autosave']) || ! $_POST['autosave']) ) {

            if( isset($_POST['dw-featured-post']) && $_POST['dw-featured-post'] ) {
                $feature = true;
            } else {
                $feature = false;
            }
            update_post_meta( $post_id, '_dw_featured_post', $feature );
        }
    }
    add_action( 'save_post', 'dw_add_post_featured_save_setting' );
}

if( ! function_exists('dw_content_video') ) {
    function dw_content_video_thumbnail( $post_id = null ) {
        if( ! $post_id ) {
            $post_id = get_the_ID();
        }
        if( has_post_thumbnail( $post_id ) ) {
            $thumbnail = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
            if( $thumbnail ) {
                return $thumbnail;
            }
        }
        $post = get_post( $post_id );
        $post_video_thumbnail = maybe_unserialize(  get_post_meta( $post_id, '_video_thumbnail', true ) );
        if( preg_match('#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#', $post->post_content, $matches ) ) {
            $thumbnail = 'http://img.youtube.com/vi/'.$matches[0].'/0.jpg';
            $post_video_thumbnail[ 'youtube-'.$matches[0] ] = $thumbnail;
            update_post_meta( $post_id, '_video_thumbnail', $post_video_thumbnail );
            return $thumbnail;
        }
        if( preg_match('/[vimeo\.com|player\.vimeo\.com\/video]\/([0-9]+)[^&\n]+/', $post->post_content, $matches  ) ) {
            $vimeo_id = $matches[1];
            if( isset($post_video_thumbnail['vimeo-'.$vimeo_id]) 
                && $post_video_thumbnail['vimeo-'.$vimeo_id] ) {
                return $post_video_thumbnail['vimeo-'.$vimeo_id];
            } 
            $thumbnail = dw_content_get_vimeo( $vimeo_id );
            $post_video_thumbnail[ 'vimeo-'.$vimeo_id ] = $thumbnail;
            update_post_meta( $post_id, '_video_thumbnail', serialize($post_video_thumbnail) );
            return $thumbnail;
        }
    }
}

if( ! function_exists('dw_content_get_vimeo') ) {
    function dw_content_get_vimeo( $vimeo_id ) {
        $vimeo = dw_file_get_content( 'http://vimeo.com/api/v2/video/'.$vimeo_id.'.json' );
        return $vimeo[0]->thumbnail_large;
    }
}

if( ! function_exists('dw_gallery_shortcode') ) {
    function dw_gallery_shortcode($attr) {
        $post = get_post();
        static $instance = 0;
        $instance++;
        if ( ! empty( $attr['ids'] ) ) {
            // 'ids' is explicitly ordered, unless you specify otherwise.
            if ( empty( $attr['orderby'] ) )
                $attr['orderby'] = 'post__in';
            $attr['include'] = $attr['ids'];
        }
        // Allow plugins/themes to override the default gallery template.
        $output = apply_filters('post_gallery', '', $attr);
        if ( $output != '' )
            return $output;
        // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
        if ( isset( $attr['orderby'] ) ) {
            $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
            if ( !$attr['orderby'] )
                unset( $attr['orderby'] );
        }
        extract(shortcode_atts(array(
            'order'      => 'ASC',
            'orderby'    => 'menu_order ID',
            'id'         => $post->ID,
            'itemtag'    => 'li',
            'icontag'    => 'dt',
            'captiontag' => 'dd',
            'columns'    => 3,
            'size'       => 'thumbnail',
            'include'    => '',
            'exclude'    => ''
        ), $attr));
        $id = intval($id);
        if ( 'RAND' == $order )
            $orderby = 'none';
        if ( !empty($include) ) {        
            $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
            $attachments = array();
            foreach ( $_attachments as $key => $val ) {
                $attachments[$val->ID] = $_attachments[$key];
            }
        } elseif ( !empty($exclude) ) {
            $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
        } else {
            $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
        }
        if ( empty($attachments) )
            return '';
        if ( is_feed() ) {
            $output = "\n";
            foreach ( $attachments as $att_id => $attachment )
                $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
            return $output;
        }
        $itemtag = tag_escape($itemtag);
        $captiontag = tag_escape($captiontag);
        $columns = intval($columns);
        $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
        $float = is_rtl() ? 'right' : 'left';
        $selector = "gallery-{$instance}";
        $gallery_style = $gallery_div = '';
        $size_class = sanitize_html_class( $size );
        $gid = rand(1,15);
        $carousel_div = "<div id='gallery-{$id}{$gid}' class='gallery carousel slide'> <div class='carousel-inner'>";
        $output .= apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $carousel_div );
        $i = 0;
        $thumbnails = array();
        foreach ( $attachments as $img_id => $attachment ) {
            $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($img_id, $size, false, false) : wp_get_attachment_link($img_id, $size, true, false);
            $full_url= wp_get_attachment_image_src( $img_id,'full');
            $thumb_url= wp_get_attachment_image_src( $img_id, $size );
            $thumbnails[] = $thumb_url;
            $output .= "<div class='item";
            if( $i == 0 ) {
                $output .= ' active';
                $i++;
            }
            $output .= "'>";
            $output .= "<img src='".$full_url[0]."' />";
            $output .= "</div>";
        }
        $output .= " </div>";
        $a = 1;
        $catt = count($attachments);
        $output .= ' <ol class="carousel-indicators">';
        $output .= "<li data-target='#dgallery-{$id}{$gid}' data-slide-to='0' class='active'></li>";
        while( $a < $catt ) {
            $output .= "<li data-target='#dgallery-{$id}{$gid}' data-slide-to=".$a."></li>";
            $a++;       
        }
        $output .= '</ol>';
        $output .= '<a class="carousel-control left" href="#gallery-'.$id.$gid.'" data-slide="prev"><i class="icon-chevron-left"></i></a>
        <a class="carousel-control right" href="#gallery-'.$id.$gid.'" data-slide="next"><i class="icon-chevron-right"></i></a>';
        $output .= "</div>";
        return $output;
    }
    remove_shortcode('gallery', 'gallery_shortcode');
    add_shortcode('gallery', 'dw_gallery_shortcode');
}

if( ! function_exists('dw_paging_nav') ) {
    function dw_paging_nav() {
        global $wp_query, $paged;
        wp_link_pages( array() );
        if ( $wp_query->max_num_pages < 1 ) {
            return; 
        }
        ?>
        <nav class="navigation paging-navigation" role="navigation">
            <div class="nav-links">
                <div class="nav-next">
                    <?php if ( get_next_posts_link() ) : ?>
                    <?php next_posts_link( __( '<i class="icon-chevron-right"></i>' ) ); ?>
                    <?php else: ?>
                    <span class="btn next-pev disabled"><i class="icon-chevron-right"></i></span>
                    <?php endif; ?>
                </div>
                <div class="nav-previous">
                    <?php if ( get_previous_posts_link() ) : ?>
                    <?php previous_posts_link( __( '<i class="icon-chevron-left"></i>' ) ); ?>
                    <?php else: ?>
                    <span class="btn next-pev disabled"><i class="icon-chevron-left"></i></span>
                    <?php endif; ?>
                </div>
                <div class="nav-current-page">
                    <?php printf('Page %d of %d', $paged, $wp_query->max_num_pages) ?>
                </div>       
            </div>
        </nav>
        <?php
    }
}

if( ! function_exists('dw_submit_contact') ) {
    function dw_submit_contact(){
        global $contact_error;
        if( ! isset($_POST['action']) || $_POST['action'] != 'submit-contact' ){
            return false;
        }
        $contact_error = array();
        $contact_error['success'] = false;
        if( !isset($_POST['_wpnonce']) || ! wp_verify_nonce( $_POST['_wpnonce'], '_dw_contact_form_nonce' ) ) {
            $contact_error[] = __('Are you cheating huh?','dw');
            return false;
        }
        if( ! isset($_POST['clientname']) || ! $_POST['clientname'] ) {
            $contact_error['name'] = __('Your name','dw');
        }
        if( ! isset($_POST['clientemail']) || ! is_email( $_POST['clientemail'] ) ) {
            $contact_error['email'] = __('Your email','dw');        }
        if( ! isset($_POST['clientmsg']) || ! $_POST['clientmsg'] ) {
            $contact_error['msg']   = __('Your message','dw');
        }
        $to = get_option('admin_email');
        $headers = 'From: <'.$_POST['clientemail'].'>' . "\r\n";
        $subject = sprintf('%s %s',
                __('You have received an email from ','dw'),
                $_POST['clientemail']
            );
        $action = wp_mail( 
            $to, 
            $subject, 
            $_POST['clientmsg'],
            $headers
        );
        if( $action ) {
            $contact_error['success'] = true;
            $contact_error['message'] = __('Thanks for contacting us! Your message has been successfully sent. We will check and get back to you as soon as possible.','dw');
        } else {
            $contact_error['sending'] = __('Failed to send your message. Please try later or contact the administrator by another method.','dw') ;
        }
    }
    add_action( 'wp', 'dw_submit_contact' );
}

if( ! function_exists('dw_update_social_homepage_settings') ) {
    function dw_update_social_homepage_settings(){
        if( !isset($_POST['action']) || $_POST['action'] != 'update-social-homepage-setting' ) {
            return false;
        }
        if( ! isset($_POST['_wpnonce']) || ! wp_verify_nonce( $_POST['_wpnonce'], '_dw_update_social_homepage_setting' ) ) {
            return false;
        }
        if( ! isset($_POST['dw_theme_options']) ) {
            return false;
        }
        $theme_options = get_option( 'dw_theme_options' );
        foreach ($_POST['dw_theme_options'] as $key => $value) {
            $theme_options[$key]    = $value;
        }
        update_option( 'dw_theme_options', $theme_options );
    }
    add_action( 'init', 'dw_update_social_homepage_settings' );
}

if( ! function_exists('dw_show_more_button') ) {
    function dw_show_more_button(){
        $show_more_type = dw_get_theme_option('show_more_type', 'infinite');
        if( 'button' == $show_more_type ) {
            global $wp_query;
            if( $wp_query->query_vars['posts_per_page'] < $wp_query->found_posts ) {
            ?>
            <div class="show-more"><a href="#" class="btn button-add-content" data-query-var="<?php echo  http_build_query( $wp_query->query_vars ); ?>" data-paged="<?php echo $wp_query->query_vars['paged'] ?>"><?php _e('Show More','dw') ?></a></div>
            <?php   
            }
        }
    } 
}

if( ! function_exists('dw_file_get_content') ) {
    function dw_file_get_content( $url ){
        $content = wp_remote_get( $url );
        return wp_remote_retrieve_body( $content );
    }
}

if( ! function_exists('dw_contact_form') ) {
    function dw_contact_form() {
        global $contact_error;
        ob_start();
        ?>
            <form class="contact-form" action="<?php echo get_permalink() ?>" method="post" >
                <?php if( ! empty($contact_error) && $contact_error['success'] == false ) : ?>
                <div class="alert alert-block alert-error fade in">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?php  
                        unset($contact_error['success']);
                        foreach ( $contact_error as $err ) {
                            echo '<span> *'.$err.'</span><br>';
                        }
                    ?>
                </div>
                <?php endif; ?>
                <?php if( ! empty($contact_error) && $contact_error['success'] != false ) : ?>
                <div class="alert alert-block alert-success fade in">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?php echo $contact_error['message'] ?>
                </div>
                <?php endif; ?>
                <?php wp_nonce_field( '_dw_contact_form_nonce' ) ?>
                <input type="hidden" name="action" value="submit-contact">
                <div class="control-group">
                    <label for="clientname"><?php _e('Name','dw') ?></label>
                    <div class="controls">
                        <input type="text" id="clientname" name="clientname" placeholder="<?php _e('Your name...','dw') ?>" required="required" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="clientname"><?php _e('Email','dw') ?></label>
                    <div class="controls">
                        <input type="email" id="clientemail" name="clientemail" placeholder="<?php _e('Your email address...','dw') ?>" required="required"  />
                    </div>
                </div>
                <div class="control-group">
                    <label for="clientname"><?php _e('Website','dw') ?></label>
                    <div class="controls">
                        <input type="text" id="clienturl" name="clienturl" placeholder="<?php _e('Your website url ...','dw') ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="clientname"><?php _e('Message','dw') ?></label>
                    <div class="controls">
                        <textarea type="text" id="clientmsg" name="clientmsg" placeholder="<?php _e('Your message...','dw') ?>" required="required" /></textarea>
                    </div>
                </div>
                <button type="submit" class="btn"><?php _e('Send','dw') ?></button>
            </form>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
    add_shortcode( 'dw_contact_form', 'dw_contact_form' );
}

// load style for dw qa plugin
if( !function_exists('dwqa_fixel_scripts') ){
    function dwqa_fixel_scripts(){
        wp_enqueue_style( 'dw-fixel-qa', get_stylesheet_directory_uri() . '/dwqa-templates/style.css' );
    }
    add_action( 'wp_enqueue_scripts', 'dwqa_fixel_scripts' );
}

// FB meta social share
if( ! function_exists('dw_fixel_fb_meta') ) {
    function dw_fixel_fb_meta() {
        if( is_single() ){
            global $post;
            echo '<meta property="og:title" content="'.get_the_title().'" />';
            echo '<meta property="og:url" content="'.get_permalink().'" />';
            if( has_post_thumbnail() ) {
                $thumb_id = get_post_thumbnail_id();
                $thumb = wp_get_attachment_image_src( $thumb_id, 'full' );
                echo '<meta property="og:image" content="'.$thumb[0].'" />';   
            }
            echo '<meta property="og:description" content="'. esc_html( get_the_excerpt() ) .'"/>';
        }
    }
    add_action('wp_head', 'dw_fixel_fb_meta');
}

add_action( 'init', 'create_post_type' );
function create_post_type() {
    $labels = array(
        'name'               => _x( 'Members', 'post type general name', 'your-plugin-textdomain' ),
        'singular_name'      => _x( 'Member', 'post type singular name', 'your-plugin-textdomain' ),
        'menu_name'          => _x( 'Members', 'admin menu', 'your-plugin-textdomain' ),
        'name_admin_bar'     => _x( 'Member', 'add new on admin bar', 'your-plugin-textdomain' ),
        'add_new'            => _x( 'Add New', 'book', 'your-plugin-textdomain' ),
        'add_new_item'       => __( 'Add New Member', 'your-plugin-textdomain' ),
        'new_item'           => __( 'New Member', 'your-plugin-textdomain' ),
        'edit_item'          => __( 'Edit Member', 'your-plugin-textdomain' ),
        'view_item'          => __( 'View Member', 'your-plugin-textdomain' ),
        'all_items'          => __( 'All Members', 'your-plugin-textdomain' ),
        'search_items'       => __( 'Search Members', 'your-plugin-textdomain' ),
        'parent_item_colon'  => __( 'Parent Members:', 'your-plugin-textdomain' ),
        'not_found'          => __( 'No members found.', 'your-plugin-textdomain' ),
        'not_found_in_trash' => __( 'No members found in Trash.', 'your-plugin-textdomain' )
    );

    $args = array(
        'public' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'show_in_nav_menus' => false,
        'menu_icon' => 'dashicons-admin-users',
        'menu_position' => 21,

        'labels'             => $labels,
        'supports'           => array( 'title', 'excerpt' ),
        'show_in_rest'       => true
    );

    register_post_type( 'member', $args );

    $labels = array(
        'name'               => _x( 'Supporters', 'post type general name', 'your-plugin-textdomain' ),
        'singular_name'      => _x( 'Supporter', 'post type singular name', 'your-plugin-textdomain' ),
        'menu_name'          => _x( 'Supporters', 'admin menu', 'your-plugin-textdomain' ),
        'name_admin_bar'     => _x( 'Supporter', 'add new on admin bar', 'your-plugin-textdomain' ),
        'add_new'            => _x( 'Add New', 'book', 'your-plugin-textdomain' ),
        'add_new_item'       => __( 'Add New Supporter', 'your-plugin-textdomain' ),
        'new_item'           => __( 'New Supporter', 'your-plugin-textdomain' ),
        'edit_item'          => __( 'Edit Supporter', 'your-plugin-textdomain' ),
        'view_item'          => __( 'View Supporter', 'your-plugin-textdomain' ),
        'all_items'          => __( 'All Supporters', 'your-plugin-textdomain' ),
        'search_items'       => __( 'Search Supporters', 'your-plugin-textdomain' ),
        'parent_item_colon'  => __( 'Parent Supporters:', 'your-plugin-textdomain' ),
        'not_found'          => __( 'No supporters found.', 'your-plugin-textdomain' ),
        'not_found_in_trash' => __( 'No supporters found in Trash.', 'your-plugin-textdomain' )
    );

    $args = array(
        'public' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'show_in_nav_menus' => false,
        'menu_icon' => 'dashicons-admin-users',
        'menu_position' => 22,

        'labels'             => $labels,
        'supports'           => array( 'title', 'excerpt' ),
        'show_in_rest'       => true
    );

    register_post_type( 'supporter', $args );
}
