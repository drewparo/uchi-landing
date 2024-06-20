<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

include_once LQD_CORE_PATH . 'elementor/kit/condition.php';
include_once LQD_CORE_PATH . 'elementor/kit/tabs/header.php';
include_once LQD_CORE_PATH . 'elementor/kit/tabs/title-wrapper.php';
include_once LQD_CORE_PATH . 'elementor/kit/tabs/footer.php';
include_once LQD_CORE_PATH . 'elementor/kit/tabs/sidebar.php';
include_once LQD_CORE_PATH . 'elementor/kit/tabs/typography.php';
include_once LQD_CORE_PATH . 'elementor/kit/tabs/blog.php';
include_once LQD_CORE_PATH . 'elementor/kit/tabs/portfolio.php';
include_once LQD_CORE_PATH . 'elementor/kit/tabs/woocommerce.php';
include_once LQD_CORE_PATH . 'elementor/kit/tabs/performance.php';
include_once LQD_CORE_PATH . 'elementor/kit/tabs/api-keys.php';
include_once LQD_CORE_PATH . 'elementor/kit/tabs/extras.php';
include_once LQD_CORE_PATH . 'elementor/kit/tabs/gdpr.php';
include_once LQD_CORE_PATH . 'elementor/kit/tabs/advanced.php';
include_once LQD_CORE_PATH . 'elementor/kit/tabs/sizes.php';
include_once LQD_CORE_PATH . 'elementor/kit/tabs/dark.php';
include_once LQD_CORE_PATH . 'elementor/kit/tabs/button.php';
include_once LQD_CORE_PATH . 'elementor/kit/tabs/ai.php';

function custom_font_mime_types( $mimes = array() ) {

	$arr =  [
		'woff' => 'font/woff|application/font-woff|application/x-font-woff|application/octet-stream',
		'woff2' => 'font/woff2|application/octet-stream|font/x-woff2',
		'ttf' => 'application/x-font-ttf|application/octet-stream|font/ttf',
		'svg' => 'image/svg+xml|application/octet-stream|image/x-svg+xml',
		'eot' => 'application/vnd.ms-fontobject|application/octet-stream|application/x-vnd.ms-fontobject',
	];

	$mimes['woff'] = 'application/x-font-woff';
	$mimes['woff2'] = 'application/x-font-woff2';
	$mimes['ttf'] = 'application/x-font-ttf';
	$mimes['eot'] = 'application/x-vnd.ms-fontobject';
	// Depending on your server setup, you may need to use these instead:
	//$mimes['woff'] = 'font/woff';
	//$mimes['woff2'] = 'font/woff2';
	return $mimes;

}

add_filter('upload_mimes', 'custom_font_mime_types');