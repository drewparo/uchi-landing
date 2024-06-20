<?php

/**
 * Post Type: Title Wrapper
 * Register Custom Post Type
 */

register_post_type( 'liquid-title-wrapper',
    array(
		'labels' => array(
			'name' => esc_html__( 'Title Wrapper', 'aihub-core' ),
			'menu_position' => 2,
		),
    'public' => true,
    'has_archive' => false,
	'exclude_from_search' => true,
	'capability_type' => 'page',
    'show_in_menu' => 'liquid-templates-library',
    )
);