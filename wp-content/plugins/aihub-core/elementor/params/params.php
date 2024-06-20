<?php 

defined( 'ABSPATH' ) || exit;

include LQD_CORE_PATH . 'classes/typekit.php';
include LQD_CORE_PATH . 'classes/admin-menu.php';
include LQD_CORE_PATH . 'classes/newsletter.php';
include LQD_CORE_PATH . 'classes/helper.php';
include LQD_CORE_PATH . 'elementor/params/advanced-text.php';
include LQD_CORE_PATH . 'elementor/params/button.php';
include LQD_CORE_PATH . 'elementor/params/parallax.php';
include LQD_CORE_PATH . 'elementor/params/animations.php';
include LQD_CORE_PATH . 'elementor/params/additional-animations.php';
include LQD_CORE_PATH . 'elementor/params/testimonials.php';
include LQD_CORE_PATH . 'elementor/params/trigger.php';
if ( class_exists( 'WooCommerce' ) ) {
    include LQD_CORE_PATH . 'classes/woo-ajax-search.php'; 
}