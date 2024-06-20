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
 * [at_meta_mobile_app description]
 * @method at_meta_mobile_app
 * @return [type]             [description]
 */
add_action( 'wp_head', 'liquid_meta_mobile_app', 0 );
function liquid_meta_mobile_app() {

	echo '<meta name="mobile-web-app-capable" content="yes">' . "\n";
	echo '<meta name="apple-mobile-web-app-capable" content="yes">' . "\n";
	printf( '<meta name="apple-mobile-web-app-title" content="%s - %s">' . "\n", esc_html( get_bloginfo('name') ), esc_html( get_bloginfo('description') ) );
}

/**
 * [liquid_meta_name_url description]
 * @method liquid_meta_name_url
 * @return [type]          [description]
 */
add_action( 'wp_head', 'liquid_meta_name_url', 1 );
function liquid_meta_name_url() {

	if ( ! is_front_page() ) {
		return;
	}

	printf( '<meta itemprop="name" content="%s" />' . "\n", get_bloginfo( 'name' ) );
	printf( '<meta itemprop="url" content="%s" />' . "\n", trailingslashit( home_url() ) );
}

/**
 * [liquid_meta_pingback description]
 * @method liquid_meta_pingback
 * @return [type]              [description]
 */
add_action( 'wp_head', 'liquid_meta_pingback', 0 );
function liquid_meta_pingback() {

	if ( 'open' === get_option( 'default_ping_status' ) ) {
		echo '<link rel="pingback" href="' . get_bloginfo( 'pingback_url' ) . '" />' . "\n";
	}
}

/**
 * [liquid_load_favicon description]
 * @method liquid_load_favicon
 * @return [type]             [description]
 */
add_action( 'wp_head', 'liquid_load_favicon' );
function liquid_load_favicon() {
?>
	<?php if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) :?>

		<?php
		if ( $icon = liquid_helper()->get_kit_frontend_option('favicon')['url'] ) : ?>
			<link rel="shortcut icon" href="<?php echo esc_url( $icon ) ?>" />
		<?php else: ?>
			<link rel="shortcut icon" href="<?php echo esc_url(get_template_directory_uri() . '/favicon.png') ?>" />
		<?php endif; ?>

		<?php
		if ( $icon = liquid_helper()->get_kit_frontend_option( 'iphone_icon' )['url'] ) : ?>
			<!-- For iPhone -->
			<link rel="apple-touch-icon-precomposed" href="<?php echo esc_url( $icon ) ?>">
		<?php endif;

		if ( $icon = liquid_helper()->get_kit_frontend_option( 'ipad_icon' )['url'] ) : ?>
			<!-- For iPad -->
			<link rel="apple-touch-icon" sizes="72x72" href="<?php echo esc_url( $icon ) ?>">
		<?php endif; ?>

	<?php else: ?>

		<link rel="shortcut icon" href="<?php echo esc_url(get_template_directory_uri() . '/favicon.png') ?>" />

	<?php endif;
}

/**
 * [liquid_output_advance_code description]
 * @method liquid_output_advance_code
 * @return [type]                  [description]
 */
add_action( 'wp_head', 'liquid_output_advance_code', 999 );
function liquid_output_advance_code() {

	echo liquid_helper()->get_kit_option( 'liquid_custom_code_tracking' );

	echo liquid_helper()->get_kit_option( 'liquid_custom_code_before_head' );
}

/**
 * Add skiplinks for screen readers and keyboard navigation
 */
add_action( 'liquid_before', 'liquid_skip_links', 1 );
function liquid_skip_links() {

	// Determine which skip links are needed
	$links = array();

	if ( has_nav_menu( 'primary' ) ) {
		$links['primary-nav'] =  esc_html__( 'Skip to primary navigation', 'aihub' );
	}

	$links['lqd-site-content'] = esc_html__( 'Skip to content', 'aihub' );

	// write HTML, skiplinks in a list with a heading
	$skiplinks  =  '<div>';
	$skiplinks .=  '<div class="screen-reader-text">'. esc_html__( 'Skip links', 'aihub' ) .'</div>';
	$skiplinks .=  '<ul class="liquid-skip-link screen-reader-text">';

	// Add markup for each skiplink
	foreach ($links as $key => $value) {
		$skiplinks .=  '<li><a href="' . esc_url( '#' . $key ) . '" class="screen-reader-shortcut"> ' . esc_html( $value ) . '</a></li>';
	}

	$skiplinks .=  '</ul>';
	$skiplinks .=  '</div>' . "\n";

	echo wp_kses( $skiplinks, 'lqd_post' );
}

/**
 * [liquid_attributes_header description]
 * @method liquid_attributes_header
 * @param  [type]                  $attributes [description]
 * @return [type]                              [description]
 */
add_filter( 'liquid_attr_header', 'liquid_attributes_header' );
function liquid_attributes_header( $attributes ) {

	if( !isset( $attributes['id'] ) || empty( $attributes['id'] ) ) {
		$attributes['id'] = 'lqd-page-header-wrap';
	}

	$attributes['class'] = !empty( $attributes['class'] ) ? 'lqd-site-header ' . $attributes['class'] : 'lqd-site-header';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'https://schema.org/WPHeader';

	return $attributes;

}


add_filter( 'liquid_attr_archive-header', 'liquid_attributes_archive_header' );
/**
 * [liquid_attributes_archive_header description]
 * @method liquid_attributes_archive_header
 * @param  [type]              $attributes [description]
 * @return [type]                          [description]
 */
function liquid_attributes_archive_header( $attributes ) {

	$attributes['class'] = 'page-header archive-header';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/WebPageElement';

	return $attributes;
}


add_filter( 'liquid_attr_archive-title', 'liquid_attributes_archive_title' );
/**
 * [liquid_attributes_archive_title description]
 * @method liquid_attributes_archive_title
 * @param  [type]              $attributes [description]
 * @return [type]                          [description]
 */
function liquid_attributes_archive_title( $attributes ) {

	$attributes['class']     = 'archive-title';
	$attributes['itemprop']  = 'headline';

	return $attributes;
}


add_filter( 'liquid_attr_archive-description', 'liquid_attributes_archive_description' );
/**
 * [liquid_attributes_archive_description description]
 * @method liquid_attributes_archive_description
 * @param  [type]              $attributes [description]
 * @return [type]                          [description]
 */
function liquid_attributes_archive_description( $attributes ) {

	$attributes['class']     = 'archive-description';
	$attributes['itemprop']  = 'text';

	return $attributes;
}

// 2. Functions ------------------------------------------------------
//

/**
 * [liquid_get_custom_header_id description]
 * @method liquid_get_custom_header_id
 * @return [type]                     [description]
 */
function liquid_get_custom_header_id() {

	$id = '';

	if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {
		$enable = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display( 'liquid_header_condition_enable' );
		if ( $enable === 'on' ){
			$id = Liquid_Page_Condition::render_condition('liquid_header_condition');
		}
	}

	return $id;
}

/**
 * [liquid_get_custom_titlewrapper_id description]
 * @method liquid_get_custom_titlewrapper_id
 * @return [type]                     [description]
 */
function liquid_get_custom_titlewrapper_id() {

	$id = '';

	if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {
		$enable = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display( 'liquid_titlewrapper_condition_enable' );
		if ( $enable === 'on' ){
			$id = Liquid_Page_Condition::render_condition('liquid_titlewrapper_condition');
		} else {
			$id = 'off';
		}
	}

	return $id;
}

// 3. Template Tags --------------------------------------------------
//

function liquid_get_custom_header( $post_id = 0 ) {

	if( ! $post_id ) {
		return;
	}
}
