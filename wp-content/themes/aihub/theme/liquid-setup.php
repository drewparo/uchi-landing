<?php
/**
 * LiquidThems Theme Framework
 */

if( !defined( 'ABSPATH' ) ) 
	exit; // Exit if accessed directly

// Custom Post Type Supports
add_theme_support( 'liquid-portfolio' );
add_theme_support( 'liquid-footer' );
add_theme_support( 'liquid-header' );
add_theme_support( 'liquid-mega-menu' );
add_theme_support( 'liquid-title-wrapper' );
add_theme_support( 'liquid-archives' );
if( liquid_helper()->is_woocommerce_active() ) {
	add_theme_support( 'liquid-product-layout' );
	add_theme_support( 'liquid-product-sizeguide' );
	add_theme_support( 'liquid-sticky-atc' );
}

// Custom Extensions
add_theme_support( 'liquid-extension', array(
	'mega-menu',
	'breadcrumb',
	'wp-editor',
	'menu-icons',
	'ai'
) );
add_post_type_support( 'post', 'liquid-post-likes' );

//Support Gutenberg
add_theme_support(
	'gutenberg',
	array( 'wide-images' => true )
);
add_theme_support( 'wp-block-styles' );
add_theme_support( 'responsive-embeds' );
add_theme_support( 'align-wide' );

if( function_exists( 'liquid_add_image_sizes' ) ) {
	liquid_add_image_sizes();
}

//Enable support for Post Formats.
//See http://codex.wordpress.org/Post_Formats
add_theme_support( 'post-formats', array(
	'audio', 'gallery', 'link', 'quote', 'video'
) );

// Sets up theme navigation locations.
register_nav_menus( array(
   'primary'   => esc_html__( 'Primary Menu', 'aihub' ),
   'secondary' => esc_html__( 'Secondary Menu', 'aihub' )
) );

// Register Widgets Area.
add_action( 'widgets_init', 'liquid_main_sidebar' );
function liquid_main_sidebar() {
	register_sidebar( array(
		'name'          => esc_html__( 'Main Sidebar', 'aihub' ),
		'id'            => 'main',
		'description'   => esc_html__( 'Main widget area to display in sidebar', 'aihub' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));
}