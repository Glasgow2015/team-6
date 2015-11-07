<?php

function dw_register_meta_boxes() {
	$prefix = 'dw_';
	$meta_boxes = array();

	$meta_boxes[] = array(
		'title' => __('Gallery','dw'),
		'pages' => array( 'post' ),
		'fields' => array(
			array(
				'name'             => __('Product Images','dw'),
				'id'               => "{$prefix}product_images",
				'type'             => 'plupload_image',
				'max_file_uploads' => 15,
			),
		),
	);

	foreach ( $meta_boxes as $meta_box ) {
		new RW_Meta_Box( $meta_box );
	}
}
add_action( 'admin_init', 'dw_register_meta_boxes' );