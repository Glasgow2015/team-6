<?php
class DesignwallShortcodes{
	
	function __construct()
	{
		//require_once('shortcodes.php');
		add_action('init',array(&$this, 'init'));
		add_action('admin_init', array(&$this, 'dwsc_init'));
		add_action( 'admin_enqueue_scripts', array(&$this, 'enqueue_script') );
	}
	
	function init(){
		$options = get_option('dwsc_options');
		if( is_admin() ){
			wp_enqueue_style("dws_admin_style", DW_URI . 'inc/shortcode-bootstrap/assets/css/admin.css');
		}

		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
	    	return;
		}
	 
		if ( get_user_option('rich_editing') == 'true' ) {
		
			add_filter( 'mce_external_plugins', array(&$this, 'regplugins') );
			add_filter( 'mce_buttons_3', array(&$this, 'regbtns') );
			add_filter("mce_buttons", array( &$this, "enable_more_buttons" ) );

		}
	}

	function regbtns($buttons)
	{
		array_push($buttons, 'dws_grid');
		array_push($buttons, 'dws_outer_grid');
		array_push($buttons, 'dws_alerts');
		array_push($buttons, 'dws_buttons');
		array_push($buttons, 'dws_icons');
		array_push($buttons, 'dws_tabs');
		array_push($buttons, 'dws_collapse');
		array_push($buttons, 'dws_table');
		return $buttons;
	}

	function regplugins($plgs)
	{
		
		$plgs['dws_grid'] = DW_URI . 'inc/shortcode-bootstrap/assets/js/plugins/grid.js';
		$plgs['dws_outer_grid'] = DW_URI . 'inc/shortcode-bootstrap/assets/js/plugins/outer_grid.js';
		$plgs['dws_alerts'] = DW_URI . 'inc/shortcode-bootstrap/assets/js/plugins/alert.js';
		$plgs['dws_buttons'] = DW_URI . 'inc/shortcode-bootstrap/assets/js/plugins/buttons.js';
		$plgs['dws_tabs'] = DW_URI . 'inc/shortcode-bootstrap/assets/js/plugins/tabs.js';
		$plgs['dws_icons'] = DW_URI . 'inc/shortcode-bootstrap/assets/js/plugins/icons.js';
		$plgs['dws_collapse'] = DW_URI . 'inc/shortcode-bootstrap/assets/js/plugins/collapse.js';
		$plgs['dws_table'] = DW_URI . 'inc/shortcode-bootstrap/assets/js/plugins/table.js';
		return $plgs;
	}

	/* Init plugin options to white list our options. */
	function dwsc_init(){
	
		register_setting( 'dwsc_plugin_options', 'dwsc_options' );

	}

	function enqueue_script(){
		wp_enqueue_script( 'dwsc-define', DW_URI . 'inc/shortcode-bootstrap/assets/js/dw-shortcode-bootstrap.js' );
		wp_localize_script( 'dwsc-define', 'dwsc', array(
			'plugin_url'	=> DW_URI . 'inc/shortcode-bootstrap/'
		) );
	}

	function enable_more_buttons($buttons) {
		$buttons[] = 'table';
		return $buttons;
	}


}
$dwcodes = new DesignwallShortcodes();