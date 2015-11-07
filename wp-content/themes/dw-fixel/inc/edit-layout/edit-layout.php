<?php  

if( ! function_exists('dw_block_edit_buttons') ) {
    function dw_block_edit_buttons(){
        if( current_user_can( 'manage_options' ) ) {
            global $block_class;
        ?>
        <div class="edit-mask">
            <div class="edit-post">
                <a href="#delete" title="Remove"><i class="icon-remove"></i></a>
                <a href="#edit" title="Edit"><i class="icon-pencil"></i></a>
                <a href="#resize" title="Resize"><i class="icon-resize-<?php echo strpos($block_class, 'w2') !== false ? 'small' : 'full' ?>"></i></a>
            </div>
        </div>
        <?php 
        }
    }
    add_action( 'dw_block_content_footer', 'dw_block_edit_buttons' );
}

if( ! function_exists('dw_enqueue_edit_layout_scripts') ) {
    function dw_enqueue_edit_layout_scripts(){
        if( is_home() && current_user_can( 'manage_options' ) ) {
            wp_enqueue_style( 'dw-edit-layout', DW_URI.'inc/edit-layout/assets/edit-layout.css' );

            $dw = array(
                'ajax_url'      => admin_url( 'admin-ajax.php' ),
                'is_single'     => is_single(),
                'site_url'      => site_url(),
                'theme_url'     => DW_URI
            );
            wp_enqueue_script( 'jquery-ui-draggable' );
            wp_enqueue_script( 'jquery-ui-droppable' );
            wp_enqueue_media();
            wp_enqueue_script( 'dw-edit-layout', DW_URI . 'inc/edit-layout/assets/edit-layout.js', array('jquery', 'jquery-ui-draggable', 'jquery-ui-droppable'), false );
            wp_localize_script( 'dw-edit-layout', 'dw', $dw );
        }
    }
    add_action( 'wp_enqueue_scripts', 'dw_enqueue_edit_layout_scripts' );
}

if( ! function_exists('dw_edit_welcome_box_ajax') )  {
    function dw_edit_welcome_box_ajax(){
        if( current_user_can( 'manage_options' ) ) {
            $homepage_options = get_option( 'dw_homepage_options' );

            if( isset($_POST['heading1st']) ) {
                $homepage_options['welcome-box-heading-1'] = $_POST['heading1st'];
            } 
            if( isset($_POST['heading2nd']) ) {
                $homepage_options['welcome-box-heading-2'] = $_POST['heading2nd'];
            } 
            if( isset($_POST['info']) ) {
                $homepage_options['welcome-box-short-intro'] = $_POST['info'];
            } 

            update_option( 'dw_homepage_options', $homepage_options );
        }
    }
    add_action( 'wp_ajax_dw-save-welcome-box', 'dw_edit_welcome_box_ajax' );
}
?>