<?php

/**
 * Post Type: Archives
 * Register Custom Post Type
 */

$labels = array(
	'name'                => esc_html__( 'Archive Layouts', 'landinghub-core' ),
	'singular_name'       => esc_html__( 'Archive', 'landinghub-core' ),
	'all_items'           => esc_html__( 'Archives', 'landinghub-core' ),
	'name_admin_bar'      => esc_html__( 'Archives', 'landinghub-core' ),
	'add_new_item'        => esc_html__( 'Add New Archive', 'landinghub-core' ),
	'new_item'            => esc_html__( 'New Archive', 'landinghub-core' ),
	'edit_item'           => esc_html__( 'Edit Archive', 'landinghub-core' ),
	'update_item'         => esc_html__( 'Update Archive', 'landinghub-core' ),
	'view_item'           => esc_html__( 'View Archive', 'landinghub-core' ),
	'search_items'        => esc_html__( 'Search Archive', 'landinghub-core' ),
);
$args = array(
	'label'               => esc_html__( 'Archive', 'landinghub-core' ),
	'labels'              => $labels,
	'supports'            => array( 'title', 'editor', 'revisions', ),
	'public'              => true,
	'has_archive'         => false,
	'hierarchical'        => true,
	'exclude_from_search' => true,
	'capability_type'     => 'page',
	'show_in_menu'        => 'liquid-templates-library',
);
register_post_type( 'liquid-archives', $args );
