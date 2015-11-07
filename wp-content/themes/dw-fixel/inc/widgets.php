<?php
if( ! function_exists('dw_widgets_init') ) {
    function dw_widgets_init() {
        register_sidebar( array(
            'name' => __( 'Single sidebar', 'dw' ),
            'id' => 'dw-single-sidebar',
            'description' => __( 'Single sidebar', 'dw' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );
        register_sidebar( array(
            'name' => __( 'Top 1', 'dw' ),
            'id' => 'dw-top-1',
            'description' => __( 'Appears on top', 'dw' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );
        register_sidebar( array(
            'name' => __( 'Top 2', 'dw' ),
            'id' => 'dw-top-2',
            'description' => __( 'Appears on top', 'dw' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );
        register_sidebar( array(
            'name' => __( 'Top 3', 'dw' ),
            'id' => 'dw-top-3',
            'description' => __( 'Appears on top', 'dw' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );
        register_sidebar( array(
            'name' => __( 'Top 4', 'dw' ),
            'id' => 'dw-top-4',
            'description' => __( 'Appears on top', 'dw' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );
    }
    add_action( 'widgets_init', 'dw_widgets_init' );
}