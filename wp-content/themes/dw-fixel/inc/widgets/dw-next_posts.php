<?php  
/**
 * DW Next Posts widget class
 *
 * @since 2.8.0
 */
class dw_next_posts extends WP_Widget {

    function __construct() {
        
        $widget_ops = array('classname' => 'dw_next_posts', 'description' => __( "Display a list of posts",'dw') );
        parent::__construct('dw_next_posts', __('DW : Next Posts','dw'), $widget_ops);
        $this->alt_option_name = 'widget_recent_entries';

    }

    function widget($args, $instance) {
        extract( $args, EXTR_SKIP );
        $instance = wp_parse_args( $instance, array(
            'title'     => '',
            'number'    => 5
        ) );

        global $post, $is_show_modal;

        if( is_single() || $is_show_modal ) {

            $previous_posts = $this->get_post_siblings( $instance['number'] );

            if ( !empty( $previous_posts ) ) {
                echo $before_widget;
                echo $before_title;
                echo $instance['title']; // Can set this with a widget option, or omit altogether
                echo $after_title;

                $i = 0;
                while( $i < $instance['number'] ) {
                    if( isset($previous_posts[$i]) ) {
                        $prev_post = $previous_posts[$i];
                    ?>
                    <article class="post">
                        <?php if( has_post_thumbnail( $prev_post->ID ) ) { ?>
                        <div class="entry-thumbnail">
                            <?php echo get_the_post_thumbnail($prev_post->ID, 'thumbnail'); ?>
                        </div>
                        <?php } ?>
                        <div class="entry-title">
                            <a data-toggle="modal" data-post-id="<?php echo $prev_post->ID; ?>" href="<?php echo get_permalink( $prev_post->ID ) ?>"><?php echo apply_filters( 'the_title', $prev_post->post_title ) ?></a>
                        </div>
                    </article>
                    <?php
                    } else {
                        break;
                    }
                    $i++;
                }
                echo $after_widget;
            }
            
        }
    }

    function update( $new_instance, $old_instance ) {
        return $new_instance;
    }

    function form( $instance ) {
        extract( wp_parse_args( $instance, array(
            'title'     => '',
            'number'    => 5
        ) ) );
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','dw_focus'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number','dw_focus'); ?><input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" /></label>
        </p>
<?php
    }


    function get_post_siblings( $limit = 5, $date = '' ) {
        global $wpdb, $post;


        if( empty( $date ) )
            $date = $post->post_date;

        $limit = absint( $limit );
        if( !$limit )
            return;
        $p = $wpdb->get_results( "
            SELECT  *
            FROM 
                $wpdb->posts p1 
            WHERE 
                p1.post_date < '{$date}' AND 
                p1.post_type = '{$post->post_type}' AND 
                p1.post_status = 'publish' 
            ORDER by 
                p1.post_date DESC
            LIMIT 
                $limit
        " );
        if( ! empty($p) )
            return $p;
        return false;
    }

    function dw_url_category_detect( $url ) {
        global $wp_rewrite;

        $url = apply_filters('dw_url_category_detect', $url);
        if( empty($url) ) {
            return false;
        }
        // First, check to see if there is a 'p=N' or 'page_id=N' to match against
        if ( preg_match('#[?&](cat)=(\d+)#', $url, $values) )   {
            $id = absint($values[2]);
            if ( $id )
                return $id;
        }

        // Check to see if we are using rewrite rules
        $rewrite = $wp_rewrite->wp_rewrite_rules();
        // Not using rewrite rules, and 'p=N' and 'page_id=N' methods failed, so we're out of options
        if ( empty($rewrite) )
            return 0;
        // Get rid of the #anchor
        $url_split = explode('#', $url);
        $url = $url_split[0];

        // Get rid of URL ?query=string
        $url_split = explode('?', $url);
        $url = $url_split[0];

        $site_url = site_url();
        // Add 'www.' if it is absent and should be there
        if ( false !== strpos($site_url, '://www.') && false === strpos($url, '://www.') )
            $url = str_replace('://', '://www.', $url);

        // Strip 'www.' if it is present and shouldn't be
        if ( false === strpos($site_url, '://www.') )
            $url = str_replace('://www.', '://', $url);

        // Strip 'index.php/' if we're not using path info permalinks
        if ( !$wp_rewrite->using_index_permalinks() )
            $url = str_replace('index.php/', '', $url);

        if ( false !== strpos($url, $site_url) ) {
            // Chop off http://domain.com
            $url = str_replace($site_url, '', $url);
        } else {
            // Chop off /path/to/blog
            $home_path = parse_url($site_url);
            $home_path = isset( $home_path['path'] ) ? $home_path['path'] : '' ;
            $url = str_replace($home_path, '', $url);
        }

        // Trim leading and lagging slashes
        $url = trim($url, '/');
        $url_split = explode('/', $url);
        $category = get_category_by_slug( $url_split[1] );
        
        if( $category ) {
            return $category->term_id;
        } 
        return 0;
    }


}

add_action( 'widgets_init', create_function( '', "register_widget('dw_next_posts');" ) );
?>