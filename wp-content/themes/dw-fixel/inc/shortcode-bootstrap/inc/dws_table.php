<?php 
/**
 *DesignWall shortcodes table
 *@package DesignWall Shorcodes
 *@since 1.0
*/

/**
 * Collapse
 */

function dws_table($params, $content = null){
    extract(shortcode_atts(array(
        'id'=>''
        ), $params));
    $content = preg_replace('/<br class="nc".\/>/', '', $content);
    $result = '<table class="table table-bordered" id="'.$id.'"><tbody>';
    $result .= do_shortcode($content );
    $result .= '</tbody></table>'; 
    return force_balance_tags( $result );
}
add_shortcode('table', 'dws_table');

function dws_tr($params, $content = null){
    $content = preg_replace('/<br class="nc".\/>/', '', $content);
    $result = '<tr>';
    $result .= do_shortcode($content );
    $result .= '</tr>'; 
    return force_balance_tags( $result );
}
add_shortcode('tr', 'dws_tr');

function dws_td($params, $content = null){
    extract(shortcode_atts(array(
        'width'=>''
        ), $params));
    $width = $width ? 'width="' . $width .'"' : '';
    $content = preg_replace('/<br class="nc".\/>/', '', $content);
    $result = '<td '.$width.'>';
    $result .= do_shortcode($content );
    $result .= '</td>'; 
    return force_balance_tags( $result );
}
add_shortcode('td', 'dws_td');
