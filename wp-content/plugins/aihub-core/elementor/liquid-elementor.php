<?php
namespace LiquidElementor;

/**
 * Class Liquid_Elementor
 *
 * Main Plugin class
 * @since 1.0
 */
class Liquid_Elementor {

	/**
	 * Instance
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;


	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 */
	public function __construct() {

		if ( is_multisite() ) {
			include_once LQD_CORE_PATH . 'elementor/kit/kit.php';
			include_once LQD_CORE_PATH . 'elementor/template-library/template-library.php';
			include_once LQD_CORE_PATH . 'elementor/hooks/global-controls.php';
		}

		include LQD_CORE_PATH . 'elementor/hooks/icon-manager.php';
		include LQD_CORE_PATH . 'elementor/hooks/section-controls.php';
		include LQD_CORE_PATH . 'elementor/params/params.php';
		include LQD_CORE_PATH . 'elementor/hooks/hooks.php';

	}

	/**
	 * Register Custom Controls.
	 */
	public function register_controls() {

		require_once __DIR__ . '/controls/animated-color/animated-color.php';
		require_once __DIR__ . '/controls/background/background.php';
		require_once __DIR__ . '/controls/background-css/background-css.php';
		require_once __DIR__ . '/controls/color/color.php';
		require_once __DIR__ . '/controls/help-me-liquid/help-me-liquid.php';
		require_once __DIR__ . '/controls/linked-dimensions/linked-dimensions.php';
		require_once __DIR__ . '/controls/particles/particles.php';

	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 */
	public function register_widgets() {

		// General Widgets
		require_once __DIR__ . '/widgets/accordion.php';
		require_once __DIR__ . '/widgets/box.php';
		require_once __DIR__ . '/widgets/button.php';
		require_once __DIR__ . '/widgets/carousel.php';
		require_once __DIR__ . '/widgets/code-highlighter.php';
		require_once __DIR__ . '/widgets/counter.php';
		require_once __DIR__ . '/widgets/chatgpt.php';
		require_once __DIR__ . '/widgets/dall-e.php';
		require_once __DIR__ . '/widgets/dark-switch.php';
		require_once __DIR__ . '/widgets/dynamic-range.php';
		require_once __DIR__ . '/widgets/draw-shape.php';
		require_once __DIR__ . '/widgets/gallery.php';
		require_once __DIR__ . '/widgets/generator.php';
		require_once __DIR__ . '/widgets/glow.php';
		require_once __DIR__ . '/widgets/image.php';
		require_once __DIR__ . '/widgets/integration.php';
		require_once __DIR__ . '/widgets/liquid-swap.php';
		require_once __DIR__ . '/widgets/lottie.php';
		require_once __DIR__ . '/widgets/marquee.php';
		require_once __DIR__ . '/widgets/menu.php';
		require_once __DIR__ . '/widgets/modal.php';
		require_once __DIR__ . '/widgets/newsletters.php';
		require_once __DIR__ . '/widgets/particles.php';
		require_once __DIR__ . '/widgets/posts-list.php';
		require_once __DIR__ . '/widgets/price-table.php';
		require_once __DIR__ . '/widgets/search.php';
		require_once __DIR__ . '/widgets/site-logo.php';
		require_once __DIR__ . '/widgets/steps.php';
		require_once __DIR__ . '/widgets/table.php';
		require_once __DIR__ . '/widgets/tabs.php';
		require_once __DIR__ . '/widgets/testimonial.php';
		require_once __DIR__ . '/widgets/text.php';
		require_once __DIR__ . '/widgets/text-rotator.php';
		require_once __DIR__ . '/widgets/throwable.php';
		require_once __DIR__ . '/widgets/typewriter.php';
		// Woocommerce Widgets
		if ( class_exists( 'woocommerce' ) ) {
			require_once __DIR__ . '/widgets/woo-cart-dropdown.php';
			require_once __DIR__ . '/widgets/woo-checkout-params.php';
			require_once __DIR__ . '/widgets/woo-order-params.php';
			require_once __DIR__ . '/widgets/woo-product-add-to-cart.php';
			require_once __DIR__ . '/widgets/woo-product-description.php';
			require_once __DIR__ . '/widgets/woo-product-image.php';
			require_once __DIR__ . '/widgets/woo-product-meta.php';
			require_once __DIR__ . '/widgets/woo-product-price.php';
			require_once __DIR__ . '/widgets/woo-product-rating.php';
			require_once __DIR__ . '/widgets/woo-product-related.php';
			require_once __DIR__ . '/widgets/woo-product-sharing.php';
			require_once __DIR__ . '/widgets/woo-product-tabs.php';
			require_once __DIR__ . '/widgets/woo-product-title.php';
			require_once __DIR__ . '/widgets/woo-product-upsell.php';
		}

	}

}

// Instantiate Plugin Class
Liquid_Elementor::instance();