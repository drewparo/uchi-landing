<?php
/**
 * Liquid Themes Theme Framework
 */

if( !defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

/**
 * Table of content
 *
 * 1. Hooks
 * 2. Functions
 * 3. Template Tags
 */

// 1. Hooks ------------------------------------------------------
//

/**
 * [liquid_output_space_body description]
 * @method liquid_output_space_body
 * @return [type]                  [description]
 */
add_action( 'wp_footer', 'liquid_output_space_body', 999 );
function liquid_output_space_body() {

	echo liquid_helper()->get_kit_option( 'liquid_custom_code_before_body' );
}

/**
 * [liquid_attributes_footer description]
 * @method liquid_attributes_footer
 * @param  [type]                  $attributes [description]
 * @return [type]                              [description]
 */
add_filter( 'liquid_attr_footer', 'liquid_attributes_footer' );
function liquid_attributes_footer( $attributes ) {

	$attributes['class'] = 'lqd-site-footer';
	$attributes['id'] = 'lqd-page-footer-wrap';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'https://schema.org/WPFooter';

	return $attributes;

}

/**
 * [liquid_footer_backtotop description]
 * @method liquid_footer_backtotop
 * @return [type]                 [description]
 */
add_action( 'liquid_after_footer', 'liquid_footer_backtotop' );
function liquid_footer_backtotop() {

	return;

	$atts = array(
		'after'    => '</div>',
		'before'   => '<div class="local-scroll site-backtotop">',
		'href'     => '#wrap',
		'nofollow' => true,
		'text'     => esc_html__( 'Return to top of page', 'aihub' ),
	);
	$atts = apply_filters( 'liquid_footer_backtotop_defaults', $atts );

	$nofollow = $atts['nofollow'] ? 'rel="nofollow"' : '';

	printf( '%s<a href="%s" %s>%s</a>%s', $atts['before'], esc_url( $atts['href'] ), $nofollow, $atts['text'], $atts['after'] );
}

// 2. Functions ------------------------------------------------------
//

/**
 * [liquid_get_custom_footer_id description]
 * @method liquid_get_custom_footer_id
 * @return [type]                     [description]
 */
function liquid_get_custom_footer_id() {

	$id = '';

	if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {
		$enable = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display( 'liquid_footer_condition_enable' );
		if ( $enable === 'on' ){
			$id = Liquid_Page_Condition::render_condition('liquid_footer_condition');
		}
	}

	if( current_theme_supports( 'theme-demo' ) && !empty( $_GET['f'] ) ) {
		$id = $_GET['f'];
	}

	return $id;
}
