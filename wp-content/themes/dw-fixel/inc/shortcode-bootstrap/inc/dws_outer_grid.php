<?php 
/**
 *DesignWall shortcodes outer grid
 *@package DesignWall Shorcodes
 *@since 1.0
*/

function dws_outer_wrapper( $params, $content ) {
    $content = preg_replace('/<br class="nc".\/>/', '', $content);
    $result = '<div class="grid-wrap">';
    $result .= do_shortcode($content );
    $result .= '</div>'; 
    return force_balance_tags( $result );
}
add_shortcode('col_grid_wrap', 'dws_outer_wrapper');
/**
 * Row
 */
function dws_outer_row($params, $content = null){
    $content = preg_replace('/<br class="nc".\/>/', '', $content);
    $result = '<div class="col-grid">';
    $result .= do_shortcode($content );
    $result .= '</div>'; 
    return force_balance_tags( $result );
}
add_shortcode('col_grid', 'dws_outer_row');

/**
 * Col span
 */
function dws_outer_col($params,$content=null){
    extract(shortcode_atts(array(
        'class' => 'col-1',
        'padding' => 'no'
        ), $params));
    $padding = ! $padding || $padding != 'yes' ? 'no-padding' : '';
    $result = '<div class="'.$class.' ' .$padding. '">';
    $result .= do_shortcode($content );
    $result .= '</div>'; 
    return force_balance_tags( $result );
}
add_shortcode('col_size', 'dws_outer_col');