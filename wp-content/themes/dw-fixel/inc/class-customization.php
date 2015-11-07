<?php  
include_once ABSPATH . 'wp-includes/class-wp-customize-control.php';

class dw_customize_layout_control extends WP_Customize_Control {
    public function render_content(){
        if ( empty( $this->choices ) )
            return;

        $name = '_customize-radio-' . $this->id;

        ?>
        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <div class="select-layout-box">
            <label id="right-sidebar-setting"  class="right-sidebar-label <?php echo $this->value() == 'right-sidebar' ? 'active' : '' ?>">
                <i class="icon-right-sidebar"></i><br>
                <input type="radio" value="right-sidebar" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), 'right-sidebar' ); ?> />
                <small><?php _e('Right Sidebar',DW_TEXT_DOMAIN) ?></small><br/>
            </label>
            <label id="left-sidebar-setting" class="left-sidebar-label <?php echo $this->value() == 'left-sidebar' ? 'active' : '' ?>">
                <i class="icon-left-sidebar"></i><br>
                <input type="radio" value="left-sidebar" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), 'left-sidebar' ); ?> />
                <small><?php _e('Left Sidebar',DW_TEXT_DOMAIN) ?></small><br/>
            </label>
        </div> 
        <?php
    }
}

class dw_customize_textarea extends WP_Customize_Control {
    public function render_content() {
        ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <textarea class="widefat" <?php $this->link(); ?> ><?php echo esc_attr( $this->value() ); ?></textarea>
        </label>
        <?php
    }
}

class dw_customize_color extends WP_Customize_Control {
    public function render_content() {
    ?>

    <label>
        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <input type="text" class="color-picker" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" /> 
    </label>
    <?php
    }
}


?>