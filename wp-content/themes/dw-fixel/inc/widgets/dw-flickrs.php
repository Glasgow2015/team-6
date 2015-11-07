<?php  
/**
 * DW Flickrs widget class
 *
 * @since 2.8.0
 */
class dw_flickrs extends WP_Widget {

    function __construct() {
        
        $widget_ops = array('classname' => 'dw_flickrs flickr', 'description' => __( "Display a gallery of flickrs images",'dw') );
        parent::__construct('dw_flickrs', __('DW : Flickr Gallery','dw'), $widget_ops);
        $this->alt_option_name = 'widget_recent_entries';

    }

    function widget($args, $instance) {
        extract( $args, EXTR_SKIP );
        $instance = wp_parse_args( $instance, array(
            'title'     => '',
            'number'    => 12,
            'flickr_id' => ''
        ) );

        if( $instance['flickr_id'] ) {
            echo $before_widget;
            echo $before_title;
            echo $instance['title']; // Can set this with a widget option, or omit altogether
            echo $after_title;

            $flickrs = get_flickrs( $instance['flickr_id'] ); $i = 0;
            if( ! empty($flickrs) ) {
            ?>
            <ul>
            <?php
                foreach ( $flickrs as $flickr ) { 
                    $i++;
                    if( $i > $instance['number'] ) {
                        break;
                    }
            ?>
                <li><a target="_blank" href="<?php echo $flickr['url'] ?>" ><img src="<?php echo $flickr['t_url']; ?>" /></a></li>
                <?php } ?>
            </ul>
            <?php
            }

            echo $after_widget;
        }
    }

    function update( $new_instance, $old_instance ) {
        return $new_instance;
    }

    function form( $instance ) {
        extract( wp_parse_args( $instance, array(
            'title'     => '',
            'number'    => 12,
            'flickr_id' => ''
        ) ) );
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','dw_focus'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('flickr_id'); ?>"><?php _e('Flickr ID','dw_focus'); ?><input class="widefat" id="<?php echo $this->get_field_id('flickr_id'); ?>" name="<?php echo $this->get_field_name('flickr_id'); ?>" type="text" value="<?php echo $flickr_id; ?>" /></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number','dw_focus'); ?><input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" /></label>
        </p>
<?php
    }


}

add_action( 'widgets_init', create_function( '', "register_widget('dw_flickrs');" ) );
?>