<?php
/**
 * LiquidThemes Template Tags
 */

if( !defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

function liquid_site_title() {
	echo liquid_get_site_title();
}

function liquid_get_site_title() {

	if ( $title = get_bloginfo( 'name' ) ) {
		$title = sprintf( '<h1 %s><a href="%s" rel="home">%s</a></h1>', liquid_helper()->get_attr( 'site-title' ), esc_url( home_url() ), $title );
	}

	return apply_filters( 'liquid_site_title', $title );
}

function liquid_site_description() {
	echo liquid_get_site_description();
}

function liquid_get_site_description() {

	if ( $desc = get_bloginfo( 'description' ) ) {
		$desc = sprintf( '<h2 %s>%s</h2>', liquid_helper()->get_attr( 'site-description' ), $desc );
	}

	return apply_filters( 'liquid_site_description', $desc );
}


function get_liquid_content( $name = 'blog' ) {

	if ( have_posts() ) {
		get_template_part( 'templates/' . $name, 'layout' );
	} else {
		get_template_part( 'templates/content/error' );
	}
	
}

function liquid_get_content_template() {
	
	if( class_exists( 'bbPress' ) && is_bbpress() ) {
		return include( locate_template( 'templates/content/content-bbpress.php' ) );
	}

	// Set up an empty array and get the post type.
	$templates = array();
	$post_type = get_post_type();

	// Assume the theme developer is creating an attachment template.
	if ( 'attachment' === $post_type ) {

		$type = liquid_helper()->get_attachment_type();

		$templates[] = "templates/content/attachment-{$type}.php";
	}

	// If the post type supports 'post-formats', get the template based on the format.
	if ( post_type_supports( $post_type, 'post-formats' ) ) {

		// Get the post format.
		$post_format = get_post_format() ? get_post_format() : 'standard';

		// Template based off post type and post format.
		$templates[] = "templates/content/{$post_type}-{$post_format}.php";

		// Template based off the post format.
		$templates[] = "templates/content/{$post_format}.php";
	}

	// Template based off the post type.
	$templates[] = "templates/content/{$post_type}.php";

	// Fallback 'content.php' template.
	$templates[] = 'templates/content/content.php';

	// Apply filters to the templates array.
	$templates = apply_filters( 'liquid_content_template_hierarchy', $templates );

	// Locate the template.
	$template = locate_template( $templates );

	// If template is found, include it.
	if ( apply_filters( 'liquid_content_template', $template, $templates ) ) {
		include( $template );
	}
}
